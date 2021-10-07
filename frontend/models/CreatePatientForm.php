<?php

namespace frontend\models;

use Yii;
use yii\base\Model;


class CreatePatientForm extends Model
{
    public $name;
    public $lastname;
    public $birthdayDate;
    public $department;
    public $email;
}
