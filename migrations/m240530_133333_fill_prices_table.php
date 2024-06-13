<?php

use yii\db\Migration;

/**
 * Class m240530_133333_fill_prices_table
 */
class m240530_133333_fill_prices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        INSERT INTO prices (tonnage_id, month_id, raw_type_id, price)
SELECT
    t.id AS tonnage_id,
    m.id AS month_id,
    r.id AS raw_type_id,
    FLOOR(100 + RAND() * 100) AS price -- генерируем случайное значение цены в диапазоне от 100 до 200
FROM
    tonnages t
JOIN
    months m
JOIN
    raw_types r;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240530_133333_fill_prices_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240530_133333_fill_prices_table cannot be reverted.\n";

        return false;
    }
    */
}
