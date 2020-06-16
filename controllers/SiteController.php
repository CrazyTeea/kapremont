<?php

namespace app\controllers;

use app\models\ChangePasswordForm;
use app\models\forms\UserRecover;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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

    /**
     * @return string|Response
     * @throws \yii\base\Exception
     */
    public function actionUserRecover(){
        $model = new UserRecover();
        if ($post = Yii::$app->request->post()){
            if ($model->load($post) and $model->resetFromIasmon())
                return $this->redirect(['login']);
        }
        return $this->render('userRecover',compact('model'));
    }


    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();
        $success = -1;
        if ( $model->load(Yii::$app->request->post()))
        {
            $success = $model->change_password();
        }
        return $this->render('change_password',compact('model','success'));
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if(Yii::$app->request->get('auth_token')) {

            $signer = new Sha256();
            $token = (new Parser())->parse(Yii::$app->request->get('auth_token'));
            if ($token->verify($signer, 'ias@mirea9884')) {
                $model->username = $token->getClaim("login");
                $model->password = $token->getClaim("password");
                if ($model->validate()) {
                    Yii::$app->user->login($model->getUser());


                    if (Yii::$app->user->can('root') or
                        Yii::$app->user->can('mgsu') or
                        Yii::$app->user->can('orglist_view') or
                        Yii::$app->user->can('faiv_admin') or
                        Yii::$app->user->can('dep') or
                        Yii::$app->user->can('dku')){
                        return $this->redirect(['/organization/list']);
                    }

                    return $this->goBack();
                }
                Yii::$app->session->setFlash("auth_error", "Ошибка входа!");
                return $this->redirect(['site/login']);
            }
        }
        else if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->user->can('root') or
                Yii::$app->user->can('mgsu') or
                Yii::$app->user->can('orglist_view') or
                Yii::$app->user->can('faiv_admin') or
                Yii::$app->user->can('dep') or
                Yii::$app->user->can('dku')){
                return $this->redirect(['/organization/list']);
            }
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

}
