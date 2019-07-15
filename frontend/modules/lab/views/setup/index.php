<?php
use kartik\detail\DetailView;
use common\models\lab\Testnamemethod;
use common\models\lab\Testname;
use common\models\lab\Methodreference;

use common\models\system\Rstl;
use common\models\system\RstlDetails;

use common\models\system\Profile;
use common\models\system\User;


use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
?>
<?php
$rstl =  Rstl::findOne(['rstl_id'=>11]);

$rstldetail =  RstlDetails::findOne(['rstl_id'=>11]);


   echo DetailView::widget([
   'model'=>$rstldetail,
   'responsive'=>true,
   'hover'=>true,
   'mode'=>DetailView::MODE_VIEW,
   'panel'=>[
       'heading'=>'<i class="glyphicon glyphicon-book"></i> Laboratory Details',
       'type'=>DetailView::TYPE_PRIMARY,
       //'type' => DetailView::TYPE_INFO,
   ],
   'attributes'=>[
       [
           
           
           'columns' => [
               [
                   'label'=>'RSTL ID',
                   'format'=>'raw',
                   'value'=>$rstldetail->rstl_id,
                   'displayOnly'=>true
               ],
           ],
       ],
       [
           'columns' => [
               [
                   'label'=>'Region',
                   'value'=> '',
                   'displayOnly'=>true,
               ],
           ],
       ],
       [
           'columns' => [
               [
                   'label'=>'Laboratory Name',
                   'format'=>'raw',
                   'value'=>$rstldetail->shortName,
                   'displayOnly'=>true
               ],
           ],
       ],
       [
        'columns' => [
                [
                    'label'=>'Code',
                    'format'=>'raw',
                    'value'=>'',
                    'displayOnly'=>true
                ],
            ],
        ],
        [
            'columns' => [
                    [
                        'label'=>'Address',
                        'format'=>'raw',
                        'value'=>$rstldetail->address,
                        'displayOnly'=>true
                    ],
                ],
        ],
        [
            'columns' => [
                    [
                        'label'=>'Contact Number',
                        'format'=>'raw',
                        'value'=>$rstldetail->contacts,
                        'displayOnly'=>true
                    ],
                ],
        ],
        [
            'columns' => [
                    [
                        'label'=>'Short Name',
                        'format'=>'raw',
                        'value'=>$rstldetail->shortName,
                        'displayOnly'=>true
                    ],
                ],
        ],
        [
            'columns' => [
                    [
                        'label'=>'Lab Type Short',
                        'format'=>'raw',
                        'value'=>$rstldetail->labtypeShort,
                        'displayOnly'=>true
                    ],
                ],
        ],

        [
            'columns' => [
                    [
                        'label'=>'Description',
                        'format'=>'raw',
                        'value'=>$rstldetail->description,
                        'displayOnly'=>true
                    ],
                ],
        ],
        [
            'columns' => [
                    [
                        'label'=>'Website',
                        'format'=>'raw',
                        'value'=>$rstldetail->website,
                        'displayOnly'=>true
                    ],
                ],
        ],
   ],
]);

?>

<?= GridView::widget([
        'dataProvider' => $userdataprovider,
        //'filterModel' => $searchModel,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  Users',
                'before'=>  Html::button('<span class="glyphicon glyphicon-plus"></span> Create Sample Type Test Name', ['value'=>'/lab/sampletypetestname/create', 'class' => 'btn btn-success modal_services','title' => Yii::t('app', "Create New Sample Type Test Name")]),
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'sampletype_id',
                'label' => 'Sample Type',
                'value' => '',
            
            ],
            [
                'attribute' => 'testname_id',
                'label' => 'Test Name',
                'value' =>'',
               
            ],
            
            
           
        ],
    ]); ?>