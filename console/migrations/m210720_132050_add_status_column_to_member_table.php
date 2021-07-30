<?php

use \yii\db\Migration;

class m210720_132050_add_status_column_to_member_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%member}}', 'status', $this->smallInteger()->notNull()->defaultValue(2));
    }

    public function down()
    {
        $this->dropColumn('{{%member}}', 'status');
    }
}
