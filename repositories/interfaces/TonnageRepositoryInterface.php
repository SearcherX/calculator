<?php

namespace app\repositories\interfaces;

interface TonnageRepositoryInterface
{
    public function findAllTonnages(): array;
    public function addTonnage(int $value): int;
    public function removeTonnage(int $value): int;
}