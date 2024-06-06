<?php

namespace app\services;

use Yii;
use yii\db\Query;

class TypeDAO
{
    public static function read(string $name)
    {
        return (new Query())
            ->select('id')
            ->from('raw_types')
            ->where('name=:name')
            ->addParams([':name' => $name])
            ->one();
    }

    public static function readAll()
    {
        return (new Query())
            ->select('name')
            ->from('raw_types')
            ->all();
    }

    public static function add(string $name)
    {
        Yii::$app->db->createCommand('INSERT INTO raw_types(name) VALUES(:name)')
            ->bindValues([':name' => $name])->execute();
    }

    public static function remove(string $name)
    {
        Yii::$app->db->createCommand('DELETE FROM raw_types WHERE name=:name')
            ->bindValues([':name' => $name])->execute();
    }

}