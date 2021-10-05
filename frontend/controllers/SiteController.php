<?php

namespace frontend\controllers;

use common\models\ChatForm;
use common\models\LoginForm;
use common\models\RoomMemberRepository;
use common\models\User;
use common\models\UserSetting;
use frontend\models\ContactForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;

use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\filters\AccessControl;
use yii\helpers\BaseFileHelper;
use yii\helpers\VarDumper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use const YII_ENV_TEST;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                "class" => AccessControl::class,
                "only" => ['logout', 'text-room', 'video-room-create'],
                "rules" => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionCreateVideoRoom()
    {
        $model = new \frontend\models\CreateVideoRoomForm();

        if ($this->request->getBodyParam('addUser') !== null) {
            $model->addMembers($this->request->getBodyParam('CreateVideoRoomForm')['addMembers'], $this->request->getBodyParam('CreateVideoRoomForm')['roomMembers']);
        }

        return $this->render('createVideoRoom', ['model' => $model]);
    }

    public function actionVideoRoom($roomUuid)
    {
        $token = RoomMemberRepository::getMemberTokenByRoom(Yii::$app->getUser()->getId(), $roomUuid);

        if (null === $token) {
            throw new NotFoundHttpException();
        }

        Yii::$app->janusApi->videoRoomCreate($token->room_id);
    }


    public function actionScreenSharing()
    {
        return $this->render('screenSharing');
    }

    public function actionTextRoom()
    {
        return $this->render('textRoom');
    }

    public function actionTextRoomMulti()
    {
        $users = User::find()->all();
        $model = new ChatForm();

        if (Yii::$app->request->isPost) {
            $userId = Yii::$app->getUser()->getId();
            // $model->load(Yii::$app->request->post());
            $model->text = Yii::$app->request->post('ChatForm')['text'];
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            $filename = "";

            if ($model->imageFile) {
                $path = 'uploads' . DIRECTORY_SEPARATOR . $userId;
                BaseFileHelper::createDirectory($path);
                $filename = $path . DIRECTORY_SEPARATOR . $model->imageFile->baseName . '.' . $model->imageFile->extension;
                $model->imageFile->saveAs($filename);
            }

            Yii::$app->response->format = Response::FORMAT_JSON;

            return ["data" => [
                'url' => $filename,
                'text' => $model->text,
            ]];
        }

        return $this->render(
            'textRoomMulti',
            [
                'users' => $users,
                'model' => $model,
            ]
        );
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    // {
    {
        // $res = UserSetting::setValue(Yii::$app->getUser()->getId(), 'view_mode2', 'calendar', 'month');
        // $res = UserSetting::getSetting(Yii::$app->getUser()->getId(), 'test', 'calendar');
        $res = \strtotime('2021-08-27 11:00:00');
        \var_dump($res,date('Y-m-d H:i:s','1630072316'));
        die;
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'adminlte/main-login';
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }
        // $this->layout = 'adminlte/main-login';
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }
        // $this->layout = 'adminlte/main-login';
        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}
