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
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
        //'showOnEmpty' => false,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            //'id',
            'creator',
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

<?= \yii2fullcalendar\yii2fullcalendar::widget(array(
    'googleCalendar' => true,
    'options' => [
        'lang' => 'ru',
    ],
    'events'=> $events,
));
?>
</div>
