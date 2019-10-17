<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use common\models\lab\Request;
use common\models\lab\Businessnature;
use common\models\lab\Lab;
use common\models\lab\Markettype;
use common\models\lab\Paymenttype;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\CsfSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<h3 style="color:#142142;font-family:verdana;text-align:center;font-size:150%;text-shadow: 
      4px 4px 0px #d5d5d5, 
      7px 7px 0px rgba(0, 0, 0, 0.2);"><b>Department of Science and Technology</b></h3>
<h3 style="color:#142142;font-family:verdana;text-align:center;font-size:150%;text-shadow: 
      4px 4px 0px #d5d5d5, 
      7px 7px 0px rgba(0, 0, 0, 0.2);"><b>REGIONAL STANDARDS AND TESTING LABORATORY</b></h3>

<h1 style="color:#1a4c8f;font-family:Century Gothic;text-align:center;font-size:250%;text-shadow: 
      4px 4px 0px #d5d5d5, 
      7px 7px 0px rgba(0, 0, 0, 0.2);"><b>Customer Satisfaction Feedback Survey</b></h1><br>

   
 
                
              
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>   
            