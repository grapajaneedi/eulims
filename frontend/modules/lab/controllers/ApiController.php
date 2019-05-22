<?php
namespace frontend\modules\lab\controllers;
use Yii;
use common\models\lab\Analysis;
use common\models\lab\Sample;
use common\models\lab\Request;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

use common\models\lab\Lab;
use common\models\lab\Labsampletype;
use common\models\lab\Sampletype;
use common\models\lab\Sampletypetestname;
use common\models\lab\Testnamemethod;
use common\models\lab\Methodreference;
use common\models\lab\Testname;
use yii\data\ArrayDataProvider;


/**
 * AnalysisController implements the CRUD actions for Analysis model.
 */
class ApiController extends Controller
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
     * Lists all Analysis models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AnalysisSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    //Server Status
    public function actionStatus($server)
    {  
      
            if(!$sock = @fsockopen($server, 80))
            {
                $data = array("status" => "Offline");
            }
            else
            {
                $data = array("status" => "Online");
            }

            return $this->asJson($data);
       
   }  

   //Login
  public function actionLogin($email, $password)
  {  

                
            return $u.$p;
  }  

 public function actionUser()
  {  
         $model = new Sample();    
        

             if (!isset($_GET['rstl_id'])){
                 $rstl = 11;
                 $year = 2019;
             }else{
                 $rstl = (int) $_GET['rstl_id'];
                 $year = (int) $_GET['year'];
             }
                 $data = $model::find()
                      ->leftJoin('tbl_request', 'tbl_sample.request_id=tbl_request.request_id') 
                      ->where(['tbl_request.rstl_id'=>$rstl]) 
                      ->AndWhere(['like', 'request_ref_num', '%'.$year.'%', false]) 
                      ->count();
                
                     return $data;
 }  

 public function actionSamplecode()
  {  
         $model = new Sample();    
        

             if (!isset($_GET['rstl_id'])){
                 $rstl = 11;
                 $year = 2019;
             }else{
                 $rstl = (int) $_GET['rstl_id'];
                 $year = (int) $_GET['year'];
             }
                 $data = $model::find()
                      ->leftJoin('tbl_request', 'tbl_sample.request_id=tbl_request.request_id') 
                      ->where(['tbl_request.rstl_id'=>$rstl]) 
                      ->AndWhere(['like', 'request_ref_num', '%'.$year.'%', false]) 
                      ->count();
                
                     return $data;
 }  

 public function actionAnalysis()
  {  
         $model = new Sample();    
        

             if (!isset($_GET['rstl_id'])){
                 $rstl = 11;
                 $year = 2019;
             }else{
                 $rstl = (int) $_GET['rstl_id'];
                 $year = (int) $_GET['year'];
             }
                 $data = $model::find()
                      ->leftJoin('tbl_request', 'tbl_sample.request_id=tbl_request.request_id') 
                      ->where(['tbl_request.rstl_id'=>$rstl]) 
                      ->AndWhere(['like', 'request_ref_num', '%'.$year.'%', false]) 
                      ->count();
                
                     return $data;
 }  

    /**
     * Displays a single Analysis model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

}
