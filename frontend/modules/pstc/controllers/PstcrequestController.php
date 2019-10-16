<?php

namespace frontend\modules\pstc\controllers;

use Yii;
//use common\models\referral\Pstcrequest;
//use common\models\referral\Pstcsample;
//use common\models\referral\Pstcanalysis;
//use common\models\referral\PstcrequestSearch;
//use common\models\referral\Customer;
//use common\models\lab\CustomerSearch;
use common\models\lab\Request;
use common\models\lab\Sample;
use common\models\lab\Analysis;
use common\models\lab\Customer;
use common\models\lab\Requestcode;
use common\models\lab\Discount;
use common\models\lab\Labsampletype;
use common\models\lab\Sampletype;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
//use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use common\components\PstcComponent;
use yii\db\Query;

/*** for saving pstc request details ***/
use DateTime;
use common\models\system\Profile;
use common\components\Functions;
use common\components\ReferralComponent;
use frontend\modules\lab\components\eRequest;
use common\models\lab\exRequestreferral;
use linslin\yii2\curl;
use yii\helpers\Json;
/*** end for saving pstc request details ***/

/**
 * PstcrequestController implements the CRUD actions for Pstcrequest model.
 */
class PstcrequestController extends Controller
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
     * Lists all Pstcrequest models.
     * @return mixed
     */
    /*public function actionIndex()
    {
        $rstlId = (int) Yii::$app->user->identity->profile->rstl_id;

        if($rstlId > 0) {
            $refcomponent = new ReferralComponent();

            $not_accept = json_decode($refcomponent->getReferralAll($rstlId),true);

            if((int) $referrals == 0){
                $referralDataprovider = new ArrayDataProvider([
                    'allModels' => [],
                    'pagination'=> ['pageSize' => 10],
                ]);
            } else {
                $referralDataprovider = new ArrayDataProvider([
                    'allModels' => $referrals,
                    'pagination'=> ['pageSize' => 10],
                ]);
            }

            return $this->render('index', [
                //'searchModel' => $searchModel,
                'dataProvider' => $referralDataprovider,
            ]);
        } else {
            return $this->redirect(['/site/login']);
        }
    } */

    public function actionNot_accepted()
    {
        $rstlId = (int) Yii::$app->user->identity->profile->rstl_id;

        if($rstlId > 0) {
            $pstcComponent = new PstcComponent();
            //$searchModel = new CustomerSearch();

            //set second parameter to 0 for not accepted request
            $request = json_decode($pstcComponent->getRequest($rstlId,0),true);

            if($request == 0) {
                $requestDataprovider = new ArrayDataProvider([
                    'allModels' => [],
                    'pagination'=> ['pageSize' => 10],
                ]);
            } else {
                $requestDataprovider = new ArrayDataProvider([
                    'allModels' => $request,
                    'pagination'=> ['pageSize' => 10],
                ]);
            }

            return $this->render('index_not_accepted', [
                //'searchModel' => $searchModel,
                'dataProvider' => $requestDataprovider,
            ]);
        } else {
            return $this->redirect(['/site/login']);
        }
    }

    public function actionAccepted()
    {
        $rstlId = (int) Yii::$app->user->identity->profile->rstl_id;

        if($rstlId > 0) {
            $pstcComponent = new PstcComponent();
            //$searchModel = new CustomerSearch();

            //set second parameter to 0 for not accepted request
            $request = json_decode($pstcComponent->getRequest($rstlId,1),true);

            if($request == 0) {
                $requestDataprovider = new ArrayDataProvider([
                    'allModels' => [],
                    'pagination'=> ['pageSize' => 10],
                ]);
            } else {
                $requestDataprovider = new ArrayDataProvider([
                    'allModels' => $request,
                    'pagination'=> ['pageSize' => 10],
                ]);
            }

            return $this->render('index_accepted', [
                //'searchModel' => $searchModel,
                'dataProvider' => $requestDataprovider,
            ]);
        } else {
            return $this->redirect(['/site/login']);
        }
    }

    /**
     * Displays a single Pstcrequest model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        // return $this->render('view', [
        //     'model' => $this->findModel($id),
        // ]);
        
        if(isset(Yii::$app->user->identity->profile->rstl_id)){
            $rstlId = (int) Yii::$app->user->identity->profile->rstl_id;
        } else {
            //return 'Session time out!';
            return $this->redirect(['/site/login']);
        }

        $requestId = (int) Yii::$app->request->get('request_id');
        $pstcId = (int) Yii::$app->request->get('pstc_id');

        if($rstlId > 0 && $requestId > 0 && $pstcId > 0)
        {
            $function = new PstcComponent();

            $details = json_decode($function->getViewRequest($requestId,$rstlId,$pstcId),true);

            $request = $details['request_data'];
            $samples = $details['sample_data'];
            $analyses = $details['analyses_data'];
            $respond = $details['respond_data'];
            $pstc = $details['pstc_data'];
            $customer = $details['customer_data'];
            $subtotal = $details['subtotal'];
            $discount = $details['discount'];
            $total = $details['total'];

            $sampleDataProvider = new ArrayDataProvider([
                'allModels' => $samples,
                'pagination'=>false,
            ]);

            $analysisDataprovider = new ArrayDataProvider([
                'allModels' => $analyses,
                'pagination'=>false,
            ]);
           
            //$query = new Query;
            //$subtotal = $query->from('tbl_pstcanalysis')
            //   ->join('INNER JOIN', 'tbl_pstcsample', 'tbl_pstcanalysis.pstc_sample_id = tbl_pstcsample.pstc_sample_id')
            //   ->where('pstc_request_id =:requestId',[':requestId'=>$id])
            //   ->sum('fee');

            //$rate = $model->discount_rate;
            
            //$discounted = $subtotal * ($rate/100);
            //$total = $subtotal - $discounted;
             
            return $this->render('view', [
                'model' => new Request(), //just to initialize detail view
                'request' => $request,
                'customer' => $customer,
                //'sample' => $samples,
                'sampleDataProvider' => $sampleDataProvider,
                'analysisDataprovider'=> $analysisDataprovider,
                'respond' => $respond,
                'pstc' => $pstc,
                'subtotal' => $subtotal,
                'discounted' => $discount,
                'total' => $total,
                'countSample' => count($samples),
                'countAnalysis' => count($analyses),
            ]);
        } else {
            Yii::$app->session->setFlash('error', "Invalid request!");
            return $this->redirect(['/pstc/pstcrequest']);
        }
    }

    /**
     * Creates a new Pstcrequest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pstcrequest();
        $rstlId = (int) Yii::$app->user->identity->profile->rstl_id;

        //if ($model->load(Yii::$app->request->post())) {
        //&& $model->save()


       if($rstlId > 0){
            //$model->rstl_id = $rstlId;
            //$model->user_id = (int) Yii::$app->user->identity->profile->user_id;
            $mi = !empty(Yii::$app->user->identity->profile->middleinitial) ? " ".substr(Yii::$app->user->identity->profile->middleinitial, 0, 1).". " : " ";
            $user_fullname = Yii::$app->user->identity->profile->firstname.$mi.Yii::$app->user->identity->profile->lastname;

            $customers = $this->listCustomers($rstlId);
            
            if($user_fullname){
                $model->received_by = $user_fullname;
            } else {
                $model->received_by = "";
            }
        } else {
            return $this->redirect(['/site/login']);
        }

        if(Yii::$app->request->post()) {
            $post = Yii::$app->request->post('Pstcrequest');

            //print_r(date('F j, Y h:i a'));
            //exit;

            $model->rstl_id = $rstlId;
            //$model->pstc_id = (int) Yii::$app->user->identity->profile->id;
            $model->pstc_id = 113;
            $model->customer_id = (int) $post['customer_id'];
            $model->submitted_by = $post['submitted_by'];
            $model->received_by = $user_fullname;
            $model->user_id = (int) Yii::$app->user->identity->profile->user_id;
            $model->status_id = 1;
            $model->created_at = date('Y-m-d H:i:s');
            $model->updated_at = date('Y-m-d H:i:s');

            if($model->save()){
                Yii::$app->session->setFlash('success', 'PSTC Request Successfully Created!');
                return $this->redirect(['view', 'id' => $model->pstc_request_id]);
                //return $this->redirect(['/pstc/pstcrequest']);
            } else {
                Yii::$app->session->setFlash('error', 'PSTC Request failed to create!');
                return $this->redirect(['/pstc/pstcrequest']);
            }
        } else {
            if(\Yii::$app->request->isAjax){
                return $this->renderAjax('create', [
                    'model' => $model,
                    'customers' => $customers,
                ]);
            } else {
                return $this->renderAjax('create', [
                    'model' => $model,
                    'customers' => $customers,
                ]);
            }
        }
    }

    /**
     * Updates an existing Pstcrequest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->pstc_request_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Pstcrequest model.
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
     * Finds the Pstcrequest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pstcrequest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pstcrequest::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function listCustomers($rstlId)
    {
        $customer = ArrayHelper::map(Customer::find()->where('rstl_id =:rstlId',[':rstlId'=>$rstlId])->all(), 'customer_id',
            function($customer, $defaultValue) {
                return $customer->customer_name;
        });
        return $customer;
    }

    //pstc details save as local request
    public function actionRequest_local()
    {
        $model = new eRequest();
        $connection= Yii::$app->labdb;
        $connection->createCommand('SET FOREIGN_KEY_CHECKS=0')->execute();
        $transaction = $connection->beginTransaction();
        
        if(isset(Yii::$app->user->identity->profile->rstl_id)){
            $rstlId = (int) Yii::$app->user->identity->profile->rstl_id;
        } else {
            //return 'Session time out!';
            return $this->redirect(['/site/login']);
        }

        $requestId = (int) Yii::$app->request->get('request_id');
        $pstcId = (int) Yii::$app->request->get('pstc_id');
        $function = new PstcComponent();

        if($rstlId > 0 && $pstcId > 0 && $requestId > 0) {
            $details = json_decode($function->getViewRequest($requestId,$rstlId,$pstcId),true);

            $request = $details['request_data'];
            $samples = $details['sample_data'];
            $analyses = $details['analyses_data'];
            $respond = $details['respond_data'];
            $pstc = $details['pstc_data'];
            $customer = $details['customer_data'];
            $subtotal = $details['subtotal'];
            $discount = $details['discount'];
            $total = $details['total'];

            $sampleDataProvider = new ArrayDataProvider([
                'allModels' => $samples,
                'pagination'=>false,
            ]);

            $analysisDataprovider = new ArrayDataProvider([
                'allModels' => $analyses,
                'pagination'=>false,
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'Invalid request!');
            return $this->redirect(['/pstc/pstcrequest']);
        }

        //if (Yii::$app->request->post()) {
        //if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post('eRequest');
            $total_fee = $total - ($subtotal * ($post['discount']/100));

            $model->modeofrelease_ids = implode(",", $post['modeofreleaseids']);
            $model->total = $total_fee;
            $model->pstc_request_id = $requestId;
            $model->created_at = date('Y-m-d H:i:s');
            $model->rstl_id = $rstlId;

            if($model->save(false)) {
                $local_requestId = $model->request_id;
                $psct_requestdetails = json_decode($function->getRequestDetails($requestId,$rstlId,$pstcId),true);

                $samples_analyses = $psct_requestdetails['sample_analysis_data'];
                $customer = $psct_requestdetails['customer_data'];

                foreach($samples_analyses as $sample) {
                    $modelSample = new Sample();

                    $modelSample->request_id = $local_requestId;
                    $modelSample->rstl_id = $rstlId;
                    $modelSample->sample_month = date_format(date_create($model->request_datetime),'m');
                    $modelSample->sample_year = date_format(date_create($model->request_datetime),'Y');
                    //$modelSample->testcategory_id = 0; //pstc request, test category id is in analysis
                    //$modelSample->sampletype_id = 0; //pstc request, sample type id is in analysis
                    $modelSample->samplename = $sample['sample_name'];
                    $modelSample->description = $sample['sample_description'];
                    // $modelSample->sampling_date = $sample['sampling_date']; //to be updated
                    $modelSample->sampling_date = date('Y-m-d H:i:s'); //to be updated
                    $modelSample->pstcsample_id = $sample['pstc_sample_id'];
                    $modelSample->testcategory_id = $post['testcategory_id'];
                    $modelSample->sampletype_id = $post['sampletype_id'];

                    if($modelSample->save(false)) {
                        foreach ($sample['analyses'] as $analysis) {
                            $modelAnalysis = new Analysis();
                            $modelAnalysis->rstl_id = $rstlId;
                            $modelAnalysis->date_analysis = date('Y-m-d');
                            $modelAnalysis->request_id = $local_requestId;
                            $modelAnalysis->pstcanalysis_id = $analysis['pstc_analysis_id'];
                            $modelAnalysis->package_id =  $analysis['package_id'];
                            $modelAnalysis->package_name =  $analysis['package_name'];
                            $modelAnalysis->sample_id = $modelSample->sample_id;
                            $modelAnalysis->test_id = $analysis['testname_id'];
                            $modelAnalysis->testname = $analysis['testname'];
                            $modelAnalysis->methodref_id = $analysis['method_id'];
                            $modelAnalysis->method = $analysis['method'];
                            $modelAnalysis->references = $analysis['reference'];
                            $modelAnalysis->fee =$analysis['fee'];
                            $modelAnalysis->testcategory_id = $post['testcategory_id'];
                            $modelAnalysis->sample_type_id = $post['sampletype_id'];
                            $modelAnalysis->is_package = $analysis['is_package'];
                            $modelAnalysis->is_package_name = $analysis['is_package_name'];
                            $modelAnalysis->quantity = 1;
                            if($modelAnalysis->save(false)) {
                                $analysisSave = 1;
                            } else {
                                $transaction->rollBack();
                                $analysisSave = 0;
                            }
                        }
                        $sampleSave = 1;
                    } else {
                        $transaction->rollBack();
                        $sampleSave = 0;
                    }
                }

                if($sampleSave == 1 && $analysisSave == 1) {
                    //$transaction->commit();
                    //if($transaction->commit()) {
                    //if($generate_code == 'success') {
                        $generate_code = $this->saveRequest($local_requestId,$model->lab_id,$rstlId,date('Y',strtotime($model->request_datetime)));
                        //$func = new Functions();
                        //$samplecode = $func->GenerateSampleCode($local_requestId);
                        //print_r($generate_code);
                        //exit;
                        $sample_data = [];
                        if($generate_code == "success") {
                            $local_samples = Sample::find()->where(['request_id'=>$local_requestId])->asArray()->all();
                            $local_request = Request::findOne($local_requestId);

                            $requestData = [
                                'pstc_request_id' => $local_request->pstc_request_id,
                                'request_ref_num' => $local_request->request_ref_num,
                                'rstl_id' => $local_request->rstl_id,
                                'pstc_id' => $pstcId,
                                'local_request_id' => $local_request->request_id,
                                'request_date_created' => $local_request->request_datetime,
                                'estimated_due_date' => $local_request->report_due,
                                'lab_id' => $local_request->lab_id,
                                'discount_id' => $local_request->discount_id,
                                'discount_rate' => $local_request->discount,
                            ];

                            foreach ($local_samples as $data) {
                                $sampleData = [
                                    'sample_id' => $data['pstcsample_id'],
                                    'sample_code' => $data['sample_code'],
                                    'sample_month' => $data['sample_month'],
                                    'sample_year' => $data['sample_year'],
                                ];
                                array_push($sample_data, $sampleData);
                            }

                            $pstc_request_details = Json::encode(['request_data'=>$requestData,'sample_data'=>$sample_data,'local_request_id'=>$local_requestId],JSON_NUMERIC_CHECK);
                            $pstcUrl='https://eulimsapi.onelab.ph/api/web/referral/pstcrequests/updaterequest_details';
                       
                            $curl = new curl\Curl();
                            $pstc_return = $curl->setRequestBody($pstc_request_details)
                            ->setHeaders([
                                'Content-Type' => 'application/json',
                                'Content-Length' => strlen($pstc_request_details),
                            ])->post($pstcUrl);

                            if($pstc_return == 1){
                                $transaction->commit();
                                Yii::$app->session->setFlash('success', 'Request successfully saved!');
                                return $this->redirect(['/lab/request/view','id'=>$local_requestId]);
                            } else {
                                $transaction->rollBack();
                                return "<div class='alert alert-danger'><span class='glyphicon glyphicon-exclamation-sign' style='font-size:18px;'></span>&nbsp;Request 1 failed to save!</div>";
                            }
                        } else {
                            $transaction->rollBack();
                            return "<div class='alert alert-danger'><span class='glyphicon glyphicon-exclamation-sign' style='font-size:18px;'></span>&nbsp;Failed to generate samplecode!</div>";
                        }
                    //} else {
                    //    echo 'GG';
                   // }
                } else {
                    $transaction->rollBack();
                    return "<div class='alert alert-danger'><span class='glyphicon glyphicon-exclamation-sign' style='font-size:18px;'></span>&nbsp;Request 2 failed to save!</div>";
                }
            } else {
                //Yii::$app->session->setFlash('error', "Request failed to save!");
                //return $this->redirect(['/pstc/pstcrequest/view','request_id'=>$requestId,'pstc_id'=>$pstcId]);
                $transaction->rollBack();
                return "<div class='alert alert-danger'><span class='glyphicon glyphicon-exclamation-sign' style='font-size:18px;'></span>&nbsp;Request 3 failed to save!</div>";
            }
        } else {
            $date = new DateTime();
            $date2 = new DateTime();
            $profile= Profile::find()->where(['user_id'=> Yii::$app->user->id])->one();
            date_add($date2,date_interval_create_from_date_string("1 day"));
            $model->request_datetime = date("Y-m-d h:i:s");
            $model->report_due = date_format($date2,"Y-m-d");
            $model->created_at = date('U');
            $model->rstl_id = $rstlId;
            $model->payment_type_id = 1;
            $model->modeofrelease_ids = '1';
            $model->discount_id = 0;
            $model->discount = '0.00';
            $model->total = 0.00;
            $model->posted = 0;
            $model->status_id = 1;
            $model->request_type_id = 1;
            $model->modeofreleaseids = '1';
            $model->payment_status_id = 1;
            $model->request_date = date("Y-m-d");
            $model->customer_id = $request['customer_id'];
            $model->conforme = $request['submitted_by'];

            if($profile){
                $model->receivedBy=$profile->firstname.' '. strtoupper(substr($profile->middleinitial,0,1)).'. '.$profile->lastname;
            }else{
                $model->receivedBy="";
            }

            if(\Yii::$app->request->isAjax) {
                return $this->renderAjax('_formRequestDetails', [
                    'model' => $model,
                    'request' => $request,
                    'customer' => $customer,
                    'sampleDataProvider' => $sampleDataProvider,
                    'analysisDataprovider'=> $analysisDataprovider,
                    'respond' => $respond,
                    'pstc' => $pstc,
                    'subtotal' => $subtotal,
                    'discounted' => $discount,
                    'total' => $total,
                    'countSample' => count($samples),
                    'countAnalysis' => count($analyses),
                    'testcategory' => null,
                    'sampletype' => null,
                ]);
            } else {
                return $this->renderAjax('_formRequestDetails', [
                    'model' => $model,
                    'request' => $request,
                    'customer' => $customer,
                    'sampleDataProvider' => $sampleDataProvider,
                    'analysisDataprovider'=> $analysisDataprovider,
                    'respond' => $respond,
                    'pstc' => $pstc,
                    'subtotal' => $subtotal,
                    'discounted' => $discount,
                    'total' => $total,
                    'countSample' => count($samples),
                    'countAnalysis' => count($analyses),
                    'testcategory' => null,
                    'sampletype' => null,
                ]);
            }
        }
    }

    //pstc details save as referral request
    public function actionRequest_referral()
    {
        /*$model = new exRequestreferral();
        $Func=new Functions();
        $refcomponent = new ReferralComponent();
        $Func->CheckRSTLProfile();
        $connection= Yii::$app->labdb;
        $connection->createCommand('SET FOREIGN_KEY_CHECKS=0')->execute();
        //$GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
        $labreferral = ArrayHelper::map(json_decode($refcomponent->listLabreferral()), 'lab_id', 'labname');
        $discountreferral = ArrayHelper::map(json_decode($refcomponent->listDiscountreferral()), 'discount_id', 'type');
        $purposereferral = ArrayHelper::map(json_decode($refcomponent->listPurposereferral()), 'purpose_id', 'name');
        $modereleasereferral = ArrayHelper::map(json_decode($refcomponent->listModereleasereferral()), 'modeofrelease_id', 'mode');
        
        if ($model->load(Yii::$app->request->post())) {
            $transaction = $connection->beginTransaction();
            $modelReferralrequest = new Referralrequest();
            $model->request_datetime="0000-00-00 00:00:00";
            if ($model->save(false)){
                $modelReferralrequest->request_id = $model->request_id;
                $modelReferralrequest->sample_received_date = date('Y-m-d h:i:s',strtotime($model->sample_received_date));
                $modelReferralrequest->receiving_agency_id = Yii::$app->user->identity->profile->rstl_id;
                //$modelReferralrequest->testing_agency_id = null;
                $modelReferralrequest->referral_type_id = 1;
                if ($modelReferralrequest->save()){
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                    print_r($modelReferralrequest->getErrors());
                    //return false;
                }
                Yii::$app->session->setFlash('success', 'Referral Request Successfully Created!');
                return $this->redirect(['view', 'id' => $model->request_id]); ///lab/request/view?id=1
            } else {
                $transaction->rollBack();
                print_r($model->getErrors());
                //return false;
            }
        } else {
            $date = new DateTime();
            $date2 = new DateTime();
            $profile= Profile::find()->where(['user_id'=> Yii::$app->user->id])->one();
            date_add($date2,date_interval_create_from_date_string("1 day"));
            //$model->request_datetime=date("Y-m-d h:i:s");
            $model->request_datetime="0000-00-00 00:00:00";
            $model->report_due=date_format($date2,"Y-m-d");
            $model->created_at=date('U');
            $model->rstl_id=Yii::$app->user->identity->profile->rstl_id;//$GLOBALS['rstl_id'];
            $model->payment_type_id=1;
            $model->modeofrelease_ids='1';
            $model->discount_id=0;
            $model->discount='0.00';
            $model->total=0.00;
            $model->posted=0;
            $model->status_id=1;
            $model->request_type_id=2;
            $model->modeofreleaseids='1';
            $model->payment_status_id=1;
            $model->request_date=date("Y-m-d");
            if($profile){
                $model->receivedBy=$profile->firstname.' '. strtoupper(substr($profile->middleinitial,0,1)).'. '.$profile->lastname;
            }else{
                $model->receivedBy="";
            }
            if(\Yii::$app->request->isAjax){
                return $this->renderAjax('createReferral', [
                    'model' => $model,
                    'labreferral' => $labreferral,
                    'discountreferral' => $discountreferral,
                    'purposereferral' => $purposereferral,
                    'modereleasereferral' => $modereleasereferral,
                ]);
            }else{
                return $this->renderAjax('createReferral', [
                    'model' => $model,
                    'labreferral' => $labreferral,
                    'discountreferral' => $discountreferral,
                    'purposereferral' => $purposereferral,
                    'modereleasereferral' => $modereleasereferral,
                ]);
            }
        } */

        //$model = new eRequest();
        $model = new exRequestreferral();
        $connection= Yii::$app->labdb;
        $refcomponent = new ReferralComponent();
        $connection->createCommand('SET FOREIGN_KEY_CHECKS=0')->execute();
        $transaction = $connection->beginTransaction();
        
        if(isset(Yii::$app->user->identity->profile->rstl_id)){
            $rstlId = (int) Yii::$app->user->identity->profile->rstl_id;
        } else {
            //return 'Session time out!';
            return $this->redirect(['/site/login']);
        }

        $requestId = (int) Yii::$app->request->get('request_id');
        $pstcId = (int) Yii::$app->request->get('pstc_id');
        $function = new PstcComponent();

        if($rstlId > 0 && $pstcId > 0 && $requestId > 0) {
            $details = json_decode($function->getViewRequest($requestId,$rstlId,$pstcId),true);

            $request = $details['request_data'];
            $samples = $details['sample_data'];
            $analyses = $details['analyses_data'];
            $respond = $details['respond_data'];
            $pstc = $details['pstc_data'];
            $customer = $details['customer_data'];
            $subtotal = $details['subtotal'];
            $discount = $details['discount'];
            $total = $details['total'];

            $labreferral = ArrayHelper::map(json_decode($refcomponent->listLabreferral()), 'lab_id', 'labname');
            $discountreferral = ArrayHelper::map(json_decode($refcomponent->listDiscountreferral()), 'discount_id', 'type');
            $purposereferral = ArrayHelper::map(json_decode($refcomponent->listPurposereferral()), 'purpose_id', 'name');
            $modereleasereferral = ArrayHelper::map(json_decode($refcomponent->listModereleasereferral()), 'modeofrelease_id', 'mode');
            //$sampletype = ArrayHelper::map(json_decode($refcomponent->getSampletype()), 'modeofrelease_id', 'mode');

            $sampleDataProvider = new ArrayDataProvider([
                'allModels' => $samples,
                'pagination'=>false,
            ]);

            $analysisDataprovider = new ArrayDataProvider([
                'allModels' => $analyses,
                'pagination'=>false,
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'Invalid request!');
            return $this->redirect(['/pstc/pstcrequest']);
        }

        //if (Yii::$app->request->post()) {
        //if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post('eRequest');
            $total_fee = $total - ($subtotal * ($post['discount']/100));

            $model->modeofrelease_ids = implode(",", $post['modeofreleaseids']);
            $model->total = $total_fee;
            $model->pstc_request_id = $requestId;
            $model->created_at = date('Y-m-d H:i:s');
            $model->rstl_id = $rstlId;
            $model->request_datetime="0000-00-00 00:00:00";

            if($model->save(false)) {
                $local_requestId = $model->request_id;
                $psct_requestdetails = json_decode($function->getRequestDetails($requestId,$rstlId,$pstcId),true);

                $samples_analyses = $psct_requestdetails['sample_analysis_data'];
                $customer = $psct_requestdetails['customer_data'];

                $modelReferralrequest = new Referralrequest();
                $modelReferralrequest->request_id = $local_requestId;
                $modelReferralrequest->sample_received_date = date('Y-m-d h:i:s',strtotime($model->sample_received_date));
                $modelReferralrequest->receiving_agency_id = $rstlId;
                //$modelReferralrequest->testing_agency_id = null;
                $modelReferralrequest->referral_type_id = 1;

                if($modelReferralrequest->save()) {
                    //$transaction->commit();
                    $referral_request_save = 1;
                } else {
                    $referral_request_save = 0;
                    $transaction->rollBack();
                }

                foreach($samples_analyses as $sample) {
                    $modelSample = new Sample();

                    $modelSample->request_id = $local_requestId;
                    $modelSample->rstl_id = $rstlId;
                    $modelSample->sample_month = date_format(date_create($model->request_datetime),'m');
                    $modelSample->sample_year = date_format(date_create($model->request_datetime),'Y');
                    $modelSample->testcategory_id = 0; //pstc request, test category id is in analysis
                    //$modelSample->sampletype_id = 0; //pstc request, sample type id is in analysis
                    $modelSample->samplename = $sample['sample_name'];
                    $modelSample->description = $sample['sample_description'];
                    // $modelSample->sampling_date = $sample['sampling_date']; //to be updated
                    $modelSample->sampling_date = date('Y-m-d H:i:s'); //to be updated
                    $modelSample->pstcsample_id = $sample['pstc_sample_id'];
                    //$modelSample->testcategory_id = $post['testcategory_id'];
                    $modelSample->sampletype_id = $post['sampletype_id'];

                    if($modelSample->save(false)) {
                        foreach ($sample['analyses'] as $analysis) {
                            $modelAnalysis = new Analysis();
                            $modelAnalysis->rstl_id = $rstlId;
                            $modelAnalysis->date_analysis = date('Y-m-d');
                            $modelAnalysis->request_id = $local_requestId;
                            $modelAnalysis->pstcanalysis_id = $analysis['pstc_analysis_id'];
                            $modelAnalysis->package_id =  $analysis['package_id'];
                            $modelAnalysis->package_name =  $analysis['package_name'];
                            $modelAnalysis->sample_id = $modelSample->sample_id;
                            $modelAnalysis->test_id = $analysis['testname_id'];
                            $modelAnalysis->testname = $analysis['testname'];
                            $modelAnalysis->methodref_id = $analysis['method_id'];
                            $modelAnalysis->method = $analysis['method'];
                            $modelAnalysis->references = $analysis['reference'];
                            $modelAnalysis->fee =$analysis['fee'];
                            //$modelAnalysis->testcategory_id = $post['testcategory_id'];
                            $modelAnalysis->sample_type_id = $post['sampletype_id'];
                            $modelAnalysis->is_package = $analysis['is_package'];
                            $modelAnalysis->is_package_name = $analysis['is_package_name'];
                            $modelAnalysis->quantity = 1;
                            if($modelAnalysis->save(false)) {
                                $analysisSave = 1;
                            } else {
                                $transaction->rollBack();
                                $analysisSave = 0;
                            }
                        }
                        $sampleSave = 1;
                    } else {
                        $transaction->rollBack();
                        $sampleSave = 0;
                    }
                }

                if($sampleSave == 1 && $analysisSave == 1 && $referral_request_save == 1) {

                    $generate_code = $this->saveRequest($local_requestId,$model->lab_id,$rstlId,date('Y',strtotime($model->request_datetime)));
                    $sample_data = [];
                    if($generate_code == "success") {
                        $local_samples = Sample::find()->where(['request_id'=>$local_requestId])->asArray()->all();
                        $local_request = Request::findOne($local_requestId);

                        $requestData = [
                            'pstc_request_id' => $local_request->pstc_request_id,
                            'request_ref_num' => $local_request->request_ref_num,
                            'rstl_id' => $local_request->rstl_id,
                            'pstc_id' => $pstcId,
                            'local_request_id' => $local_request->request_id,
                            'request_date_created' => $local_request->request_datetime,
                            'estimated_due_date' => $local_request->report_due,
                            'lab_id' => $local_request->lab_id,
                            'discount_id' => $local_request->discount_id,
                            'discount_rate' => $local_request->discount,
                            'sample_received_date' => $local_request->referralrequest->sample_received_date,
                        ];

                        foreach ($local_samples as $data) {
                            $sampleData = [
                                'sample_id' => $data['pstcsample_id'],
                                'sample_code' => $data['sample_code'],
                                'sample_month' => $data['sample_month'],
                                'sample_year' => $data['sample_year'],
                            ];
                            array_push($sample_data, $sampleData);
                        }

                        $pstc_request_details = Json::encode(['request_data'=>$requestData,'sample_data'=>$sample_data,'local_request_id'=>$local_requestId],JSON_NUMERIC_CHECK);
                        $pstcUrl='https://eulimsapi.onelab.ph/api/web/referral/pstcrequests/updaterequest_details';
                   
                        $curl = new curl\Curl();
                        $pstc_return = $curl->setRequestBody($pstc_request_details)
                        ->setHeaders([
                            'Content-Type' => 'application/json',
                            'Content-Length' => strlen($pstc_request_details),
                        ])->post($pstcUrl);

                        if($pstc_return == 1){
                            $transaction->commit();
                            Yii::$app->session->setFlash('success', 'Request successfully saved!');
                            return $this->redirect(['/lab/request/view','id'=>$local_requestId]);
                        } else {
                            $transaction->rollBack();
                            return "<div class='alert alert-danger'><span class='glyphicon glyphicon-exclamation-sign' style='font-size:18px;'></span>&nbsp;Request 1 failed to save!</div>";
                        }
                    } else {
                        $transaction->rollBack();
                        return "<div class='alert alert-danger'><span class='glyphicon glyphicon-exclamation-sign' style='font-size:18px;'></span>&nbsp;Failed to generate samplecode!</div>";
                    }
                } else {
                    $transaction->rollBack();
                    return "<div class='alert alert-danger'><span class='glyphicon glyphicon-exclamation-sign' style='font-size:18px;'></span>&nbsp;Request 2 failed to save!</div>";
                }
            } else {
                //Yii::$app->session->setFlash('error', "Request failed to save!");
                //return $this->redirect(['/pstc/pstcrequest/view','request_id'=>$requestId,'pstc_id'=>$pstcId]);
                $transaction->rollBack();
                return "<div class='alert alert-danger'><span class='glyphicon glyphicon-exclamation-sign' style='font-size:18px;'></span>&nbsp;Request 3 failed to save!</div>";
            }
        } else {
            $date = new DateTime();
            $date2 = new DateTime();
            $profile= Profile::find()->where(['user_id'=> Yii::$app->user->id])->one();
            date_add($date2,date_interval_create_from_date_string("1 day"));
            //$model->request_datetime=date("Y-m-d h:i:s");
            $model->request_datetime="0000-00-00 00:00:00";
            $model->report_due=date_format($date2,"Y-m-d");
            $model->created_at=date('U');
            $model->rstl_id=$rstlId;
            $model->payment_type_id=1;
            $model->modeofrelease_ids='1';
            $model->discount_id=0;
            $model->discount='0.00';
            $model->total=0.00;
            $model->posted=0;
            $model->status_id=1;
            $model->request_type_id=2;
            $model->modeofreleaseids='1';
            $model->payment_status_id=1;
            $model->request_date=date("Y-m-d");
            $model->customer_id = $request['customer_id'];
            $model->conforme = $request['submitted_by'];

            if($profile){
                $model->receivedBy=$profile->firstname.' '. strtoupper(substr($profile->middleinitial,0,1)).'. '.$profile->lastname;
            }else{
                $model->receivedBy="";
            }

            if(\Yii::$app->request->isAjax) {
                return $this->renderAjax('_formReferralDetails', [
                    'model' => $model,
                    'request' => $request,
                    'customer' => $customer,
                    'sampleDataProvider' => $sampleDataProvider,
                    'analysisDataprovider'=> $analysisDataprovider,
                    'respond' => $respond,
                    'pstc' => $pstc,
                    'subtotal' => $subtotal,
                    'discounted' => $discount,
                    'total' => $total,
                    'countSample' => count($samples),
                    'countAnalysis' => count($analyses),
                    'sampletype' => null,
                    'labreferral' => $labreferral,
                    'discountreferral' => $discountreferral,
                    'purposereferral' => $purposereferral,
                    'modereleasereferral' => $modereleasereferral,
                ]);
            } else {
                return $this->renderAjax('_formReferralDetails', [
                    'model' => $model,
                    'request' => $request,
                    'customer' => $customer,
                    'sampleDataProvider' => $sampleDataProvider,
                    'analysisDataprovider'=> $analysisDataprovider,
                    'respond' => $respond,
                    'pstc' => $pstc,
                    'subtotal' => $subtotal,
                    'discounted' => $discount,
                    'total' => $total,
                    'countSample' => count($samples),
                    'countAnalysis' => count($analyses),
                    'sampletype' => null,
                    'labreferral' => $labreferral,
                    'discountreferral' => $discountreferral,
                    'purposereferral' => $purposereferral,
                    'modereleasereferral' => $modereleasereferral,
                ]);
            }
        }
    }

    //get lists of test category by sampletype_id
    public function actionGet_testcategory()
    {
        $labId = (int) Yii::$app->request->get('lab_id');

        if($labId > 0)
        {
            $testcategory = Labsampletype::find()
                //->select('tbl_sampletype.*')
                ->joinWith(['testcategory'],true)
                ->where('tbl_lab_sampletype.lab_id = :labId', [':labId' => $labId])
                //->asArray()
                ->groupBy('tbl_testcategory.testcategory_id')
                ->all();

                //print_r($testcategory);

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(count($testcategory) > 0)
            {
                foreach($testcategory as $list) {
                    $data[] = ['id' => $list->testcategory->testcategory_id, 'text' => $list->testcategory->category];
                }
                //$data = ['id' => '', 'text' => 'No results found'];
            } else {
                $data = ['id' => '', 'text' => 'No results found'];
            }
        } else {
            $data = ['id' => '', 'text' => 'No results found'];
        }
        return ['data' => $data];
    }

    //get lists of sampletype by test category id
    public function actionGet_sampletype()
    {
        $testcategoryId = (int) Yii::$app->request->get('testcategory_id');

        if($testcategoryId > 0)
        {
            $sampletype = Sampletype::find()
                //->select('tbl_sampletype.*')
                ->joinWith(['labSampletypes'],false)
                ->where('tbl_lab_sampletype.testcategory_id = :testcategoryId', [':testcategoryId' => $testcategoryId])
                //->asArray()
                ->groupBy('tbl_sampletype.sampletype_id')
                ->all();

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(count($sampletype) > 0)
            {
                foreach($sampletype as $list) {
                    $data[] = ['id' => $list->sampletype_id, 'text' => $list->type];
                }
                //$data = ['id' => '', 'text' => 'No results found'];
            } else {
                $data = ['id' => '', 'text' => 'No results found'];
            }
        } else {
            $data = ['id' => '', 'text' => 'No results found'];
        }
        return ['data' => $data];
    }

    //get lists of referral sampletype by lab id
    public function actionGet_referral_sampletype0()
    {
        $labId = (int) Yii::$app->request->get('lab_id');

        if($labId > 0)
        {
            $sampletype = Sampletype::find()
                //->select('tbl_sampletype.*')
                ->joinWith(['labSampletypes'],false)
                ->where('tbl_lab_sampletype.testcategory_id = :testcategoryId', [':testcategoryId' => $testcategoryId])
                //->asArray()
                ->groupBy('tbl_sampletype.sampletype_id')
                ->all();

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(count($sampletype) > 0)
            {
                foreach($sampletype as $list) {
                    $data[] = ['id' => $list->sampletype_id, 'text' => $list->type];
                }
                //$data = ['id' => '', 'text' => 'No results found'];
            } else {
                $data = ['id' => '', 'text' => 'No results found'];
            }
        } else {
            $data = ['id' => '', 'text' => 'No results found'];
        }
        return ['data' => $data];
    }

    //get lists of referral sampletype by lab id
    public function actionGet_referral_sampletype()
    {
        //$apiUrl='http://localhost/eulimsapi.onelab.ph/api/web/referral/listdatas/labsampletypebylab?lab_id='.$labId;
        /*$apiUrl='http://localhost/eulimsapi.onelab.ph/api/web/referral/listdatas/sampletypebylab?lab_id='.$labId;
        $curl = new curl\Curl();
        $list = $curl->get($apiUrl);

        $data = ArrayHelper::map(json_decode($list), 'sampletype_id', 'type');
        
        return $data;

        $apiUrl='https://eulimsapi.onelab.ph/api/web/referral/listdatas/testnamebysampletype?sampletype_id='.$sampletypeId;
        $curl = new curl\Curl();
        $curl->setOption(CURLOPT_CONNECTTIMEOUT, 120);
        $curl->setOption(CURLOPT_TIMEOUT, 120);
        $lists = $curl->get($apiUrl); */

        $labId = (int) Yii::$app->request->get('lab_id');

        $refcomponent = new ReferralComponent();
        $lists = $refcomponent->getSampletype($labId);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if(count($lists)>0 && $lists != 'Not valid lab')
        {
            foreach(json_decode($lists,true) as $list) {
                $data[] = ['id' => $list['sampletype_id'], 'text' => $list['type']];
            }
        } else {
            $data = [['id' => '', 'text' => 'No results found']];
        }

        return ['data' => $data];
    }

    protected function saveRequest($requestId,$labId,$rstlId,$year) {
        $post= Yii::$app->request->post();
        // echo $post['request_id'];
        //exit;
        $return="failed";
        //$request_id=(int) $post['request_id'];
        //$lab_id=(int) $post['lab_id'];
        //$rstl_id=(int) $post['rstl_id'];
        //$year=(int) $post['year'];
        // Generate Reference Number
        $func=new Functions();
        $proc="spGetNextGeneratedRequestCode(:RSTLID,:LabID)";
        $params=[
            ':RSTLID'=>$rstlId,
            ':LabID'=>$labId
        ];
        $connection= Yii::$app->labdb;
        $transaction =$connection->beginTransaction();
        $row=$func->ExecuteStoredProcedureOne($proc, $params, $connection);
        $referenceNumber=$row['GeneratedRequestCode'];
        $requestIncrement=$row['RequestIncrement'];
        //Update the tbl_requestcode
        $requestcode= Requestcode::find()->where([
            'rstl_id'=>$rstlId,
            'lab_id'=>$labId,
            'year'=>$year
        ])->one($connection);
        
        if(!$requestcode){
            $requestcode=new Requestcode();
        }
        $requestcode->request_ref_num=$referenceNumber;
        $requestcode->rstl_id=$rstlId;
        $requestcode->lab_id=$labId;
        $requestcode->number=$requestIncrement;
        $requestcode->year=$year;
        $requestcode->cancelled=0;
        $requestcode->save(false);
        //Update tbl_request table
        $request= Request::find()->where(['request_id'=>$requestId])->one($connection);
        $request->request_ref_num=$referenceNumber;
       
        $discountquery = Discount::find()->where(['discount_id' => $request->discount_id])->one();

        $rate =  $discountquery->rate;
        
        $sql = "SELECT SUM(fee) as subtotal FROM tbl_analysis WHERE request_id=$requestId";
        $command = $connection->createCommand($sql);
        $row = $command->queryOne();
        $subtotal = $row['subtotal'];
        $total = $subtotal - ($subtotal * ($rate/100));
        
        $request->total=$total;

        if($request->save(false)) {
            //$Func=new Functions();
            $response=$func->GenerateSampleCode($requestId);
            if($response){
                $transaction->commit();
                $return="success";
                //Yii::$app->session->setFlash('success', 'Request Reference # and Sample Code Successfully Generated!');
            } else {
                $transaction->rollback();
                //Yii::$app->session->setFlash('danger', 'Request Reference # and Sample Code Failed to Generate!');
                $return="failed";
            }
        } else {
            //Yii::$app->session->setFlash('danger', 'Request Reference # and Sample Code Failed to Generate!');
            $transaction->rollback();
            $return="failed";
        }
        return $return;
    }
}
