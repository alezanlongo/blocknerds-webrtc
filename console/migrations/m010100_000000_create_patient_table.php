<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000000_create_patient_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%patient}}', [
            'id' => $this->primaryKey(),
            'ext_id' => $this->integer(),
            'identifier__system' => $this->string(),
            'identifier__use' => $this->string(),
            'identifier__value' => $this->string(),
            'active' => $this->boolean(),
            'name__family' => $this->string(),
            'name__given' => $this->string(),
            'name__use' => $this->string(),
            'telecom__system' => $this->string(),
            'telecom__use' => $this->string(),
            'telecom__value' => $this->string(),
            'gender' => $this->string(),
            'birthDate' => $this->string(),
            'deceasedBoolean' => $this->boolean(),
            'deceasedDateTime' => $this->string(),
            'multipleBirthBoolean' => $this->boolean(),
            'multipleBirthInteger' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%patient}}');
    }
}
