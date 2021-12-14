<?php

/**
 * Table for OrderableImaging
 */
class m211214_000000_126_OrderableImaging extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%orderable_imagings}}', [
            'name' => $this->string(),
            'ordertypeid' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%orderable_imagings}}');
    }
}
