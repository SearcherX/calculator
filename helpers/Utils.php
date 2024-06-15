<?php

namespace app\helpers;

class Utils
{
    public static function getSelectedAttributeOnInputCondition(
        array  $input,
        string $inputName,
        mixed  $condition,
        bool   $asInt = false
    ): ?string
    {
        if (isset($input[$inputName]) === false) {
            return null;
        }

        $condition = $asInt === true ? (int)$condition : (string)$condition;

        if ($input[$inputName] !== $condition) {
            return null;
        }

        return 'selected';
    }

    public static function getPriceTonnages(string $rawType, array $prices): array
    {

        if (isset($prices[$rawType]) === true) {

            $firstMonth = array_key_first($prices[$rawType]);

            return array_keys($prices[$rawType][$firstMonth]);
        }

        throw new \LogicException('Стоимости для типа сырья ' . $rawType . ' отсутствуют');
    }

    public static function isSetAllAttributes($month, $tonnage, $raw_type): bool
    {
        return isset($month) && isset($tonnage) && isset($raw_type);
    }

    public static function getMonthTonnageTable($tonnagesMonth)
    {
        $res = null;

        foreach ($tonnagesMonth as $month => $tonnages) {
            foreach ($tonnages as $tonnage => $price) {
                $res[$tonnage][$month] = $price;
            }
        }

        return $res;
    }

    public static function getLengths($table)
    {
        $length = [];
        $length['м/т'] = self::getMaxLength('м/т', array_keys($table));

        foreach ($table as $tonnage => $months) {
            foreach ($months as $month => $price) {
                $length[$month] = self::getMaxLength($month, array_column($table, $month));
            }
        }

        return $length;
    }

    public static function getMaxLength($head, $arr): int
    {
        $max = mb_strlen($head);

        foreach ($arr as $item) {
            $curLength = mb_strlen($item);

            if ($max < $curLength) {
                $max = $curLength;
            }
        }

        return $max;
    }
}