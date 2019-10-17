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
/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\CsfSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$requestlist= ArrayHelper::map(Request::find()->orderBy(['request_id' => SORT_DESC])->all(),'request_id','request_ref_num');

$js=<<<SCRIPT
SCRIPT;
?>

<?php ini_set("memory_limit", "10000M");?>

<h3 style="color:#142142;font-family:verdana;text-align:center;font-size:150%;text-shadow: 
      4px 4px 0px #d5d5d5, 
      7px 7px 0px rgba(0, 0, 0, 0.2);"><b>Department of Science and Technology</b></h3>
<h3 style="color:#142142;font-family:verdana;text-align:center;font-size:150%;text-shadow: 
      4px 4px 0px #d5d5d5, 
      7px 7px 0px rgba(0, 0, 0, 0.2);"><b>REGIONAL STANDARDS AND TESTING LABORATORY</b></h3>

<h1 style="color:#1a4c8f;font-family:Century Gothic;text-align:center;font-size:250%;text-shadow: 
      4px 4px 0px #d5d5d5, 
      7px 7px 0px rgba(0, 0, 0, 0.2);"><b>Customer Satisfaction Feedback Survey</b></h1><br>

    <?php
                    $btn_style = ';height: 45px;width: 45px; border-radius: 50%;display: inline-block;color:#0f096d;box-shadow: inset 0px 25px 0 rgba(255,255,255,0.3), 0 5px 5px rgba(0, 0, 0, 0.3);';
                    $space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    ?>
    <div class="csf-form" style="margin: 0 70px;">
    <?php $form = ActiveForm::begin(); ?>         
    <div class="row">
        <div class="col-sm-6">
                <div class="panel panel-info">
                            <div class="panel-heading" style="color:#142142;font-family:Century Gothic;font-size:130%;"><b>Legends</b></div>
                            <div class="panel-body">
                            <?php echo Html::button('5', [ 'style'=>'background-color: #3CB371;'.$btn_style]).$space ?> 
                            <?php echo Html::button('4', [ 'style'=>'background-color: #98FB98;'.$btn_style]).$space ?>                 
                            <?php echo Html::button('3', [ 'style'=>'background-color: #F5DEB3'.$btn_style]).$space ?>
                            <?php echo Html::button('2', [ 'style'=>'background-color: #FFA07A'.$btn_style]).$space ?>
                            <?php echo Html::button('1', [ 'style'=>'background-color: #DC143C'.$btn_style]).$space ?>
                            <br>
                            <br>
                            (<b>5</b>) Very satisfied <br>
                            (<b>4</b>) Quite Satisfied <br>
                            (<b>3</b>) Neither satisfied nor Dissatisfied <br>
                            (<b>2</b>) Quite Dissatisfied <br>
                            (<b>1</b>) Very Dissatisfied <br>        
                        </div>
                </div>
                <div class="panel panel-info">
                <div class="panel-heading" style="color:#142142;font-family:Century Gothic;font-size:130%;"><b>Information</b></div>
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
                                                    ArrayHelper::map(Lab::find()->where(['active'=> 1])->all(),'lab_id','labname'),
                                                    ['itemOptions' => ['onchange'=>$js]]
                        ); ?>
                      
                    </div>
                </div>
                
              
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>   
            