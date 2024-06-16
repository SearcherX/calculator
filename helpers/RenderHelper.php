<?php

namespace app\helpers;

class RenderHelper
{
    public static function getBorderClass($month, $tonnage, $postMonth, $postTonnage): string
    {
        if (mb_strtolower($month) === mb_strtolower($postMonth) && (int)$tonnage === (int)$postTonnage) {
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