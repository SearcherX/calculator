<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%raw_types}}`.
 */
class m240530_133039_create_raw_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        CREATE TABLE raw_types (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(10) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP
)
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%raw_types}}');
    }
}
