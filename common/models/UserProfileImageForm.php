<?php

namespace common\models;

use common\models\User;
use common\models\UserProfile;
use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
class UserProfileImageForm extends Model
{
    public $image;
    public $rawimage;

    /**
     * 
     * @var UserProfile
     */
    public $userProfile;

    public function init()
    {
        $this->userProfile = Yii::$app->getUser()->getIdentity()->getUserProfile()->one();
    }

    public function rules()
    {
        return [
            ['rawimage', 'string', 'skipOnEmpty' => true],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, png, gif']
        ];
    }

    public function save()
    {
    }
}
