<?php

/**
 * Table for PostProblem200Response
 */
class m211118_000000_081_PostProblem200Response extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%post_problem200_responses}}', [
            'errormessage' => $this->string(),
            'problemid' => $this->string(),
            'success' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%post_problem200_responses}}');
    }
}
