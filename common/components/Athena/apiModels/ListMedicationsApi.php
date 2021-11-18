<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $lastdownloaddenialreason BETA FIELD: The reason the last medication history download was denied.
 * @property string $lastdownloaddenied BETA FIELD: Whether or not the last medication history download was denied.
 * @property string $lastdownloadeddate The time of the last attempted medication history download from SureScripts.
 * @property string $lastupdated The last time any of the medications were updated
 * @property array $medications The list of medications
 * @property string $nomedicationsreported Whether the patient explicitly has no reported medications
 * @property string $patientdownloadconsent Whether or not the patient has consented to have their medication history downloaded. There are plans to deprecate this field.
 * @property string $patientneedsdownloadconsent Whether or not the patient needs to consent to have medication history downloaded. This will be true if either the patient has not currently consented, or the practice is not enabled for these downloads.  This field is typically used when determining whether to message to the patient that they have not consented to these downloads. Note that regardless of this setting, medication history that has already been downloaded will remain available.
 * @property string $sectionnote A section-wide note
 */
class ListMedicationsApi extends BaseApiModel
{

    public $lastdownloaddenialreason;
    public $lastdownloaddenied;
    public $lastdownloadeddate;
    public $lastupdated;
    public $medications;
    public $nomedicationsreported;
    public $patientdownloadconsent;
    public $patientneedsdownloadconsent;
    public $sectionnote;

    public function rules()
    {
        return [
            [['lastdownloaddenialreason', 'lastdownloaddenied', 'lastdownloadeddate', 'lastupdated', 'nomedicationsreported', 'patientdownloadconsent', 'patientneedsdownloadconsent', 'sectionnote'], 'trim'],
            [['lastdownloaddenialreason', 'lastdownloaddenied', 'lastdownloadeddate', 'lastupdated', 'nomedicationsreported', 'patientdownloadconsent', 'patientneedsdownloadconsent', 'sectionnote'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
