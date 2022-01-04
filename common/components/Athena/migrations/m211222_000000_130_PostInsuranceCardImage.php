<?php

/**
 * Table for PostInsuranceCardImage
 */
class m211222_000000_130_PostInsuranceCardImage extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%post_insurance_card_images}}', [
            'departmentid' => $this->string(),
            'image' => $this->string()->notNull(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%post_insurance_card_images}}');
    }
}
