<?php

use yii\db\Migration;

/**
 * Class m210729_194334_remove_status_column_to_member_table
 */
class m210729_194334_remove_status_column_to_member_table extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%member}}', 'status');
    }

    public function down()
    {
        $this->addColumn('{{%member}}', 'status', $this->smallInteger()->notNull()->defaultValue(2));
    }
}
