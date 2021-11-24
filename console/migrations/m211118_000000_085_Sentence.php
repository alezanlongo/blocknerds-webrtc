<?php

/**
 * Table for Sentence
 */
class m211118_000000_085_Sentence extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%sentences}}', [
            'sentencename' => $this->string(),
            'sentencenote' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%sentences}}');
    }
}
