<?php

/**
 * Table for ReferralOrderType
 */
class m220112_000000_140_ReferralOrderType extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%referral_order_types}}', [
            'name' => $this->string(),
            'ordertypeid' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%referral_order_types}}');
    }
}
