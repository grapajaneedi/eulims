<?php
use kartik\grid\GridView;

echo $gridColumn="<div class='row'><div class='col-md-12'>". GridView::widget([
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