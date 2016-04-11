<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SearchAccess */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Accesses');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Access'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

            //'id',
				[
					'attribute' => 'user_guest',
					'value'     => 'userGuest.username'
				],
            [
                'attribute' => 'date',
                'value'     => 'date',
                'filter' => \yii\jui\DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date',
                    'language' => 'ru',
                    'dateFormat' => 'yyyy-MM-dd'
                ]),
                'format'    => 'html'
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
        ]
    ); ?>
</div>
