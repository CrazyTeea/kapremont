<?php

namespace app\controllers;

use app\models\ChangePasswordForm;
use app\models\forms\UserRecover;
use app\models\Founders;
use app\models\Organizations;
use app\models\Program;
use app\models\ProgramObjects;
use app\models\User;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Html;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\FileHelper;
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
    public function actionUserRecover()
    {
        $model = new UserRecover();
        if ($post = Yii::$app->request->post()) {
            if ($model->load($post) and $model->resetFromIasmon())
                return $this->redirect(['login']);
        }
        return $this->render('userRecover', compact('model'));
    }


    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();
        $success = -1;
        if ($model->load(Yii::$app->request->post())) {
            $success = $model->change_password();
        }
        return $this->render('change_password', compact('model', 'success'));
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
            if (Yii::$app->user->can('root') or
                Yii::$app->user->can('mgsu') or
                Yii::$app->user->can('orglist_view') or
                Yii::$app->user->can('faiv_admin') or
                Yii::$app->user->can('dep') or
                Yii::$app->user->can('dku')) {
                return $this->redirect(['/organization/list']);
            } else return $this->redirect(['/program']);
        }

        $model = new LoginForm();
        if (Yii::$app->request->get('auth_token')) {

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
                        Yii::$app->user->can('dku')) {
                        return $this->redirect(['/organization/list']);
                    }

                    return $this->redirect(['/program']);
                }
                Yii::$app->session->setFlash("auth_error", "Ошибка входа!");
                // return $this->redirect(['site/login']);
            }
        } else if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->user->can('root') or
                Yii::$app->user->can('mgsu') or
                Yii::$app->user->can('orglist_view') or
                Yii::$app->user->can('faiv_admin') or
                Yii::$app->user->can('dep') or
                Yii::$app->user->can('dku')) {
                return $this->redirect(['/organization/list']);
            }
            return $this->redirect(['/program']);
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function Founders(){
        echo "Выполняется синхронизация фаундеров\n";
        $signer = new Sha256();
        $key = new Key('secret');

        $token = (new Builder())->withClaim('reference', 'organization_founder')
            ->getToken($signer, $key);
        $response_token = file_get_contents("http://api.xn--80apneeq.xn--p1ai/api.php?option=reference_api&action=get_reference&module=constructor&reference_token=$token");

        $signer = new Sha256();
        $token = (new Parser())->parse($response_token);
        if ($token->verify($signer, 'secret')) {

            $data_reference = $token->getClaims();

            foreach ($data_reference as $key => $data) {
                $founder = Founders::findOne($data->getValue()->id) ?? new Founders();
                $founder->id = $data->getValue()->id;
                $founder->name = $data->getValue()->name;
                if (!$founder->save()) {
                    print_r($founder->getErrors());
                }
            }
        }

    }

    public function actionP()
    {

        $this->Founders();

        echo "Выполняется синхронизация организаций\n";
        $err = 0;
        $signer = new Sha256();
        $key = new Key('secret');
        $token = (new Builder())->withClaim('reference', 'organization')
            // ->sign($signer, self::$jwt_key)
            ->getToken($signer, $key);
        $response_token = file_get_contents("http://api.xn--80apneeq.xn--p1ai/api.php?option=reference_api&action=get_reference&module=constructor&reference_token=$token");
        $signer = new Sha256();
        $token = (new Parser())->parse($response_token);
        if ($token->verify($signer, 'secret')) {
            $data_reference = $token->getClaims();
            foreach ($data_reference as $key => $data) {
                $row_org = Organizations::findOne($data->getValue()->id) ?? new Organizations();
                $row_org->id = $data->getValue()->id;
                $row_org->id_founder = $data->getValue()->subordination;
                $row_org->full_name = htmlspecialchars_decode($data->getValue()->fullname);
                $row_org->address = htmlspecialchars_decode($data->getValue()->fullname);
                $row_org->short_name = htmlspecialchars_decode($data->getValue()->shot_name);
                $row_org->name = htmlspecialchars_decode($data->getValue()->name);
                $row_org->inn = htmlspecialchars_decode($data->getValue()->inn);
                $row_org->id_type = htmlspecialchars_decode($data->getValue()->type_org);
                $row_org->id_region = ($data->getValue()->region_id != 0) ? $data->getValue()->region_id : 86;
                $row_org->save(false);

            }
        }

        /*$orgs = Organizations::findAll(['>','id_founder',1]);
        foreach ($orgs as $org){
            $u = User::findAll(['id_org'=>$org->id]);
            foreach ($u as $kek){
                $pgp = new PhpManager();
                $pgp->revokeAll($kek->id);
                $pgp->assign($pgp->getRole('faiv_user'),$kek->id);
            }
        }*/
    }

    public function actionKek(){
        $path = Yii::getAlias('@webroot').'/kek.csv';
        $csv = fopen($path, 'r');
        while (($row = fgetcsv($csv, 32000, ';')) != false) {
            $p = Program::findOne(['id_org'=>$row[0]]);
            if ($p){
                $p->finance_volume = str_replace(',','.',str_replace(' ','',$row[2]));
                $p->finance_events = str_replace(',','.',str_replace(' ','',$row[3]));
                $p->cost2 = str_replace(',','.',str_replace(' ','',$row[4]));
                $p->save(false);
            }
        }

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

    public function actionExport()
    {


        $objs = ProgramObjects::find()->where(['id_org' => 100, 'status' => 5])->joinWith(['svedenia', 'svedenia2'])->asArray()->all();
        $param = 'export';
        $html = $this->renderPartial('_export', compact('objs'));
        $reader = new HTML();
        $spreadsheet = $reader->loadFromString($html);
        $writer = IOFactory::createWriter($spreadsheet, 'Xls');

        $path = Yii::getAlias('@webroot') . "/uploads/$param";
        if (!file_exists($path))
            FileHelper::createDirectory($path);
        $writer->save("$path/$param.xls");
        Yii::$app->response->sendFile("$path/$param.xls")->send();
        if (file_exists("$path/$param.xls"))
            unlink("$path/$param.xls");

    }

}
