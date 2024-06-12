<?php

namespace app\repositories\interfaces;

interface PriceRepositoryInterface
{
    public function findPriceByMonthAndTonnageAndType(string $month, int $tonnage, string $type): array|bool;

    public function findPriceByTypeName(string $type): array;

    public function addPrice(string $month, int $tonnage, string $type, int $price): int;

    public function updatePrice(string $month, int $tonnage, string $type, int $price): int;

    public function removePrice(string $month, int $tonnage, string $type): int;
}