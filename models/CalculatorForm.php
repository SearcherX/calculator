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
            [['month', 'tonnage', 'raw_type'], 'required', 'message' => 'Пожалуйста, выберите значение из списка'],
        ];
    }
}