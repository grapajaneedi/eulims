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
    <!-- customer and address, tel no here -->
    <?= $form->field($model, 'customer_id')->textInput() ?>
    <?= $form->field($model, 'joborder_date')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'sampling_date')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'lsono')->textInput(['maxlength' => true]) ?>
     <?= $form->field($model, 'sample_received')->textInput(['maxlength' => true]) ?>

    <div class="form-group pull-right">
    <?php if(Yii::$app->request->isAjax){ ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <?php } ?>
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div> 