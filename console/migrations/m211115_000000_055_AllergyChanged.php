<?php

/**
 * Table for AllergyChanged
 */
class m211115_000000_055_AllergyChanged extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%allergy_changeds}}', [
            'totalcount' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%allergy_changeds}}');
    }
}
