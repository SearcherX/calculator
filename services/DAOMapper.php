<?php

namespace app\services;

class DAOMapper
{
    //функция преобразования записей из БД в таблицу для вывода
    public static function toTable($rows): array
    {
        $res = [];

        foreach ($rows as $row) {
            $res[$row['name']][$row['value']] = $row['price'];
        }

        return $res;
    }

    //функция преобразования записей из бд в массив для вывода
    public static function toArray($rows, $fieldName): array
    {
        return array_map(function ($object) use ($fieldName) {
            return $object[$fieldName];
        }, $rows);
    }
}