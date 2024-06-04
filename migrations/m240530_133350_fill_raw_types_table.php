<?php

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
        $this->execute("
        INSERT INTO raw_types (name) VALUES ('шрот'), ('соя'), ('жмых');
        ");
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
