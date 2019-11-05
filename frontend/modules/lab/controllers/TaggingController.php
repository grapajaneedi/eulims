<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Tagging;
use common\models\lab\Analysis;
use common\models\lab\Request;
use common\models\lab\Sample;
use common\models\TaggingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use common\models\system\Profile;

/**
 * TaggingController implements the CRUD actions for Tagging model.
 */
class TaggingController extends Controller
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
     * Lists all Tagging models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaggingSearch();
       // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Sample();
        
        $samplesQuery = Sample::find()->where(['sample_id' =>0]);
        $dataProvider = new ActiveDataProvider([
                'query' => $samplesQuery,
                'pagination' => [
                    'pageSize' => 10,
                ],
             
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$model,
        ]);
    }

    /**
     * Displays a single Tagging model.
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
     * Creates a new Tagging model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tagging();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->tagging_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tagging model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->tagging_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Tagging model.
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
     * Finds the Tagging model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tagging the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tagging::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetsamplecode($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('sample_id as id, sample_code AS text')
                    ->from('tbl_sample')
                    ->where(['like', 'sample_code', $q])
                    ->limit(20);
            $command = $query->createCommand();
            $command->db= \Yii::$app->labdb;
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' =>Sample::find()->where(['sample_id'=>$id])->sample_code];
        }
        return $out;
    }

    public function actionStartanalysis()
    {
        
        if(isset($_POST['id'])){
			$ids = $_POST['id'];
            $analysisID = explode(",", $ids);
                
			if ($ids){
				foreach ($analysisID as $aid){
                    
                    $taggingmodel = Tagging::find()->where(['analysis_id'=>$aid])->one();
                    if ($taggingmodel){

                    }else{
                        $tagging = new Tagging();
                        $profile= Profile::find()->where(['user_id'=> Yii::$app->user->id])->one();
                        $tagging->user_id = $profile->user_id;
                        $tagging->analysis_id = $aid;
                        $tagging->start_date = date("Y-m-d");
                       // $tagging->end_date = "0000-00-00";
                        $tagging->tagging_status_id = 1;
                     //   $tagging->cancel_date = "0000-00-00";
                        $tagging->reason = 1;
                        $tagging->cancelled_by = 1;
                    //    $tagging->disposed_date = "0000-00-00";
                        $tagging->iso_accredited = 1;
                        $tagging->save(false); 


                       	
                    }
                 
            }

        }
       

            $analysis_id = $_POST['analysis_id'];

            
            
            $samplesQuery = Sample::find()->where(['sample_id' =>$analysis_id]);
            $sampleDataProvider = new ActiveDataProvider([
                    'query' => $samplesQuery,
                    'pagination' => [
                        'pageSize' => 10,
                    ],
                 
            ]);
            $analysisQuery = Analysis::find()->where(['sample_id' => $analysis_id]);      
            $analysisdataprovider = new ActiveDataProvider([
                    'query' => $analysisQuery,
                    'pagination' => [
                        'pageSize' => 10,
                    ],
                 
            ]);
            return $this->renderAjax('_viewAnalysis', [
                'sampleDataProvider' => $sampleDataProvider,
                'analysisdataprovider'=> $analysisdataprovider,
                'analysis_id'=>$analysis_id,
             ]);
         
            
        }
            
     }

     public function actionCompletedanalysis()
     {
         
         if(isset($_POST['id'])){
             $ids = $_POST['id'];
             $analysis_id = $_POST['analysis_id'];
             $analysisID = explode(",", $ids);
             $profile= Profile::find()->where(['user_id'=> Yii::$app->user->id])->one();
             if ($ids){
                 foreach ($analysisID as $aid){
                    $tagging= Tagging::find()->where(['analysis_id'=> $aid])->one();
                    $analysis= Analysis::find()->where(['analysis_id'=> $aid])->one();
                
                    if ($tagging){
                        $now = date('Y-m-d');
                        $Connection= Yii::$app->labdb;
                        $sql="UPDATE `tbl_tagging` SET `end_date`='$now', `tagging_status_id`='2' WHERE `tagging_id`=".$tagging->tagging_id;
                        $Command=$Connection->createCommand($sql);
                        $Command->execute();                      
                        $sample= Sample::find()->where(['sample_id'=> $aid])->one();
                                      
                        $taggingcount= Tagging::find()
                        ->leftJoin('tbl_analysis', 'tbl_tagging.analysis_id=tbl_analysis.analysis_id')
                        ->leftJoin('tbl_sample', 'tbl_analysis.sample_id=tbl_sample.sample_id')    
                        ->where(['tbl_tagging.tagging_status_id'=>2, 'tbl_sample.sample_id'=>$analysis->sample_id ])
                        ->all();                                        
                    }else{

                    }                     
             } 

             if ($taggingcount){
                $counttag = count($taggingcount); 
             } 
              $sql="UPDATE `tbl_sample` SET `completed`='$counttag' WHERE `sample_id`=".$analysis_id;
              $Command=$Connection->createCommand($sql);
              $Command->execute();                 
              $samplesq = Sample::find()->where(['sample_id' =>$analysis_id])->one();             
              $samcount = $samplesq->completed;

              $sampletagged= Sample::find()
              ->leftJoin('tbl_analysis', 'tbl_sample.sample_id=tbl_analysis.sample_id')
              ->leftJoin('tbl_tagging', 'tbl_analysis.analysis_id=tbl_tagging.analysis_id') 
              ->leftJoin('tbl_request', 'tbl_request.request_id=tbl_analysis.request_id')    
              ->where(['tbl_tagging.tagging_status_id'=>2, 'tbl_request.request_id'=>$samplesq->request_id ])
              ->all();  

              $st = count($sampletagged);

              if ($samcount==$counttag){
                $sql="UPDATE `tbl_request` SET `completed`='$st' WHERE `request_id`=".$samplesq->request_id;
                $Command=$Connection->createCommand($sql);
                $Command->execute(); 
              }
            
         }
            
             $samplesQuery = Sample::find()->where(['sample_id' =>$analysis_id]);
             $sampleDataProvider = new ActiveDataProvider([
                     'query' => $samplesQuery,
                     'pagination' => [
                         'pageSize' => 10,
                     ],
                  
             ]);
             $analysisQuery = Analysis::find()->where(['sample_id' => $analysis_id]);   
             $analysisdataprovider = new ActiveDataProvider([
                     'query' => $analysisQuery,
                     'pagination' => [
                         'pageSize' => 10,
                     ],
                  
             ]);
 
             return $this->renderAjax('_viewAnalysis', [
                 'sampleDataProvider' => $sampleDataProvider,
                 'analysisdataprovider'=> $analysisdataprovider,
                 'analysis_id'=>$analysis_id,
              ]);
          
             
         }
             
      }

    public function actionGetanalysis()
	{
        $id = $_GET['analysis_id'];
        $analysis_id = $id;
        $model = new Tagging();
         $samplesQuery = Sample::find()->where(['sample_id' => $id]);
         $sampleDataProvider = new ActiveDataProvider([
                 'query' => $samplesQuery,
                 'pagination' => [
                     'pageSize' => 10,
                 ],       
         ]);

         $analysisQuery = Analysis::find()->where(['sample_id' => $id]);
         $request = Request::find()->where(['request_id' =>42]);
         $analysisdataprovider = new ActiveDataProvider([
                 'query' => $analysisQuery,
                 'pagination' => [
                     'pageSize' => 10,
                 ],
              
         ]);
         
         return $this->renderAjax('_viewAnalysis', [
            'request'=>$request,
            'model'=>$model,
            'sampleDataProvider' => $sampleDataProvider,
            'analysisdataprovider'=> $analysisdataprovider,
            'analysis_id'=>$analysis_id,
            'id'=>$id,
         ]);
	
	 }
}
