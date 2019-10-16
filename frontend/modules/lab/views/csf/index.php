<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use common\models\lab\Request;
use common\models\lab\Markettype;
use common\models\lab\Paymenttype;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\CsfSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$requestlist= ArrayHelper::map(Request::find()->orderBy(['request_id' => SORT_DESC])->all(),'request_id','request_ref_num');


$js=<<<SCRIPT
    if(this.value==1){//Paid
        $("#erequest-discount_id").val(0).trigger('change');
        $("#erequest-discount_id").prop('disabled',false);
    }else{//Fully Subsidized
        $("#erequest-discount_id").val(0).trigger('change');
        $("#erequest-discount_id").prop('disabled',true);
    }
    $("#erequest-payment_type_id").val(this.value);  
SCRIPT;

?>

<h3 style="color:#142142;font-family:verdana;text-align:center;font-size:150%;text-shadow: 
      4px 4px 0px #d5d5d5, 
      7px 7px 0px rgba(0, 0, 0, 0.2);"><b>Department of Science and Technology</b></h3>
<h3 style="color:#142142;font-family:verdana;text-align:center;font-size:150%;text-shadow: 
      4px 4px 0px #d5d5d5, 
      7px 7px 0px rgba(0, 0, 0, 0.2);"><b>REGIONAL STANDARDS AND TESTING LABORATORY</b></h3>

<h1 style="color:#1a4c8f;font-family:Century Gothic;text-align:center;font-size:250%;text-shadow: 
      4px 4px 0px #d5d5d5, 
      7px 7px 0px rgba(0, 0, 0, 0.2);"><b>Customer Satisfaction Feedback Survey</b></h1><br>

