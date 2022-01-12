<?php

/**
 * Table for InsuranceCardImage
 */
class m220112_000000_131_InsuranceCardImage extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%insurance_card_images}}', [
            'image' => $this->string(),
            'insuranceid' => $this->integer(),
            'patientInsurance_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-patientInsurance-patientInsurance_id',
            '{{%insurance_card_images}}',
            'patientInsurance_id',
            'patient_insurances',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%insurance_card_images}}');
    }
}
