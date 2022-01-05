<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $email User's email address
 * @property string $firstname User's firstname
 * @property string $lastname User's lastname
 * @property string $shortname User's shortname
 * @property int $gender User's gender (0: man, 1: woman)
 * @property int $birthdate Unix timestamp of user's birthdate
 * @property string $preflang User's language preference. Examples: en_EN / en_US / de_DE / es_ES / fr_FR / it_IT / ja_JA / ko_KR / nl_NL / pt_PT / ru_RU / zh_CN
 * @property string $timezone User's timezone. Examples: "Europe/Paris" / "America/New_York". A complete list of all possible timezones can be found on the "TZ database name" column of this page : https://en.wikipedia.org/wiki/List_of_tz_database_time_zones
 * @property bool $mailingpref Specifies if user accepted Withings commercial contacts.
 * @property integer $unit_pref_id User's unit preferences (cf. [Unit preferences](#section/Models/Unit-preferences) model).
 * @property inline_response_200_19_body_user_unit_pref $unit_pref User's unit preferences (cf. [Unit preferences](#section/Models/Unit-preferences) model).
 * @property string $phonenumber User's phone number. *(Only if set)*
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class inline_response_200_19_body_user extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%inline_response_200_19_body_users}}';
    }

    public function rules()
    {
        return [
            [['email', 'firstname', 'lastname', 'shortname', 'preflang', 'timezone', 'phonenumber'], 'trim'],
            [['email', 'firstname', 'lastname', 'shortname', 'preflang', 'timezone', 'phonenumber'], 'string'],
            [['gender', 'birthdate', 'unit_pref_id', 'externalId', 'id'], 'integer'],
            [['mailingpref'], 'boolean'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getUnit_pref()
    {
        return $this->hasOne(inline_response_200_19_body_user_unit_pref::class, ['id' => 'unit_pref_id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($email = ArrayHelper::getValue($apiObject, 'email')) {
            $this->email = $email;
        }
        if($firstname = ArrayHelper::getValue($apiObject, 'firstname')) {
            $this->firstname = $firstname;
        }
        if($lastname = ArrayHelper::getValue($apiObject, 'lastname')) {
            $this->lastname = $lastname;
        }
        if($shortname = ArrayHelper::getValue($apiObject, 'shortname')) {
            $this->shortname = $shortname;
        }
        if($gender = ArrayHelper::getValue($apiObject, 'gender')) {
            $this->gender = $gender;
        }
        if($birthdate = ArrayHelper::getValue($apiObject, 'birthdate')) {
            $this->birthdate = $birthdate;
        }
        if($preflang = ArrayHelper::getValue($apiObject, 'preflang')) {
            $this->preflang = $preflang;
        }
        if($timezone = ArrayHelper::getValue($apiObject, 'timezone')) {
            $this->timezone = $timezone;
        }
        if($mailingpref = ArrayHelper::getValue($apiObject, 'mailingpref')) {
            $this->mailingpref = $mailingpref;
        }
        if($unit_pref_id = ArrayHelper::getValue($apiObject, 'unit_pref_id')) {
            $this->unit_pref_id = $unit_pref_id;
        }
        if($unit_pref = ArrayHelper::getValue($apiObject, 'unit_pref')) {
            $this->unit_pref = $unit_pref;
        }
        if($phonenumber = ArrayHelper::getValue($apiObject, 'phonenumber')) {
            $this->phonenumber = $phonenumber;
        }
        if($externalId = ArrayHelper::getValue($apiObject, 'externalId')) {
            $this->externalId = $externalId;
        }
        if($id = ArrayHelper::getValue($apiObject, 'id')) {
            $this->id = $id;
        }

        return $this;
    }
    
    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
    /* FIXME link doesn't work
    public function save($runValidation = true, $attributeNames = null) {
        $saved = parent::save($runValidation, $attributeNames);

        return $saved;
    }
    */
}
