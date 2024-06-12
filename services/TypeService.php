<?php

namespace app\services;

use app\repositories\interfaces\TypeRepositoryInterface;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class TypeService
{
    private TypeRepositoryInterface $typeRepository;

    public function __construct(TypeRepositoryInterface $typeRepository)
    {
        $this->typeRepository = $typeRepository;
    }

    public function getAllTypes(): array
    {
        return DAOMapper::toArray($this->typeRepository->findAllTypes(), 'name');
    }

    /**
     * @throws BadRequestHttpException
     */
    public function addType(string $name): void
    {
        if ($this->typeRepository->addType($name) === 0) {
            throw new BadRequestHttpException('The raw type already exists');
        }
    }

    /**
     * @throws NotFoundHttpException
     */
    public function removeType(string $name): void
    {
        if ($this->typeRepository->removeType($name) === 0) {
            throw new NotFoundHttpException('Raw type not found');
        }

    }
}