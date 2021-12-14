<?php

/**
 * Table for ContraindicationReason
 */
class m211214_000000_062_ContraindicationReason extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%contraindication_reasons}}', [
            'code' => $this->string(),
            'codeset' => $this->string(),
            'description' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%contraindication_reasons}}');
    }
}
