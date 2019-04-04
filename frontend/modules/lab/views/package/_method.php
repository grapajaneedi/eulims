<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\lab\Sampletype;
use common\models\lab\Services;
use common\models\lab\Lab;
use common\models\lab\Testname;
use common\models\lab\Methodreference;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use kartik\widgets\DatePicker;
use kartik\datetime\DateTimePicker;

?>

<?= GridView::widget([
        'dataProvider' => $testnamedataprovider,
        'pjax' => true,    
        'id'=>'testname-grid',
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'columns' => [
            [
                'label' => 'Add',
                'format' => 'raw',
               
                'contentOptions' => ['style' => 'width: 30%;word-wrap: break-word;white-space:pre-line;'],  
                'value' => function($data) {
                   
                    return "<span class='btn btn-danger glyphicon glyphicon-minus' id='offer' onclick=deleteworkflow(".$data->method_id.")></span>";
                 }          
            ],
            [
                'attribute' => 'method',
                'label' => 'Method',
                'format' => 'raw',
                'width'=> '150px',
                //'contentOptions' => ['style' => 'width: 98%;word-wrap: break-word;white-space:pre-line;'],  
                'value' => function($data) {
                    $method_query = Methodreference::find()->where(['method_reference_id'=>$data->method_id])->one();
                    return $method_query->method;
                 }    
               
             
            ],
       ],
    ]); ?>