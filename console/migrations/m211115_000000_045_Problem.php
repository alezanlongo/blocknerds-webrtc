<?php

/**
 * Table for Problem
 */
class m211115_000000_045_Problem extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%problems}}', [
            'bestmatchicd10code' => $this->string(),
            'code' => $this->string(),
            'codeset' => $this->string(),
            'deactivateddate' => $this->string(),
            'deactivateduser' => $this->string(),
            'lastmodifiedby' => $this->string(),
            'lastmodifieddatetime' => $this->string(),
            'mostrecentdiagnosisnote' => $this->string(),
            'name' => $this->string(),
            'problemid' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%problems}}');
    }
}
