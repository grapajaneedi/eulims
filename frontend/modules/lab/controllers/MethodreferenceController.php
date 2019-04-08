<?php

namespace frontend\modules\lab\controllers;
use Yii;
use common\models\lab\Methodreference;
use common\models\lab\MethodreferenceSearch;
use common\models\lab\TestnamemethodSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MethodreferenceController implements the CRUD actions for Methodreference model.
 */
class MethodreferenceController extends Controller
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
     * Lists all Methodreference models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MethodreferenceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = ['method' => SORT_ASC];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTestname()
    {
        $searchModel = new TestnamemethodSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/testnamemethod/indextestname', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Methodreference model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]);
        }
    }

    /**
     * Creates a new Methodreference model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    //  $model = new Testname();
    //  $post= Yii::$app->request->post();
    //  if ($model->load(Yii::$app->request->post())) {
    //      $testname = Testname::find()->where(['testName'=> $post['Testname']['testName']])->one();

    //      if($testname){
    //          Yii::$app->session->setFlash('warning', "The system has detected a duplicate record. You are not allowed to perform this operation."); 
    //          return $this->runAction('testname');
    //      }else{
    //          $post= Yii::$app->request->post();
    //          $model->save();  
    //          Yii::$app->session->setFlash('success', 'Test Name Successfully Created'); 
    //          return $this->runAction('testname');
    //      } 
    //  }


    public function actionCreate()
    {
        $model = new Methodreference();
        $model->testname_id = 0;

        $post= Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post())) {

            $methodreference = Methodreference::find()->where(['method'=> $post['Methodreference']['method'], 'reference'=> $post['Methodreference']['reference'], 'fee'=> $post['Methodreference']['fee']])->one();
            if ($methodreference){
                Yii::$app->session->setFlash('warning', "The system has detected a duplicate record. You are not allowed to perform this operation."); 
                return $this->runAction('index');
            }else{
                Yii::$app->session->setFlash('success', 'Method Reference Successfully Created'); 
                $model->save();
                return $this->runAction('index');
            }
            
        }


            $model->create_time=date("Y-m-d h:i:s");
            $model->update_time=date("Y-m-d h:i:s");

            $model->testname_id = 0;
            
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
       }
    }

    public function actionCreatemethod()
    {
        $model = new Methodreference();
        $model->testname_id = 0;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
           // Yii::$app->session->setFlash('success', 'Method Reference Successfully Created'); 
            return $this->runAction('testname');
        }
        $model->create_time=date("Y-m-d h:i:s");
        $model->update_time=date("Y-m-d h:i:s");

       $model->testname_id = 0;
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('_formmethodreference', [
                'model' => $model,
            ]);
       }
    }

    /**
     * Updates an existing Methodreference model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    Yii::$app->session->setFlash('success', 'Method Reference Successfully Updated'); 
                    return $this->redirect(['index']);

                } else if (Yii::$app->request->isAjax) {
                    return $this->renderAjax('update', [
                        'model' => $model,
                    ]);
                 }
    }

    /**
     * Deletes an existing Methodreference model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id); 
        if($model->delete()) {            
            Yii::$app->session->setFlash('success', 'Method Reference Successfully Deleted'); 
            return $this->redirect(['index']);
        } else {
            return $model->error();
        }
    }

    /**
     * Finds the Methodreference model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Methodreference the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Methodreference::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
