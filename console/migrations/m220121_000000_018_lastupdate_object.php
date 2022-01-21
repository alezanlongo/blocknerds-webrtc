<?php

/**
 * Table for lastupdate_object
 */
class m220121_000000_018_lastupdate_object extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_lastupdate_objects}}', [
            'measure' => $this->integer(),
            'externalId' => $this->integer(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%wth_lastupdate_objects}}');
    }
}
