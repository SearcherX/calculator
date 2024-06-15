<?php

namespace app\services;

use app\helpers\DAOMapper;
use app\repositories\interfaces\TonnageRepositoryInterface;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class TonnageService
{
    private TonnageRepositoryInterface $tonnageRepository;

    public function __construct(TonnageRepositoryInterface $tonnageRepository)
    {
        $this->tonnageRepository = $tonnageRepository;
    }

    public function getAllTonnages(): array
    {
        return DAOMapper::toArray($this->tonnageRepository->findAllTonnages(), 'value');
    }

    /**
     * @throws BadRequestHttpException
     */
    public function addTonnage(int $value): void
    {
        if ($this->tonnageRepository->addTonnage($value) === 0) {
            throw new BadRequestHttpException('The tonnage already exists');
        }
    }

    /**
     * @throws NotFoundHttpException
     */
    public function deleteTonnage(int $value): void
    {
        if ($this->tonnageRepository->removeTonnage($value) === 0) {
            throw new NotFoundHttpException('Tonnage not found');
        }

    }
}