<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%member}}`.
 */
class m210721_212024_add_token_column_to_member_table extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%member}}', 'token', 'uuid DEFAULT uuid_generate_v4() UNIQUE NOT NULL');
        $this->createIndex(
                '{{%idx-member-token}}',
                '{{%member}}',
                'token',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%member}}', 'token');
    }

}
