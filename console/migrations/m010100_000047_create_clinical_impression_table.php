<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000047_create_clinical_impression_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%clinical_impression}}', [
            'id' => $this->primaryKey(),
            'ext_id' => $this->integer(),
            'patient__display' => $this->json(),
            'patient__reference' => $this->string(),
            'assessor__display' => $this->json(),
            'assessor__reference' => $this->string(),
            'status' => $this->string(),
            'date' => $this->string(),
            'description' => $this->string(),
            'previous__display' => $this->json(),
            'previous__reference' => $this->string(),
            'problem__display' => $this->json(),
            'problem__reference' => $this->string(),
            'triggerCodeableConcept__coding' => $this->json(),
            'triggerCodeableConcept__text' => $this->string(),
            'triggerReference__display' => $this->json(),
            'triggerReference__reference' => $this->string(),
            'protocol' => $this->string(),
            'summary' => $this->string(),
            'prognosis' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%clinical_impression}}');
    }
}
