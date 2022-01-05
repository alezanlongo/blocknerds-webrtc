<?php

/**
 * Table for inline_response_200_19_body_user_unit_pref
 */
class m220104_000000_068_inline_response_200_19_body_user_unit_pref extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_19_body_user_unit_prefs}}', [
            'weight' => $this->integer(),
            'height' => $this->integer(),
            'temperature' => $this->integer(),
            'distance' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_19_body_user_unit_prefs}}');
    }
}
