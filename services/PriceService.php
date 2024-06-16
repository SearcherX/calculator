<?php

namespace app\services;

use app\helpers\DAOMapper;
use app\helpers\RenderHelper;
use app\repositories\interfaces\PriceRepositoryInterface;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class PriceService
{
    private PriceRepositoryInterface $priceRepository;

    /**
     * @param PriceRepositoryInterface $priceRepository
     */
    public function __construct(PriceRepositoryInterface $priceRepository)
    {
        $this->priceRepository = $priceRepository;
    }

    /**
     * @throws NotFoundHttpException
     */
    public function getPriceByType(string $type): array
    {
        $rows = $this->priceRepository->findPriceByTypeName($type);

        if (count($rows) === 0) {
            throw new NotFoundHttpException('Raw type not found');
        }

        $data = DAOMapper::getMonthsAndTonnagesFromRecords($rows);
        $emptyPrices = DAOMapper::createEmptyPrices($data['months'], $data['tonnages']);

        return DAOMapper::toTable($rows, $emptyPrices);
    }

    public function getByMonthAndTonnageAndType(string $month, int $tonnage, string $type): int
    {
        $rows = $this->priceRepository->findPriceByMonthAndTonnageAndType($month, $tonnage, $type);

        if ($rows === false) {
            throw new NotFoundHttpException('There is no price for the selected parameters');
        }

        return $rows['price'];
    }

    /**
     * @throws BadRequestHttpException
     */
    public function addPrice(string $month, int $tonnage, string $type, int $price): void
    {
        if ($this->priceRepository->addPrice($month, $tonnage, $type, $price) === 0) {
            throw new BadRequestHttpException('Incorrect parameters');
        }
    }

    /**
     * @throws NotFoundHttpException
     */
    public function updatePrice(string $month, int $tonnage, string $type, int $price): void
    {
        if ($this->priceRepository->updatePrice($month, $tonnage, $type, $price) === 0) {
            throw new NotFoundHttpException(
                'There is no price for the selected parameters or the new price is the same as the current one'
            );
        }
    }

    /**
     * @throws NotFoundHttpException
     */
    public function deletePrice(string $month, int $tonnage, string $type): void
    {
        if ($this->priceRepository->removePrice($month, $tonnage, $type) === 0) {
            throw new NotFoundHttpException('There is no price for the selected parameters');
        }

    }
}