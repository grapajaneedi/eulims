<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Request */

$this->title = $model->request_id;
$this->params['breadcrumbs'][] = ['label' => 'Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

echo "request ref num".$model->request_ref_num;
echo $model->request_ref_num;

//unique tracking number - request id and reference number
?>
<div class="request-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->request_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->request_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php
    //  DetailView::widget([
    //     'model' => $model,
    //     'attributes' => [
    //         'request_id',
    //         'request_ref_num',
    //         'request_datetime',
    //         'rstl_id',
    //         'lab_id',
    //         'customer_id',
    //         'payment_type_id',
    //         'modeofrelease_ids',
    //         'discount',
    //         'discount_id',
    //         'purpose_id',
    //         'total',
    //         'report_due',
    //         'conforme',
    //         'receivedBy',
    //         'created_at',
    //         'posted',
    //         'status_id',
    //         'selected',
    //         'other_fees_id',
    //         'request_type_id',
    //         'position',
    //         'recommended_due_date',
    //         'est_date_completion',
    //         'items_receive_by',
    //         'equipment_release_date',
    //         'certificate_release_date',
    //         'released_by',
    //         'received_by',
    //         'payment_status_id',
    //         'completed',
    //         'request_old_id',
    //         'oldColumn_requestId',
    //         'oldColumn_sublabId',
    //         'oldColumn_orId',
    //         'oldColumn_completed',
    //         'oldColumn_cancelled',
    //         'oldColumn_create_time',
    //         'customer_old_id',
    //         'tmpCustomerID',
    //         'local_request_id',
    //         'local_customer_id',
    //         'is_sync_up',
    //         'is_updated',
    //         'is_deleted',
    //         'sample_received_date',
    //         'referral_id',
    //         'contact_num',
    //     ],
    // ]) ?>

</div>
