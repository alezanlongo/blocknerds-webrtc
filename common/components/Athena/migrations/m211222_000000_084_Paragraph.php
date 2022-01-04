<?php

/**
 * Table for Paragraph
 */
class m211222_000000_084_Paragraph extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%paragraphs}}', [
            'paragraphname' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%paragraphs}}');
    }
}
