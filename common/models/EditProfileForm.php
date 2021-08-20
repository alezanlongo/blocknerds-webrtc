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
    public $image;
    public $email;
    public $password;
    public $confirm_password;

    private $user;

    public function rules()
    {
        return [
            [['username', 'email', 'password', 'confirm_password'], 'required'],
            ['password', 'string', 'min' => 6],
            ['email', 'email'],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
            ['username', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'username', 'message' => "Username already exists", 'when' => function ($model, $attribute) {
                return Yii::$app->getUser()->getIdentity()->$attribute !== $model->$attribute;
            }],
            ['email', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'email', 'message' => "Email already exists", 'when' => function ($model, $attribute) {
                return Yii::$app->getUser()->getIdentity()->$attribute !== $model->$attribute;
            }],
            ['image', 'file', 'skipOnEmpty' => true],

        ];
    }

    public function __construct()
    {
        $this->user = $this->getUserLogged();
        $this->username = $this->user->username;
        $this->image = $this->user->image;
        $this->email = $this->user->email;
        $this->password = '';
        $this->confirm_password = '';
    }


    public function save()
    {
        try {
            $this->user->username = $this->username;
            $this->user->email = $this->email;
            $this->user->image = $this->image;
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
            ->select('id, username, email, image')
            ->where(['id' => Yii::$app->getUser()->getId()])
            ->limit(1)->one();
    }
}
