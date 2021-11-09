<?php

/**
 * Table for Allergy
 */
class m211104_000000_048_Allergy extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%allergies}}', [
            'allergenid' => $this->integer(),
            'allergenname' => $this->string(),
            'deactivatedate' => $this->string(),
            'note' => $this->string(),
            'onsetdate' => $this->string(),
            'patientid' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%allergies}}');
    }
}