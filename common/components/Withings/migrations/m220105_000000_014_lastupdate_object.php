<?php

/**
 * Table for lastupdate_object
 */
class m220105_000000_014_lastupdate_object extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%lastupdate_objects}}', [
            'measure' => $this->integer(),
            'externalId' => $this->integer(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%lastupdate_objects}}');
    }
}
