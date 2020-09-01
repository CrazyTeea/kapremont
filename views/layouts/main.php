<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\assets\AppAsset;
use app\models\User;
use app\widgets\Alert;
use app\widgets\NavBar;
use mdm\admin\components\MenuHelper;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\helpers\Json;

AppAsset::register($this);

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
    <script>
        window.Permission = <?= Json::encode(User::getRole(Yii::$app->user->id)) ?>;
        window.currentUser = <?= Json::encode(Yii::$app->user->id) ?>;
    </script>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => 'https://xn--80apneeq.xn--p1ai/',
        'brandImage' => '/img/light-logo.svg',
        //'renderInnerContainer'=>false,
        'options' => [
            'class' => 'navbar-expand-lg navbar-dark bg-dark d-flex align-items-center',
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
        <?= $content ?>

    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-6">
                Официальный ресурс Министерства науки и высшего образования Российской Федерации
            </div>
            <div class="col-6">
                Служба технической поддержки: 8-495-989-84-47 доб. 1 (многоканальный) По техническим вопросам:
                ias@mirea.ru,
                по методическим вопросам (в части капитального ремонта): <a href="support_monitoring@mirea.ru">support_monitoring@mirea.ru</a>,
                по методическим вопросам (в части АТЗ):
                <a href="support_atz@mirea.ru">support_atz@mirea.ru</a>.
                <?= Html::a('Типовые вопросы', ['/tips_quations.pdf'], ['target' => '_blank', 'class' => 'btn btn-warning btn-sm']) ?>
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
