<?php

/**
 * Table for VaccineChanged
 */
class m211109_000000_068_VaccineChanged extends \yii\db\Migration
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
