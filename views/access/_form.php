<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;


/* @var $this yii\web\View */
/* @var $model app\models\Access */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="access-form">

    <?php $form = ActiveForm::begin(); ?>


    <?=
    $form->field($model, 'user_guest')->widget(
        \yii\jui\AutoComplete::className(),[
    'clientOptions' => [
        'source' => \app\models\User::find()
            ->select(['id as value', 'username as label', 'id'])
            ->where('id !='.Yii::$app->user->id)
            ->asArray()
            ->all(),
        'select' => new JsExpression("function( event, ui ) { 
                                $('#access-user_guest').val(ui.item.id);
                             }"
        )
    ],
        'options' =>[
        'class'=>'form-control']
    ]) ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
