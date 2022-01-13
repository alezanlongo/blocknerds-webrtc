<?php

/**
 * Table for inline_response_200
 */
class m220113_000000_015_inline_response_200 extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200s}}', [
            'status' => $this->integer(),
            'body_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-body-body_id',
            '{{%inline_response_200s}}',
            'body_id',
            'bodies',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200s}}');
    }
}
