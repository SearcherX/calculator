<?php

namespace app\services;

use Yii;
use yii\db\Query;

class TonnageDAO
{
    public static function read(int $value)
    {
        return (new Query())
            ->select('id')
            ->from('tonnages')
            ->where('value=:value')
            ->addParams([':value' => $value])
            ->one();
    }

    public static function readAll()
    {
        return (new Query())
            ->select('value')
            ->from('tonnages')
            ->all();
    }

    public static function add(int $value)
    {
        Yii::$app->db->createCommand('INSERT INTO tonnages(value) VALUES(:value)')
            ->bindValues([':value' => $value])->execute();
    }

    public static function remove(int $value)
    {
        Yii::$app->db->createCommand('DELETE FROM tonnages WHERE value=:value')
            ->bindValues([':value' => $value])->execute();
    }

}