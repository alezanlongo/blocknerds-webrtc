<?php


namespace frontend\controllers;

use common\models\EditProfileForm;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\Controller;

class UserController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                "class" => AccessControl::class,
                "only" => ['index', "edit-profile"],
                "rules" => [
                    [
                        'allow' => true,
                        'roles' => ["@"],
                    ]
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        # code...
    }

    public function actionEditProfile()
    {

        $model = new EditProfileForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Profile successfully updated.');
            } else{
                Yii::$app->session->setFlash('error', 'Error updating profile.');
            }

            return $this->redirect(['user/edit-profile']);
        } 
        
        return $this->render(
            'edit',
            [
                "model" => $model
            ]
        );
    }
}
