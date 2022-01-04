<?php

/**
 * Table for Order
 */
class m211222_000000_109_Order extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%orders}}', [
            'class' => $this->string(),
            'classdescription' => $this->string(),
            'clinicalprovider' => $this->string(),
            'clinicalproviderid' => $this->integer(),
            'clinicalproviderordertype' => $this->string(),
            'clinicalproviderordertypeid' => $this->integer(),
            'createduser' => $this->string(),
            'dateordered' => $this->string(),
            'declinedreasontext' => $this->string(),
            'departmentid' => $this->integer(),
            'description' => $this->string(),
            'documentationonly' => $this->string(),
            'orderid' => $this->integer(),
            'orderingprovider' => $this->string(),
            'ordertype' => $this->string(),
            'ordertypeid' => $this->integer(),
            'priority' => $this->integer(),
            'providerid' => $this->integer(),
            'specimencollectionsite' => $this->string(),
            'status' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%orders}}');
    }
}
