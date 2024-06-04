<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%prices}}`.
 */
class m240530_133055_create_prices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        CREATE TABLE prices (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tonnage_id INT(11) UNSIGNED NOT NULL,
    month_id INT(11) UNSIGNED NOT NULL,
    raw_type_id INT(11) UNSIGNED NOT NULL,
    price INT(3) UNSIGNED NOT NULL,
    UNIQUE (tonnage_id, month_id, raw_type_id),
    FOREIGN KEY (tonnage_id) REFERENCES tonnages(id) ON UPDATE NO ACTION ON DELETE CASCADE,
    FOREIGN KEY (month_id) REFERENCES months(id) ON UPDATE NO ACTION ON DELETE CASCADE,
    FOREIGN KEY (raw_type_id) REFERENCES raw_types(id) ON UPDATE NO ACTION ON DELETE CASCADE
)
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%prices}}');
    }
}
