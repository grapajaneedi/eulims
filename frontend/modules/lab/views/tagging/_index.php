<?php
use common\models\TaggingSearch;
use common\models\lab\Sample;
use yii\data\ActiveDataProvider;
?>

<?php $searchModel = new TaggingSearch();
     
     $model = new Sample();
     
     $samplesQuery = Sample::find()->where(['sample_id' =>0]);
     $dataProvider = new ActiveDataProvider([
             'query' => $samplesQuery,
             'pagination' => [
                 'pageSize' => 10,
             ],
          
     ]);

     ?>


<?= $this->render('index', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                   
                ]) ?>   