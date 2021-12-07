<?php

/**
 * Table for Finding
 */
class m211206_000000_082_Finding extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%findings}}', [
            'findingname' => $this->string(),
            'findingnote' => $this->string(),
            'findingtype' => $this->string(),
            'freetext' => $this->string(),
            'selectedoptions' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%findings}}');
    }
}
