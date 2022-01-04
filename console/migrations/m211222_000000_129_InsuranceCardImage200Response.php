<?php

/**
 * Table for InsuranceCardImage200Response
 */
class m211222_000000_129_InsuranceCardImage200Response extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%insurance_card_image200_responses}}', [
            'success' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%insurance_card_image200_responses}}');
    }
}
