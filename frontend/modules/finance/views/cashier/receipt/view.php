<?php
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use common\models\finance\Collection;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\finance\Op */
$this->title = 'Receipt';
$this->params['breadcrumbs'][] = ['label' => 'Finance', 'url' => ['/finance']];
$this->params['breadcrumbs'][] = ['label' => 'Receipt', 'url' => ['/finance/cashier/receipt']];
$this->params['breadcrumbs'][] = 'View';
$enable=false;
$receiptid=$receipt->receipt_id;
$collectiontype_id=$model->collectiontype_id;
$displayy='';
if($collectiontype_id == 1 || $collectiontype_id == 2){
   $displayy='';
}
else{
   $displayy='display: none';
}
$print_button=Html::button('<span class="glyphicon glyphicon-download"></span> Print Receipt Excel', ['value'=>'/finance/cashier/printview?id='.$model->receipt_id, 'class' => 'btn btn-small btn-primary','title' => Yii::t('app', "Print Report"),'onclick'=>"location.href=this.value"]);
$add_paymentitem=Html::button('<i class="glyphicon glyphicon-plus"></i> Add Paymentitem', ['value' => Url::to(['/finance/cashier/addpaymentitem','collectiontype_id'=>$model->collectiontype_id,'receiptid'=>$model->receipt_id]),'title'=>'Add Payment Item', 'onclick'=>'addPaymentitem(this.value,this.title)', 'class' => 'btn btn-primary','id' => 'modalBtn']);
$add_extra=Html::button('<i class="glyphicon glyphicon-plus"></i> Excess Payment', ['value' => Url::to(['/finance/cashier/addextra','collectiontype_id'=>$model->collectiontype_id,'receiptid'=>$model->receipt_id]),'title'=>'Excess Payment', 'onclick'=>'addPaymentitem(this.value,this.title)', 'class' => 'btn btn-primary','id' => 'modalBtn','style'=>$displayy]);

