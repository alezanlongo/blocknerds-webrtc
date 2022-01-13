<?php

/**
 * Table for inline_response_200_16_body_series
 */
class m220113_000000_064_inline_response_200_16_body_series extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_16_body_series}}', [
            'startdate' => $this->integer(),
            'enddate' => $this->integer(),
            'state' => $this->integer(),
            'hr_id' => $this->integer(),
            'rr_id' => $this->integer(),
            'snoring_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-hr-hr_id',
            '{{%inline_response_200_16_body_series}}',
            'hr_id',
            'hrs',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-rr-rr_id',
            '{{%inline_response_200_16_body_series}}',
            'rr_id',
            'rrs',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-snoring-snoring_id',
            '{{%inline_response_200_16_body_series}}',
            'snoring_id',
            'snorings',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_16_body_series}}');
    }
}
