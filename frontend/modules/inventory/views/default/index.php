<?php

use yii\helpers\Html;
use kartik\grid\GridView;
?>
<div class="Lab-default-index">
    <h2>Reorder Point</h2>
     <div class="expired-index">
       
    </div>
    <h2>Expired</h2>
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
