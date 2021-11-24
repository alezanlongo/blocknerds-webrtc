<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $accessionid A unique identifier given to a document to track it over time.
 * @property array $analytes This is an array of hashes in JSON. Each entry contains information for a single analyte. See <a href="https://developer.athenahealth.com/docs/read/workflows/documents/Lab_Analytes">https://developer.athenahealth.com/docs/read/workflows/documents/Lab_Analytes</a> for an example.
 * @property int $documenttypeid A specific document type identifier.
 * @property int $facilityid The ID of the facility or clinical provider who received the order.
 * @property string $internalnote An internal note for the provider or staff. Updating this will append to any previous notes if replaceinternalnote is not set.
 * @property string $interpretation The practice entered interpretation of this result. Updating this will append to any previous values.
 * @property string $notetopatient This is a note specifically for the patient to view or action on. Updating this will append to any previous notes.
 * @property string $observationdate The date an observation was made (mm/dd/yyyy).
 * @property string $observationtime The time an observation was made (hh24:mi).  24 hour time.
 * @property string $priority Priority of this result.  1 is high; 2 is normal.
 * @property int $providerid The ID of the ordering provider.
 * @property bool $replaceinternalnote If true, will replace the existing internal note with the new one. If false, will append to the existing note.
 * @property bool $replacepatientnote If true, will replace the existing patient note with the new one. If false, will append to the existing note.
 * @property string $reportstatus The status of the report.
 * @property string $resultnotes Result notes of a document.
 * @property string $resultstatus The status of the result.
 * @property string $specimenreceiveddatetime Date-time indicating when the specimen was received in format (yyyy-mm-ddThh:mm:ss).
 * @property string $specimenreporteddatetime Date-time indicating when the specimen was reported in format (yyyy-mm-ddThh:mm:ss).
 * @property int $tietoorderid Tie the result document to this order.
 */
class PutLabResultApi extends BaseApiModel
{

    public $accessionid;
    public $analytes;
    public $documenttypeid;
    public $facilityid;
    public $internalnote;
    public $interpretation;
    public $notetopatient;
    public $observationdate;
    public $observationtime;
    public $priority;
    public $providerid;
    public $replaceinternalnote;
    public $replacepatientnote;
    public $reportstatus;
    public $resultnotes;
    public $resultstatus;
    public $specimenreceiveddatetime;
    public $specimenreporteddatetime;
    public $tietoorderid;

    public function rules()
    {
        return [
            [['accessionid', 'internalnote', 'interpretation', 'notetopatient', 'observationdate', 'observationtime', 'priority', 'reportstatus', 'resultnotes', 'resultstatus', 'specimenreceiveddatetime', 'specimenreporteddatetime'], 'trim'],
            [['accessionid', 'internalnote', 'interpretation', 'notetopatient', 'observationdate', 'observationtime', 'priority', 'reportstatus', 'resultnotes', 'resultstatus', 'specimenreceiveddatetime', 'specimenreporteddatetime'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
