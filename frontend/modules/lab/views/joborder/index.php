<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\JoborderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Job Order';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="joborder-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'hover'=>true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
                'before'=> Html::button("<span class='glyphicon glyphicon-plus'></span> Create New Job Order", ["value"=>"/lab/labsampletype/create", "class" => "btn btn-success modal_services","title" => Yii::t("app", "Create New Lab Sample Type")]),
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'joborder_id',
            'customer_id',
            'joborder_date',
            'sampling_date',
            'lsono',
            //'sample_received',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div> 