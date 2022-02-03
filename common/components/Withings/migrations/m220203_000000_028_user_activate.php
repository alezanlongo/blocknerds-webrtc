<?php

/**
 * Table for user_activate
 */
class m220203_000000_028_user_activate extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_user_activates}}', [
            'user_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-user-user_id',
            '{{%wth_user_activates}}',
            'user_id',
            'wth_dropshipment_users',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%wth_user_activates}}');
    }
}
