<?php

/**
 * Table for Department
 */
class m211115_000000_007_Department extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%departments}}', [
            'address' => $this->string(),
            'address2' => $this->string(),
            'chartsharinggroupid' => $this->string(),
            'city' => $this->string(),
            'clinicalproviderfax' => $this->string(),
            'clinicals' => $this->string(),
            'communicatorbrandid' => $this->string(),
            'creditcardtypes' => $this->string(),
            'departmentid' => $this->string(),
            'doesnotobservedst' => $this->string(),
            'ecommercecreditcardtypes' => $this->string(),
            'fax' => $this->string(),
            'ishospitaldepartment' => $this->string(),
            'latitude' => $this->string(),
            'longitude' => $this->string(),
            'medicationhistoryconsent' => $this->string(),
            'name' => $this->string(),
            'oneyearcontractmax' => $this->string(),
            'patientdepartmentname' => $this->string(),
            'phone' => $this->string(),
            'placeofservicefacility' => $this->string(),
            'placeofservicetypeid' => $this->string(),
            'placeofservicetypename' => $this->string(),
            'portalurl' => $this->string(),
            'providergroupid' => $this->string(),
            'providergroupname' => $this->string(),
            'providerlist' => $this->string(),
            'servicedepartment' => $this->string(),
            'singleappointmentcontractmax' => $this->string(),
            'state' => $this->string(),
            'timezone' => $this->string(),
            'timezonename' => $this->string(),
            'timezoneoffset' => $this->string(),
            'zip' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%departments}}');
    }
}
