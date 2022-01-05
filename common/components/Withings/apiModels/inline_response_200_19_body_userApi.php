<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $email User's email address
 * @property string $firstname User's firstname
 * @property string $lastname User's lastname
 * @property string $shortname User's shortname
 * @property int $gender User's gender (0: man, 1: woman)
 * @property int $birthdate Unix timestamp of user's birthdate
 * @property string $preflang User's language preference. Examples: en_EN / en_US / de_DE / es_ES / fr_FR / it_IT / ja_JA / ko_KR / nl_NL / pt_PT / ru_RU / zh_CN
 * @property string $timezone User's timezone. Examples: "Europe/Paris" / "America/New_York". A complete list of all possible timezones can be found on the "TZ database name" column of this page : https://en.wikipedia.org/wiki/List_of_tz_database_time_zones
 * @property bool $mailingpref Specifies if user accepted Withings commercial contacts.
 * @property inline_response_200_19_body_user_unit_pref $unit_pref User's unit preferences (cf. [Unit preferences](#section/Models/Unit-preferences) model).
 * @property string $phonenumber User's phone number. *(Only if set)*
 */
class inline_response_200_19_body_userApi extends BaseApiModel
{

    public $email;
    public $firstname;
    public $lastname;
    public $shortname;
    public $gender;
    public $birthdate;
    public $preflang;
    public $timezone;
    public $mailingpref;
    public $unit_pref;
    public $phonenumber;

    public function rules()
    {
        return [
            [['email', 'firstname', 'lastname', 'shortname', 'preflang', 'timezone', 'phonenumber'], 'trim'],
            [['email', 'firstname', 'lastname', 'shortname', 'preflang', 'timezone', 'phonenumber'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
