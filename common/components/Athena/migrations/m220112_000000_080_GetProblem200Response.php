<?php

/**
 * Table for GetProblem200Response
 */
class m220112_000000_080_GetProblem200Response extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%get_problem200_responses}}', [
            'lastmodifiedby' => $this->string(),
            'lastmodifieddatetime' => $this->string(),
            'lastupdated' => $this->string(),
            'noknownproblems' => $this->string(),
            'notelastmodifiedby' => $this->string(),
            'notelastmodifieddatetime' => $this->string(),
            'sectionnote' => $this->string(),
            'totalcount' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%get_problem200_responses}}');
    }
}
