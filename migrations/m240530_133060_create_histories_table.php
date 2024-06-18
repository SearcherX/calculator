<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%histories}}`.
 */
class m240530_133060_create_histories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE histories (
                id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                user_id INT(11) UNSIGNED NOT NULL,
                tonnage INT(11) UNSIGNED NOT NULL,
                month VARCHAR(10) NOT NULL,
                raw_type VARCHAR(10) NOT NULL,
                price INT(3) UNSIGNED NOT NULL,
                table_data TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES user(id) ON UPDATE CASCADE ON DELETE CASCADE
            )
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%histories}}');
    }
}
