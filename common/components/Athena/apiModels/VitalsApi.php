<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property EncounterVitals $encounterVital
 * @property string $abbreviation Short human-readable string for this vital group. E.g., Ht.
 * @property string $key Key for this vital group. E.g., HEIGHT.
 * @property int $ordering Configured order for this vital group
 * @property string $clinicalelementid Key used to identify this particular vital attribute
 * @property string $code Code indentifier for the reading.
 * @property string $codedescription Description of the code identifier.
 * @property string $codeset Codeset of the code.
 * @property string $createdby The athenaNet username of the person who entered the vital.
 * @property string $createddate The date this vital was entered into the chart. Returned in mm/dd/yyyy hh24:mi:ss format.
 * @property string $isgraphable Flag indicating if this vital is graphable.
 * @property object $percentilespec
 * @property int $readingid Numeric key used to tie related and distinguish separate readings. So the diastolic and systolic blood pressure should have the same readingid.
 * @property string $readingtaken Date that the reading was taken.
 * @property string $source The source of this reading.
 * @property int $sourceid External key to source.
 * @property string $unit Unit that describes this vital's value.
 * @property string $value The value of this reading. NOTE: for numeric values, the units are always in the 'native' units per the configuration.
 * @property int $vitalid Unique ID for this vital attribute reading. Used to update/delete this reading.
 */
class VitalsApi extends BaseApiModel
{

    public $encounterVital;
    public $abbreviation;
    public $key;
    public $ordering;
    public $clinicalelementid;
    public $code;
    public $codedescription;
    public $codeset;
    public $createdby;
    public $createddate;
    public $isgraphable;
    public $percentilespec;
    public $readingid;
    public $readingtaken;
    public $source;
    public $sourceid;
    public $unit;
    public $value;
    public $vitalid;

    public function rules()
    {
        return [
            [['abbreviation', 'key', 'clinicalelementid', 'code', 'codedescription', 'codeset', 'createdby', 'createddate', 'isgraphable', 'readingtaken', 'source', 'unit', 'value'], 'trim'],
            [['abbreviation', 'key', 'clinicalelementid', 'code', 'codedescription', 'codeset', 'createdby', 'createddate', 'isgraphable', 'readingtaken', 'source', 'unit', 'value'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
