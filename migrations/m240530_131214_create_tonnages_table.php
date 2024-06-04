<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tonnages}}`.
 */
class m240530_131214_create_tonnages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        CREATE TABLE tonnages (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    value TINYINT(3) UNSIGNED NOT NULL UNIQUE,
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

    }
}
