<?php

use yii\db\Migration;

/**
 * Class m210811_155951_assessments
 */
class m210811_155951_assessments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('assessments', [
            'id'                    => $this->primaryKey(),
            'ext_id'                => $this->string(255)->null(),
            'assessmenttext'        => $this->string(255)->null(),
            'lastmodifiedby'        => $this->string(255)->null(),
            'lastmodifieddatatime'  => $this->string(255)->null(),
            'encounter_id'          => $this->integer()->null()
        ]);

        // creates index for column `author_id`
        $this->createIndex(
            'idx_assessments_01',
            'assessments',
            'encounter_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk_assessments_01',
            'assessments',
            'encounter_id',
            'encounters',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210811_155951_assessments cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210811_155951_assessments cannot be reverted.\n";

        return false;
    }
    */
}
