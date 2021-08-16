<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000030_create_allergy_intolerance_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%allergy_intolerance}}', [
            'id' => $this->primaryKey(),
            'ext_id' => $this->integer(),
            'identifier__system' => $this->string(),
            'identifier__use' => $this->string(),
            'identifier__value' => $this->string(),
            'onset' => $this->string(),
            'recordedDate' => $this->string(),
            'substance__coding' => $this->json(),
            'substance__text' => $this->string(),
            'status' => $this->string(),
            'criticality' => $this->string(),
            'type' => $this->string(),
            'category' => $this->string(),
            'last_occurence' => $this->string(),
            'note__authorReference' => $this->string(),
            'note__authorString' => $this->string(),
            'note__time' => $this->string(),
            'note__text' => $this->string(),
            'patient__display' => $this->string(),
            'patient__reference' => $this->string(),
            'text__div' => $this->json(),
            'text__status' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%allergy_intolerance}}');
    }
}
