
<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin(); ?>         
                    <?= $form->field($taggingmodel, 'start_date')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($taggingmodel,'end_date')->textInput(['maxlength' => true]) ?>

                    <div class="row" style="float: right;padding-right: 15px">

         <?php echo Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>

         </div>
                    <?php ActiveForm::end(); ?>