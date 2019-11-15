<?php 

namespace frontend\modules\track\controllers;

use yii\web\Controller;
use common\models\lab\Request;
use Yii;

/**
 * Default controller for the `Lab` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
   

    public function actionIndex()
    {
        $model = new Request();
        $post= Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post())) {

            
            return $this->render('view', [
                'model' => $model,
            ]);
        }


        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new Request();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->request_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
}