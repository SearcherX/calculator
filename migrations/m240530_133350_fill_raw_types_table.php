<?php

use app\helpers\DAOMapper;
use yii\db\Migration;

/**
 * Class m240530_133350_fill_raw_types_table
 */
class m240530_133350_fill_raw_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $months = Yii::$app->params['lists']['raw_types'];
        $rows = DAOMapper::toRecords($months, 'name');
        $this->batchInsert('raw_types', ['name'], $rows);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240530_133350_fill_raw_types_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240530_133350_fill_raw_types_table cannot be reverted.\n";

        return false;
    }
    */
}
