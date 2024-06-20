<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $raw_type
 * @property User $user
 * @property string $month
 * @property int $tonnage
 * @property int $price
 * @property string $table_data
 */
class History extends ActiveRecord
{
    public static function tableName()
    {
        return '{{histories}}';
    }

    public function rules()
    {
        return [
            [['user_id', 'raw_type', 'month', 'tonnage', 'price', 'table_data'], 'required'],
            [['user_id', 'tonnage', 'price'], 'integer'],
            [['raw_type', 'month'], 'string', 'max' => 255],
            [['table_data'], 'string', 'max' => 1000]
        ];
    }

    public function getPrices()
    {
        return json_decode($this->table_data, true);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getUsername()
    {
        return $this->user->username;
    }

    public function getEmail()
    {
        return $this->user->email;
    }

    public function getCalculationDate()
    {
        return $this::find()->select('created_at')->where(['id' => $this->id])->scalar();
    }

    public function snapshot(CalculatorForm $model, int $price, array $prices)
    {
        if (!Yii::$app->user->isGuest) {
            $this->month = $model->month;
            $this->tonnage = $model->tonnage;
            $this->raw_type = $model->raw_type;
            $this->price = $price;
            $this->table_data = json_encode($prices);
            $this->link('user', Yii::$app->user->identity);
        }
    }

    public function attributeLabels() {
        return [
            'username' => 'Имя пользователя',
        ];
    }

}