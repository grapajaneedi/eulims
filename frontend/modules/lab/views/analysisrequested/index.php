<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\AnlysisrequestedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Analysisrequesteds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="analysisrequested-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Analysisrequested', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'analysis_id',
            'sample_description',
            'control_no',
            'analysis',
            'price',
            //'total',
            //'joborder_id',
            //'type',
            //'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div> 