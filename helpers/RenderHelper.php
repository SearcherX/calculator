<?php

namespace app\helpers;

use yii\data\ArrayDataProvider;

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

    public static function getColumns(ArrayDataProvider $dataProvider, string $rowIndex, int $columnIndex, string $options): array
    {
        $columns[] = [
            'value' => function ($data, $key) {
                return mb_convert_case($key, MB_CASE_TITLE, 'UTF-8');
            },
            'label' => 'Месяц'
        ];

        $models = $dataProvider->getModels();

        foreach (reset($models) as $columnName => $value) {
            $columns[] = [
                'attribute' => $columnName,
                'label' => $columnName,
                'contentOptions' => function($data, $key) use ($rowIndex, $columnIndex, $columnName, $options)
                {
                    return ['class' => ($key == $rowIndex && $columnName == $columnIndex ? $options : '')];
                }
            ];
        }

        return $columns;
    }
}