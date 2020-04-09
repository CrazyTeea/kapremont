<?php

use app\models\ApproveStatus;
use yii\bootstrap4\Accordion;
use yii\bootstrap4\Html;
use yii\widgets\DetailView;


$weara = [
    'Менее 20%',
    'От 20% до 50%',
    'От 50% до 70%',
    'От 70% до 90%',
    'Более 90%'
];

$ext_status=[
        'not'=>'в обработке',
    'approved'=>'Согласовано',
    'rejected'=>'Резерв'
];

/* @var $this yii\web\View */
/* @var $model app\models\ProgramObjects */
/* @var $canChange boolean */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Программа модернизации', 'url' => ['/program/view']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="program-objects-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($canChange and (Yii::$app->user->can('root') or Yii::$app->user->can('faiv_user'))):?>

        <p>
            <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>

    <?php endif; ?>

    <div class="row">
        <div class="col-4">
            <h5>Текущий статус эксперта МОН:
                <br>
                <?php
                $class = '';
                switch ($model->status){
                    case 1:{
                        $class = 'secondary';
                        break;
                    }
                    case 2:{
                        $class = 'success';
                        break;
                    }
                    case 3:{
                        $class = 'danger';
                        break;
                    }
                    default:{
                        $class = 'warning';
                    }
                }
                $status = ($model->status) ? ApproveStatus::findOne($model->status)->label : 'Черновик';
                echo "<label class='text-$class'>$status</label> "
                ?>

            </h5>
        </div>
        <div class="col-4">
            <h5>Текущий статус ДЭП:
                <br>
                <?php
                $class = '';
                switch ($model->dep_status){
                    case 'not':{
                        $class = 'secondary';
                        break;
                    }
                    case 'approved':{
                        $class = 'success';
                        break;
                    }
                    default:{
                        $class = 'warning';
                    }
                }
                $status = ($model->dep_status) ? $ext_status[$model->dep_status] : '';
                echo "<label class='text-$class'>$status</label> "
                ?>
            </h5>
        </div>
        <div class="col-4">
            <h5>
                Текущий статус ДКУ:
                <br>
                <?php
                $class = '';
                switch ($model->dku_status){
                    case 'not':{
                        $class = 'secondary';
                        break;
                    }
                    case 'approved':{
                        $class = 'success';
                        break;
                    }
                    default:{
                        $class = 'warning';
                    }
                }
                $status = ($model->dku_status) ? $ext_status[$model->dku_status] : '';
                echo "<label class='text-$class'>$status</label> "
                ?>
            </h5>
        </div>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'org.name',
            'name:ntext',
            'address:ntext',
            'assignment:ntext',
            'square',
            'year',
            [                      // the owner name of the model
                'attribute' => 'wear',
                'value' => function($model) use ($weara){return $weara[($model->wear and  $model->wear < 5) ? $model->wear : 0];},
            ],


            /*        'event_type:ntext',
                    'finance_sum',
                    'coFinancing',*/
            'note:ntext',
        ],
    ]) ?>

    <?php
    if(Yii::$app->user->can('root')) {
        echo Accordion::widget([
            'encodeLabels'=>true,
            'itemToggleOptions'=>[
                'class'=>['btn', 'btn-default'],
                'style'=>'display: block;min-width: 100%;text-align: left;margin: 0; padding: 0 !important;'
            ],
            'items'=>[
                [
                    'label'=>'Сведения о планируемых мероприятиях',
                    'content'=>$this->render('_svediniaView',compact('model'))
                ],
                [
                    'label'=>'Обоснование необходимости (целесообразности) планируемых мероприятий',
                    'content'=>$this->render('_nesView',compact('model'))
                ],
                [
                    'label'=>'Ожидаемые результаты',
                    'content'=>$this->render('_waitesView',compact('model'))
                ],
                [
                    'label'=>'Прогнозируемые риски',
                    'content'=>$this->render('_risksView',compact('model'))
                ],
                [
                    'label' => 'Загруженные файлы',
                    'content' => $this->render('_filesView',compact('docList','model')),
                ],
            ]
        ]);
    } else {
        echo Accordion::widget([
            'encodeLabels'=>true,
            'itemToggleOptions'=>[
                'class'=>['btn', 'btn-default'],
                'style'=>'display: block;min-width: 100%;text-align: left;margin: 0; padding: 0 !important;'
            ],
            'items'=>[
                [
                    'label'=>'Сведения о планируемых мероприятиях',
                    'content'=>$this->render('_svediniaView',compact('model'))
                ]
            ]
        ]);
    }
    ?>


    <script>
        window.object_status = <?=$model->status?>;
    </script>

    <div id="app"></div>

</div>


