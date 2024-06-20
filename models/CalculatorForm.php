<?php

namespace app\models;

use yii\base\Model;

class CalculatorForm extends Model
{
    public $month;
    public $tonnage;
    public $raw_type;

    public function rules()
    {
        return [
            [['month', 'tonnage', 'raw_type'], 'required', 'message' => 'Пожалуйста, выберите {attribute}'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'month' => 'месяц',
            'tonnage' => 'тоннаж',
            'raw_type' => 'тип сырья'
        ];
    }


}