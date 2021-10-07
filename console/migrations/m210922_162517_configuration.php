<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%configuration}}`.
 */
class m210922_162517_configuration extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('{{%configuration}}', [
            'id'            => $this->primaryKey(),
            'type'          => $this->string(),
            'content'       => $this->json(),
            'practiceId'    => $this->integer()
        ]);
    }

    public function down()
    {
        echo "m210922_162517_configuration cannot be reverted.\n";

        return false;
    }
}
