<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use common\models\lab\Request;
use common\models\lab\Lab;
use common\models\lab\Markettype;
use common\models\lab\Paymenttype;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use common\models\lab\Csf;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Csf */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>    
<?php
                    $btn_style = ';height: 45px;width: 45px; border-radius: 50%;display: inline-block;color:#0f096d;box-shadow: inset 0px 25px 0 rgba(255,255,255,0.3), 0 5px 5px rgba(0, 0, 0, 0.3);';
                    $space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    ?>
<div class="panel panel-info">
                    <div class="panel-heading" style="color:#142142;font-family:Century Gothic;font-size:130%;"><b>Delivery of Service</b></div>
                    <div class="panel-body">
                 
                    <?= $form->field($model, 'd_deliverytime')->hiddenInput()->label("Delivery Time") ?>
                    <?php echo Html::button('5', ['onclick'=>'changeColor(this)', 'class' => 'd_deliverytime', 'value'=>'5', 'style'=>'background-color: #3CB371;'.$btn_style]).$space ?> 
                    <?php echo Html::button('4', ['onclick'=>'changeColor(this)', 'class' => 'd_deliverytime', 'value'=>'4', 'style'=>'background-color: #98FB98;'.$btn_style]).$space ?>                 
                    <?php echo Html::button('3', ['onclick'=>'changeColor(this)', 'class' => 'd_deliverytime', 'value'=>'3', 'style'=>'background-color: #F5DEB3'.$btn_style]).$space ?>
                    <?php echo Html::button('2', ['onclick'=>'changeColor(this)', 'class' => 'd_deliverytime', 'value'=>'2', 'style'=>'background-color: #FFA07A'.$btn_style]).$space ?>
                    <?php echo Html::button('1', ['onclick'=>'changeColor(this)', 'class' => 'd_deliverytime','value'=>'1', 'style'=>'background-color: #DC143C'.$btn_style]).$space ?>           
                    <br>
                    <br>     
                    <?= $form->field($model, 'd_accuracy')->hiddenInput()->label("Correctness and accuracy of test results") ?>
                    <?php echo Html::button('5', ['onclick'=>'changeColor(this)', 'class' => 'd_accuracy', 'value'=>'5', 'style'=>'background-color: #3CB371;'.$btn_style]).$space ?>
                    <?php echo Html::button('4', ['onclick'=>'changeColor(this)', 'class' => 'd_accuracy', 'value'=>'4', 'style'=>'background-color: #98FB98;'.$btn_style]).$space ?>
                    <?php echo Html::button('3', ['onclick'=>'changeColor(this)', 'class' => 'd_accuracy', 'value'=>'3', 'style'=>'background-color: #F5DEB3;'.$btn_style]).$space ?>
                    <?php echo Html::button('2', ['onclick'=>'changeColor(this)', 'class' => 'd_accuracy', 'value'=>'2', 'style'=>'background-color: #FFA07A;'.$btn_style]).$space ?>
                    <?php echo Html::button('1', ['onclick'=>'changeColor(this)', 'class' => 'd_accuracy','value'=>'1', 'style'=>'background-color: #DC143C;'.$btn_style]).$space ?>   
                    <br>
                    <br>
                    <?= $form->field($model, 'd_speed')->hiddenInput()->label("Speed of Service") ?>
                    <?php echo Html::button('5', ['onclick'=>'changeColor(this)', 'class'=>'d_speed', 'value'=>'5', 'style'=>'background-color: #3CB371;'.$btn_style]).$space ?>
                    <?php echo Html::button('4', ['onclick'=>'changeColor(this)', 'class'=>'d_speed', 'value'=>'4', 'style'=>'background-color: #98FB98;'.$btn_style]).$space ?>
                    <?php echo Html::button('3', ['onclick'=>'changeColor(this)', 'class'=>'d_speed', 'value'=>'3', 'style'=>'background-color: #F5DEB3;'.$btn_style]).$space ?>
                    <?php echo Html::button('2', ['onclick'=>'changeColor(this)', 'class'=>'d_speed', 'value'=>'2', 'style'=>'background-color: #FFA07A;'.$btn_style]).$space ?>
                    <?php echo Html::button('1', ['onclick'=>'changeColor(this)','class'=>'d_speed', 'value'=>'1', 'style'=>'background-color: #DC143C;'.$btn_style]).$space ?>        
                   <br>
                    <br>
                     <?= $form->field($model, 'd_cost')->hiddenInput()->label("Cost") ?>
                    <?php echo Html::button('5', ['onclick'=>'changeColor(this)', 'class'=>'d_cost', 'value'=> '5', 'style'=>'background-color: #3CB371;'.$btn_style]).$space ?>
                    <?php echo Html::button('4', ['onclick'=>'changeColor(this)', 'class'=>'d_cost', 'value'=> '4', 'style'=>'background-color: #98FB98;'.$btn_style]).$space ?>
                    <?php echo Html::button('3', ['onclick'=>'changeColor(this)', 'class'=>'d_cost', 'value'=> '3', 'style'=>'background-color: #F5DEB3;'.$btn_style]).$space ?>
                    <?php echo Html::button('2', ['onclick'=>'changeColor(this)', 'class'=>'d_cost', 'value'=> '2', 'style'=>'background-color: #FFA07A;'.$btn_style]).$space ?>
                    <?php echo Html::button('1', ['onclick'=>'changeColor(this)', 'class'=>'d_cost', 'value'=> '1', 'style'=>'background-color: #DC143C;'.$btn_style]).$space ?>                
                    <br>
                    <br>
                    <?= $form->field($model, 'd_attitude')->hiddenInput()->label("Attitude of staff") ?>
                    <?php echo Html::button('5', ['onclick'=>'changeColor(this)', 'class'=>'d_attitude', 'value'=>'5','style'=>'background-color: #3CB371;'.$btn_style]).$space ?> 
                    <?php echo Html::button('4', ['onclick'=>'changeColor(this)', 'class'=>'d_attitude', 'value'=>'4','style'=>'background-color: #98FB98;'.$btn_style]).$space ?>
                    <?php echo Html::button('3', ['onclick'=>'changeColor(this)', 'class'=>'d_attitude', 'value'=>'3','style'=>'background-color: #F5DEB3;'.$btn_style]).$space ?>
                    <?php echo Html::button('2', ['onclick'=>'changeColor(this)', 'class'=>'d_attitude', 'value'=>'2','style'=>'background-color: #FFA07A;'.$btn_style]).$space ?>
                    <?php echo Html::button('1', ['onclick'=>'changeColor(this)', 'class'=>'d_attitude', 'value'=>'1', 'style'=>'background-color: #DC143C;'.$btn_style]).$space ?>          
                   <br>
                    <br>  <?= $form->field($model, 'd_overall')->hiddenInput()->label("Over-all customer experience") ?>
                    <?php echo Html::button('5', ['onclick'=>'changeColor(this)', 'class'=>'d_overall', 'value'=>'5','style'=>'background-color: #3CB371;'.$btn_style]).$space ?>
                    <?php echo Html::button('4', ['onclick'=>'changeColor(this)', 'class'=>'d_overall', 'value'=>'4','style'=>'background-color: #98FB98;'.$btn_style]).$space ?>
                    <?php echo Html::button('3', ['onclick'=>'changeColor(this)', 'class'=>'d_overall', 'value'=>'3','style'=>'background-color: #F5DEB3;'.$btn_style]).$space ?>
                    <?php echo Html::button('2', ['onclick'=>'changeColor(this)', 'class'=>'d_overall', 'value'=>'2','style'=>'background-color: #FFA07A;'.$btn_style]).$space ?>
                    <?php echo Html::button('1', ['onclick'=>'changeColor(this)', 'class'=>'d_overall', 'value'=>'1','style'=>'background-color: #DC143C;'.$btn_style]).$space ?>
                    </div>
                </div>
            </div>
            <div class="row">
        <div class="col-sm-6">
        <div class="panel panel-info">
        <div class="panel-heading" style="color:#142142;font-family:Century Gothic;font-size:130%;"><b>How <font color="red">Important</font> are these items to you?</b></div>
                <div class="panel-body">               
                <?= $form->field($model, 'i_deliverytime')->hiddenInput()->label("Delivery Time") ?>
                    <?php echo Html::button('5', ['onclick'=>'changeColor(this)', 'class'=>'i_deliverytime', 'value'=>'5','style'=>'background-color: #3CB371;'.$btn_style]).$space ?>   
                    <?php echo Html::button('4', ['onclick'=>'changeColor(this)', 'class'=>'i_deliverytime', 'value'=>'4','style'=>'background-color: #98FB98;'.$btn_style]).$space ?>
                    <?php echo Html::button('3', ['onclick'=>'changeColor(this)', 'class'=>'i_deliverytime', 'value'=>'3','style'=>'background-color: #F5DEB3;'.$btn_style]).$space ?> 
                    <?php echo Html::button('2', ['onclick'=>'changeColor(this)', 'class'=>'i_deliverytime',  'value'=>'2','style'=>'background-color: #FFA07A;'.$btn_style]).$space ?>
                    <?php echo Html::button('1', ['onclick'=>'changeColor(this)', 'class'=>'i_deliverytime', 'value'=>'1','style'=>'background-color: #DC143C;'.$btn_style]).$space ?>  
                    <br>
                    <br>
                    <?= $form->field($model, 'i_accuracy')->hiddenInput()->label("Correctness and accuracy of test results") ?>
                    <?php echo Html::button('5', ['onclick'=>'changeColor(this)', 'class'=>'i_accuracy', 'value'=>'5','style'=>'background-color: #3CB371;'.$btn_style]).$space ?>  
                    <?php echo Html::button('4', ['onclick'=>'changeColor(this)', 'class'=>'i_accuracy', 'value'=>'4','style'=>'background-color: #98FB98;'.$btn_style]).$space ?>    
                    <?php echo Html::button('3', ['onclick'=>'changeColor(this)', 'class'=>'i_accuracy', 'value'=>'3','style'=>'background-color: #F5DEB3;'.$btn_style]).$space ?>
                    <?php echo Html::button('2', ['onclick'=>'changeColor(this)', 'class'=>'i_accuracy', 'value'=>'2','style'=>'background-color: #FFA07A;'.$btn_style]).$space ?>             
                    <?php echo Html::button('1', ['onclick'=>'changeColor(this)', 'class'=>'i_accuracy', 'value'=>'1','style'=>'background-color: #DC143C;'.$btn_style]).$space ?>        
                    <br>
                    <br>
                    <?= $form->field($model, 'i_speed')->hiddenInput()->label("Speed of Service") ?>
                    <?php echo Html::button('5', ['onclick'=>'changeColor(this)', 'class'=>'i_speed', 'value'=>'5','style'=>'background-color: #3CB371;'.$btn_style]).$space ?>
                    <?php echo Html::button('4', ['onclick'=>'changeColor(this)', 'class'=>'i_speed', 'value'=>'4','style'=>'background-color: #98FB98;'.$btn_style]).$space ?> 
                    <?php echo Html::button('3', ['onclick'=>'changeColor(this)', 'class'=>'i_speed', 'value'=>'3','style'=>'background-color: #F5DEB3;'.$btn_style]).$space ?> 
                    <?php echo Html::button('2', ['onclick'=>'changeColor(this)', 'class'=>'i_speed', 'value'=>'2','style'=>'background-color: #FFA07A;'.$btn_style]).$space ?> 
                    <?php echo Html::button('1', ['onclick'=>'changeColor(this)', 'class'=>'i_speed', 'value'=>'1','style'=>'background-color: #DC143C;'.$btn_style]).$space ?>          
                    <br>
                    <br>
                    <?= $form->field($model, 'i_cost')->hiddenInput()->label("Cost") ?>
                    <?php echo Html::button('5', ['onclick'=>'changeColor(this)', 'class'=>'i_cost', 'value'=>'5','style'=>'background-color: #3CB371;'.$btn_style]).$space ?>         
                    <?php echo Html::button('4', ['onclick'=>'changeColor(this)', 'class'=>'i_cost', 'value'=>'4','style'=>'background-color: #98FB98;'.$btn_style]).$space ?>        
                    <?php echo Html::button('3', ['onclick'=>'changeColor(this)', 'class'=>'i_cost', 'value'=>'3','style'=>'background-color: #F5DEB3;'.$btn_style]).$space ?>
                    <?php echo Html::button('2', ['onclick'=>'changeColor(this)', 'class'=>'i_cost', 'value'=>'2','style'=>'background-color: #FFA07A;'.$btn_style]).$space ?>
                    <?php echo Html::button('1', ['onclick'=>'changeColor(this)', 'class'=>'i_cost', 'value'=>'1','style'=>'background-color: #DC143C;'.$btn_style]).$space ?>                  
                    <br>
                    <br>
                    <?= $form->field($model, 'i_attitude')->hiddenInput()->label("Attitude of Staff") ?>
                    <?php echo Html::button('5', ['onclick'=>'changeColor(this)', 'class'=>'i_attitude', 'value'=>'5','style'=>'background-color: #3CB371;'.$btn_style]).$space ?>             
                    <?php echo Html::button('4', ['onclick'=>'changeColor(this)', 'class'=>'i_attitude', 'value'=>'4','style'=>'background-color: #98FB98;'.$btn_style]).$space ?>
                    <?php echo Html::button('3', ['onclick'=>'changeColor(this)', 'class'=>'i_attitude', 'value'=>'3','style'=>'background-color: #F5DEB3;'.$btn_style]).$space ?>
                    <?php echo Html::button('2', ['onclick'=>'changeColor(this)', 'class'=>'i_attitude', 'value'=>'2','style'=>'background-color: #FFA07A;'.$btn_style]).$space ?>
                    <?php echo Html::button('1', ['onclick'=>'changeColor(this)', 'class'=>'i_attitude', 'value'=>'1','style'=>'background-color: #DC143C;'.$btn_style]).$space ?>                   
                    <br>
                    <br>
                    <?= $form->field($model, 'i_overall')->hiddenInput()->label("Over-all customer experience") ?>
                    <?php echo Html::button('5', ['onclick'=>'changeColor(this)', 'class'=>'i_overall', 'value'=>'5','style'=>'background-color: #3CB371;'.$btn_style]).$space ?>
                    <?php echo Html::button('4', ['onclick'=>'changeColor(this)', 'class'=>'i_overall', 'value'=>'4','style'=>'background-color: #98FB98;'.$btn_style]).$space ?>
                    <?php echo Html::button('3', ['onclick'=>'changeColor(this)', 'class'=>'i_overall', 'value'=>'3','style'=>'background-color: #F5DEB3;'.$btn_style]).$space ?>                  
                    <?php echo Html::button('2', ['onclick'=>'changeColor(this)', 'class'=>'i_overall', 'value'=>'2','style'=>'background-color: #FFA07A;'.$btn_style]).$space ?>     
                    <?php echo Html::button('1', ['onclick'=>'changeColor(this)', 'class'=>'i_overall', 'value'=>'1','style'=>'background-color: #DC143C;'.$btn_style]).$space ?>          
                                     
                    <br>
                    <br>
                </div>
        </div>
        <div class="panel panel-info">
            <div class="panel-heading" style="color:#142142;font-family:Century Gothic;font-size:130%;"><b>How likely is it that you would <font color="red">recommend</font> our service to others? 1-10</b></div>

                <div class="panel-body">
                    <?= $form->field($model, 'recommend')->hiddenInput()->label("Recommend")->label(false) ?>
                    <?php echo Html::button('10', ['onclick'=>'changeColor_rec(this)','class'=>'recommend', 'value'=>'10','style'=>'background-color: #006400;'.$btn_style]) ?>
                    <?php echo Html::button('9', ['onclick'=>'changeColor_rec(this)', 'class'=>'recommend', 'value'=>'9','style'=>'background-color: #008000;'.$btn_style]) ?>
                    <?php echo Html::button('8', ['onclick'=>'changeColor_rec(this)', 'class'=>'recommend', 'value'=>'8','style'=>'background-color: #32CD32;'.$btn_style]) ?>
                    <?php echo Html::button('7', ['onclick'=>'changeColor_rec(this)', 'class'=>'recommend', 'value'=>'7','value' => '2', 'style'=>'background-color: #98FB98;'.$btn_style]) ?>
                    <?php echo Html::button('6', ['onclick'=>'changeColor_rec(this)',' class'=>'recommend', 'value'=>'6','style'=>'background-color: #FFEFD5;'.$btn_style]) ?>
                    <?php echo Html::button('5', ['onclick'=>'changeColor_rec(this)', 'class'=>'recommend', 'value'=>'5','style'=>'background-color: #FFA07A;'.$btn_style]) ?>
                    <?php echo Html::button('4', ['onclick'=>'changeColor_rec(this)', 'class'=>'recommend', 'value'=>'4','style'=>'background-color: #E9967A;'.$btn_style]) ?>
                    <?php echo Html::button('2', ['onclick'=>'changeColor_rec(this)', 'class'=>'recommend', 'value'=>'2','value' => '2', 'style'=>'background-color: #CD5C5C;'.$btn_style]) ?>     
                    <?php echo Html::button('1', ['onclick'=>'changeColor_rec(this)', 'class'=>'recommend', 'value'=>'1','style'=>'background-color: #DC143C;'.$btn_style])?>        
                 </div>     
        </div>
        <div class="panel panel-info">
        <div class="panel-heading" style="color:#142142;font-family:Century Gothic;font-size:130%;"><b>Please give us your comments/ suggestions to improve our services. Also, let us know other test you require that we are not able to provide yet.</b></div>
            <div class="panel-body">
                 <?= $form->field($model, 'essay')->textArea(['rows' => '5'])->label(false) ?>
            </div>  
        </div>    
            <?php $form->field($model, 'r_date')->hiddenInput()->label(false) ?>
        </div>
        </div>
        <div class="row" style="float: right;padding-right: 30px">
        <?= Html::submitButton('Submit Answers', ['class' => 'btn btn-primary']) ?>
        <?php if($model->isNewRecord){ ?>
        <?php } ?>
    <?php ActiveForm::end(); ?>
</div>
<script type="text/javascript">
    function changeColor (btn, txtBoxId) {
        document.querySelectorAll('.' + btn.className).forEach(function (btn) {
            btn.style.backgroundColor = '#bbb';
        })
        let colors = ['#DC143C', '#FFA07A', '#F5DEB3', '#98FB98', '#3CB371' ]
        btn.style.backgroundColor = colors[btn.value - 1];
        document.getElementById('csf-' + btn.className).value = btn.value;
    }
    function changeColor_rec (btn, txtBoxId) {
        document.querySelectorAll('.' + btn.className).forEach(function (btn) {
            btn.style.backgroundColor = '#bbb';
        })
        let colors = ['#DC143C', '#CD5C5C', '#F08080', '#E9967A', '#FFA07A', '#FFEFD5', '#98FB98','#32CD32','#008000','#006400' ]
        btn.style.backgroundColor = colors[btn.value - 1];
        document.getElementById('csf-' + btn.className).value = btn.value;
    }
</script>
<?php ini_set("memory_limit", "10000M");?>