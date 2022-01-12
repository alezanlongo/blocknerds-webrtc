<?php

/**
 * Table for VaccineChanged
 */
class m220112_000000_065_VaccineChanged extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%vaccine_changeds}}', [
            'totalcount' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%vaccine_changeds}}');
    }
}