<!-- <div class="alert alert-success" style="!important;margin-top: 1px !important;">
     <a href="#" class="close" data-dismiss="alert" >×</a>
    <p class="note" >(5) Very Satisfied (4) Quite Satisfied (3) Neither satisfied nor Dissatisfied (2) Quite Dissatisifed (1) Very Dissatisifed
    </p>    
    </div> -->

    <div class="csf-form" style="margin: 0 70px;">
    <?php $form = ActiveForm::begin(); ?>         
    <div class="row">
        <div class="col-sm-6">
       
                <div class="panel panel-info">
                    <div class="panel-heading">Information</div>
                    <div class="panel-body">
                    <?= $form->field($model,'ref_num')->widget(Select2::classname(),[
                        'data' => $requestlist,
                        'id'=>'name',
                        'theme' => Select2::THEME_KRAJEE,
                        'options' => ['id'=>'sample-type_id'],
                        'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Request Reference Number'],
                        'pluginEvents'=>[
                            "change" => 'function() { 
                                var discountid=this.value;
                        
                                $.post("/ajax/getcustomer/", {
                                        discountid: discountid
                                    }, function(result){
                                    if(result){
                                       $("#csf-name").val(result.customer_name);
                                       $("#csf-nob").val(result.nob);
                                    }
                                });
                            }
                        ',]
                        ])
                        ?>

                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'nob')->textInput(['maxlength' => true]) ?>
                        <?php echo $form->field($model, 'tom')->radioList(
                            ArrayHelper::map(Markettype::find()->all(),'id','type'),
                            ['itemOptions' => ['onchange'=>$js]]
                        ); ?>
                        <?php echo $form->field($model, 'service')->radioList(
                                                    ArrayHelper::map(Markettype::find()->all(),'id','type'),
                                                    ['itemOptions' => ['onchange'=>$js]]
                        ); ?>

                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">Delivery of Service</div>
                    <div class="panel-body">
                   <?php
                    $btn_style = ';height: 45px;width: 45px; border-radius: 50%;display: inline-block;color:#0f096d;box-shadow: inset 0px 25px 0 rgba(255,255,255,0.3), 0 5px 5px rgba(0, 0, 0, 0.3);';
                    $space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    ?>
                    <?= $form->field($model, 'd_deliverytime')->hiddenInput()->label("Delivery Time") ?>
                    <?php echo Html::button('1', ['onclick'=>'changeColor(this)', 'class' => 'd_deliverytime','value'=>'1', 'style'=>'background-color: #DC143C'.$btn_style]).$space ?>
                    <?php echo Html::button('2', ['onclick'=>'changeColor(this)', 'class' => 'd_deliverytime', 'value'=>'2', 'style'=>'background-color: #FFA07A'.$btn_style]).$space ?>
                    <?php echo Html::button('3', ['onclick'=>'changeColor(this)', 'class' => 'd_deliverytime', 'value'=>'3', 'style'=>'background-color: #F5DEB3'.$btn_style]).$space ?>
                    <?php echo Html::button('4', ['onclick'=>'changeColor(this)', 'class' => 'd_deliverytime', 'value'=>'4', 'style'=>'background-color: #98FB98;'.$btn_style]).$space ?>
                    <?php echo Html::button('5', ['onclick'=>'changeColor(this)', 'class' => 'd_deliverytime', 'value'=>'5', 'style'=>'background-color: #3CB371;'.$btn_style]).$space ?>                  
                    <br>
                    <br>     
                    <?= $form->field($model, 'd_accuracy')->hiddenInput()->label("Correctness and accuracy of test results") ?>
                    <?php echo Html::button('1', ['onclick'=>'changeColor(this)', 'class' => 'd_accuracy','value'=>'1', 'style'=>'background-color: #DC143C;'.$btn_style]).$space ?>
                    <?php echo Html::button('2', ['onclick'=>'changeColor(this)', 'class' => 'd_accuracy', 'value'=>'2', 'style'=>'background-color: #FFA07A;'.$btn_style]).$space ?>
                    <?php echo Html::button('3', ['onclick'=>'changeColor(this)', 'class' => 'd_accuracy', 'value'=>'3', 'style'=>'background-color: #F5DEB3;'.$btn_style]).$space ?>
                    <?php echo Html::button('4', ['onclick'=>'changeColor(this)', 'class' => 'd_accuracy', 'value'=>'4', 'style'=>'background-color: #98FB98;'.$btn_style]).$space ?>
                    <?php echo Html::button('5', ['onclick'=>'changeColor(this)', 'class' => 'd_accuracy', 'value'=>'5', 'style'=>'background-color: #3CB371;'.$btn_style]).$space ?>
                    <br>
                    <br>
                    <?= $form->field($model, 'd_speed')->hiddenInput()->label("Speed of Service") ?>
                    <?php echo Html::button('1', ['onclick'=>'changeColor(this)','class'=>'d_speed', 'value'=>'1', 'style'=>'background-color: #DC143C;'.$btn_style]).$space ?>
                    <?php echo Html::button('2', ['onclick'=>'changeColor(this)', 'class'=>'d_speed', 'value'=>'2', 'style'=>'background-color: #FFA07A;'.$btn_style]).$space ?>
                    <?php echo Html::button('3', ['onclick'=>'changeColor(this)', 'class'=>'d_speed', 'value'=>'3', 'style'=>'background-color: #F5DEB3;'.$btn_style]).$space ?>
                    <?php echo Html::button('4', ['onclick'=>'changeColor(this)', 'class'=>'d_speed', 'value'=>'4', 'style'=>'background-color: #98FB98;'.$btn_style]).$space ?>
                    <?php echo Html::button('5', ['onclick'=>'changeColor(this)', 'class'=>'d_speed', 'value'=>'5', 'style'=>'background-color: #3CB371;'.$btn_style]).$space ?>
                   <br>
                    <br>
                     <?= $form->field($model, 'd_cost')->hiddenInput()->label("Cost") ?>
                    <?php echo Html::button('1', ['onclick'=>'changeColor(this)', 'class'=>'d_cost', 'value'=> '1', 'style'=>'background-color: #DC143C;'.$btn_style]).$space ?>
                    <?php echo Html::button('2', ['onclick'=>'changeColor(this)', 'class'=>'d_cost', 'value'=> '2', 'style'=>'background-color: #FFA07A;'.$btn_style]).$space ?>
                    <?php echo Html::button('3', ['onclick'=>'changeColor(this)', 'class'=>'d_cost', 'value'=> '3', 'style'=>'background-color: #F5DEB3;'.$btn_style]).$space ?>
                    <?php echo Html::button('4', ['onclick'=>'changeColor(this)', 'class'=>'d_cost', 'value'=> '4', 'style'=>'background-color: #98FB98;'.$btn_style]).$space ?>
                    <?php echo Html::button('5', ['onclick'=>'changeColor(this)', 'class'=>'d_cost', 'value'=> '5', 'style'=>'background-color: #3CB371;'.$btn_style]).$space ?>
                    <br>
                    <br>
                    <?= $form->field($model, 'd_attitude')->hiddenInput()->label("Attitude of staff") ?>
                    <?php echo Html::button('1', ['onclick'=>'changeColor(this)', 'class'=>'d_attitude', 'value'=>'1', 'style'=>'background-color: #DC143C;'.$btn_style]).$space ?>
                    <?php echo Html::button('2', ['onclick'=>'changeColor(this)', 'class'=>'d_attitude', 'value'=>'2','style'=>'background-color: #FFA07A;'.$btn_style]).$space ?>
                    <?php echo Html::button('3', ['onclick'=>'changeColor(this)', 'class'=>'d_attitude', 'value'=>'3','style'=>'background-color: #F5DEB3;'.$btn_style]).$space ?>
                    <?php echo Html::button('4', ['onclick'=>'changeColor(this)', 'class'=>'d_attitude', 'value'=>'4','style'=>'background-color: #98FB98;'.$btn_style]).$space ?>
                    <?php echo Html::button('5', ['onclick'=>'changeColor(this)', 'class'=>'d_attitude', 'value'=>'5','style'=>'background-color: #3CB371;'.$btn_style]).$space ?> 
                    <br>
                    <br>  <?= $form->field($model, 'd_overall')->hiddenInput()->label("Over-all customer experience") ?>
                    <?php echo Html::button('1', ['onclick'=>'changeColor(this)', 'class'=>'d_overall', 'value'=>'1','style'=>'background-color: #DC143C;'.$btn_style]).$space ?>
                    <?php echo Html::button('2', ['onclick'=>'changeColor(this)', 'class'=>'d_overall', 'value'=>'2','style'=>'background-color: #FFA07A;'.$btn_style]).$space ?>
                    <?php echo Html::button('3', ['onclick'=>'changeColor(this)', 'class'=>'d_overall', 'value'=>'3','style'=>'background-color: #F5DEB3;'.$btn_style]).$space ?>
                    <?php echo Html::button('4', ['onclick'=>'changeColor(this)', 'class'=>'d_overall', 'value'=>'4','style'=>'background-color: #98FB98;'.$btn_style]).$space ?>
                    <?php echo Html::button('5', ['onclick'=>'changeColor(this)', 'class'=>'d_overall', 'value'=>'5','style'=>'background-color: #3CB371;'.$btn_style]).$space ?>
                    </div>
                </div>
            </div>

            <div class="row">
        <div class="col-sm-6">
        <div class="panel panel-info">
            <div class="panel-heading">How Important are these items to you?</div>
                <div class="panel-body">
                    <?= $form->field($model, 'i_deliverytime')->hiddenInput()->label("Delivery Time") ?>
                    <?php echo Html::button('1', ['onclick'=>'changeColor(this)', 'class'=>'i_deliverytime', 'value'=>'1','style'=>'background-color: #DC143C;'.$btn_style]).$space ?>
                    <?php echo Html::button('2', ['onclick'=>'changeColor(this)', 'class'=>'i_deliverytime',  'value'=>'2','style'=>'background-color: #FFA07A;'.$btn_style]).$space ?>
                    <?php echo Html::button('3', ['onclick'=>'changeColor(this)', 'class'=>'i_deliverytime', 'value'=>'3','style'=>'background-color: #F5DEB3;'.$btn_style]).$space ?> 
                    <?php echo Html::button('4', ['onclick'=>'changeColor(this)', 'class'=>'i_deliverytime', 'value'=>'4','style'=>'background-color: #98FB98;'.$btn_style]).$space ?>
                    <?php echo Html::button('5', ['onclick'=>'changeColor(this)', 'class'=>'i_deliverytime', 'value'=>'5','style'=>'background-color: #3CB371;'.$btn_style]).$space ?>   
                    <br>
                    <br>
                    <?= $form->field($model, 'i_accuracy')->hiddenInput()->label("Correctness and accuracy of test results") ?>
                    <?php echo Html::button('1', ['onclick'=>'changeColor(this)', 'class'=>'i_accuracy', 'value'=>'1','style'=>'background-color: #DC143C;'.$btn_style]).$space ?>  
                    <?php echo Html::button('2', ['onclick'=>'changeColor(this)', 'class'=>'i_accuracy', 'value'=>'2','style'=>'background-color: #FFA07A;'.$btn_style]).$space ?>          
                    <?php echo Html::button('3', ['onclick'=>'changeColor(this)', 'class'=>'i_accuracy', 'value'=>'3','style'=>'background-color: #F5DEB3;'.$btn_style]).$space ?>
                    <?php echo Html::button('4', ['onclick'=>'changeColor(this)', 'class'=>'i_accuracy', 'value'=>'4','style'=>'background-color: #98FB98;'.$btn_style]).$space ?>
                    <?php echo Html::button('5', ['onclick'=>'changeColor(this)', 'class'=>'i_accuracy', 'value'=>'5','style'=>'background-color: #3CB371;'.$btn_style]).$space ?>      
                    <br>
                    <br>
                    <?= $form->field($model, 'i_speed')->hiddenInput()->label("Speed of Service") ?>
                    <?php echo Html::button('1', ['onclick'=>'changeColor(this)', 'class'=>'i_speed', 'value'=>'1','style'=>'background-color: #DC143C;'.$btn_style]).$space ?>  
                    <?php echo Html::button('2', ['onclick'=>'changeColor(this)', 'class'=>'i_speed', 'value'=>'2','style'=>'background-color: #FFA07A;'.$btn_style]).$space ?>     
                    <?php echo Html::button('3', ['onclick'=>'changeColor(this)', 'class'=>'i_speed', 'value'=>'3','style'=>'background-color: #F5DEB3;'.$btn_style]).$space ?>
                    <?php echo Html::button('4', ['onclick'=>'changeColor(this)', 'class'=>'i_speed', 'value'=>'4','style'=>'background-color: #98FB98;'.$btn_style]).$space ?>
                    <?php echo Html::button('5', ['onclick'=>'changeColor(this)', 'class'=>'i_speed', 'value'=>'5','style'=>'background-color: #3CB371;'.$btn_style]).$space ?>           
                    <br>
                    <br>
                    <?= $form->field($model, 'i_cost')->hiddenInput()->label("Cost") ?>
                    <?php echo Html::button('1', ['onclick'=>'changeColor(this)', 'class'=>'i_cost', 'value'=>'1','style'=>'background-color: #DC143C;'.$btn_style]).$space ?>     
                    <?php echo Html::button('2', ['onclick'=>'changeColor(this)', 'class'=>'i_cost', 'value'=>'2','style'=>'background-color: #FFA07A;'.$btn_style]).$space ?>
                    <?php echo Html::button('3', ['onclick'=>'changeColor(this)', 'class'=>'i_cost', 'value'=>'3','style'=>'background-color: #F5DEB3;'.$btn_style]).$space ?>
                    <?php echo Html::button('4', ['onclick'=>'changeColor(this)', 'class'=>'i_cost', 'value'=>'4','style'=>'background-color: #98FB98;'.$btn_style]).$space ?>        
                    <?php echo Html::button('5', ['onclick'=>'changeColor(this)', 'class'=>'i_cost', 'value'=>'5','style'=>'background-color: #3CB371;'.$btn_style]).$space ?>         
                    <br>
                    <br>
                    <?= $form->field($model, 'i_attitude')->hiddenInput()->label("Attitude of Staff") ?>
                    <?php echo Html::button('1', ['onclick'=>'changeColor(this)', 'class'=>'i_attitude', 'value'=>'1','style'=>'background-color: #DC143C;'.$btn_style]).$space ?>  
                    <?php echo Html::button('2', ['onclick'=>'changeColor(this)', 'class'=>'i_attitude', 'value'=>'2','style'=>'background-color: #FFA07A;'.$btn_style]).$space ?>
                    <?php echo Html::button('3', ['onclick'=>'changeColor(this)', 'class'=>'i_attitude', 'value'=>'3','style'=>'background-color: #F5DEB3;'.$btn_style]).$space ?>
                    <?php echo Html::button('4', ['onclick'=>'changeColor(this)', 'class'=>'i_attitude', 'value'=>'4','style'=>'background-color: #98FB98;'.$btn_style]).$space ?>
                    <?php echo Html::button('5', ['onclick'=>'changeColor(this)', 'class'=>'i_attitude', 'value'=>'5','style'=>'background-color: #3CB371;'.$btn_style]).$space ?>             
                    <br>
                    <br>
                    <?= $form->field($model, 'i_overall')->hiddenInput()->label("Over-all customer experience") ?>
                    <?php echo Html::button('1', ['onclick'=>'changeColor(this)', 'class'=>'i_overall', 'value'=>'1','style'=>'background-color: #DC143C;'.$btn_style]).$space ?>          
                    <?php echo Html::button('2', ['onclick'=>'changeColor(this)', 'class'=>'i_overall', 'value'=>'2','style'=>'background-color: #FFA07A;'.$btn_style]).$space ?>     
                    <?php echo Html::button('3', ['onclick'=>'changeColor(this)', 'class'=>'i_overall', 'value'=>'3','style'=>'background-color: #F5DEB3;'.$btn_style]).$space ?>                  
                    <?php echo Html::button('4', ['onclick'=>'changeColor(this)', 'class'=>'i_overall', 'value'=>'4','style'=>'background-color: #98FB98;'.$btn_style]).$space ?>
                    <?php echo Html::button('5', ['onclick'=>'changeColor(this)', 'class'=>'i_overall', 'value'=>'5','style'=>'background-color: #3CB371;'.$btn_style]).$space ?>                  
                    <br>
                    <br>
                </div>
        </div>

        <div class="panel panel-info">

            <div class="panel-heading">How likely is it that you would recommend our service to others?</div>
                <div class="panel-body">
                    <?= $form->field($model, 'recommend')->hiddenInput()->label("Recommend") ?>
                    <?php echo Html::button('1', ['onclick'=>'changeColor_rec(this)', 'class'=>'recommend', 'value'=>'1','style'=>'background-color: #DC143C;'.$btn_style])?>        
                    <?php echo Html::button('2', ['onclick'=>'changeColor_rec(this)', 'class'=>'recommend', 'value'=>'2','value' => '2', 'style'=>'background-color: #CD5C5C;'.$btn_style]) ?>
                    <?php echo Html::button('3', ['onclick'=>'changeColor_rec(this)', 'class'=>'recommend', 'value'=>'3','style'=>'background-color: #F08080;'.$btn_style])?>
                    <?php echo Html::button('4', ['onclick'=>'changeColor_rec(this)', 'class'=>'recommend', 'value'=>'4','style'=>'background-color: #E9967A;'.$btn_style]) ?>
                    <?php echo Html::button('5', ['onclick'=>'changeColor_rec(this)', 'class'=>'recommend', 'value'=>'5','style'=>'background-color: #FFA07A;'.$btn_style]) ?>
                    <?php echo Html::button('6', ['onclick'=>'changeColor_rec(this)',' class'=>'recommend', 'value'=>'6','style'=>'background-color: #FFEFD5;'.$btn_style]) ?>
                    <?php echo Html::button('7', ['onclick'=>'changeColor_rec(this)', 'class'=>'recommend', 'value'=>'7','value' => '2', 'style'=>'background-color: #98FB98;'.$btn_style]) ?>
                    <?php echo Html::button('8', ['onclick'=>'changeColor_rec(this)', 'class'=>'recommend', 'value'=>'8','style'=>'background-color: #32CD32;'.$btn_style]) ?>
                    <?php echo Html::button('9', ['onclick'=>'changeColor_rec(this)', 'class'=>'recommend', 'value'=>'9','style'=>'background-color: #008000;'.$btn_style]) ?>
                    <?php echo Html::button('10', ['onclick'=>'changeColor_rec(this)','class'=>'recommend', 'value'=>'10','style'=>'background-color: #006400;'.$btn_style]) ?>    
                 </div>
          
        </div>

        <div class="panel panel-info">

        <div class="panel-heading"></div>
            <div class="panel-body">
                 <?= $form->field($model, 'essay')->textInput(['maxlength' => true]) ?>
            </div>
       
        </div>    

            <?= $form->field($model, 'r_date')->textInput() ?>
        </div>
        </div>
   
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

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