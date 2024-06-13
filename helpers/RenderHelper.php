<?php

namespace app\helpers;

class RenderHelper
{
    public static function getTonnages(array $table): array
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

    public static function getBorderClass($month, $tonnage, $postMonth, $postTonnage): string
    {
        if ($month === $postMonth && $tonnage === (int)$postTonnage) {
            return 'with-border';
        }

        return ' ';
    }

    public static function getDropDownArray(array $arr): array
    {
        $values = array_map(function ($str) {
            return mb_convert_case($str, MB_CASE_TITLE, 'UTF-8');
        }, $arr);
        return array_combine($arr, $values);
    }
}