?>
<div class="receipt-view">

   <div class="container">
    <?= DetailView::widget([
        'model'=>$model,
        'responsive'=>true,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'<i class="glyphicon glyphicon-book"></i> Receipt#: ' . $model->or_number,
            'type'=>DetailView::TYPE_PRIMARY,
         ],
        'buttons1' => '',
        'attributes' => [
            [
                'columns' => [
                    [
                        'label'=>'Payor',
                        'format'=>'raw',
                        'value'=>$model->payor,
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                    [
                        'label'=>'Nature of Collection',
                        'format'=>'raw',
                        'value'=>$model->collectiontype ? $model->collectiontype->natureofcollection : "",
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                ],
                    
            ],
            [
                'columns' => [
                    [
                        'label'=>'Receipt Date',
                        'format'=>'raw',
                        'value'=>$model->receiptDate,
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                    [
                        'label'=>'Total of Collection',
                        'value'=>$model->total,
                        'format' => ['decimal', 2],
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                ],
                    
            ],
          
        ],
    ]) ?>
   </div>
    <div class="main-container">
        <div class="container">
        <div class="table-responsive">
        <?php
            $gridColumns = [
                ['class' => 'kartik\grid\SerialColumn', 
                ],
                [
                    'attribute'=>'details',
                    'enableSorting' => false,
                    'contentOptions' => [
                        'style'=>'max-width:70px; overflow: auto; white-space: normal; word-wrap: break-word;'
                    ],
                ],
                [
                    'attribute'=>'amount',
                    'enableSorting' => false,
                    'hAlign' => 'right', 
                    'vAlign' => 'middle',
                    'width' => '15%',
                    'format' => ['decimal', 2],
                    'pageSummary' => true
                ],
              
            ];
            echo GridView::widget([
                'id' => 'collection-grid',
                'dataProvider'=> $paymentitemDataProvider,
                'pjax'=>true,
                'pjaxSettings' => [
                    'options' => [
                        'enablePushState' => false,
                    ]
                ],
                'responsive'=>true,
                'striped'=>true,
                'showPageSummary' => true,
                'hover'=>true,
                'panel' => [
                    'heading'=>'<h3 class="panel-title">Collection</h3>',
                    //remove add collection Html::button('<i class="glyphicon glyphicon-plus"></i> Add Collection', ['disabled'=>$enable, 'value' => Url::to(['add-collection','opid'=>$op_model->orderofpayment_id,'receiptid'=>$model->receipt_id]),'title'=>'Add Collection', 'onclick'=>'addCollection(this.value,this.title)', 'class' => 'btn btn-success','id' => 'modalBtn'])." 
                    'type'=>'primary', 'before'=>$add_paymentitem."&nbsp;&nbsp;&nbsp;".$add_extra."&nbsp;&nbsp;&nbsp;".Html::button('<i class="glyphicon glyphicon-print"></i> Print Receipt', ['disabled'=>$enable, 'onclick'=>"window.location.href = '" . \Yii::$app->urlManager->createUrl(['/reports/preview?url=/finance/cashier/print-or','or_number'=>$model->or_number]) . "';" ,'title'=>'Print Receipt',  'class' => 'btn btn-success'])."&nbsp;&nbsp;&nbsp;".$print_button,
                    'after'=>false,
                ],
                'columns' => $gridColumns,
               'toolbar' => [
                ],
            ]);
        ?>
        </div>
    </div>
    </div>
    <?php
     if($model->payment_mode_id == 2 && $model->total > 0){
         
        ?>
          <div class="main-container-check">
        <div class="container">
        <div class="table-responsive">
        <?php
            $gridColumns = [
                [
                    'attribute'=>'bank',
                    'enableSorting' => false,
                ],
                [
                    'attribute'=>'checknumber',
                    'enableSorting' => false,
                ],
                [
                    'attribute'=>'checkdate',
                    'enableSorting' => false,
                ],
                [
                    'attribute'=>'amount',
                    'enableSorting' => false,
                    'hAlign' => 'right', 
                    'vAlign' => 'middle',
                    'width' => '15%',
                    'format' => ['decimal', 2],
                    'pageSummary' => true
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'delete') {
                            $url ='/finance/cashier/remove-check?checkid='.$model->check_id;
                            return $url;
                        }
                    },
                    'template' => '{delete}',
                    'buttons'=>[
                       'delete' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,['data-confirm'=>"Are you sure you want to delete cheque #: <b>".$model->checknumber."</b>?",'data-method'=>'post','class'=>'btn btn-danger','title'=>'Delete','data-pjax'=>'0']);
                        },
                    ],
                    'dropdown' => false,
                    'dropdownOptions' => ['class' => 'pull-right'],
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                ],
            ];
            echo GridView::widget([
                'id' => 'check-grid',
                'dataProvider'=> $check_model,
                'pjax'=>true,
                'pjaxSettings' => [
                    'options' => [
                        'enablePushState' => false,
                    ]
                ],
                'responsive'=>true,
                'striped'=>true,
                'showPageSummary' => true,
                'hover'=>true,
                'panel' => [
                    'heading'=>'<h3 class="panel-title">Cheque(s) Details</h3>',
                    'type'=>'primary', 'before'=>Html::button('<i class="glyphicon glyphicon-plus"></i> Add Check', ['disabled'=>$enable, 'value' => Url::to(['add-check','receiptid'=>$model->receipt_id]),'title'=>'Add Check', 'onclick'=>'addCheck(this.value,this.title)', 'class' => 'btn btn-success','id' => 'modalBtn']),
                    'after'=>false,
                ],
                'columns' => $gridColumns,
               'toolbar' => [
                ],
            ]);
        ?>
        </div>
    </div>
    </div>
    <?php
     }
    ?>
   
    
</div>
<script type="text/javascript">
   
    function addCollection(url,title){
       //var url = 'Url::to(['sample/update']) . "?id=' + id;
       //var url = '/lab/sample/update?id='+id;
        $(".modal-title").html(title);
        $('#modal').modal('show')
            .find('#modalContent')
            .load(url);
    }
    function addCheck(url,title){
       //var url = 'Url::to(['sample/update']) . "?id=' + id;
       //var url = '/lab/sample/update?id='+id;
        $(".modal-title").html(title);
        $('#modal').modal('show')
            .find('#modalContent')
            .load(url);
    }
    // ['/finance/cashier/remove-check?checkid='.$check_model->check_id], 
   $('#btnRemoveCheck').on('click',function() {
       alert('heheh');
   });
   
   
    function addPaymentitem(url,title){
        LoadModal(title,url,'true','1100px');
    }
</script>