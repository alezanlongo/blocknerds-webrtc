<?php

/**
 * Table for inline_response_200_7_body
 */
class m220104_000000_050_inline_response_200_7_body extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_7_bodies}}', [
            'user_id' => $this->integer(),
            'invalid_address_customer_ref_ids' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-user-user_id',
            '{{%inline_response_200_7_bodies}}',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_7_bodies}}');
    }
}
