<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\grid\ActionColumn;
use \yii\helpers\ArrayHelper;
use common\components\Functions;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use common\components\ReferralComponent;
use kartik\grid\DataColumn;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $searchModel common\models\referral\ServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Referral Request';
$this->params['breadcrumbs'][] = ['label' => 'Referrals', 'url' => ['/referrals']];
$this->params['breadcrumbs'][] = $this->title;
$func=new Functions();
$refcomp = new ReferralComponent();
?>
<div class="service-index">
    <!--<div style="background-color: #aed6f1 ;border: 2px solid  #5dade2 ;" class="alert">
        <span style="color:#000000;">
            <strong>Note : </strong> Offer / Unoffer test for your agency. If test/calibration is not found in the list, please contact the administrator to add your test/calibration.
        </span>
    </div>-->
        <div class="row">
            <?php
                $form = ActiveForm::begin([
                    'id' => 'service-form',
                    'options' => [
                        'class' => 'form-horizontal',
                        'data-pjax' => true,
                    ],
                    'method' => 'get',
                ])
            ?>
            <div class="col-sm-4">
            <?php
                echo '<label class="control-label">Laboratory </label>';
                echo Select2::widget([
                    'name' => 'service-lab_id',
                    'data' => $laboratory,
                    'theme' => Select2::THEME_KRAJEE,
                    'options' => ['id' => 'service-lab_id'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'placeholder' => 'Select Laboratory',
                    ],
                ]);
            ?>
            </div>
            <div class="col-sm-4">
            <?php
                echo '<label class="control-label">Sample Type </label>';
                echo DepDrop::widget([
                    'type'=>DepDrop::TYPE_SELECT2,
                    'name' => 'service-sampletype_id',
                    'data' => $sampletype,
                    'options' => ['id'=>'service-sampletype_id'],
                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                    'pluginOptions' => [
                        'depends'=>['service-lab_id'],
                        'placeholder' => 'Select Sample Type',
                        'url'=>Url::to(['list_sampletype']),
                        'loadingText' => 'Loading Sample type...',
                    ],
                ]);
            ?>
            </div>
            <div class="col-sm-4">
            <?php
                echo '<label class="control-label">Test Name </label>';
                echo DepDrop::widget([
                    'type'=>DepDrop::TYPE_SELECT2,
                    'name' => 'service-testname_id',
                    'data' => $testname,
                    'options' => ['id'=>'service-testname_id'],
                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                    'pluginOptions' => [
                        'placeholder' => 'Select Test Name',
                        'depends'=>['service-lab_id','service-sampletype_id'],
                        'url'=>Url::to(['list_testname']),
                        'loadingText' => 'Loading Test name...',
                    ],
                ]);
            ?>
            <?php ActiveForm::end(); ?>
            </div>
        </div>
        <br>
        <!--<div class="container">-->
            <!--<div class="table-responsive">-->
        <div>
            <?php
                /*echo GridView::widget([
                    'id' => 'service-grid',
                    'dataProvider'=> $dataProvider,
                    'pjax'=>true,
                    'pjaxSettings' => [
                        'options' => [
                            'enablePushState' => false,
                        ]
                    ],
                    'responsive'=>true,
                    'striped'=>true,
                    'hover'=>true,
                    'panel' => [
                        'heading'=>'<h3 class="panel-title">Offer / Unoffer Services</h3>',
                        'type'=>'primary',
                        'before'=>'
                        <span style="color:#000000;">
                            <strong>Note : </strong> Offer / Unoffer test for your agency. If test/calibration is not found in the list, please contact the administrator to add your test/calibration.
                        </span>',
                        'after'=>'',
                    ],
                    'columns' => [
                        'service_id',
                        'agency_id',
                        'method_ref_id',
                        'offered_date',
                    ],
                    'toolbar' => '',
                ]);*/
            ?>
        </div>
    </div>
</div>
