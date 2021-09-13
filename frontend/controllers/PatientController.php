<?php

namespace frontend\controllers;

use Yii;
use frontend\AthenaClient;

class PatientController extends \yii\web\Controller
{
    private $client;

    function __construct($id, $module, AthenaClient $client)
    {
        parent::__construct($id, $module);
        $this->client = $client;
    }
    public function actionIndex()
    {
        echo $this->client->postClient();
    }
}
