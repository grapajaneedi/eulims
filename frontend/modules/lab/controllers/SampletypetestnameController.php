<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Sampletypetestname;
use common\models\lab\SampletypetestnameSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\lab\Testname;
use yii\helpers\Json;

/**
 * SampletypetestnameController implements the CRUD actions for Sampletypetestname model.
 */
class SampletypetestnameController extends Controller
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
     * Lists all Sampletypetestname models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SampletypetestnameSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sampletypetestname model.
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
     * Creates a new Sampletypetestname model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sampletypetestname();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Sample Type Test Name Successfully Created'); 
            return $this->runAction('index');
        }

        $testname = [];
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('_form', [
                'model' => $model,
                'testname'=>$testname,
            ]);
       }
    }

    /**
     * Updates an existing Sampletypetestname model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'sampletype_testname_id' => $model->sampletype_testname_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Sampletypetestname model.
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
     * Finds the Sampletypetestname model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sampletypetestname the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sampletypetestname::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function listSampletype()
    {
        $sampletype = ArrayHelper::map(
            Sampletype::find()
            ->leftJoin('tbl_lab_sampletype', 'tbl_sampletype.sampletype_id=tbl_lab_sampletype.sampletypeId')
            ->Where(['tbl_lab_sampletype.lab_id'=>$id])
            ->all(), 'lab_sampletype_id', 
            function($sampletype, $defaultValue) {
                return $sampletype->testName;
        });

        return $sampletype;
    }

    
    public function actionListsampletype() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
          
            $list = Sampletype::find()
            ->leftJoin('tbl_lab_sampletype', 'tbl_sampletype.sampletype_id=tbl_lab_sampletype.sampletypeId')
            ->Where(['tbl_lab_sampletype.lab_id'=>$id])
            ->asArray()
            ->all();

            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $sampletype) {
                    $out[] = ['id' => $sampletype['sampletype_id'], 'name' => $sampletype['type']];
                    if ($i == 0) {
                        $selected = $sampletype['sampletype_id'];
                    }
                }
                
                echo Json::encode(['output' => $out, 'selected'=>$selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected'=>'']);
    }

    public function listTestname()
    {
        $sampletype = ArrayHelper::map(
            Testname::find()
            ->leftJoin('tbl_sampletype_testname', 'tbl_testname.testname_id=tbl_sampletype_testname.testname_id')
            ->Where(['tbl_sampletype_testname.sampletype_id'=>$id])
            ->all(), 'testname_id', 
            function($sampletype, $defaultValue) {
                return $sampletype->testName;
        });

        return $sampletype;
    }

    
    public function actionListtestname() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
          
            $list =  Testname::find()
            ->leftJoin('tbl_sampletype_testname', 'tbl_testname.testname_id=tbl_sampletype_testname.testname_id')
            ->Where(['tbl_sampletype_testname.sampletype_id'=>$id])
            ->asArray()
            ->all();

            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $sampletype) {
                    $out[] = ['id' => $sampletype['testname_id'], 'name' => $sampletype['testName']];
                    if ($i == 0) {
                        $selected = $sampletype['testname_id'];
                    }
                }
                
                echo Json::encode(['output' => $out, 'selected'=>$selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected'=>'']);
    }
}
