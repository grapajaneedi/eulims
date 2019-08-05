<?php



namespace frontend\modules\finance\components\models;
use Yii;
use yii\base\Model;
use common\models\finance\Soa;
use common\models\finance\SoaBilling;
/**
 * Description of SoaForm
 *
 * @author OneLab
 */
class SoaForm extends Model{
    public $soa_id;
    public $bi_ids;
    public $active;
    public $soa_date;
    public $customer_id;
    public $user_id;
    public $soa_number;
    public $payment_due_date;
    public $previous_balance;
    public $current_amount;
    public $total_amount;
    public $payment_amount;
    public $isNewRecord;
    
    public function init() {
        $this->isNewRecord=TRUE;
        parent::init();
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['soa_date','payment_due_date', 'customer_id', 'user_id'], 'required'],
            [['soa_date','isNewRecord'], 'safe'],
            [['customer_id', 'user_id','soa_id','active'], 'integer'],
            [['previous_balance', 'current_amount','payment_amount','total_amount'], 'number'],
            [['soa_number','bi_ids'], 'string', 'max' => 100]
        ];
    }
    public function save(){
        if (!$this->validate()) {
            return null;
        }
        /*echo "<pre>";
        var_dump(Yii::$app->request->post());
        echo "</pre>";
        exit;
        */
        $Connection= Yii::$app->financedb;
        // create new Soa
        $Soamodel=new Soa();
        $Soamodel->soa_date= $this->soa_date;
        $Soamodel->payment_due_date= $this->payment_due_date;
        $Soamodel->customer_id= $this->customer_id;
        $Soamodel->user_id= $this->user_id;
        $Soamodel->previous_balance= $this->previous_balance;
        $Soamodel->current_amount= $this->current_amount;
        $Soamodel->total_amount= $this->total_amount;
        $Soamodel->payment_amount= $this->payment_amount;
        $Soamodel->active= $this->active;
        // Get the last generated id
        $Soa= Soa::find()->where(['customer_id'=>$this->customer_id])->orderBy('soa_id DESC')->one();
        if($Soa){
            $Pre_Soa_id=(int)$Soa->soa_id;
            $Soa->active=0;
            $Soa->save();
        }else{
            $Pre_Soa_id=0;
        }
        
        $Pre_Soa_id=$Pre_Soa_id+1;
        $Soamodel->soa_number=str_pad($Pre_Soa_id, 13,"0",STR_PAD_LEFT); 
        $BiArr= explode(",", $this->bi_ids);
       
        if($Soamodel->save()){
            //Update Billing
            // Update orderofpayment
            $sql="UPDATE `tbl_billing` SET `soa_number`='$Soamodel->soa_number' WHERE `billing_id` IN ($this->bi_ids)";
            $Command=$Connection->createCommand($sql);
            $Command->execute();
            foreach ($BiArr as $Bi){
                // Create record on SoaBilling
                $SoaBilling=new SoaBilling();
                $SoaBilling->soa_id=$Soamodel->soa_id;
                $SoaBilling->billing_id=$Bi;
                $SoaBilling->save();
            }
            return $Soamodel;
        }else{
            return NULL;
        }
    }
}
