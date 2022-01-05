<?php

/**
 * Table for inline_response_200_11
 */
class m220104_000000_026_inline_response_200_11 extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_11s}}', [
            'status' => $this->integer(),
            'body_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-body-body_id',
            '{{%inline_response_200_11s}}',
            'body_id',
            'bodies',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_11s}}');
    }
}
