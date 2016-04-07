<?php
use yii\helpers\Html;
use yii\grid\GridView;
/**
 * Created by PhpStorm.
 * User: ritor
 * Date: 02.04.16
 * Time: 20:36
 */
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SearchAccess */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title                   = Yii::t('app', 'Users opened the access');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget(
        [
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'columns'      => [
                'id',
                [
                    'attribute' => 'user_owner',
                    'value'     => 'userOwner.username'
                ],
                [
                    'attribute' => 'date',
                    'value'     => 'date',
                    'filter'    => \yii\jui\DatePicker::widget(
                        [
                            'language'   => 'ru',
                            'dateFormat' => 'yyyy-MM-dd'
                        ]
                    ),
                    'format'    => 'html'
                ],
                [
                    'class'    => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'buttons'  => [
                        'view' => function ($url, $model) {
                            if ($model->user_guest === Yii::$app->user->id) {
                                return Html::a(
                                    '<span class="glyphicon glyphicon-eye-open"></span>', '/calendar/view?id='.$model->user_owner."&date=".$model->date
                                );
                            }
                        },
                    ],
                ],
            ],
        ]
    ); ?>
</div>