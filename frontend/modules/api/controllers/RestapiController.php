<?php

namespace frontend\modules\api\controllers;

use common\models\system\LoginForm;
use common\models\inventory\Products;

class RestapiController extends \yii\rest\Controller
{
    
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => \sizeg\jwt\JwtHttpBearerAuth::class,
            'except' => ['login','getproducts'],
        ];

        return $behaviors;
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogin()
    {
        // make a login precodure here
        $model = new LoginForm();
        $my_var = \Yii::$app->request->post();
        $model->email = $my_var['email'];
        $model->password = $my_var['password'];
        // var_dump($model); exit;

        if ($model->login()) {
            
           // here you can put some credentials validation logic
            // so if it success we return token
            $signer = new \Lcobucci\JWT\Signer\Hmac\Sha256();
            /** @var Jwt $jwt */
            $jwt = \Yii::$app->jwt;
            $token = $jwt->getBuilder()
                ->setIssuer('http://example.com')// Configures the issuer (iss claim)
                ->setAudience('http://example.org')// Configures the audience (aud claim)
                ->setId('4f1g23a12aa', true)// Configures the id (jti claim), replicating as a header item
                ->setIssuedAt(time())// Configures the time that the token was issue (iat claim)
                ->setExpiration(time() + 3600)// Configures the expiration time of the token (exp claim)
                ->set('uid', \Yii::$app->user->identity->user_id)// Configures a new claim, called "uid"
                //->set('username', \Yii::$app->user->identity->username)// Configures a new claim, called "uid"
                ->sign($signer, $jwt->key)// creates a signature using [[Jwt::$key]]
                ->getToken(); // Retrieves the generated token

            return $this->asJson([
                'token' => (string)$token,
            ]);
        } else {
            return $this->asJson([
                'success' => false,
                'message' => 'Email and Password didn\'t match',
            ]);
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
    public function actionGetproducts($keyword = ""){

        $products = Products::find()->select(['product_id','product_code','product_name','image1','producttype_id'])->where(['LIKE', 'product_name', $keyword])->all();
        //product type 1 = consumables and 2 = non consumable
        return $this->asJson([
            'data' => $products,
        ]);   
    }

    public function actionGetproduct($productcode){

        $product = Products::find()->select(['product_id','product_code','product_name','image1','producttype_id'])->where(['product_code' => $productcode])->one();
        //product type 1 = consumables and 2 = non consumable
        if($product){
             return $this->asJson([
                'data' => $product,
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
    //************************************************

}
