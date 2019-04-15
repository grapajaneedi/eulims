<?php

use yii\helpers\Html;
use kartik\grid\GridView;
?>
<div class="Lab-default-index">
    <div class="alert alert-warning">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
         <h2><i class="icon fa fa-warning"></i>Reorder Point !</h2>
         Products need to reorder.
    </div>
     <div class="reorder-index">
       <?= GridView::widget([
            'dataProvider' => $dataProvider2,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'product_id',
                 [
                    'header'=>'Product',
                    'value'=>function($model){
                        return $model->product->product_name;
                    }
                ],
                [
                    'header'=>'Reorder Point',
                    'value'=>function($model){
                        return $model->product->qty_reorder." ".$model->product->unittype->unit;
                    }
                ],
                [
                    'header'=>'Total onHand',
                    'value'=>function($model){
                        return $model->product->getTotalqty()." ".$model->product->unittype->unit;
                    }
                ],
                'date_created',

                // ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
    <div class="alert alert-warning">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
         <h2><i class="icon fa fa-warning"></i>Expired !</h2>
         Products need to dispose.
    </div>
    <div class="expired-index">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'inventory_transactions_id',
                [
                    'header'=>'Product',
                    'value'=>function($model){
                        return $model->product->product_name;
                    }
                ],
                'expiration_date',
                'po_number',
                'content',
                'quantity',
                'description',
                [
                    'header'=>'Created_at',
                    'value'=>function($model){
                        return date('Y-m-d',$model->created_at);
                    }
                ],

                // ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>

</div>
