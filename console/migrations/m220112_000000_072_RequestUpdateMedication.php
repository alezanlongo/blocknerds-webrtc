<?php

/**
 * Table for RequestUpdateMedication
 */
class m220112_000000_072_RequestUpdateMedication extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%request_update_medications}}', [
            'departmentid' => $this->integer()->notNull(),
            'hidden' => $this->boolean(),
            'patientnote' => $this->string(),
            'providernote' => $this->string(),
            'startdate' => $this->string(),
            'stopdate' => $this->string(),
            'stopreason' => $this->string(),
            'unstructuredsig' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%request_update_medications}}');
    }
}
