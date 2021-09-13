<?php

namespace common\models;

use yii\base\Model;
use yii\web\UploadedFile;

class ChatForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $text;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => true ], //'extensions' => 'png, jpg'
        ];
    }

}
