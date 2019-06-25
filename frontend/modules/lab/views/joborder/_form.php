<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Joborder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="joborder-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'joborder_id')->textInput() ?>

    <?= $form->field($model, 'customer_id')->textInput() ?>

    <?= $form->field($model, 'joborder_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sampling_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lsono')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sample_received')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div> 