<?php

namespace app\repositories;

use app\repositories\interfaces\MonthRepositoryInterface;
use app\repositories\interfaces\TonnageRepositoryInterface;
use Yii;
use yii\db\Exception;
use yii\db\Query;

class SqlTonnageRepository implements TonnageRepositoryInterface
{
    public function findAllTonnages(): array
    {
        return (new Query())
            ->select('*')
            ->from('tonnages')
            ->all();
    }

    public function addTonnage(int $value): int
    {
        return Yii::$app->db->createCommand('
            INSERT INTO tonnages(value) 
            SELECT :tonnage
            WHERE NOT EXISTS (SELECT * FROM tonnages WHERE value = :tonnage)
        ')->bindValues([
            ':tonnage' => $value
        ])
            ->execute();
    }

    public function removeTonnage(int $value): int
    {
        return Yii::$app->db->createCommand('
            DELETE FROM tonnages
            WHERE value = :tonnage AND EXISTS(SELECT 1 FROM tonnages WHERE value = :tonnage LIMIT 1)
        ')
            ->bindValues([
                ':tonnage' => $value
            ])->execute();
    }
}