<?php

/**
 * Table for Provider
 */
class m211206_000000_010_Provider extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%providers}}', [
            'acceptingnewpatientsyn' => $this->string(),
            'ansinamecode' => $this->string(),
            'ansispecialtycode' => $this->string(),
            'billable' => $this->string(),
            'createencounteroncheckinyn' => $this->string(),
            'createencounterprovideridlist' => $this->string(),
            'displayname' => $this->string(),
            'entitytype' => $this->string(),
            'federalidnumber' => $this->string(),
            'firstname' => $this->string(),
            'hideinportalyn' => $this->string(),
            'homedepartment' => $this->string(),
            'lastname' => $this->string(),
            'npi' => $this->integer(),
            'otherprovideridlist' => $this->string(),
            'personalpronouns' => $this->string(),
            'providergrouplist' => $this->string(),
            'providerid' => $this->integer(),
            'providertype' => $this->string(),
            'providertypeid' => $this->string(),
            'providerusername' => $this->string(),
            'scheduleresourcetype' => $this->string(),
            'schedulingname' => $this->string(),
            'sex' => $this->string(),
            'specialty' => $this->string(),
            'specialtyid' => $this->integer(),
            'supervisingproviderid' => $this->integer(),
            'supervisingproviderusername' => $this->string(),
            'usualdepartmentid' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%providers}}');
    }
}
