<?php

namespace app\repositories\interfaces;

interface TypeRepositoryInterface
{
    public function findAllTypes(): array;
    public function addType(string $name): int;
    public function removeType(string $name): int;
}