<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SearchCalendar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Календари');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calendar-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (!Yii::$app->user->isGuest) { ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= Html::a(Yii::t('app', 'My Accesses'), ['/access'], ['class' => 'btn btn-success']) ?>
    <?= Html::a(Yii::t('app', 'Calendars of my friend'), ['/calendar/friendcalendars?id='.Yii::$app->user->id], ['class' => 'btn btn-success']) ?>

    <?php
        \yii\bootstrap\Modal::begin([
            'header' =>'<h4>Календарь</h4>',
            'id' => 'modal',
            'size' => 'modal-lg'
        ]);
    echo "<div id='modalContent'></div>";
        \yii\bootstrap\Modal::end();
    ?>



    <?= GridView::widget([
        'showOnEmpty' => false,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => false,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            //'id',
            [
                'attribute' =>'creator',
                'value' =>'userCreator.username'
            ],

            'text',
            //'date_event',
            // 'password',
            // 'salt',
            // 'access_token',
            [
                'attribute' => 'date_event',
                'value' => 'date_event',
                'filter' => \yii\jui\DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date_event',
                    'language' => 'ru',
                    'dateFormat' => 'yyyy-MM-dd'
                ]),
                'format' => 'html'
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <h2>Для добавления события, счелкните по нужной вам дате</h2>
   <?php } ?>
<?= \yii2fullcalendar\yii2fullcalendar::widget(array(
    'googleCalendar' => true,
    'options' => [
        'lang' => 'ru',
    ],
    'events'=> $events,
));
?>
</div>
