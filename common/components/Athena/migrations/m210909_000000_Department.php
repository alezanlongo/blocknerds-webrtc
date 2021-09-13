<?php

/**
 * Table for Department
 */
class m210909_000000_Department extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%departments}}', [
            'address' => text,
            'address2' => text,
            'chartsharinggroupid' => text,
            'city' => text,
            'clinicalproviderfax' => text,
            'clinicals' => text,
            'communicatorbrandid' => text,
            'creditcardtypes' => text,
            'departmentid' => text,
            'doesnotobservedst' => text,
            'ecommercecreditcardtypes' => text,
            'fax' => text,
            'ishospitaldepartment' => text,
            'latitude' => text,
            'longitude' => text,
            'medicationhistoryconsent' => text,
            'name' => text,
            'oneyearcontractmax' => text,
            'patientdepartmentname' => text,
            'phone' => text,
            'placeofservicefacility' => text,
            'placeofservicetypeid' => text,
            'placeofservicetypename' => text,
            'portalurl' => text,
            'providergroupid' => text,
            'providergroupname' => text,
            'providerlist' => text,
            'servicedepartment' => text,
            'singleappointmentcontractmax' => text,
            'state' => text,
            'timezone' => text,
            'timezonename' => text,
            'timezoneoffset' => text,
            'zip' => text,
            'external_id' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('{{%departments}}');
    }
}
