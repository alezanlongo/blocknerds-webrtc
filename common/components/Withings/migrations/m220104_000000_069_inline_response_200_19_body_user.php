<?php

/**
 * Table for inline_response_200_19_body_user
 */
class m220104_000000_069_inline_response_200_19_body_user extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_19_body_users}}', [
            'email' => $this->string(),
            'firstname' => $this->string(),
            'lastname' => $this->string(),
            'shortname' => $this->string(),
            'gender' => $this->integer(),
            'birthdate' => $this->integer(),
            'preflang' => $this->string(),
            'timezone' => $this->string(),
            'mailingpref' => $this->boolean(),
            'unit_pref_id' => $this->integer(),
            'phonenumber' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-unit_pref-unit_pref_id',
            '{{%inline_response_200_19_body_users}}',
            'unit_pref_id',
            'unit_prefs',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_19_body_users}}');
    }
}
