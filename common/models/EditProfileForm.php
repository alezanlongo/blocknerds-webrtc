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
    public $username;
    public $email;
    public $password;
    public $confirm_password;

    private $user;

    public function rules()
    {
        return [
            [['username', 'email', 'password', 'confirm_password'], 'required'],
            ['password', 'string', 'min' => 6],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
        ];
    }

    public function __construct()
    {
        $this->user = $this->getUserLogged();
        $this->username = $this->user->username;
        $this->email = $this->user->email;
        $this->password = '';
        $this->confirm_password = '';
    }


    public function save()
    {
        try {
            $this->user->username = $this->username;
            $this->user->email = $this->email;
            $this->user->setPassword($this->password);
            $this->user->status = User::STATUS_ACTIVE;
            $this->user->save();

            return true;
        } catch (Exception $err) {
            return false;
        }
    }

    private function getUserLogged()
    {
        return User::find()
            ->select('id, username,email')
            ->where(['id' => Yii::$app->getUser()->getId()])
            ->limit(1)->one();
    }
}
