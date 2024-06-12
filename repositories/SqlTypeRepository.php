<?php

namespace app\repositories;

use app\repositories\interfaces\MonthRepositoryInterface;
use app\repositories\interfaces\TypeRepositoryInterface;
use Yii;
use yii\db\Exception;
use yii\db\Query;

class SqlTypeRepository implements TypeRepositoryInterface
{
    public function findAllTypes(): array
    {
        return (new Query())
            ->select('*')
            ->from('raw_types')
            ->all();
    }

    public function addType(string $name): int
    {
        return Yii::$app->db->createCommand('
            INSERT INTO raw_types(name) 
            SELECT :type
            WHERE NOT EXISTS (SELECT * FROM raw_types WHERE name = :type)
        ')->bindValues([
            ':type' => $name
        ])
            ->execute();
    }

    public function removeType(string $name): int
    {
        return Yii::$app->db->createCommand('
            DELETE FROM raw_types
            WHERE name = :type AND EXISTS(SELECT 1 FROM raw_types WHERE name = :type LIMIT 1)
        ')
            ->bindValues([
                ':type' => $name
            ])->execute();
    }
}