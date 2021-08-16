<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000015_create_care_plan_note_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%care_plan_note}}', [
            'id' => $this->primaryKey(),
            'note__authorReference' => $this->string(),
            'note__authorString' => $this->string(),
            'note__time' => $this->string(),
            'note__text' => $this->string(),
            'care_plan_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-note-care_plan_id',
            'care_plan_note',
            'care_plan_id',
            'care_plan',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%care_plan_note}}');
    }
}
