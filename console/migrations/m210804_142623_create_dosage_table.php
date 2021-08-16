<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%dosage}}`.
 */
class m210804_142623_create_dosage_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%dosage}}', [
            'id' => $this->primaryKey(),
            'route__coding__coding' => $this->json(),
            'route__coding__text' => $this->string(),
            'route__text' => $this->string(),
            'text' => $this->string(),
            'timing__event' => $this->json(),
            'timing__repeat__frequency' => $this->integer(),
            'timing__repeat__period' => $this->integer(),
            'timing__repeat__periodunits' => $this->string(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%dosage}}');
    }
}
