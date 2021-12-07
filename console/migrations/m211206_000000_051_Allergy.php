<?php

/**
 * Table for Allergy
 */
class m211206_000000_051_Allergy extends \yii\db\Migration
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
