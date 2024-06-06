<?php

namespace app\services;

class DAOUtils
{
    public static function getTable($rows)
    {
        $res = [];

        foreach ($rows as $row) {
            $res[$row['name']][$row['value']] = $row['price'];
        }

        return $res;
    }

    public static function mapToString($rows, $fieldName)
    {
        return array_map(function ($object) use ($fieldName) {
            return $object[$fieldName];
        }, $rows);
    }
}