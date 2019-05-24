<?php

namespace frontend\modules\api\controllers;

use common\models\system\LoginForm2;
use common\models\system\LoginForm;

class RestapiController extends \yii\rest\Controller
{
    
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => \sizeg\jwt\JwtHttpBearerAuth::class,
            'except' => ['login'],
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

}
