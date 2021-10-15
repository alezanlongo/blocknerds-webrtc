<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m210705_150004_add_athena_users
 */
class m210705_150004_add_athena_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $user = \Yii::createObject([
            'class'    => User::class,
            'username' => 'athena',
            'auth_key' =>  Yii::$app->getSecurity()->generateRandomString(),
            'password' => 'athena',
            'email'    => 'athena@example.com',
            'status' => 10,
            'verification_token' =>  Yii::$app->getSecurity()->generateRandomString(),
            'ext_practice_id' => 195900,
            'ext_provider_id' => 26,
            'ext_provider_username' => 'dfenick',
        ]);
        $user->insert();

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m210705_150004_add_athena_users cannot be reverted.\n";

        return true;
    }
}
