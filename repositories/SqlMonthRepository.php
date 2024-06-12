<?php

namespace app\repositories;

use app\repositories\interfaces\MonthRepositoryInterface;
use Yii;
use yii\db\Exception;
use yii\db\Query;

class SqlMonthRepository implements MonthRepositoryInterface
{
    public function findAllMonths(): array
    {
        return (new Query())
            ->select('*')
            ->from('months')
            ->all();
    }

    public function addMonth(string $name): int
    {
        return Yii::$app->db->createCommand('
            INSERT INTO months(name) 
            SELECT :month
            WHERE NOT EXISTS (SELECT * FROM months WHERE name = :month)
        ')->bindValues([
            ':month' => $name
        ])
            ->execute();
    }

    public function removeMonth(string $name): int
    {
        return Yii::$app->db->createCommand('
            DELETE FROM months
            WHERE name = :month AND EXISTS(SELECT 1 FROM months WHERE name = :month LIMIT 1)
        ')
            ->bindValues([
                ':month' => $name
            ])->execute();
    }
}