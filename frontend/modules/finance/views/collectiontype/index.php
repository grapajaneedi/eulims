<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel common\models\finance\CollectiontypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Collection Type';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collectiontype-index">

    <div class="table-responsive">
        <?php 
        $Buttontemplate='{update}{delete}'; 
        ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'pjaxSettings' => [
                'options' => [
                    'enablePushState' => false,
                ]
            ],
           
            'panel' => [
                'type'=>'primary', 'before'=>Html::button('<i class="glyphicon glyphicon-plus"></i> Create Collection Type', ['value' => Url::to(['/finance/collectiontype/create']),'title'=>'Create Collection Type', 'onclick'=>'addType(this.value,this.title)', 'class' => 'btn btn-success','id' => 'modalBtn']),
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
                
            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'natureofcollection',
                [
                    'class' => kartik\grid\ActionColumn::className(),
                    'template' => $Buttontemplate,
                    'buttons'=>[
                    'update'=>function ($url, $model) {
                        $t = '/finance/collectiontype/update?id='.$model->collectiontype_id;
                        //return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>Url::to($t), 'class' => 'btn btn-success btn-modal']);
                        return Html::button('<i class="glyphicon glyphicon-pencil"></i>', ['value' => Url::to($t),'title'=>'Update Collection Type', 'onclick'=>'editType(this.value,this.title)', 'class' => 'btn btn-success']);
                    },
                    
                ],
                ],
            ],
        ]); ?>
    </div>
</div>
<script type="text/javascript">
    function addType(url,title){
         $(".modal-title").html(title);
         $('#modal').modal('show')
            .find('#modalContent')
            .load(url);
    }
    function editType(url,title){
         $(".modal-title").html(title);
         $('#modal').modal('show')
            .find('#modalContent')
            .load(url);
    }
  
</script>
