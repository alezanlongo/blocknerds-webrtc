<?php

namespace frontend\controllers;

use Yii;

class PatientController extends \yii\web\Controller
{
    private $component;

    function __construct($id, $module)
    {
        parent::__construct($id, $module);
        $this->component = Yii::$app->athenaComponent;
    }
    public function actionIndex()
    {
        echo $this->component->postClient();
    }
}
