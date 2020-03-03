<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use mdm\admin\components\MenuHelper;
use xtetis\bootstrap4glyphicons\assets\GlyphiconAsset;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

GlyphiconAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<img src="/img/light-logo.svg"> &nbsp;'.Yii::$app->name,
        'options' => [
            'class' => 'navbar-expand-lg navbar-dark bg-dark',
        ],
    ]);
    echo Nav::widget([
        'items' => MenuHelper::getAssignedMenu(Yii::$app->user->id)
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ml-auto'],
        'items' => [

            ['label' => 'Информация', 'url' => ['/site/about']],

            Yii::$app->user->isGuest ? (
            ['label' => 'Вход', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                //. Html::hiddenInput('id_org',\app\models\User::findOne(Yii::$app->user->id)->id_org,['id'=>'global_id_org'])
                //. Html::hiddenInput('username',Yii::$app->user->identity->username,['id'=>'global_username'])
                . Html::submitButton(
                    'Выход (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn nav-link']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>


        <div id="app"></div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-6">
                Официальный ресурс Министерства науки и высшего образования Российской Федерации
            </div>
            <div class="col-6">
                Служба технической поддержки:
                8-495-989-84-47 доб. 1 (многоканальный)
                ias@mirea.ru <?=Html::a('Типовые вопросы',['/tips_quations.pdf'],['target'=>'_blank'])?>
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
