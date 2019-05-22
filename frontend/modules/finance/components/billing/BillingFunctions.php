<?php
namespace frontend\modules\finance\components\billing;
use Yii;
use yii\base\Component;
/*
 * Project Name: eulims_ * 
 * Copyright(C)2018 Department of Science & Technology -IX * 
 * 07 2, 18 , 9:15:30 AM * 
 * Module: BillingFunctions * 
 */

/**
 * Description of BillingFunctions
 *
 * @author OneLab
 */
class BillingFunctions extends Component{
    /**
     * 
     * @param type $Billing_id
     */
    function GetTransactionnumbers($Billing_id){
        $Connection=Yii::$app->financedb;
        $Proc="CALL spGetTransactionNumbers(:mbilling_id)";
        $Command=$Connection->createCommand($Proc);
        $Command->bindValue(':mbilling_id',$Billing_id);
        $row = $Command->queryOne();
        $trans=$row['transactionnumbers'];
        return str_replace(",","<br>",$trans);
    }
}
