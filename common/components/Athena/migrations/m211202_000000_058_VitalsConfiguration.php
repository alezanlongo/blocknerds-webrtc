<?php

/**
 * Table for VitalsConfiguration
 */
class m211202_000000_058_VitalsConfiguration extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%vitals_configurations}}', [
            'abbreviation' => $this->string(),
            'attributes' => $this->string(),
            'istiedtomeasurement' => $this->string(),
            'key' => $this->string(),
            'ordering' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%vitals_configurations}}');
    }
}