<?php

use yii\db\Migration;

/**
 * Class m240530_133333_fill_prices_table
 */
class m240530_133500_fill_prices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $months = $this->getDb()->createCommand('SELECT * FROM months')->queryAll();
        $tonnages = $this->getDb()->createCommand('SELECT * FROM tonnages')->queryAll();
        $types = $this->getDb()->createCommand('SELECT * FROM raw_types')->queryAll();
        $prices = Yii::$app->params['prices'];
        $columns = ['price', 'month_id', 'tonnage_id', 'raw_type_id'];
        $rows = \app\helpers\DAOMapper::toPriceRecords($prices, $months, $tonnages, $types);
        $this->batchInsert('prices', $columns, $rows);
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
