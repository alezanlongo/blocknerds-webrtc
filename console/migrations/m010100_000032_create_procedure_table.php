<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000032_create_procedure_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%procedure}}', [
            'id' => $this->primaryKey(),
            'ext_id' => $this->integer(),
            'identifier__system' => $this->string(),
            'identifier__use' => $this->string(),
            'identifier__value' => $this->string(),
            'status' => $this->string(),
            'notPerformed' => $this->json(),
            'code__coding' => $this->json(),
            'code__text' => $this->string(),
            'category__coding' => $this->json(),
            'category__text' => $this->string(),
            'performedDatetime' => $this->string(),
            'subject__display' => $this->json(),
            'subject__reference' => $this->string(),
            'reasonCodeableConcept__coding' => $this->json(),
            'reasonCodeableConcept__text' => $this->string(),
            'performedDateTime' => $this->string(),
            'performedPeriod__start' => $this->string(),
            'performedPeriod__end' => $this->string(),
            'outcome__coding' => $this->json(),
            'outcome__text' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%procedure}}');
    }
}
