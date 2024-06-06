<?php

namespace app\services;

use Yii;
use yii\db\Query;

class MonthDAO
{
    public static function read(string $name)
    {
        return (new Query())
            ->select('id')
            ->from('months')
            ->where('name=:month')
            ->addParams([':month' => $name])
            ->one();
    }

    public static function readAll()
    {
        return (new Query())
            ->select('name')
            ->from('months')
            ->all();
    }

    public static function add(string $name)
    {
        Yii::$app->db->createCommand('INSERT INTO months(name) VALUES(:month)')
            ->bindValues([':month' => $name])->execute();
    }

    public static function remove(string $name)
    {
        Yii::$app->db->createCommand('DELETE FROM months WHERE name=:month')
            ->bindValues([':month' => $name])->execute();
    }

}