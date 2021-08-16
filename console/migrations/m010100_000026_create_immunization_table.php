<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000026_create_immunization_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%immunization}}', [
            'id' => $this->primaryKey(),
            'ext_id' => $this->integer(),
            'identifier__system' => $this->string(),
            'identifier__use' => $this->string(),
            'identifier__value' => $this->string(),
            'status' => $this->string(),
            'date' => $this->string(),
            'expiration_date' => $this->string(),
            'patient__display' => $this->string(),
            'patient__reference' => $this->string(),
            'reported' => $this->string(),
            'vaccinecode__coding' => $this->json(),
            'vaccinecode__text' => $this->string(),
            'wasNotGiven' => $this->boolean(),
            'reported' => $this->boolean(),
            'lotNumber' => $this->string(),
            'expirationDate' => $this->string(),
            'site__coding' => $this->json(),
            'site__text' => $this->string(),
            'route__coding' => $this->json(),
            'route__text' => $this->string(),
            'doseQuantity' => $this->json(),
            'explanation__reason' => $this->json(),
            'explanation__reasonNotGiven' => $this->json(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%immunization}}');
    }
}
