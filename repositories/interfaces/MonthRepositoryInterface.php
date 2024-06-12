<?php

namespace app\repositories\interfaces;

interface MonthRepositoryInterface
{
    public function findAllMonths(): array;
    public function addMonth(string $name): int;
    public function removeMonth(string $name): int;
}