<?php

/**
 * Table for dropshipment_createuserorder
 */
class m220203_000000_024_dropshipment_createuserorder extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_dropshipment_createuserorders}}', [
            'user_id' => $this->integer(),
            'invalid_address_customer_ref_ids' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-user-user_id',
            '{{%wth_dropshipment_createuserorders}}',
            'user_id',
            'wth_dropshipment_users',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%wth_dropshipment_createuserorders}}');
    }
}
