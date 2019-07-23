<?php

namespace frontend\modules\api\controllers;

use common\models\lab\Sample;
use common\models\lab\Analysis;
use common\models\lab\Workflow;
use common\models\lab\Request;
use common\models\lab\Procedure;
use common\models\system\LoginForm;
use common\models\system\Profile;
use common\models\system\User;
use common\models\inventory\Products;
use common\models\finance\CustomerWallet;
use common\models\finance\CustomerTransaction;
use common\models\lab\Booking;
use common\models\system\Rstl;

class RestapiController extends \yii\rest\Controller
{
    
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => \sizeg\jwt\JwtHttpBearerAuth::class,
            'except' => ['login', 'server', 'getwallettransaction','getcustomerwallet','getcustonreq','setbooking','getrstl','getproducts'],
        ];

        return $behaviors;
    }

    protected function verbs(){
        return [
            'login' => ['POST'],
            'user' => ['GET'],
            'samplecode' => ['GET'],
            'analysis' => ['GET'],
           // 'server' => ['GET'],
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
        
                    return $this->asJson([
                        'token' => (string)$token,
                        'user'=> (['email'=>$users->email,
                                    'firstName'=>$profile->firstname,
                                    'middleInitial' => $profile->middleinitial,
                                    'lastname' => $profile->lastname]),
                    ]);
                } else {
                    return $this->asJson([
                        'success' => false,
                        'message' => 'Email and Password didn\'t match',
                    ]);
                }

            
               
        
    }

        public function actionUser()
        {  
            $user_id =\Yii::$app->user->identity->profile->user_id;
            $users = User::find()->where(['LIKE', 'user_id', $user_id])->one();
            $profile = Profile::find()->where(['user_id'=>$user_id])->one();
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
                    'lastname' => $profile->lastname]),
                ]);
                       
            }

            public function actionSamplecode()
            {  
                if (isset($_GET['q'])) {
                //limit for this year only
                $samplecode = Sample::find()->select(['sample_id','sample_code'])
                ->where(['LIKE', 'tbl_sample.sample_code', $_GET['q']])
                ->AndWhere(['LIKE', 'sample_year', '2018'])
                ->all();
                return $this->asJson(['sampleCodes'=>$samplecode]);
                           
                }
            }

            public function actionAnalysis()
            {  
                if (isset($_GET['samplecode'])) {

                $sample = Sample::find()->select(['samplename','description'])->where(['sample_code'=>$_GET['samplecode']])->one();
                $analysis = Analysis::find()->select(['analysis_id','testname', 'method'])
                ->where(['LIKE', 'sample_code', $_GET['samplecode']])->all();
                //progress - count ng ilang ang natapos
                //workflow - count ng workflow
                //status

                $workflow = Workflow::find()->select(['sample_id','sample_code'])->where(['LIKE', 'sample_code', $_GET['samplecode']])->all();
               // $tagginganalysis = Procedure::find()->select(['sample_id','sample_code'])->where(['LIKE', 'sample_code', $_GET['samplecode']])->all();
                
                return $this->asJson(['sampleCode'=>$sample->sample_code,
                        'samples'=>$sample, 'tests'=>$analysis]);
                           
                }
            }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return \yii\web\Response
     */
    public function actionData()
    {
         $myvar = \Yii::$app->request->headers->get('Authorization');

         $rawToken = explode("Bearer ", $myvar);
         $rawToken = $rawToken[1];
         $token = \Yii::$app->jwt->getParser()->parse((string) $rawToken);
         var_dump($token->getClaim('uid')); exit;

        return $this->asJson([
            'success' => true,

        ]);
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
  


    //************************************************
    public function actionGetproducts($keyword = ""){
        $products = Products::find()->select(['product_id','product_code','product_name','Image1','producttype_id'])->where(['LIKE', 'product_name', $keyword])->all();

        //product type 1 = consumables and 2 = non consumable
          
        return $this->asJson(
            $products
        );
    }

    public function actionGetproduct($productcode){

        $product = Products::find()->select(['product_id','product_code','product_name','Image1','producttype_id'])->where(['product_code' => $productcode])->one();
        //product type 1 = consumables and 2 = non consumable
        if($product){
             return $this->asJson([
                $product,
            ]);
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

    public function actionGetcustonreq($id=50){
        $model = Request::find()->select(['request_id','request_ref_num','request_datetime'])->where(['customer_id'=>$id, 'status_id'=>1])->all();

        if($model){
            return $this->asJson(
                $model
            ); 
        }else{
            return $this->asJson([
                'success' => false,
                'message' => 'No Request Found',
            ]); 
        }
    }

    public function actionGetcustcomreq($id){
        $model = Request::find()->select(['request_id','request_ref_num','request_datetime'])->where(['customer_id'=>$id, 'status_id'=>2])->all();

        if($model){
            return $this->asJson(
                $model
            ); 
        }else{
            return $this->asJson([
                'success' => false,
                'message' => 'No Request Found',
            ]); 
        }
    }

    public function actionGetcustomerwallet($id=50){
            $transactions = CustomerWallet::find()->where(['customer_id'=>$id])->one();
        return $this->asJson(
            $transactions
        );
    }

     public function actionGetwallettransaction($id){
        $transactions = CustomerTransaction::find()->where(['customerwallet_id'=>$id])->orderby('date DESC')->all();
        return $this->asJson(
            $transactions
        );
    }
    //************************************************

    public function actionSetbooking(){ //create booking for customers
        //set booking default to pending
        $my_var = \Yii::$app->request->post();


       if(!$my_var){
            return $this->asJson([
                'success' => false,
                'message' => 'POST empty',
            ]); 
       }

        //Booking
        $bookling = new Booking;
        $bookling->scheduled_date = $my_var['date'];
        $bookling->booking_reference = '34ertgdsg';
        $bookling->rstl_id = $my_var['lab'];
        $bookling->date_created = $my_var['date'];
        $bookling->qty_sample = $my_var['qty'];
        $bookling->customer_id = $my_var['userid'];
        $bookling->booking_status = 0;
         // return $this->asJson($bookling); exit;

        if($bookling->save()){
            return $this->asJson([
                'success' => true,
                'message' => 'Booked Successfully',
            ]); 
        }
        else{
            return $this->asJson([
                'success' => false,
                'message' => 'Booking Failed',
            ]); 
        }
    }

    public function actionGetbookings($id){
        $my_var = Booking::find()->orderby('scheduled_date DESC')->all();
        return $this->asJson(
            $my_var
        );
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
}
