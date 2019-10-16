<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Csf */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="csf-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nob')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tom')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'service')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'd_deliverytime')->textInput() ?>

    <?= $form->field($model, 'd_accuracy')->textInput() ?>

    <?= $form->field($model, 'd_speed')->textInput() ?>

    <?= $form->field($model, 'd_cost')->textInput() ?>

    <?= $form->field($model, 'd_attitude')->textInput() ?>

    <?= $form->field($model, 'd_overall')->textInput() ?>

    <?= $form->field($model, 'i_deliverytime')->textInput() ?>

    <?= $form->field($model, 'i_accuracy')->textInput() ?>

    <?= $form->field($model, 'i_speed')->textInput() ?>

    <?= $form->field($model, 'i_cost')->textInput() ?>

    <?= $form->field($model, 'i_attitude')->textInput() ?>

    <?= $form->field($model, 'i_overall')->textInput() ?>

    <?= $form->field($model, 'recommend')->textInput() ?>

    <?= $form->field($model, 'essay')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'r_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
