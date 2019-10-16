<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Csf */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Csfs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="csf-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ref_num',
            'name',
            'nob',
            'tom',
            'service',
            'd_deliverytime',
            'd_accuracy',
            'd_speed',
            'd_cost',
            'd_attitude',
            'd_overall',
            'i_deliverytime',
            'i_accuracy',
            'i_speed',
            'i_cost',
            'i_attitude',
            'i_overall',
            'recommend',
            'essay',
            'r_date',
        ],
    ]) ?>

</div>
