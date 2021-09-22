<?php
// Fidelizar el response que proviene del vardum de api de Michael contra el APIDOc (API de Athena)
// Nota a considerar: json_decode convierte el objeto JSON a arreglo PHP


// CASE: Create Patient
//array(1) { [0]=> array(1) { ["patientid"]=> string(5) "33906" } }

$arr = array();
$arr['patientid'] = '330645';
$json = json_encode([$arr]);
var_dump("Create Patient", json_decode($json, true));


// CASE: Create Insurance
// array(1) { [0]=> array(24) { ["insurancepolicyholdercountrycode"]=> string(3) "USA" ["sequencenumber"]=> int(1) ["insurancepolicyholderlastname"]=> string(2) "B2" ["insuredentitytypeid"]=> int(1) ["insuranceidnumber"]=> string(3) "123" ["relationshiptoinsured"]=> string(4) "Self" ["eligibilitystatus"]=> string(10) "Unverified" ["insurancepackageaddress1"]=> string(13) "PO BOX 182223" ["insurancepolicyholdersex"]=> string(1) "M" ["ircname"]=> string(5) "Cigna" ["insuranceplanname"]=> string(16) "CIGNA HEALTHCARE" ["insurancetype"]=> string(10) "Commercial" ["insurancephone"]=> string(14) "(800) 882-4462" ["insurancepackagestate"]=> string(2) "TN" ["insurancepackagecity"]=> string(11) "CHATTANOOGA" ["relationshiptoinsuredid"]=> int(1) ["insuranceid"]=> string(5) "22539" ["insurancepolicyholder"]=> string(5) "A1 B2" ["insurancepolicyholderfirstname"]=> string(2) "A1" ["insurancepackageid"]=> int(74) ["insurancepolicyholdercountryiso3166"]=> string(2) "US" ["ircid"]=> int(131) ["insuranceplandisplayname"]=> string(5) "Cigna" ["insurancepackagezip"]=> string(10) "37422-7223" } }

$arr = array();
$arr["insurancepolicyholdercountrycode"] =  "USA";
$arr["sequencenumber"] = 0;
$arr["insurancepolicyholderlastname"] =  "B2";
$arr["insuredentitytypeid"] = 0;
$arr["insuranceidnumber"] =  "123";
$arr["relationshiptoinsured"] =  "Self";
$arr["eligibilitystatus"] =  "Unverified";
$arr["insurancepackageaddress1"] =  "PO BOX 182223";
$arr["insurancepolicyholdersex"] =  "M";
$arr["ircname"] =  "Cigna";
$arr["insuranceplanname"] =  "CIGNA HEALTHCARE";
$arr["insurancetype"] =  "Commercial";
$arr["insurancephone"] =  "(800) 882-4462";
$arr["insurancepackagestate"] =  "TN";
$arr["insurancepackagecity"] =  "CHATTANOOGA";
$arr["relationshiptoinsuredid"] = 0;
$arr["insuranceid"] =  "22539";
$arr["insurancepolicyholder"] =  "A1 B2";
$arr["insurancepolicyholderfirstname"] =  "A1";
$arr["insurancepackageid"] = 0;
$arr["insurancepolicyholdercountryiso3166"] =  "US";
$arr["ircid"] = 0;
$arr["insuranceplandisplayname"] = "Cigna";
$arr["insurancepackagezip"] =  "37422-7223";

$json = json_encode([$arr]);
var_dump("Create Insurance", json_decode($json, true));


// CASE: Create Appointment
// array(2) { ["missingfields"]=> array(2) { [0]=> string(10) "providerid" [1]=> string(12) "departmentid" } ["error"]=> string(31) "Additional fields are required." }

$arr = array();
$arr["missingfields"] =  array("providerid", "departmentid");
$arr["error"] = "Additional fields are required.";
$json = json_encode([$arr]);
var_dump("Create Appointment", json_decode($json, true));


// CASE: Book Appointment for the Patient
// array(1) { [0]=> array(12) { ["date"]=> string(10) "10/10/2021" ["appointmentid"]=> string(7) "1195761" ["starttime"]=> string(5) "02:02" ["departmentid"]=> string(3) "102" ["appointmentstatus"]=> string(1) "f" ["patientid"]=> string(5) "33909" ["duration"]=> int(30) ["appointmenttypeid"]=> string(2) "62" ["appointmenttype"]=> string(7) "Consult" ["providerid"]=> string(2) "24" ["chargeentrynotrequired"]=> bool(false) ["patientappointmenttypename"]=> string(18) "Consultation Visit" } }

$arr = array();
$arr["date"] = "10/10/2021";
$arr["appointmentid"] = "1195761";
$arr["starttime"] = "02:02";
$arr["departmentid"] = "102";
$arr["appointmentstatus"] = "f";
$arr["patientid"] = "33909";
$arr["duration"] = 0;
$arr["appointmenttypeid"] = "62";
$arr["appointmenttype"] = "Consult";
$arr["providerid"] = "24";
$arr["chargeentrynotrequired"] = false;
$arr["patientappointmenttypename"] = "Consultation Visit";

$json = json_encode([$arr]);
var_dump("Book Appointment for the Patient", json_decode($json, true));



// CASE: Start Checkin
// array(1) { ["success"]=> bool(true) }

$arr = array();
$arr['success'] = true;
$json = json_encode($arr);
var_dump("Start Checkin", json_decode($json, true));



// CASE: Checkin
// array(2) { ["detailedmessage"]=> string(57) "The appointment is either already canceled or checked in." ["error"]=> string(45) "This appointment has already been checked in." }
$arr = array();
$arr["detailedmessage"] = "The appointment is either already canceled or checked in.";
$arr["error"] = "This appointment has already been checked in.";
$json = json_encode($arr);
var_dump("Checkin", json_decode($json, true));


// CASE: Encounter Created and Update
// array(2) { ["encounters"]=> array(1) { [0]=> array(17) { ["encountertype"]=> string(5) "VISIT" ["patientstatusid"]=> int(1) ["stage"]=> string(6) "INTAKE" ["status"]=> string(4) "OPEN" ["appointmentstartdate"]=> string(25) "2021-10-10T02:02:00-04:00" ["appointmentid"]=> int(1195761) ["patientlocationid"]=> int(21) ["departmentid"]=> int(102) ["providerid"]=> int(24) ["encounterdate"]=> string(10) "10/10/2021" ["encountervisitname"]=> string(7) "Consult" ["patientlocation"]=> string(12) "Waiting Room" ["providerlastname"]=> string(9) "McDermott" ["encounterid"]=> int(41252) ["lastupdated"]=> string(10) "09/22/2021" ["providerfirstname"]=> string(8) "Vivienne" ["patientstatus"]=> string(15) "Ready For Staff" } } ["totalcount"]=> int(1) }

$arr = array();
$arr["encounters"] = array(
    array(
        "encountertype" => "VISIT",
        "patientstatusid" => 0,
        "stage" => "INTAKE",
        "status" => "OPEN",
        "appointmentstartdate" => "2021-10-10T02:02:00-04:00",
        "appointmentid" => 1195761,
        "patientlocationid" => 21,
        "departmentid" => 102,
        "providerid" => 24,
        "encounterdate" => "10/10/2021",
        "encountervisitname" => "Consult",
        "patientlocation" => "Waiting Room",
        "providerlastname" => "McDermott",
        "encounterid" => 41252,
        "lastupdated" => "09/22/2021",
        "providerfirstname" => "Vivienne",
        "patientstatus" => "Ready For Staff"
    )
);
$arr["totalcount"] = 1;
$json = json_encode($arr);
var_dump("Checkin", json_decode($json, true));
