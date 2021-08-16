<?php

use yii\db\Migration;

/**
 * Class m210808_141111_devices
 */
class m210808_141111_devices extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('devices', [
            'id'                    => $this->primaryKey(),
            'ext_id'                => $this->string(255)->null(),
            'manufacter'            => $this->string(255)->null(),
            'model'                 => $this->string(255)->null(),
            'patient__display'      => $this->string(255)->null(),
            'patient__reference'    => $this->string(255)->null(),
            'resourcetype'          => $this->string(255)->null(),
            'type__coding'          => $this->json()->null(),
            'type__text'            => $this->string(255)->null(),
            'udi'                   => $this->string(255)->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210808_141111_devices cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210808_141111_devices cannot be reverted.\n";

        return false;
    }
    */
}
