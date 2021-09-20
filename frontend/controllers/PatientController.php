<?php

namespace frontend\controllers;

use Yii;
use common\components\Athena\models\Patient;

class PatientController extends \yii\web\Controller
{
    private $component;

    function __construct($id, $module)
    {
        parent::__construct($id, $module);
        $this->component = Yii::$app->athenaComponent;
        $this->component->setPracticeid(195900);
    }
    public function actionIndex()
    {
        $model = new Patient;

        if ($model->load(Yii::$app->request->post())) {
            $model = $this->component->createPatient(
                $model
            );

            $model->save();

        }

        return $this->render('create', [
            'model' => $model,
            'departments' => $this->component->getDepartments(true),
        ]);
    }
}
