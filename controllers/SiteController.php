<?php

namespace app\controllers;

use app\models\ChangePasswordForm;
use app\models\forms\UserRecover;
use app\models\Program;
use app\models\ProgramObjects;
use app\models\User;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\rbac\PhpManager;
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
    public function actionLp(){
        $users = User::find()->all();
        foreach ($users as $user){
            $rbac = new PhpManager();
            $rbac->revokeAll($user->id);
            $rbac->assign($rbac->getRole('user'),$user->id);
            $rbac->assign($rbac->getPermission('dev_program'),$user->id);
        }
    }
    public function actionLL(){
        $signer = new Sha256();

        $token = (new Builder())->set('reference', 'user')
            ->sign($signer, 'example_key233')
            ->getToken();

        $response_token = file_get_contents("http://api.xn--80apneeq.xn--p1ai/api.php?option=reference_api&action=get_reference&module=constructor&reference_token=$token");

        $signer = new Sha256();
        $token = (new Parser())->parse($response_token);
        $user = null;
        if($token->verify($signer, 'example_key233')) {
            $data_reference = $token->getClaims();
            foreach ($data_reference as $ias_user){
                $user = User::findOne(['username' => $ias_user->getValue()->login]);

                if (!$user)
                    $user = new User();
                $user->id_org = $ias_user->getValue()->podved_id;;
                $user->username = $ias_user->getValue()->login;
                $user->auth_key = Yii::$app->getSecurity()->generateRandomString();
                $user->setPassword($ias_user->getValue()->pwd);
                $user->status = 10;
                $user->save(false);

                $rbac = new PhpManager();
                $role = 'user';
                switch ($ias_user->getValue()->access){
                    case 'user':
                    case 'podved':
                    case 'other_podved':{
                        $role = 'user';
                        break;
                    }
                    case 'admin':{
                        $role='root';
                    }
                }
                print_r($user->username);

                echo " ";
                $rbac->revokeAll($user->id);
                $rbac->assign($rbac->getRole($role),$user->id);
                $rbac->assign($rbac->getPermission('dev_program'),$user->id);
                print_r($role);
                echo "\n";
                //ss
            }
        }
    }

    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();
        $success = -1;
        if ( $model->load(Yii::$app->request->post()))
        {
            $success = $model->change_password();
        }
        echo Json::encode($success);
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
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
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
    public function actionKek(){
        $p = ProgramObjects::find()->all();
        foreach ($p as $item) {
            if ($item->id_priority > 3)
                $item->id_priority = 1;
            if ($item->wear > 4)
                $item->wear = 1;
            if (isset($item->prav_sob) and !($item->prav_sob=='fast' || $item->prav_sob=='others'))
                $item->prav_sob = 'fast';
            $item->save(false);
        }
    }

}
