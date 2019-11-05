<?php

namespace frontend\modules\api\controllers;

use common\models\lab\Sample;
use common\models\lab\Analysis;
use common\models\lab\Workflow;
use common\models\lab\Request;
use common\models\lab\Procedure;
use common\models\lab\Tagging;
use common\models\lab\Customer;
use common\models\lab\Customeraccount;
use common\models\lab\LogincForm;
use common\models\system\LoginForm;
use common\models\system\Profile;
use common\models\system\User;
use common\models\inventory\Products;
use common\models\inventory\InventoryEntries;
use common\models\inventory\Equipmentservice;
use common\models\inventory\InventoryWithdrawal;
use common\models\inventory\InventoryWithdrawaldetails;
use common\models\finance\CustomerWallet;
use common\models\finance\CustomerTransaction;
use common\models\lab\Booking;
use common\models\system\Rstl;
use common\models\auth\AuthAssignment;

class RestapiController extends \yii\rest\Controller
{
    
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => \sizeg\jwt\JwtHttpBearerAuth::class,
            'except' => ['login', 'server'],
            // 'user'=> [\Yii::$app->customeraccount,\Yii::$app->user]
        ];

        return $behaviors;
    }

    protected function verbs(){
        return [
            'login' => ['POST'],
            'logout' => ['POST'],
            'user' => ['GET'],
            'samplecode' => ['GET'],
            'analysis' => ['GET'],
           // 'server' => ['GET'],
             'data' => ['GET'],
        ];
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogin()
    {
            $model = new LoginForm();
            $my_var = \Yii::$app->request->post();
            $model->email = $my_var['email'];
            $model->password = $my_var['password'];
           
            if ($model->login()) {      
                $signer = new \Lcobucci\JWT\Signer\Hmac\Sha256();
                /** @var Jwt $jwt */
                $jwt = \Yii::$app->jwt;
                $token = $jwt->getBuilder()
                    ->setIssuer('http://example.com')// Configures the issuer (iss claim)
                    ->setAudience('http://example.org')// Configures the audience (aud claim)
                    ->setId('4f1g23a12aa', true)// Configures the id (jti claim), replicating as a header item
                    ->setIssuedAt(time())// Configures the time that the token was issue (iat claim)
                    ->setExpiration(time() + 3600 * 24)// Configures the expiration time of the token (exp claim)
                    ->set('uid', \Yii::$app->user->identity->user_id)// Configures a new claim, called "uid"
                    //->set('username', \Yii::$app->user->identity->username)// Configures a new claim, called "uid"
                    ->sign($signer, $jwt->key)// creates a signature using [[Jwt::$key]]
                    ->getToken(); // Retrieves the generated token
    
                    $users = User::find()->where(['LIKE', 'email', $my_var['email']])->one();
                    $profile = Profile::find()->where(['user_id'=>$users->user_id])->one();
                    $role = AuthAssignment::find()->where(['user_id'=>$users->user_id])->one();
        
                    return $this->asJson([
                        'token' => (string)$token,
                        'user'=> (['email'=>$users->email,
                                    'firstName'=>$profile->firstname,
                                    'middleInitial' => $profile->middleinitial,
                                    'lastname' => $profile->lastname,
                                    'type' => $role->item_name,]),
                    ]);
                } else {
                    return $this->asJson([
                        'success' => false,
                        'message' => 'Email and Password didn\'t match',
                    ]);
                }
    }



    // public function actionLogout(){
    //     \Yii::$app->user->logout();
    //     return "Logout";
    // }


    public function actionUser()
    {  
        $user_id =\Yii::$app->user->identity->profile->user_id;
        $users = User::find()->where(['LIKE', 'user_id', $user_id])->one();
        $profile = Profile::find()->where(['user_id'=>$user_id])->one();
        $role = AuthAssignment::find()->where(['user_id'=>$users->user_id])->one();
        $signer = new \Lcobucci\JWT\Signer\Hmac\Sha256();
        /** @var Jwt $jwt */
        $jwt = \Yii::$app->jwt;
        $token = $jwt->getBuilder()
            ->setIssuer('http://example.com')// Configures the issuer (iss claim)
            ->setAudience('http://example.org')// Configures the audience (aud claim)
            ->setId('4f1g23a12aa', true)// Configures the id (jti claim), replicating as a header item
            ->setIssuedAt(time())// Configures the time that the token was issue (iat claim)
            ->setExpiration(time() + 3600 * 24)// Configures the expiration time of the token (exp claim)
            ->set('uid', \Yii::$app->user->identity->user_id)// Configures a new claim, called "uid"
            //->set('username', \Yii::$app->user->identity->username)// Configures a new claim, called "uid"
            ->sign($signer, $jwt->key)// creates a signature using [[Jwt::$key]]
            ->getToken(); // Retrieves the generated token
        return $this->asJson([
                'token' => (string)$token,
                'user'=> (['email'=>$users->email,
                'firstName'=>$profile->firstname,
                'middleInitial' => $profile->middleinitial,
                'lastname' => $profile->lastname,
                'type' => $role->item_name]),
                'user_id'=> $users->user_id
            ]);
                   
    }

    public function actionChangestatus()
    {  
     $year = date("Y");
     if (isset($_GET['samplecode'])) {
        //limit for this year only
        $samplecode = Sample::find()->select(['sample_id','sample_code'])
        ->where(['LIKE', 'tbl_sample.sample_code', $_GET['samplecode']])
        ->AndWhere(['LIKE', 'sample_year', $year])
        ->all();
        return $this->asJson(['sampleCodes'=>$samplecode]);            
        }
    }

    public function actionSamplecode()
    {  
     $year = date("Y");
     if (isset($_GET['samplecode'])) {
        //limit for this year only
        $samplecode = Sample::find()->select(['sample_id','sample_code'])
        ->where(['LIKE', 'tbl_sample.sample_code', $_GET['samplecode']])
        ->AndWhere(['LIKE', 'sample_year', $year])
        ->all();
        return $this->asJson(['sampleCodes'=>$samplecode]);            
        }
    }

    public function actionAnalysis()
    {  
        if (isset($_GET['id'])) {

            $code = $_GET['id'];
            $year = date("Y");
            $sample = Sample::find()->select(['sample_id','sample_code', 'samplename', 'description'])
            ->where(['LIKE', 'tbl_sample.sample_code', $_GET['id']])
            ->AndWhere(['LIKE', 'sample_year', $year])->one();

            $analysis = Analysis::find()->select(['tbl_analysis.analysis_id','tbl_analysis.testname', 'tbl_analysis.method', 'tbl_tagging.tagging_status_id', 'tbl_tagging.start_date', 'tbl_tagging.end_date'])
            ->leftJoin('tbl_tagging', 'tbl_tagging.analysis_id=tbl_analysis.analysis_id')
            ->where(['LIKE', 'tbl_analysis.sample_id', $sample->sample_id])->all();

          
           
            if ($sample){
                return $this->asJson(['sampleCode'=>$sample->sample_code, 
                'samples'=>['name'=>$sample->samplename, 
                'description'=>$sample->description], 
                'tests'=>$analysis]);

                //echo print_r($analysis);
            }else{
                return $this->asJson(['sampleCode'=>'Not found']);
            }
          

       
                   
        }
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogout()
    {
        return $this->render('index');
    }

    /**
     * @return \yii\web\Response
     */
    public function actionData()
    {
        return $this->getuserid();
    }

    function getuserid(){
        $myvar = \Yii::$app->request->headers->get('Authorization');

        $rawToken = explode("Bearer ", $myvar);
        $rawToken = $rawToken[1];
        $token = \Yii::$app->jwt->getParser()->parse((string) $rawToken);
        return $token->getClaim('uid');
    }

     //************************************************
     public function actionServer(){

        $server = $_SERVER['SERVER_NAME'];
        if(!$sock = @fsockopen($server, 80))
            {
                $data = array("status" => "offline");
            }
            else
            {
                $data = array("status" => "online");
            }

           
        return $this->asJson($data);   
    }


    //************************************************
    public function actionGetproducts($keyword = ""){
        $products = Products::find()->where(['LIKE', 'product_name', $keyword])->all();

        //product type 1 = consumables and 2 = non consumable
        return $this->asJson(
            $products
        );
    }

    public function actionGetproduct($productcode){

        $product = Products::find()->where(['product_code' => $productcode])->one();
        //product type 1 = consumables and 2 = non consumable
        if($product){
             return $this->asJson(
                $product
            );
        }else{
            return $this->asJson([
                'success' => false,
                'message' => 'no product code found',
            ]);  
        } 
    }

    public function actionUpdatethumbnail(){
        $my_var = \Yii::$app->request->post();
        if($my_var){
            $product = Products::find()->where(['product_code' => $my_var['product_code']]); //find product using the primarykey
            if($product){
                //fetch and save the picture, if (success) update the product
                //$product->Image1 = my_var/** productname + product code + extension */

                if($product->save()){
                    return $this->asJson([
                        'success' => true,
                        'message' => 'Product ('.$product_code.') updated!',
                    ]);
                }else{
                    return $this->asJson([
                        'success' => false,
                        'message' => 'Product ('.$product_code.') failed to update!',
                    ]); 
                }
                          
            }else{
                return $this->asJson([
                    'success' => false,
                    'message' => 'Product not found using code '.$my_var['product_id'],
                ]); 
            }
        }else{
            return $this->asJson([
                    'success' => false,
                    'message' => 'No Submission',
                ]); 
        }
        
    }


    public function actionSetschedule(){
        $my_var = \Yii::$app->request->post();
        $product = Products::findOne($my_var['product_id']); //find product using the primarykey
        if($product){
            //create schedule
            $model = new Equipmentservice;
            $model->inventory_transactions_id=$my_var['product_id'];
            $model->servicetype_id=$my_var['servicetype_id'];
            $model->requested_by=$this->getuserid();
            $model->startdate=$my_var['startdate'];
            $model->enddate=$my_var['enddate'];
            $model->request_status=0;
            $model->save();

            return $this->asJson([
                'success' => true,
                'message' => 'Schedule created for product code'.$my_var['product_name'],
            ]); 
        }else{
            return $this->asJson([
                'success' => false,
                'message' => 'Product not found using id '.$my_var['product_id'],
            ]); 
        }
    }

    public function actionGetschedules(){
         return $this->asJson([
                'success' => false,
                'message' => 'charchar',
            ]); 
    }

    public function actionGetsamples($id){
        $model = Sample::find()->select(['sample_code','samplename','completed'])->where(['request_id'=>$id])->all();
        if($model){
            return $this->asJson(
                $model
            ); 
        }
    }

    public function actionGetrstl(){
        $model = Rstl::find()->all();
        if($model){
            return $this->asJson(
                $model
            ); 
        }
    }

    public function actionGetentries($product_id){
        $model = InventoryEntries::find()->where(['product_id'=>$product_id])->all();
       
        return $this->asJson(
            $model
        ); 
        
    }

    public function actionWithdraw(){
        //use transaction per item
        $my_var = \Yii::$app->request->post();
        //first let us save the mother record before the child/item

        $model = new InventoryWithdrawal;
        $model->created_by=$this->getuserid();
        $model->withdrawal_datetime=date('Y-m-d');
        $model->lab_id=1;
        $model->total_qty=0;//$key['Quantity'];
        $model->total_cost=0;//$key['Subtotal'];
        $model->remarks="transaction from mobile";
        $model->save();

        // the format is objects inside an array
        foreach($my_var as $myvar) {
            $entry = InventoryEntries::findOne($key['ID']); //get the entries record

        }
        return true;
    }
}
