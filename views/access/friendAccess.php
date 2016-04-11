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
                            if (!\Yii::$app->user->isGuest) {
                                $e = \app\models\Calendar::find()->where(['creator' => $model->user_owner, 'date_event' => $model->date])->one();
                                return Html::a(
                                    '<span class="glyphicon glyphicon-eye-open"></span>', '/calendar/view?id='.$e->id."&date=".$model->date
                                );
                            }
                        },
                    ],
                ],
            ],
        ]
    ); ?>
</div>