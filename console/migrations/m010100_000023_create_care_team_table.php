<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000023_create_care_team_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%care_team}}', [
            'id' => $this->primaryKey(),
            'ext_id' => $this->integer(),
            'identifier__system' => $this->string(),
            'identifier__use' => $this->string(),
            'identifier__value' => $this->string(),
            'status' => $this->string(),
            'name' => $this->string(),
            'participant__member__display' => $this->string(),
            'participant__member__reference' => $this->string(),
            'participant__role__coding' => $this->json(),
            'participant__role__text' => $this->string(),
            'participant__period__start' => $this->json(),
            'participant__period__end' => $this->string(),
            'subject__display' => $this->string(),
            'subject__reference' => $this->string(),
            'encounter__display' => $this->string(),
            'encounter__reference' => $this->string(),
            'period__start' => $this->string(),
            'period__end' => $this->string(),
            'text__div' => $this->string(),
            'text__status' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%care_team}}');
    }
}
