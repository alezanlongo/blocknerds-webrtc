<?php

namespace common\models;

use yii\base\Model;

class UnsplashForm extends Model
{
    public $search;

    public function rules()
    {
        return [
            [['search'], 'string', 'max' => 255],
        ];
    }

}
