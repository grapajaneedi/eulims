<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Analysis */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
    // $checkMethod = ($model->methodref_id) ? $model->methodref_id : null;
?>

<div class="analysismethodreference-form">
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
            <?php
                /*$gridColumns = [
                    [
                        'class' => '\kartik\grid\SerialColumn',
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center','style'=>'max-width:10px;'],
                    ],
                    [
                        'class' => '\kartik\grid\CheckboxColumn',
                        //'class' => '\yii\grid\CheckboxColumn',
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center','style'=>'max-width:10px;'],
                        'name' => 'methodref_ids',
                        //'checked' => $model['sample_id'] == 125,
                        //'multiple' => false,
                    ],
                    [
                        //'attribute'=>'samplename',
                        //'enableSorting' => false,
                        //'contentOptions' => ['style'=>'max-width:200px;'],
                        'header' => 'Offered',
                        'format' => 'raw',
                        'value' => 'YES/NO',
                    ],
                    [
                        'attribute'=>'description',
                        'format' => 'raw',
                        'enableSorting' => false,
                        'value' => function($data){
                            return ($data->request->lab_id == 2) ? "Sampling Date: <span style='color:#000077;'><b>".date("Y-m-d h:i A",strtotime($data->sampling_date))."</b></span>,&nbsp;".$data->description : $data->description;
                        },
                       'contentOptions' => [
                            'style'=>'max-width:200px; overflow: auto; white-space: normal; word-wrap: break-word;'
                        ],
                    ],
                ];

                echo GridView::widget([
                    'id' => 'sample-analysis-grid',
                    'dataProvider'=> $sampleDataProvider,
                    //'dataProvider' => ,
                    'pjax'=>true,                
                    'pjaxSettings' => [
                        'options' => [
                            'enablePushState' => false,
                        ]
                    ],
                    'containerOptions'=>[
                        'style'=>'overflow:auto; height:250px',
                    ],
                    'floatHeaderOptions' => ['scrollingTop' => true],
                    'responsive'=>true,
                    'striped'=>true,
                    'hover'=>true,
                    'bordered' => true,
                    'panel' => [
                       'heading'=>'<h3 class="panel-title">Samples</h3>',
                       'type'=>'primary',
                       'before' => '',
                       'after'=>false,
                       'footer'=>false,
                    ],
                    'columns' => $gridColumns,
                    'toolbar' => false,
                ]);*/
            ?>
            <?php
                $gridColumns = [
                    [
                        'class' => '\kartik\grid\SerialColumn',
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center','style'=>'max-width:5px;'],
                    ],
                    /*[
                        'class' =>  '\kartik\grid\RadioColumn',
                        'radioOptions' => function ($model) use ($checkMethod) {
                            return [
                                'value' => $model['methodreference_id'],
                                'checked' => $model['methodreference_id'] == $checkMethod,
                            ];
                        },
                        'name' => 'methodref_id',
                        'showClear' => true,
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center','style'=>'max-width:20px;'],
                    ],*/
                    [
                        //'class' => '\kartik\grid\CheckboxColumn',
                        'class' => '\yii\grid\CheckboxColumn',
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center','style'=>'max-width:5px;'],
                        'name' => 'methodref_ids',
                        'checkboxOptions'=> function($data) {
                            return [
                                'value' => $data['methodreference']['methodreference_id'],
                            ];
                        },
                    ],
                    [
                        'header' => 'Offered',
                        'format' => 'raw',
                        'value' => 'YES/NO',
                        'contentOptions' => [
                            'style'=>'max-width:10px; overflow: auto; white-space: normal; word-wrap: break-word;',
                            'class' => 'text-center'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                    ],
                    [
                        //'attribute'=>'testname_method_id',
                        'header' => 'Method',
                        'enableSorting' => false,
                        'value' => function($data){
                            return $data['methodreference']['method'];
                        },
                        'contentOptions' => [
                            'style'=>'max-width:200px; overflow: auto; white-space: normal; word-wrap: break-word;'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                    ],
                    [
                        //'attribute'=>'testname_method_id',
                        'header' => 'Reference',
                        'enableSorting' => false,
                        'value' => function($data){
                            return $data['methodreference']['reference'];
                        },
                        'contentOptions' => [
                            'style'=>'max-width:200px; overflow: auto; white-space: normal; word-wrap: break-word;'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                    ],
                    [
                        //'attribute'=>'testname_method_id',
                        'header' => 'Fee',
                        'enableSorting' => false,
                        'value' => function($data){
                            return number_format($data['methodreference']['fee'],2);
                        },
                        'contentOptions' => [
                            'style'=>'text-align:right;max-width:45px;'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'header' => 'Offered by',
                        'format' => 'raw',
                        'value' => 'List of Agencies',
                        'contentOptions' => [
                            'style'=>'max-width:10px; overflow: auto; white-space: normal; word-wrap: break-word;',
                            'class' => 'text-center'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                    ],
                ];

                echo GridView::widget([
                    'id' => 'method-reference-grid',
                    'dataProvider'=> $methodrefDataProvider,
                    'pjax'=>true,
                    'pjaxSettings' => [
                        'options' => [
                            'enablePushState' => false,
                        ]
                    ],
                    'containerOptions'=>[
                        'style'=>'overflow:auto; height:250px',
                    ],
                    'floatHeaderOptions' => ['scrollingTop' => true],
                    'responsive'=>true,
                    'striped'=>true,
                    'hover'=>true,
                    'bordered' => true,
                    'panel' => [
                       'heading'=>'<h3 class="panel-title">Method Reference</h3>',
                       'type'=>'primary',
                       'before' => '<span style="color:#000000;">
                            <strong>Note : </strong> Offer / Unoffer test for your agency. If test/calibration is not found in the list, please contact the administrator to add your test/calibration.
                        </span>'.(($count_methods > 0) ? '<br><div style="position:relative;float:left;margin: 10px 0 0 0;">
                    <button type="button" id="btn-offer" onclick="offerService()" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok-sign"></span> Offer</button>&nbsp;&nbsp;<button type="button" id="btn-remove" onclick="removeService()" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove-sign"></span> Remove</button>
                </div>' : ''),
                       'after'=>false,
                    ],
                    'columns' => $gridColumns,
                    'toolbar' => false,
                ]);
            ?>
            </div>
        </div>
    </div>
</div>