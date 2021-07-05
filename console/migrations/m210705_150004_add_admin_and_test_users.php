<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m210705_150004_add_admin_and_test_users
 */
class m210705_150004_add_admin_and_test_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $userAdmin = \Yii::createObject([
            'class'    => User::class,
            'username' => 'admin',
            'auth_key' =>  Yii::$app->getSecurity()->generateRandomString(),
            'password' => '12345678',
            'email'    => 'admin@@example.com',
            'status' => 10,
            'verification_token' =>  Yii::$app->getSecurity()->generateRandomString(),
            'is_admin' => 1,
        ]);
        $userAdmin->insert();

        $user = \Yii::createObject([
            'class'    => User::class,
            'username' => 'test',
            'auth_key' =>  Yii::$app->getSecurity()->generateRandomString(),
            'password' => '12345678',
            'email'    => 'test@@example.com',
            'status' => 10,
            'verification_token' =>  Yii::$app->getSecurity()->generateRandomString(),
        ]);
        $user->insert();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210705_150004_add_admin_and_test_users cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210705_150004_add_admin_and_test_users cannot be reverted.\n";

        return false;
    }
    */
}
