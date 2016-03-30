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

    <p>
        <?= Html::a(Yii::t('app', 'Создать календарь'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
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
                    'language' => 'ru',
                    'dateFormat' => 'dd-MM-yyyy'
                ]),
                'format' => 'html'
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?= \yii2fullcalendar\yii2fullcalendar::widget(array(
    'googleCalendar' => true,
    'options' => [
        'lang' => 'ru',
    ],
    'events'=> $events,
));
?>
</div>
