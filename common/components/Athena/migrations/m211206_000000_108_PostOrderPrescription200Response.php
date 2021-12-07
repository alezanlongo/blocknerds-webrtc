<?php

/**
 * Table for PostOrderPrescription200Response
 */
class m211206_000000_108_PostOrderPrescription200Response extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%post_order_prescription200_responses}}', [
            'documentid' => $this->integer(),
            'errormessage' => $this->string(),
            'success' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%post_order_prescription200_responses}}');
    }
}
