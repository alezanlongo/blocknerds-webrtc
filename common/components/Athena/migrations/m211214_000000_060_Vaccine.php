<?php

/**
 * Table for Vaccine
 */
class m211214_000000_060_Vaccine extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%vaccines}}', [
            'administerdate' => $this->string(),
            'administernote' => $this->string(),
            'administerroute' => $this->string(),
            'administerroutedescription' => $this->string(),
            'administersite' => $this->string(),
            'amount' => $this->float(),
            'approvedby' => $this->string(),
            'approveddate' => $this->string(),
            'chartsharinggroupid' => $this->integer(),
            'cvx' => $this->integer(),
            'declinedreasontext' => $this->string(),
            'deleteddate' => $this->string(),
            'description' => $this->string(),
            'enteredby' => $this->string(),
            'entereddate' => $this->string(),
            'expirationdate' => $this->string(),
            'genusname' => $this->string(),
            'lotnumber' => $this->string(),
            'mvx' => $this->string(),
            'ndc' => $this->string(),
            'orderedby' => $this->string(),
            'ordereddate' => $this->string(),
            'partiallyadministered' => $this->string(),
            'patientid' => $this->integer(),
            'prescribeddate' => $this->string(),
            'refuseddate' => $this->string(),
            'refusednote' => $this->string(),
            'refusedreason' => $this->string(),
            'status' => $this->string(),
            'submitdate' => $this->string(),
            'units' => $this->string(),
            'vaccinator' => $this->string(),
            'vaccineid' => $this->string(),
            'vaccinetype' => $this->string(),
            'visgivendate' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%vaccines}}');
    }
}
