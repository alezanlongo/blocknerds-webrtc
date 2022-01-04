<?php

/**
 * Table for VaccineDeclinedReason
 */
class m211222_000000_136_VaccineDeclinedReason extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%vaccine_declined_reasons}}', [
            'active' => $this->string(),
            'declinedreason' => $this->string(),
            'declinedreasonid' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%vaccine_declined_reasons}}');
    }
}
