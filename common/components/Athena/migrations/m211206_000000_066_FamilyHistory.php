<?php

/**
 * Table for FamilyHistory
 */
class m211206_000000_066_FamilyHistory extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%family_histories}}', [
            'description' => $this->string(),
            'diedofage' => $this->integer(),
            'note' => $this->string(),
            'onsetage' => $this->integer(),
            'patientid' => $this->integer(),
            'problemid' => $this->integer(),
            'relation' => $this->string(),
            'relationkeyid' => $this->integer(),
            'resolvedage' => $this->integer(),
            'snomedcode' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%family_histories}}');
    }
}
