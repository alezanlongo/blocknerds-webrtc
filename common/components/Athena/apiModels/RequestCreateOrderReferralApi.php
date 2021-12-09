<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $diagnosissnomedcode The SNOMED code for diagnosis this order is for.
 * @property int $facilityid The athena ID of the facility you want to send the order to. Get a localized list using /chart/configuration/facilities.
 * @property string $facilitynote A note to send to the facility.
 * @property string $futuresubmitdate The date the order should be sent. Defaults to today.
 * @property bool $highpriority If true, then the order should be sent STAT.
 * @property string $notetopatient If this referral has a field for 'Notes to Patient' you may fill it in with this parameter.  If the referral does not have this field available, this will error.
 * @property int $ordertypeid The athena ID of the referral type.
 * @property string $procedurecode If this referral has a field for 'Procedure Code' you may fill it in with this parameter.  If the referral does not have this field available, this will error.
 * @property string $providernote An internal note for the provider or staff.
 * @property string $reasonforreferral If this referral has a field for 'Reason for Referral' you may fill it in with this parameter.  If the referral does not have this field available, this will error.
 * @property string $startdate If this referral has a field for 'Start Date' you may fill it in with this parameter.  If the referral does not have this field available, this will error.
 */
class RequestCreateOrderReferralApi extends BaseApiModel
{

    public $diagnosissnomedcode;
    public $facilityid;
    public $facilitynote;
    public $futuresubmitdate;
    public $highpriority;
    public $notetopatient;
    public $ordertypeid;
    public $procedurecode;
    public $providernote;
    public $reasonforreferral;
    public $startdate;

    public function rules()
    {
        return [
            [['facilitynote', 'futuresubmitdate', 'notetopatient', 'procedurecode', 'providernote', 'reasonforreferral', 'startdate'], 'trim'],
            [['diagnosissnomedcode', 'ordertypeid'], 'required'],
            [['facilitynote', 'futuresubmitdate', 'notetopatient', 'procedurecode', 'providernote', 'reasonforreferral', 'startdate'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
