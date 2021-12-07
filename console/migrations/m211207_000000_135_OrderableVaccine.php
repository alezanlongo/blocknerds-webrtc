<?php

/**
 * Table for OrderableVaccine
 */
class m211207_000000_135_OrderableVaccine extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%orderable_vaccines}}', [
            'name' => $this->string(),
            'ordertypeid' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%orderable_vaccines}}');
    }
}
