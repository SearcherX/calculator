<?php

use yii\db\Migration;

/**
 * Class m240614_082402_fill_users_table
 */
class m240614_082402_fill_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('users',
            ['username', 'email', 'password_hash', 'status', 'auth_key'], $this->getUserData());
    }

    public function getUserData()
    {
        return [
            ['admin', 'admin@mail.ru', Yii::$app->security->generatePasswordHash('root'), 10,
                Yii::$app->security->generateRandomString()
            ],
            ['user1', 'newbie@mail.ru', Yii::$app->security->generatePasswordHash('123'), 10,
                Yii::$app->security->generateRandomString()
            ],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240614_082402_fill_users_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240614_082402_fill_users_table cannot be reverted.\n";

        return false;
    }
    */
}
