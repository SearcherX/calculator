<?php

namespace app\repositories;

use app\repositories\interfaces\MonthRepositoryInterface;
use app\repositories\interfaces\PriceRepositoryInterface;
use Yii;
use yii\db\Exception;
use yii\db\Query;

class SqlPriceRepository implements PriceRepositoryInterface
{
    public function findPriceByMonthAndTonnageAndType(string $month, int $tonnage, string $type): array|bool
    {
        return Yii::$app->db->createCommand('
            SELECT p.price FROM prices p
                JOIN months m ON m.id = p.month_id
                JOIN tonnages t ON t.id = p.tonnage_id
                JOIN raw_types rt ON rt.id = p.raw_type_id
            WHERE m.name = :month AND t.value = :tonnage AND rt.name = :type
        ')->bindValues([
            ':month' => $month,
            ':tonnage' => $tonnage,
            ':type' => $type
        ])->queryOne();
    }

    public function findPriceByTypeName(string $type): array
    {
        return Yii::$app->db->createCommand('
            SELECT p.price, m.name, t.value FROM prices p
                JOIN months m ON m.id = p.month_id
                JOIN tonnages t ON t.id = p.tonnage_id
            WHERE EXISTS(SELECT id FROM raw_types rt WHERE rt.id = p.raw_type_id AND rt.name = :type)
            ORDER BY m.id, t.value
        ')->bindValues([
            ':type' => $type
        ])->queryAll();
    }

    public function addPrice(string $month, int $tonnage, string $type, int $price): int
    {
        return Yii::$app->db->createCommand('
            INSERT INTO prices (price, month_id, tonnage_id, raw_type_id)
            SELECT :price, m.id, t.id, rt.id
            FROM months m, tonnages t, raw_types rt
            WHERE m.name = :month AND t.value = :tonnage AND rt.name = :type
            AND NOT EXISTS(
                SELECT month_id, tonnage_id, raw_type_id
                FROM prices p
                WHERE p.month_id = m.id AND p.tonnage_id = t.id AND p.raw_type_id = rt.id
            )
        ')->bindValues([
            ':price' => $price,
            ':month' => $month,
            ':tonnage' => $tonnage,
            ':type' => $type
        ])->execute();

    }

    public function updatePrice(string $month, int $tonnage, string $type, int $price): int
    {
        return Yii::$app->db->createCommand('
            UPDATE prices SET price=:price
              WHERE EXISTS (SELECT * FROM months WHERE months.id = prices.month_id AND name=:month)
                AND EXISTS (SELECT * FROM tonnages WHERE tonnages.id = prices.tonnage_id AND value=:tonnage)
                AND EXISTS (SELECT * FROM raw_types WHERE raw_types.id = prices.raw_type_id AND name=:type)
                ')->bindValues([
            ':price' => $price,
            ':month' => $month,
            ':tonnage' => $tonnage,
            ':type' => $type
        ])->execute();
    }

    public function removePrice(string $month, int $tonnage, string $type): int
    {
        return Yii::$app->db->createCommand('
            DELETE FROM prices
            WHERE EXISTS (SELECT * FROM months WHERE months.id = prices.month_id AND name=:month)
                AND EXISTS (SELECT * FROM tonnages WHERE tonnages.id = prices.tonnage_id AND value=:tonnage)
                AND EXISTS (SELECT * FROM raw_types WHERE raw_types.id = prices.raw_type_id AND name=:type)
        ')->bindValues([
            ':month' => $month,
            ':tonnage' => $tonnage,
            ':type' => $type
        ])->execute();
    }
}