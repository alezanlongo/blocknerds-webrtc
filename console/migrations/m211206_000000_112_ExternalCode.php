<?php

/**
 * Table for ExternalCode
 */
class m211206_000000_112_ExternalCode extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%external_codes}}', [
            'code' => $this->string(),
            'codeset' => $this->string(),
            'description' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%external_codes}}');
    }
}
