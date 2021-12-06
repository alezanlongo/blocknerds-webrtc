<?php

/**
 * Table for AllergyChanged
 */
class m211202_000000_053_AllergyChanged extends \yii\db\Migration
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
