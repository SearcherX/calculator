<?php

namespace app\services;

use Yii;
use yii\db\Query;

class PriceDAO
{
    public static function read(int $monthId, int $typeId, int $tonnageId)
    {
        return (new Query())
            ->select('price')
            ->from('prices')
            ->where([
                'month_id' => $monthId,
                'raw_type_id' => $typeId,
                'tonnage_id' => $tonnageId
            ])
            ->one();
    }

    public static function readAll(int $typeId)
    {
        return (new Query())
            ->select('name, value, price')
            ->from('prices')
            ->join('LEFT JOIN', 'months', 'months.id = prices.month_id')
            ->join('LEFT JOIN', 'tonnages', 'tonnages.id = prices.tonnage_id')
            ->where('raw_type_id=:typeId')
            ->addParams([':typeId' => $typeId])
            ->orderBy([
                'month_id' => SORT_ASC,
                'tonnage_id' => SORT_ASC
            ])
            ->all();
    }

    public static function add(int $price, int $monthId, int $tonnageId, int $typeId)
    {
        Yii::$app->db->createCommand('
                    INSERT INTO prices(price, month_id, tonnage_id, raw_type_id) 
                    VALUES(:price, :monthId, :tonnageId, :typeId)
                ')
            ->bindValues([
                ':price' => $price,
                ':monthId' => $monthId,
                ':tonnageId' => $tonnageId,
                ':typeId' => $typeId
            ])->execute();
    }

    public static function update(int $price, int $monthId, int $tonnageId, int $typeId)
    {
        Yii::$app->db->createCommand('
                    UPDATE prices SET price=:price WHERE month_id=:monthId AND tonnage_id=:tonnageId AND raw_type_id=:typeId
                    ')
            ->bindValues([
                ':price' => $price,
                ':monthId' => $monthId,
                ':tonnageId' => $tonnageId,
                ':typeId' => $typeId
            ])->execute();
    }

    public static function remove(int $monthId, int $tonnageId, int $typeId)
    {
        Yii::$app->db->createCommand('
                    DELETE FROM prices WHERE month_id=:monthId AND tonnage_id=:tonnageId AND raw_type_id=:typeId
                    ')
            ->bindValues([
                ':monthId' => $monthId,
                ':tonnageId' => $tonnageId,
                ':typeId' => $typeId
            ])->execute();
    }

}