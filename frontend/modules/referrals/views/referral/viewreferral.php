<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use common\components\Functions;
use common\components\ReferralComponent;
use common\models\lab\Cancelledrequest;
use common\models\lab\Discount;
use common\models\lab\Request;
use common\models\lab\Sample;
use common\models\lab\Sampletype;
use common\models\finance\Paymentitem;

use common\models\lab\Package;
use yii\bootstrap\Modal;
use kartik\dialog\Dialog;
use yii\web\JsExpression;
//use kop\y2sp\ScrollPager;
use yii\widgets\ListView;
use kartik\tabs\TabsX;

//$Connection = Yii::$app->financedb;
//$func = new Functions();
//$referralcomp = new ReferralComponent();

$this->title = empty($request['referral_code']) ? $request['referral_id'] : $request['referral_code'];
$this->params['breadcrumbs'][] = ['label' => 'Referrals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("/css/modcss/progress.css", [], 'css-search-bar');

$rstl_id=$rstl_id=(int) Yii::$app->user->identity->profile->rstl_id;
$statusreceived="progress-todo";
$statusshipped="progress-todo";
$statusaccepted="progress-todo";
$statusongoing="progress-todo";
$statuscompleted="progress-todo";
$statusuploaded="progress-todo";

foreach($logs as $log){
    if($log->referralstatus_id == 1){
       $statusreceived ="progress-done";
    }
    if($log->referralstatus_id == 2){
       $statusshipped ="progress-done";
    }
    if($log->referralstatus_id == 3){
       $statusaccepted ="progress-done";
    }
    if($log->referralstatus_id == 4){
       $statusongoing ="progress-done";
    }
    
    if($log->referralstatus_id == 4){
       $statuscompleted ="progress-done";
    }
    if($log->referralstatus_id == 5){
       $statusuploaded ="progress-done";
    }
}

$haveStatus = "";
//$Func="LoadModal('Update Received Track','/finance/cancelop/create?op=".$model->orderofpayment_id."',true,500)";
//$UpdateButton='<button id="btnUpdate" onclick="'.$Func.'" type="button" style="float: right;padding-right:5px;margin-left: 5px" class="btn btn-danger"><i class="fa fa-remove"></i> Cancel Order of Payment</button>';
if(!isset(\Yii::$app->session['config-item'])){
   \Yii::$app->session['config-item']=1; //Laboratories 
}
switch(\Yii::$app->session['config-item']){
    case 1: //Laboratories
        $LogActive=true;
        $ResultActive=false;
        $TrackActive=false;
        break;
    case 2: // Technical Managers
        $LogActive=false;
        $ResultActive=true;
        $TrackActive=false;
        break;
    case 3: //Discount
        $LogActive=false;
        $ResultActive=false;
        $TrackActive=true;
        break;
}
$Session= Yii::$app->session;
?>
<div class="section-request">
<div class="request-view ">
    <div class="image-loader" style="display: none;"></div>
    <div class="container table-responsive">
        <?php
            echo DetailView::widget([
            'model'=>$model,
            'responsive'=>true,
            'hover'=>true,
            'mode'=>DetailView::MODE_VIEW,
            'panel'=>[
                'heading'=>'<i class="glyphicon glyphicon-book"></i> Referral Code ' . $request['referral_code'],
                'type'=>DetailView::TYPE_PRIMARY,
            ],
            'buttons1' => '',
            'attributes'=>[
                [
                    'group'=>true,
                    'label'=>'Referral Details ',
                    'rowOptions'=>['class'=>'info']
                ],
                [
                    'columns' => [
                        [
                            'label'=>'Referral Code',
                            'displayOnly'=>true,
                            'valueColOptions'=>['style'=>'width:30%'],
                            'value'=> $request['referral_code'],
                        ],
                        [
                            'label'=>'Customer / Agency',
                            'format'=>'raw',
                            'value'=> $request['customer_id'] > 0 && count($customer) > 0 ? $customer['customer_name'] : "",
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                    ],
                ],
                [
                    'columns' => [
                        [
                            'label'=>'Referral Date / Time',
                            'format'=>'raw',
                            'value'=> ($request['referral_date_time'] != "0000-00-00 00:00:00") ? Yii::$app->formatter->asDate($request['referral_date_time'], 'php:F j, Y h:i a') : "<i class='text-danger font-weight-bold h5'>Pending referral request</i>",
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                        [
                            'label'=>'Address',
                            'format'=>'raw',
                            'value'=> $request['customer_id'] > 0 && count($customer) > 0 ? $customer['address'] : "",
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                    ],
                    
                ],
                [
                    'columns' => [
                       [
                            'label'=>'Sample Received Date',
                            'format'=>'raw',
                            'value'=> !empty($request['sample_received_date']) ? Yii::$app->formatter->asDate($request['sample_received_date'], 'php:F j, Y') : "<i class='text-danger font-weight-bold h5'>No sample received date</i>",
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                        [
                            'label'=>'Tel no.',
                            'format'=>'raw',
                            'value'=> $request['customer_id'] > 0 && count($customer) > 0 ? $customer['tel'] : "",
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                    ],
                ],
                [
                    'columns' => [
                        [
                            'label'=>'Estimated Due Date',
                            'format'=>'raw',
                            'value'=> ($request['report_due'] != "0000-00-00 00:00:00") ? Yii::$app->formatter->asDate($request['report_due'], 'php:F j, Y') : "<i class='text-danger font-weight-bold h5'>Pending referral request</i>",
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                        [
                            'label'=>'Fax no.',
                            'format'=>'raw',
                            'value'=> $request['customer_id'] > 0 && count($customer) > 0 ? $customer['fax'] : "",
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                    ],
                ],
                [
                    'columns' => [
                        [
                            //'attribute'=>'report_due',
                            'label'=>'Referred by',
                            'format'=>'raw',
                            'value'=> !empty($receiving_agency) ? $receiving_agency : null,
                            'displayOnly'=>true
                        ],
                        [
                            'label'=>'Referred to',
                            'format'=>'raw',
                            //'value'=>$model->customer ? $model->customer->fax : "",
                            'value'=> !empty($testing_agency) ? $testing_agency : null,
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                    ],
                ],
                [
                    'group'=>true,
                    'label'=>'Payment Details',
                    'rowOptions'=>['class'=>'info']
                ],
                [
                    'columns' => [
                        [
                            'label'=>'Deposit Slip',
                            'value'=>function() use ($depositslip,$model,$request){
                                $link = '';
                                if($depositslip > 0){
                                    foreach ($depositslip as $deposit) {
                                        $link .= Html::a('<span class="glyphicon glyphicon-save-file"></span> '.$deposit['filename'],'/referrals/attachment/download?request_id='.$request['local_request_id'].'&file='.$deposit['attachment_id'], ['style'=>'font-size:12px;color:#000077;font-weight:bold;','title'=>'Download Deposit Slip','target'=>'_self'])."<br>";
                                    }
                                }
                                return $link;
                            },
                            'format'=>'raw',
                            'displayOnly'=>true,
                            'valueColOptions'=>['style'=>'width:30%;vertical-align: top;'],
                            'labelColOptions' => ['style' => 'width: 20%; text-align: right; vertical-align: top;'],
                        ],
                        [
                            'label'=>'Official Receipt',
                            'format'=>'raw',
                            'value'=>function() use ($officialreceipt,$model,$request){
                                $link = '';
                                if($officialreceipt > 0){
                                    foreach ($officialreceipt as $or) {
                                        $link .= Html::a('<span class="glyphicon glyphicon-save-file"></span> '.$or['filename'],'/referrals/attachment/download?request_id='.$request['local_request_id'].'&file='.$or['attachment_id'], ['style'=>'font-size:12px;color:#000077;font-weight:bold;','title'=>'Download Official Receipt','target'=>'_self'])."<br>";
                                    }
                                }
                                return $link;
                            },
                            'valueColOptions'=>['style'=>'width:30%;vertical-align: top;'], 
                            'displayOnly'=>true,
                            'labelColOptions' => ['style' => 'width: 20%; text-align: right; vertical-align: top;'],
                        ],
                    ],
                ],              
                [
                    'group'=>true,
                    'label'=>'Transaction Details',
                    'rowOptions'=>['class'=>'info']
                ],
                [
                    'columns' => [
                        [ 
                            'label'=>'Received By',
                            'format'=>'raw',
                            'value'=>$request['cro_receiving'],
                            'displayOnly'=>true,
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'label'=>'Conforme',
                            'value'=> $request['conforme'],
                            'format'=>'raw',
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                    ],
                ],
            ],

        ]);
        ?>
    </div>
    <div class="container">
        <div class="table-responsive">
        <?php
            $gridColumns = [
                [
                    'attribute'=>'sample_code',
                    'enableSorting' => false,
                    'contentOptions' => [
                        'style'=>'max-width:70px; overflow: auto; white-space: normal; word-wrap: break-word;'
                    ],
                ],
                [
                    'attribute'=>'sample_name',
                    'enableSorting' => false,
                ],
                [
                    'attribute'=>'description',
                    'format' => 'raw',
                    'enableSorting' => false,
                    'value' => function($data) use ($request){
                        return ($request['lab_id'] == 2) ? "Sampling Date: <span style='color:#000077;'><b>".date("Y-m-d h:i A",strtotime($data['sampling_date']))."</b></span>,&nbsp;".$data['description'] : $data['description'];
                    },
                   'contentOptions' => [
                        'style'=>'max-width:180px; overflow: auto; white-space: normal; word-wrap: break-word;'
                    ],
                ],
            ];

            echo GridView::widget([
                'id' => 'sample-grid',
                'dataProvider'=> $sampleDataProvider,
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
                    'heading'=>'<h3 class="panel-title">Samples</h3>',
                    'type'=>'primary',
                    'before'=>null,
                    'after'=>false,
                ],
                'columns' => $gridColumns,
                'toolbar' => [
                    'content'=> Html::a('<i class="glyphicon glyphicon-repeat"></i> Refresh Grid', [Url::to(['referral/view','id'=>$request['referral_id']])], [
                                'class' => 'btn btn-default', 
                                'title' => 'Refresh Grid'
                            ]),
                ],
            ]);
        ?>
        </div>
    </div>
    <div class="container">
    <?php

        $analysisgridColumns = [
            [
                'attribute'=>'sample_name',
                'header'=>'Sample',
                'format' => 'raw',
                'enableSorting' => false,
                /*'value' => function($model) {
                    //return $model->sample ? $model->sample->samplename : '-';
                },*/
                'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
               
            ],
            [
                'attribute'=>'sample_code',
                'header'=>'Sample Code',
                /*'value' => function($model) {
                    //return $model->sample ? $model->sample->sample_code : '-';
                },*/
                'format' => 'raw',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
            ],
            [
                'attribute'=>'test_name',
                'format' => 'raw',
                'header'=>'Test/ Calibration Requested',
                'contentOptions' => ['style' => 'width: 15%;word-wrap: break-word;white-space:pre-line;'],
                'enableSorting' => false,
            ],
            [
                'attribute'=>'method',
                'format' => 'raw',
                'header'=>'Test Method',
                'enableSorting' => false,  
                'contentOptions' => ['style' => 'width: 50%;word-wrap: break-word;white-space:pre-line;'],
                'pageSummary' => '<span style="float:right";>SUBTOTAL<BR>DISCOUNT<BR><B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL</B></span>',             
            ],
            [
                'attribute'=>'fee',
                'header'=>'Unit Price',
                'enableSorting' => false,
                'hAlign'=>'right',
                'format' => 'raw',
                'value'=>function($data){
                    return number_format($data['analysis_fee'],2);
                },
                'contentOptions' => [
                    'style'=>'max-width:80px; overflow: auto; white-space: normal; word-wrap: break-word;'
                ],
                'hAlign' => 'right', 
                'vAlign' => 'left',
                'width' => '7%',
                'format' => 'raw',
                'pageSummary'=> function () use ($subtotal,$discounted,$total,$countSample) {
                    if($countSample > 0){
                        return  '<div id="subtotal">₱'.number_format($subtotal, 2).'</div><div id="discount">₱'.number_format($discounted, 2).'</div><div id="total"><b>₱'.number_format($total, 2).'</b></div>';
                    } else {
                        return '';
                    }
                },
            ],
        ];
            echo GridView::widget([
                'id' => 'analysis-grid',
                'responsive'=>true,
                'dataProvider'=> $analysisdataprovider,
                'pjax'=>true,
                'pjaxSettings' => [
                    'options' => [
                        'enablePushState' => false,
                    ]
                ],
                'responsive'=>true,
                'striped'=>true,
                'hover'=>true,
                'showPageSummary' => true,
                'hover'=>true,
                
                'panel' => [
                    'heading'=>'<h3 class="panel-title">Analysis</h3>',
                    'type'=>'primary',
                    'before'=> null,
                    'after'=> false,
                    'footer'=>null,
                ],
                'columns' => $analysisgridColumns,
                'toolbar' => [
                    'content'=> Html::a('<i class="glyphicon glyphicon-repeat"></i> Refresh Grid', [Url::to(['referral/view','id'=>$request['referral_id']])], [
                                'class' => 'btn btn-default', 
                                'title' => 'Refresh Grid'
                            ]),
                ],
            ]);
        ?>
    </div>
    
    <div class="container" <?php echo $haveStatus; ?>>
        <ul class="progress-track">
                <li class="<?php echo $statusreceived; ?> progress-tooltip">
                        <div class="progress-icon-wrap">
                                <span class="fa fa-dropbox fa-fw to-fit-icon" aria-hidden="true"></span>
                        </div>
                        <span class="progress-tooltiptext">Received</span>
                </li>
                <li class="<?php echo $statusshipped; ?> progress-tooltip">
                        <div class="progress-icon-wrap">
                                <span class="fa fa-truck fa-fw fa-flip-horizontal to-fit-icon" aria-hidden="true"></span>
                        </div>
                        <span class="progress-tooltiptext">Shipped</span>
                </li>
                <li class="<?php echo $statusaccepted; ?> progress-tooltip">
                        <div class="progress-icon-wrap">
                                <span style="margin-left:2px;" class="fa fa-cube fa-fw fa-lg to-fit-icon" aria-hidden="true"></span>
                        </div>
                        <span class="progress-tooltiptext">Accepted</span>
                </li>
                <li class="<?php echo $statusongoing; ?> progress-tooltip">
                        <div class="progress-icon-wrap">
                                <span class="fa fa-flask fa-fw to-fit-icon" aria-hidden="true"></span>
                        </div>
                        <span class="progress-tooltiptext">Ongoing</span>
                </li>
                <li class="<?php echo $statuscompleted; ?> progress-tooltip">
                        <div class="progress-icon-wrap">
                                <span class="fa fa-check fa-fw to-fit-icon" aria-hidden="true"></span>
                        </div>
                        <span class="progress-tooltiptext">Completed</span>
                </li>
                <li class="<?php echo $statusuploaded; ?> progress-tooltip">
                        <div class="progress-icon-wrap">
                                <span class="fa fa-upload fa-fw to-fit-icon" aria-hidden="true"></span>
                        </div>
                        <span class="progress-tooltiptext">Uploaded</span>
                </li>
        </ul>
    </div>
    
      <div class="container">
         <div class="panel panel-primary">
        
        <div class="panel-body">
        <?php  
         $gridColumn="<div class='row'><div class='col-md-12'>". GridView::widget([
           'dataProvider' => $notificationDataProvider,
           // 'filterModel' => $searchModel,
            'id'=>'LaboratoryGrid',
            'tableOptions'=>['class'=>'table table-hover table-stripe table-hand'],
            'pjax'=>true,
            'pjaxSettings' => [
                    'options' => [
                        'enablePushState' => false,
                    ],
            ],
            'toolbar'=>[],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<i class="fa fa-columns"></i> List',
             ],
            'columns' => [
                [
                    'attribute' => '',
                    'label' => 'Date and Time',
                    'value' => function($model) {
                        return date("F j, Y h:i:s A", strtotime($model['notification_date']));
                    }
                ],
                [
                    'attribute' => '',
                    'label' => 'Details',
                    'value'=>function($model){
                        switch($model['notification_type_id']){
                            case 1:
                                return 'Notification sent to '.$model['recipient']['name'].' by '.$model['sender']['name'];
                            case 2:
                                return $model['sender']['name'].' confirmed the notification for Referral.';
                            case 3:
                                return 'Referral sent to '.$model['recipient']['name'];
                            default:

                        }
                    }
                ],
            ],
        ])."</div></div>";
         
         //$display=true;
         $trackreceiving=DetailView::widget([
                'model' =>$modelRefTrackreceiving,
                'responsive'=>true, 
             
                'hover'=>true,
                'mode'=>DetailView::MODE_VIEW,
                'panel'=>[
                    'type'=>DetailView::TYPE_PRIMARY,
                ],
                'buttons1' => '',
                'attributes' => [
                    [
                       
                        'columns' => [
                            [
                                'label'=>'Referred to',
                                'format'=>'raw',
                                'value'=>!empty($request['agencytesting']) ? $request['agencytesting']['name'] : null,//$model->transactionnum,
                                'valueColOptions'=>['style'=>'width:30%'], 
                                'displayOnly'=>true
                            ],
                            [
                                'label'=>'Referral Code',
                                'format'=>'raw',
                                'value'=>$request['referral_code'],
                                'valueColOptions'=>['style'=>'width:30%'], 
                                'displayOnly'=>true
                            ],
                        ],

                    ], 
                    [
                        'columns' => [
                            [
                                'label'=>'Date Received from Customer',
                                'format'=>'raw',
                                'value'=>!empty($modelRefTrackreceiving->sample_received_date) ? Yii::$app->formatter->asDate($modelRefTrackreceiving->sample_received_date, 'php:F j, Y') : "<i class='text-danger font-weight-bold h5'>No sample received date</i>",//$model->transactionnum,
                                'valueColOptions'=>['style'=>'width:30%'], 
                                'displayOnly'=>true
                            ],
                            [
                                'label'=>'Courier',
                                'format'=>'raw',
                                'value'=>!empty($modelRefTrackreceiving->courier) ? $modelRefTrackreceiving->courier->name : "<i class='text-danger font-weight-bold h5'>No courier</i>",//$model->customer ? $model->customer->customer_name : "",
                                'valueColOptions'=>['style'=>'width:30%'], 
                                'displayOnly'=>true
                            ],
                        ],

                    ], 
                     [
                        'columns' => [
                            [
                                'label'=>'Shipping Date',
                                'format'=>'raw',
                                'value'=>!empty($modelRefTrackreceiving->shipping_date) ? Yii::$app->formatter->asDate($modelRefTrackreceiving->shipping_date, 'php:F j, Y') : "<i class='text-danger font-weight-bold h5'>No data</i>",
                                'valueColOptions'=>['style'=>'width:30%'], 
                                'displayOnly'=>true
                            ],
                            [
                                'label'=>'Calibration Specimen Received from Customer',
                                'format'=>'raw',
                                'value'=>!empty($modelRefTrackreceiving->cal_specimen_received_date) ? Yii::$app->formatter->asDate($modelRefTrackreceiving->cal_specimen_received_date, 'php:F j, Y') : "<i class='text-danger font-weight-bold h5'>No data</i>",
                                'valueColOptions'=>['style'=>'width:30%'], 
                                'displayOnly'=>true
                            ],
                        ],

                    ],
                ],
            ]);
         $tracktesting=DetailView::widget([
                'model' =>$modelRefTracktesting,
                'responsive'=>true, 
             
                'hover'=>true,
                'mode'=>DetailView::MODE_VIEW,
                'panel'=>[
                    'type'=>DetailView::TYPE_PRIMARY,
                ],
                'buttons1' => '',
                'attributes' => [
                  
                    [
                        'columns' => [
                            [
                                'label'=>'Referred by',
                                'format'=>'raw',
                                'value'=>!empty($request['agencyreceiving']) ? $request['agencyreceiving']['name'] : null,//$model->transactionnum,
                                'valueColOptions'=>['style'=>'width:30%'], 
                                'displayOnly'=>true
                            ],
                            [
                                'label'=>'Referral Code',
                                'format'=>'raw',
                                'value'=>$request['referral_code'],
                                'valueColOptions'=>['style'=>'width:30%'], 
                                'displayOnly'=>true
                            ],
                        ],

                    ], 
                    [
                        'columns' => [
                            [
                                'label'=>'Date Received from Courier',
                                'format'=>'raw',
                                'value'=>!empty($modelRefTracktesting->date_received_courier) ? Yii::$app->formatter->asDate($modelRefTracktesting->date_received_courier, 'php:F j, Y') : "<i class='text-danger font-weight-bold h5'>No received date</i>",
                                'valueColOptions'=>['style'=>'width:30%'], 
                                'displayOnly'=>true
                            ],
                            [
                                'label'=>'Analysis/Calibration Started',
                                'format'=>'raw',
                                'value'=>!empty($modelRefTracktesting->analysis_started) ? Yii::$app->formatter->asDate($modelRefTracktesting->analysis_started, 'php:F j, Y') : "<i class='text-danger font-weight-bold h5'>No data</i>",
                                'valueColOptions'=>['style'=>'width:30%'], 
                                'displayOnly'=>true
                            ],
                        ],

                    ], 
                     [
                        'columns' => [
                            [
                                'label'=>'Analysis/Calibration Completed',
                                'format'=>'raw',
                                'value'=>!empty($modelRefTracktesting->analysis_completed) ? Yii::$app->formatter->asDate($modelRefTracktesting->analysis_completed, 'php:F j, Y') : "<i class='text-danger font-weight-bold h5'>No data</i>",
                                'valueColOptions'=>['style'=>'width:30%'], 
                                'displayOnly'=>true
                            ],
                            [
                                'label'=>'Courier',
                                'format'=>'raw',
                                'value'=>!empty($modelRefTracktesting->courier) ? $modelRefTracktesting->courier->name : "<i class='text-danger font-weight-bold h5'>No courier</i>",
                                'valueColOptions'=>['style'=>'width:30%'], 
                                'displayOnly'=>true
                            ],
                        ],

                    ],
                    [
                        'columns' => [
                            [
                                'label'=>'Calibration Specimen Send back to Receiving Lab',
                                'format'=>'raw',
                                'value'=>!empty($modelRefTracktesting->cal_specimen_send_date) ? Yii::$app->formatter->asDate($modelRefTracktesting->cal_specimen_send_date, 'php:F j, Y') : "<i class='text-danger font-weight-bold h5'>No data</i>",
                                'valueColOptions'=>['style'=>'width:30%'], 
                                'displayOnly'=>true
                            ],
                            [
                                'label'=>'',
                                'format'=>'raw',
                                'value'=>''
                            ],
                        ],

                    ],
                ],
            ]);
        
       /* $gridColumnsResults = 
      function($data) use ($testresult,$model,$rstlId){
                    $link = '';
                    $link .= Html::button('<span class="glyphicon glyphicon-upload"></span> Upload Result', ['value'=>"/referrals/attachment/upload_result?referralid=$model->referral_id", 'class' => 'btn btn-success','title' => Yii::t('app', "Upload Result"),'id'=>'btnuploadresult','onclick'=>'addresult(this.value,this.title)']);
                    if($testresult > 0){
                        foreach ($testresult as $test) {
                            $link .= Html::a('<span class="glyphicon glyphicon-save-file"></span> '.$test['filename'],'/referrals/attachment/download?referral_id='.$model->referral_id.'&file='.$test['attachment_id'], ['style'=>'font-size:12px;color:#000077;font-weight:bold;','title'=>'Download Result','target'=>'_self'])."<br>";
                        }
                    }
                    return $link;
                
          }   
        ;*/
        $gridColumnsResults="<div class='row'><div class='col-md-12'>". GridView::widget([
            'dataProvider'  => $testresult,
            'id'=>'Grid',
            'tableOptions'=>['class'=>'table table-hover table-stripe table-hand'],
            'pjax'=>true,
            'pjaxSettings' => [
                    'options' => [
                        'enablePushState' => false,
                    ],
            ],
            'toolbar'=>[],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<i class="fa fa-columns"></i> List',
             ],
            'columns' => [
                [
                    'label' => 'Result',
                    'format'=>'raw',
                    'value' =>  function($testresult){
                        return Html::a('<span class="glyphicon glyphicon-save-file"></span> '.$testresult['filename'],'/referrals/attachment/download?referral_id='.$testresult['referral_id'].'&file='.$testresult['attachment_id'], ['style'=>'font-size:12px;color:#000077;font-weight:bold;','title'=>'Download Result','target'=>'_self'])."<br>";
                    }
                ],
                
            ],
        ])."</div></div>";
                
        if($request['receiving_agency_id'] == $rstl_id){
            $Func="LoadModal('Update Tracking','/referrals/referraltrackreceiving/update?id=".$modelRefTrackreceiving->referraltrackreceiving_id."',true,500)";
            $UpdateButton='<button id="btnUpdate" onclick="'.$Func.'" type="button" style="float: left;padding-right:5px;margin-left: 5px" class="btn btn-primary"><i class="fa fa-pencil"></i> Update Tracking</button><br><br>';

            if($countreceiving > 0){
               $gridColumn2=$UpdateButton.$trackreceiving;  
            } else{
                $gridColumn2=Html::button('<span class="glyphicon glyphicon-plus"></span> Add Referral Track', ['value'=>"/referrals/referraltrackreceiving/create?referralid=$request[referral_id]", 'class' => 'btn btn-success','title' => Yii::t('app', "Referral Track Receiving Lab"),'id'=>'btnreceivedtrack','onclick'=>'addreceivedtrack(this.value,this.title)']);
            }
            
            $gridColumnResult=$gridColumnsResults;
         }
         else{
            $Uploadbtn=Html::button('<span class="glyphicon glyphicon-upload"></span> Upload Result', ['value'=>"/referrals/attachment/upload_result?referralid=$request[referral_id]", 'class' => 'btn btn-success','title' => Yii::t('app', "Upload Result"),'id'=>'btnuploadresult','onclick'=>'addresult(this.value,this.title)']).'<br><br>'; 
            $Func="LoadModal('Update Tracking','/referrals/referraltracktesting/update?id=".$modelRefTracktesting->referraltracktesting_id."',true,500)";
            $UpdateButton='<button id="btnUpdate" onclick="'.$Func.'" type="button" style="float: left;padding-right:5px;margin-left: 5px" class="btn btn-primary"><i class="fa fa-pencil"></i> Update Tracking</button><br><br>';

            if($counttesting > 0){
                $gridColumn2=$UpdateButton.$tracktesting;
            } else{
                $gridColumn2=Html::button('<span class="glyphicon glyphicon-plus"></span> Add Referral Track', ['value'=>'/referrals/referraltracktesting/create?referralid='.$modelref->referral_id.'&receivingid='.$modelref->receiving_agency_id, 'class' => 'btn btn-success','title' => Yii::t('app', "Referral Track Testing/Calibration Lab"),'id'=>'btntestingtrack','onclick'=>'addtestingtrack(this.value,this.title)']);
            }
            $gridColumnResult=$Uploadbtn.$gridColumnsResults;
            
         } 
         
        echo TabsX::widget([
            'position' => TabsX::POS_ABOVE,
            'align' => TabsX::ALIGN_LEFT,
            'encodeLabels' => false,
            'id' => 'tab_referral',
            'items' => [
                [
                    'label' => '<i class="fa fa-columns"></i> Logs',
                    'content' => $gridColumn,//$LogContent,
                    'active' => $LogActive,
                    'options' => ['id' => 'log'],
                   // 'visible' => Yii::$app->user->can('access-terminal-configurations')
                ],
                [
                    'label' => '<i class="fa fa-users"></i> Results',
                    'content' => $gridColumnResult,//$ResultContent,
                    'active' => $ResultActive,
                    'options' => ['id' => 'result'],
                   // 'visible' => Yii::$app->user->can('access-terminal-configurations')
                ],
                [
                    'label' => '<i class="fa-level-down"></i> Referral Track',
                    'content' =>$gridColumn2,//$TrackContent ,
                    'active' => $TrackActive,
                    'options' => ['id' => 'referral_track'],
                   // 'visible' => Yii::$app->user->can('access-terminal-configurations')
                ]
            ],
        ]);
        ?>
        </div>
        </div>      
    </div>
    
</div>
</div>
<style type="text/css">
/* Absolute Center Spinner */
.img-loader {
    position: fixed;
    z-index: 999;
    /*height: 2em;
    width: 2em;*/
    height: 64px;
    width: 64px;
    overflow: show;
    margin: auto;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background-image: url('/images/img-loader64.gif');
    background-repeat: no-repeat;
}
/* Transparent Overlay */
.img-loader:before {
    content: '';
    display: block;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.3);
}
</style>
<script type="text/javascript">
    function addreceivedtrack(url,title){
        //alert(title);
       LoadModal(title,url,'true','600px');
   }
    function addtestingtrack(url,title){
       LoadModal(title,url,'true','600px');
   }
   function addresult(url,title){
       LoadModal(title,url,'true','600px');
   } 
</script>