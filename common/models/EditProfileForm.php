<?php

namespace common\models;

use Exception;
use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;

/**
 * Login form
 */
class EditProfileForm extends Model
{
    public $first_name;
    public $last_name;
    public $image;
    public $phone;
    public $username;
    public $email;
    public $password;
    public $confirm_password;
    public $timezone ;
    public $locale;

    private $profile;

    public function rules()
    {
        return [
            // [['username', 'email', 'first_name', 'last_name', 'password', 'confirm_password'], 'required'],
            // ['password', 'string', 'min' => 6],
            // ['email', 'email'],
            // ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
            // ['username', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'username', 'message' => "Username already exists", 'when' => function ($model, $attribute) {
            //     return Yii::$app->getUser()->getIdentity()->$attribute !== $model->$attribute;
            // }],
            // ['email', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'email', 'message' => "Email already exists", 'when' => function ($model, $attribute) {
            //     return Yii::$app->getUser()->getIdentity()->$attribute !== $model->$attribute;
            // }],
            ['image', 'file', 'skipOnEmpty' => true],
            ['phone', 'string', 'max'=>36],
            [['timezone', 'locale', 'first_name', 'last_name'], 'string'],
        ];
    }

    public function __construct()
    {
        $this->profile = $this->getProfileLogged();

        if (!$this->profile) {
            $this->profile = $this->createProfile();
        }

        // $user =  $this->profile->getUser()->one();
        // $this->username = $user->username;
        // $this->email = $user->email;
        $this->image = $this->profile->image;
        $this->phone = $this->profile->phone;
        $this->timezone = $this->profile->timezone;
        $this->locale = $this->profile->locale;
        $this->first_name = $this->profile->first_name;;
        $this->last_name = $this->profile->last_name;;
    }
    public function createProfile()
    {
        $newProfile = new UserProfile();
        $newProfile->user_id = Yii::$app->getUser()->getId();
        $newProfile->save();

        return $newProfile;
    }


    public function save()
    {
        try {
            // $user = $this->profile->getUser()->one();
            // $user->username = $this->username;
            // $user->email = $this->email;
            // $user->save();
            $this->profile->image = $this->image;
            $this->profile->phone = $this->phone;
            $this->profile->first_name = $this->first_name;
            $this->profile->last_name = $this->last_name;
            $this->profile->timezone = $this->timezone;
            $this->profile->locale = $this->locale;
            $this->profile->save();

            return true;
        } catch (Exception $err) {
            return false;
        }
    }

    private function getProfileLogged()
    {
        return UserProfile::find()
            // ->select('id, username, email, image')
            ->where(['user_id' => Yii::$app->getUser()->getId()])
            ->limit(1)->one();
    }
}
