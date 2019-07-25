<?php

namespace frontend\modules\referrals\controllers;

use Yii;
use common\models\referral\Courier;
use common\models\referral\CourierSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\ReferralComponent;
use yii\data\ArrayDataProvider;
use linslin\yii2\curl\Curl;
use yii\helpers\Json;

/**
 * CourierController implements the CRUD actions for Courier model.
 */
class CourierController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Courier models.
     * @return mixed
     */
    public function actionIndex()
    {
       // $searchModel = new CourierSearch();
       // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $refcomponent = new ReferralComponent();
        $courier=json_decode($refcomponent->getCourierdata());
        $courierDataProvider = new ArrayDataProvider([
            'allModels' => $courier,
            'pagination'=> [
                'pageSize' => 10,
            ],
        ]); 
        return $this->render('index', [
            'dataProvider' => $courierDataProvider,
        ]);
    }

    /**
     * Displays a single Courier model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Courier model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Courier();

        if ($model->load(Yii::$app->request->post())) {
            
            $courierData = Json::encode(['data'=>$model]);
            /*echo "<pre>";
            var_dump($courierData);
            echo "</pre>";
            exit;*/
            $courierUrl ='https://eulimsapi.onelab.ph/api/web/referral/couriers/insertdata';
          //  https://eulimsapi.onelab.ph/api/web/referral/couriers/insertdata

            $curlCourier = new Curl();
            $courierResponse = $curlCourier->setRequestBody($courierData)
            ->setHeaders([
                    'Content-Type' => 'application/json',
                    'Content-Length' => strlen($courierData), 
            ])->post($courierUrl);
            if($courierResponse == 1){
                Yii::$app->session->setFlash('success', 'Successfully Added!');
                return $this->redirect(['index']);
            }else{
                return "<div class='alert alert-danger'><span class='glyphicon glyphicon-exclamation-sign' style='font-size:18px;'></span>&nbsp;ataya nag error ka uy!</div>";
            }  
           
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Courier model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = new Courier();
        $refcomponent = new ReferralComponent();
        $courier=json_decode($refcomponent->getCourierone($id));
        
        if($courier){
            $model->courier_id=$courier->courier_id;
            $model->name=$courier->name;
        }
        
        if ($model->load(Yii::$app->request->post())) {
            $courierData = Json::encode(['data'=>$model]);
            
            $courierUrl ='https://eulimsapi.onelab.ph/api/web/referral/couriers/updatedata';
          //  https://eulimsapi.onelab.ph/api/web/referral/couriers/insertdata

            $curlCourier = new Curl();
            $courierResponse = $curlCourier->setRequestBody($courierData)
            ->setHeaders([
                    'Content-Type' => 'application/json',
                    'Content-Length' => strlen($courierData), 
            ])->post($courierUrl);
            if($courierResponse == 1){
                Yii::$app->session->setFlash('success', 'Successfully Updated!');
                return $this->redirect(['index']);
            }else{
                return "<div class='alert alert-danger'><span class='glyphicon glyphicon-exclamation-sign' style='font-size:18px;'></span>&nbsp;ataya nag error ka uy!</div>";
            }
            //return $this->redirect(['view', 'id' => $model->courier_id]);
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Courier model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Courier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Courier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Courier::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
