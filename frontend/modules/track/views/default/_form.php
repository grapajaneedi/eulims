<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Request */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="request-form">
<br>
<br>
<br>
<div class="row">
        <div class="col-sm-4">       
                </div>
                <div class="col-sm-4">
                <div class="panel panel-info">
                            <div class="panel-heading" style="color:#142142;font-family:Century Gothic;font-size:130%;"><b>Track My Request</b></div>
                            <div class="panel-body">
                            <?php $form = ActiveForm::begin(); ?>

                                    <?= $form->field($model, 'request_ref_num')->textInput(['maxlength' => true]) ?>
                                    <?= $form->field($model, 'created_at')->textInput(['maxlength' => true]) ?>

                                  
                                    <div class="row" style="float: right;padding-right: 15px">
      
                                        <?= Html::submitButton('Track', ['class' => 'btn btn-success']) ?>
                                        </div>
                                </div>
                        </div>
                    </div>
                </div>


                <div class="col-sm-4">
               
                </div>
    

    <?php ActiveForm::end(); ?>

</div>
