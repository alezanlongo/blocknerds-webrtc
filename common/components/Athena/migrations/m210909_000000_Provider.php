<?php

/**
 * Table for Provider
 */
class m210909_000000_Provider extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%providers}}', [
            'acceptingnewpatientsyn' => text,
            'ansinamecode' => text,
            'ansispecialtycode' => text,
            'billable' => text,
            'createencounteroncheckinyn' => text,
            'createencounterprovideridlist' => text,
            'displayname' => text,
            'entitytype' => text,
            'federalidnumber' => text,
            'firstname' => text,
            'hideinportalyn' => text,
            'homedepartment' => text,
            'lastname' => text,
            'npi' => integer,
            'otherprovideridlist' => text,
            'personalpronouns' => text,
            'providergrouplist' => text,
            'providerid' => integer,
            'providertype' => text,
            'providertypeid' => text,
            'providerusername' => text,
            'scheduleresourcetype' => text,
            'schedulingname' => text,
            'sex' => text,
            'specialty' => text,
            'specialtyid' => integer,
            'supervisingproviderid' => integer,
            'supervisingproviderusername' => text,
            'usualdepartmentid' => integer,
            'external_id' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('{{%providers}}');
    }
}
