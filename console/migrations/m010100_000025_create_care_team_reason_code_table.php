<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000025_create_care_team_reason_code_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%care_team_reason_code}}', [
            'id' => $this->primaryKey(),
            'coding' => $this->json(),
            'text' => $this->string(),
            'care_team_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-reason_code-care_team_id',
            'care_team_reason_code',
            'care_team_id',
            'care_team',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%care_team_reason_code}}');
    }
}
