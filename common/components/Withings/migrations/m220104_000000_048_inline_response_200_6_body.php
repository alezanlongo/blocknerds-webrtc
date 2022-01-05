<?php

/**
 * Table for inline_response_200_6_body
 */
class m220104_000000_048_inline_response_200_6_body extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_6_bodies}}', [
            'invalid_address_customer_ref_ids' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_6_bodies}}');
    }
}
