<?php

namespace app\services;

use app\components\exceptions\AlreadyExistsException;
use app\repositories\interfaces\MonthRepositoryInterface;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class MonthService
{
    private MonthRepositoryInterface $monthRepository;

    public function __construct(MonthRepositoryInterface $monthRepository)
    {
        $this->monthRepository = $monthRepository;
    }

    public function getAllMonths(): array
    {
        return DAOMapper::toArray($this->monthRepository->findAllMonths(), 'name');
    }

    /**
     * @throws BadRequestHttpException
     */
    public function addMonth(string $name): void
    {
        if ($this->monthRepository->addMonth($name) === 0) {
            throw new BadRequestHttpException('The month already exists');
        }
    }

    /**
     * @throws AlreadyExistsException
     */
    public function deleteMonth(string $name): void
    {
        if ($this->monthRepository->removeMonth($name) === 0) {
            throw new NotFoundHttpException('Month not found');
        }

    }
}