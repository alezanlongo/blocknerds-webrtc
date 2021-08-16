<?php

use yii\db\Migration;

/**
 * Class m210811_153903_encounters
 */
class m210811_153903_encounters extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('encounters', [
            'id'                    => $this->primaryKey(),
            'ext_id'                => $this->string(255)->null(),
            'patient__display'      => $this->string(255)->null(),
            'patient__reference'    => $this->string(255)->null(),
            'status'                => $this->string(255)->null(),
            'resourcetype'          => $this->string(255)->null(),
            'class'                 => $this->string(255)->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210811_153903_encounters cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210811_153903_encounters cannot be reverted.\n";

        return false;
    }
    */
}
