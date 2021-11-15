<?php

/**
 * Table for PutLabResultClose
 */
class m211115_000000_079_PutLabResultClose extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%put_lab_result_closes}}', [
            'actionnote' => $this->string(),
            'actionreasonid' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%put_lab_result_closes}}');
    }
}
