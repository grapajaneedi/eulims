<?php

/*
 * Project Name: eulims_ * 
 * Copyright(C)2018 Department of Science & Technology -IX * 
 * 07 10, 18 , 3:12:38 PM * 
 * Module: BillingPayment * 
 */

namespace frontend\modules\finance\components\billing;
use yii\base\Model;
use common\models\finance\Receipt;
use common\models\finance\Check;
use common\models\finance\Soa;
use common\models\lab\Request;
use common\models\finance\Customerwallet;
use common\models\finance\Orseries;
use common\models\finance\SoaReceipt;

/**
 * Description of BillingPayment
 *
 * @author OneLab
 */
class BillingPayment extends Model{
    // Receipt Attributes
    public $rstl_id;
    PUBLIC $or;
    public $terminal_id;
    public $collection_id;
    public $deposit_type_id;
    public $or_series_id;
    public $or_number;
    public $receiptDate;
    public $payment_mode_id;
    public $payor;
    public $collectiontype_id;
    public $total;
    public $cancelled;
    public $deposit_idpublic; 
    public $isNewRecord;
    // Check Attribute
    public $check_id;
    public $receipt_id;
    public $bank;
    public $checknumber;
    public $checkdate;
    public $amount;
    // SOA Attributes
    public $soa_id;
    public $customer_id;
    public $payment_amount;
    public $total_amount;

    public function init(){
        $this->isNewRecord=true;
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rstl_id', 'terminal_id', 'or_number', 'receiptDate','deposit_type_id', 'payment_mode_id', 'payor', 'collectiontype_id', 'total', 'cancelled','or_series_id'], 'required'],
            [['rstl_id', 'terminal_id', 'collection_id', 'deposit_type_id', 'payment_mode_id', 'collectiontype_id', 'cancelled', 'deposit_id','or_series_id'], 'integer'],
            [['receiptDate','checkdate'], 'safe'],
            [['total','amount'], 'number'],
            [['checknumber','bank'], 'string', 'max' => 25],
            [['or_number'], 'string', 'max' => 50],
            [['payor'], 'string', 'max' => 100],
            [['check_id','receipt_id'],'integer']
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
           'checknumber'=>'Check #',
        ];
    }
    public function save(){
        
    }
}
