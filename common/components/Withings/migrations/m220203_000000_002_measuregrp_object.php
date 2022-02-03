<?php

/**
 * Table for measuregrp_object
 */
class m220203_000000_002_measuregrp_object extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_measuregrp_objects}}', [
            'profile_id' => $this->integer(),
            'grpid' => $this->bigInteger(),
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
        $this->dropTable('{{%wth_measuregrp_objects}}');
    }
}
