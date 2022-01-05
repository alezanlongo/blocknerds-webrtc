<?php

/**
 * Table for measuregrp_object
 */
class m220104_000000_002_measuregrp_object extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%measuregrp_objects}}', [
            'grpid' => $this->integer(),
            'attrib' => $this->integer(),
            'date' => $this->integer(),
            'created' => $this->integer(),
            'category' => $this->integer(),
            'deviceid' => $this->string(),
            'comment' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%measuregrp_objects}}');
    }
}
