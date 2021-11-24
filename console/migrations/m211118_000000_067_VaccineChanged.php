<?php

/**
 * Table for VaccineChanged
 */
class m211118_000000_067_VaccineChanged extends \yii\db\Migration
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
