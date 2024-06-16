<?php

namespace app\helpers;

class DAOMapper
{
    public static function getTonnagesFromTable(array $table): array
    {
        $res = [];

        foreach ($table as $tonnagesPrices) {
            foreach ($tonnagesPrices as $tonnage => $price) {
                if (in_array($tonnage, $res) === false) {
                    $res[] = $tonnage;
                }
            }
        }

        sort($res);
        return $res;
    }

    public static function getMonthsAndTonnagesFromRecords(array $records): array
    {
        $months = [];
        $tonnages = [];

        foreach ($records as $record) {
            if (!in_array($record['name'], $months)) {
                $months[] = $record['name'];
            }

            if (!in_array($record['value'], $tonnages)) {
                $tonnages[] = $record['value'];
            }
        }

        sort($tonnages);

        return ['months' => $months, 'tonnages' => $tonnages];
    }

    public static function createEmptyPrices(array $months, array $tonnages): array
    {
        $res = [];

        foreach ($months as $month) {
            foreach ($tonnages as $tonnage) {
                $res[$month][$tonnage] = null;
            }
        }

        return $res;
    }

    //функция преобразования записей из БД в таблицу для вывода
    public static function toTable(array $rows, array $emptyPrices): array
    {

        foreach ($rows as $row) {
            $emptyPrices[$row['name']][$row['value']] = $row['price'];
        }

        return $emptyPrices;
    }

    //функция преобразования записей из бд в массив для вывода
    public static function toArray($rows, $fieldName): array
    {
        return array_map(function ($object) use ($fieldName) {
            return $object[$fieldName];
        }, $rows);
    }

    /**
     * @throws \Exception
     */
    public static function findIdByField(array $arr, string $fieldName, int|string $value): int
    {
        foreach ($arr as $item) {
            if ($item[$fieldName] === $value) {
                return $item['id'];
            }
        }

        throw new \Exception("Value {$value} doesn't exists in array");
    }

    /**
     * @throws \Exception
     */
    public static function toRecords(array $arr, array $months, array $tonnages, array $types): array
    {
        $records = [];

        foreach ($arr as $type => $typeValues) {
            $typeId = self::findIdByField($types, 'name', $type);
            foreach ($typeValues as $month => $monthValues) {
                $monthId = self::findIdByField($months, 'name', $month);
                foreach ($monthValues as $tonnage => $price) {
                    $tonnageId = self::findIdByField($tonnages, 'value', $tonnage);
                    $records[] = [
                        'price' => $price,
                        'month_id' => $monthId,
                        'tonnage_id' => $tonnageId,
                        'raw_type_id' => $typeId
                    ];
                }
            }
        }

        return $records;
    }
}