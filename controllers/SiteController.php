<?php

namespace app\controllers;

use app\models\ChangePasswordForm;
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
            $item->regulation = $item->podrobnosti;
            $item->save(false);
        }
        /*$id_org = [
            14,
            20,
            77,
            78,
            84,
            88,
            112,
            119,
            146,
            153,
            170,
            171,
            179,
            182,
            210,
            221,
            230,
            249,
        ];
        $fin = [
            53785.97,
            35700.31,
            28478.23,
            84154.60,
            29786.87,
            30815.02,
            43938.30,
            34045.50,
            17238.38,
            32623.50,
            21354.51,
            57880.20,
            61734.10,
            70262.90,
            37795.80,
            31058.79,
            18625.78,
            22517.26
        ];
        $kek = Program::find()->where(['id_org'=>$id_org])->orderBy(['id_org'=>SORT_ASC])->all();
        foreach ($kek as $k=> $item){
            //var_dump($item->id_org);
            $item->finance_volume = $fin[$k];
            $item->save();
        }*/
    }
    public function actionUsers(){
        echo "Выполняется синхронизация пользователей\n";
        $timestart = time();
        $err = 0;
        $signer = new Sha256();
        $token = (new Builder())->set('reference', 'user')
            ->sign($signer, 'example_key233')
            ->getToken();

        $response_token = file_get_contents("http://api.xn--80apneeq.xn--p1ai/api.php?option=reference_api&action=get_reference&module=constructor&reference_token=$token");

        $signer = new Sha256();
        $token = (new Parser())->parse($response_token);
        if($token->verify($signer,'example_key233')){
            $data_reference = $token->getClaims();
            foreach ($data_reference AS $key=>$data){

                $row_user = User::findOne(["username"=>$data->getValue()->login]);

                if(!$row_user) {
                    $row_user = new User();
                    $row_user->created_at = time();
                }
                $row_user->username = $data->getValue()->login;
                $row_user->auth_key = Yii::$app->security->generateRandomString();
                $row_user->password_hash = Yii::$app->security->generatePasswordHash($data->getValue()->pwd,4);
                $row_user->fio = $data->getValue()->name;
                $row_user->updated_at = time();
                // $data->getValue()->position;
                //$row_user->position = $data->getValue()->position;
                $row_user->id_org = ($data->getValue()->podved_id!="")?$data->getValue()->podved_id:NULL;
                $str = ($row_user->isNewRecord) ? 'добавление' : 'обновление';
                if(!$row_user->save()){
                    $err++;

                }
                $role = new PhpManager();

                $role->revokeAll($row_user->id);
                $role->assign($role->getRole('root'),$row_user->id);
                $role->assign($role->getPermission('dev_program'),$row_user->id);

            }

            if($err>0){
                return false;
            }else {
                return true;
            }
        }else{
            return false;
        }

    }
}
