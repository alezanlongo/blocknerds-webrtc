<?php


namespace frontend\controllers;

use common\models\EditProfileForm;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\BaseFileHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\UploadedFile;

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
        $imageBack = $model->image;

        if ($model->load(Yii::$app->request->post()) ) {
            $model->validate();
            $image = UploadedFile::getInstance($model, 'image');

            if($image){
                $path = 'uploads' . DIRECTORY_SEPARATOR . Yii::$app->user->id;
                BaseFileHelper::createDirectory($path);
                $filename = $path . DIRECTORY_SEPARATOR . $image->baseName . '.' . $image->extension;
                $image->saveAs($filename);
                $model->image = $filename;
            }else{
                $model->image = $imageBack;
            }

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
