<?php


namespace frontend\modules\lab\controllers;
use Yii;
use common\models\lab\Joborder;
use common\models\lab\Request;
use common\models\lab\Sample;
use common\models\lab\Analysis;
use common\models\lab\JoborderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JoborderController implements the CRUD actions for Joborder model.
 */
class JoborderController extends Controller
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
     * Lists all Joborder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JoborderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Joborder model.
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
     * Creates a new Joborder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Joborder();
        $post= Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
       }
    }
       public function actionPrintjoborder()
       {  
            $id = 1;
            $mpdf = new \Mpdf\Mpdf([
                'format' => [700,200], 
                'orientation' => 'L',
            ]);
            // $request = Request::find()->where(['request_id' => $id]);
            // $samplesquery = Sample::find()->where(['request_id' => $id])->all();
            // $requestquery = Request::find()->where(['request_id' => $id])->one();
            // foreach ($samplesquery as $sample) {
            //     $limitreceived_date = substr($requestquery['request_datetime'], 0,10);
                $mpdf->AddPage('','','','','',0,0,0,0);
                $samplecode = '<div style="width: 90%; text-align: center; margin-top: 10 ; font: Arial;"><B>NEGROS PRAWN PRODUCERS COOPERATIVE
                <BR>ANALYTICAL AND DIAGNOSTIC LABORATORY</B><BR>DOOR 2, NOLKFI BLDG, 6TH STREET BACOLOD CITY 6100 PHILIPPINES<BR>
                TELEFAX 433-2131; 700-7287 EMAIL ADDRESS: NPPC';
            
             //   $mpdf->WriteHTML("<barcode code=".$sample['sample_code']." type='C39' />");
                $mpdf->WriteHTML($samplecode);
    
                // $text = '<font size="5">WI-003-F1';
                // $text2 = '<font size="5"><b>Rev 03/03.01.18<b>';
    
                // $i = 1;
                // $analysisquery = Analysis::find()->where(['sample_id' => $sample['sample_id']])->all();
                // $acount = Analysis::find()->where(['sample_id' => $sample['sample_id']])->count();
                //        foreach ($analysisquery as $analysis){
                //             $mpdf->WriteHTML("&nbsp;&nbsp;&nbsp;&nbsp;<font size='2'>".$analysis['testname']."</font>");
    
                //             if ($i++ == $acount)
                //             break;
                //        }               
                // }          
                $mpdf->Output();
           }
         // }
        
        // $model = new Labsampletype();
        // $post= Yii::$app->request->post();
        // if ($model->load(Yii::$app->request->post())) {

        //     $labsampletype = Labsampletype::find()->where(['lab_id'=> $post['Labsampletype']['lab_id'], 'sampletype_id'=>$post['Labsampletype']['sampletype_id'],  'testcategory_id'=>$post['Labsampletype']['testcategory_id']])->one();

        //     if ($labsampletype){
        //         Yii::$app->session->setFlash('warning', "The system has detected a duplicate record. You are not allowed to perform this operation."); 
        //          return $this->runAction('index');
        //     }else{
        //         $model->save();
        //         Yii::$app->session->setFlash('success', 'Lab Sample Type Successfully Created'); 
        //         return $this->runAction('index');
        //     }
     

    /**
     * Updates an existing Joborder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->joborder_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Joborder model.
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
     * Finds the Joborder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Joborder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Joborder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
} 