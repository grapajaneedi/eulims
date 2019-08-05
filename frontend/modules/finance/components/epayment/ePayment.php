<?php
namespace frontend\modules\finance\components\epayment;
use common\models\lab\Request;
use common\components\Functions;
use common\models\finance\Op;
use common\models\system\Rstl;
use common\models\lab\Customer;
use linslin\yii2\curl;



/**
 * Description of ePayment
 *
 * @author OneLab
 */
class ePayment {
    /**
     * This class function Post 
     */
    public function PostOnlinePayment($id){
        $Func=new Functions();
        $Proc="spGetPaymentForOnline(:op_id)";
        $Connection= \Yii::$app->financedb;
        $param=[
            'op_id'=>$id
        ];
        $requests=$Func->ExecuteStoredProcedureRows($Proc, $param, $Connection);
        $Payment_details=[];
        foreach($requests as $request){
            $payment_detail=[
                'request_ref_num'=>$request['request_ref_num'],
                'rrn_date_time'=>$request['request_datetime'],
                'amount'=>$request['amount']
            ];
            array_push($Payment_details, $payment_detail);
        }
        //Query order of payment
        $Op= Op::findOne($id);
        $Rstl= Rstl::findOne($Op->rstl_id);
        $Customer= Customer::findOne($Op->customer_id);
        $TransactDetails=[
            'transaction_num'=>$Op->transactionnum,
            'customer_code'=>$Customer->customer_code,
            'email'=>$Customer->email,
            'collection_type'=>$Op->collectiontype->natureofcollection,
            'collection_code'=>'collection-code',
            'order_date'=>$Op->order_date,
            'agency_code'=>$Rstl->code,
            'total_amount'=>$Op->total_amount,
            'payment_details'=>$Payment_details
        ];
        
        $content = json_encode($TransactDetails);
        //Get the epayment config
        $compo=Yii::$app->components['epayment_config'];
        $curl = new curl\Curl();
        $EpaymentURI=$compo['URI'];//"https://yii2customer.onelab.ph/web/api/op";
        //$EpaymentURI="http://www.eulims.local/capi/op";
        
        $response = $curl->setRequestBody($content)
            ->setHeaders([
               'Content-Type' => 'application/json',
               'Content-Length' => strlen($content)
            ])->post($EpaymentURI);
        return $response;
        
    }
}
