<?php

namespace frontend\modules\inventory\controllers;

use yii\web\Controller;
use Yii;
use common\models\inventory\Products;
use common\models\inventory\InventoryEntries;
use common\models\inventory\Reorder;
use yii\data\ActiveDataProvider;

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
    	//echo date("Y-m-d"); exit();
    	//detemine the product entries that are expired
    	//$entries = InventoryEntries::find()->where(['expiration_date'])->all();
    	$query = InventoryEntries::find()->where(['<','expiration_date',date("Y-m-d")]);
    	$dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query = Reorder::find();
        $dataProvider2 = new ActiveDataProvider([
            'query' => $query,
        ]);

        //query for reorderpoint 
        return $this->render('index',[
        	'dataProvider'=>$dataProvider,
            'dataProvider2'=>$dataProvider2,
        ]);
    }
}