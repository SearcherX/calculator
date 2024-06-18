<?php

use app\helpers\DAOMapper;
use yii\db\Migration;

/**
 * Class m240530_133420_fill_tonnages_table
 */
class m240530_133420_fill_tonnages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $months = Yii::$app->params['lists']['tonnages'];
        $rows = DAOMapper::toRecords($months, 'value');
        $this->batchInsert('tonnages', ['value'], $rows);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240530_133420_fill_tonnages_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240530_133420_fill_tonnages_table cannot be reverted.\n";

        return false;
    }
    */
}
