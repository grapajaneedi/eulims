<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\grid\ActionColumn;
use \yii\helpers\ArrayHelper;
use common\components\Functions;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use common\components\ReferralComponent;

/* @var $this yii\web\View */
/* @var $searchModel common\models\referral\ReferralSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Referral';
$this->params['breadcrumbs'][] = ['label' => 'Referrals', 'url' => ['/referrals']];
$this->params['breadcrumbs'][] = $this->title;
$func=new Functions();

?>
<div class="referral-index">
    <?php
        // echo $func->GenerateStatusLegend("Legend/Status",false);
    ?>

    <h1><?php //echo Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <!--<?= Html::a('Create Referral', ['create'], ['class' => 'btn btn-success']) ?>-->
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id'=>'referral-grid',
        //'filterModel' => $searchModel,
        'pjax'=>true,
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Referral</h3>',
            'type'=>'primary',
            'after'=>false,
            //'before'=>Html::button('<i class="glyphicon glyphicon-plus"></i> Create Referral Request', ['value' => Url::to(['referral/create']),'title'=>'Create Referral Request', 'onclick'=>'addSample(this.value,this.title)', 'class' => 'btn btn-success','id' => 'referralcreate']),
            //'before'=>"<button type='button' onclick='LoadModal(\"Create Referral Request\",\"/referrals/referral/create\")' class=\"btn btn-success\"><i class=\"glyphicon glyphicon-plus\"></i> Create Referral Request</button>",
            'before'=>null,
        ],
        'columns' => [
            [
                'header' => 'Referral Code',
                'attribute' => 'referral_code',
                'format' => 'raw',
                //'value' => function($data){ return $data->referral_code;},
                'headerOptions' => ['class' => 'text-center'],
            ],
            [
                'header' => 'Referral Date',
                'attribute' => 'referral_date_time',
                'format' => 'raw',
                'value' => function($data){ return ($data['referral_date_time'] != "0000-00-00 00:00:00") ? Yii::$app->formatter->asDate($data['referral_date_time'], 'php:F j, Y h:i a') : "<i class='text-danger font-weight-bold h5'>Pending referral request</i>";},
                'headerOptions' => ['class' => 'text-center'],
            ],
            [
                'header' => 'Customer',
                'attribute' => 'customer_id',
                'format' => 'raw',
                'value' => function($data){ return $data['customer_name'];},
                'headerOptions' => ['class' => 'text-center'],
            ],
            [
                'header' => 'Referred By',
                'attribute' => 'receiving_agency_id',
                'format' => 'raw',
                'value' => function($data){ 
                    $refcomp = new ReferralComponent();
                    $referred_agency = json_decode($refcomp->listAgency($data['receiving_agency_id']),true);
                    $receiving_agency = !empty($referred_agency) ? $referred_agency[0]['name'] : null;
                    return $receiving_agency;
                },
                'headerOptions' => ['class' => 'text-center'],
            ],
            [
                'header' => 'Referred To',
                'attribute' => 'testing_agency_id',
                'format' => 'raw',
                'value' => function($data){ 
                    $refcomp = new ReferralComponent();
                    $referred_agency = json_decode($refcomp->listAgency($data['testing_agency_id']),true);
                    $testing_agency = !empty($referred_agency) ? $referred_agency[0]['name'] : null;
                    return $testing_agency;
                },
                'headerOptions' => ['class' => 'text-center'],
            ],
        ],
        'toolbar' => [
            'content'=> Html::a('<i class="glyphicon glyphicon-repeat"></i> Refresh Grid', [Url::to(['/referrals/referral'])], [
                        'class' => 'btn btn-default', 
                        'title' => 'Refresh Grid'
                    ]),
            //'{toggleData}',
        ],
]); ?>

    <?php /*= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'referral_id',
            'referral_code',
            'referral_date',
            'referral_time',
            'receiving_agency_id',
            //'testing_agency_id',
            //'lab_id',
            //'sample_received_date',
            //'customer_id',
            //'payment_type_id',
            //'modeofrelease_id',
            //'purpose_id',
            //'discount_id',
            //'discount_amt',
            //'total_fee',
            //'report_due',
            //'conforme',
            //'received_by',
            //'bid',
            //'cancelled',
            //'create_time',
            //'update_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);*/ ?>
</div>

<script type="text/javascript">
    function addSample(url,title){
        $("#referralcreate").click(function(){
            $(".modal-title").html(title);
            $("#modal").modal('show')
                .find('#modalContent')
                .load(url);
        });
    }
</script>