<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\lab\Lab;
use common\models\lab\Markettype;
use common\models\lab\Sampletype;
use common\models\lab\Documentcontrolconfig;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\DocumentcontrolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customer Satisfaction Feedback Survey';
$this->params['breadcrumbs'][] = $this->title;

$lablist= ArrayHelper::map(Lab::find()->all(),'lab_id','labname');
$tomlist= ArrayHelper::map(Markettype::find()->all(),'id','type');

?>

 

<div class="row">
        <div class="col-sm-1">     
                <div class="panel panel-info">
                <div class="panel-heading" style="color:#142142;font-family:Century Gothic;font-size:130%;text-align:center"><b>JAN</div>
                <div class="panel-body" style="text-align:center;font-size:180%">
                94.43%
                </div>
            </div>
        </div>

        <div class="col-sm-1">     
                <div class="panel panel-info">
                <div class="panel-heading" style="color:#142142;font-family:Century Gothic;font-size:130%;text-align:center"><b>FEB</div>
                <div class="panel-body" style="text-align:center;font-size:180%">
                94.43%
                </div>
            </div>
        </div>

        <div class="col-sm-1">     
                <div class="panel panel-info">
                <div class="panel-heading" style="color:#142142;font-family:Century Gothic;font-size:130%;text-align:center"><b>MAR</div>
                <div class="panel-body" style="text-align:center;font-size:180%">
                94.43%
                </div>
            </div>
        </div>

        <div class="col-sm-1">     
                <div class="panel panel-info">
                <div class="panel-heading" style="color:#142142;font-family:Century Gothic;font-size:130%;text-align:center"><b>APR</div>
                <div class="panel-body" style="text-align:center;font-size:180%">
                94.43%
                </div>
            </div>
        </div>

        <div class="col-sm-1">     
                <div class="panel panel-info">
                <div class="panel-heading" style="color:#142142;font-family:Century Gothic;font-size:130%;text-align:center"><b>MAY</div>
                <div class="panel-body" style="text-align:center;font-size:180%">
                94.43%
                </div>
            </div>
        </div>

        <div class="col-sm-1">     
                <div class="panel panel-info">
                <div class="panel-heading" style="color:#142142;font-family:Century Gothic;font-size:130%;text-align:center"><b>JUN</div>
                <div class="panel-body" style="text-align:center;font-size:180%">
                94.43%
                </div>
            </div>
        </div>

        <div class="col-sm-1">     
                <div class="panel panel-info">
                <div class="panel-heading" style="color:#142142;font-family:Century Gothic;font-size:130%;text-align:center"><b>JUL</div>
                <div class="panel-body" style="text-align:center;font-size:180%">
                94.43%
                </div>
            </div>
        </div>


        <div class="col-sm-1">     
                <div class="panel panel-info">
                <div class="panel-heading" style="color:#142142;font-family:Century Gothic;font-size:130%;text-align:center"><b>AUG</div>
                <div class="panel-body" style="text-align:center;font-size:180%">
                94.43%
                </div>
            </div>
        </div>


        <div class="col-sm-1">     
                <div class="panel panel-info">
                <div class="panel-heading" style="color:#142142;font-family:Century Gothic;font-size:130%;text-align:center"><b>SEP</div>
                <div class="panel-body" style="text-align:center;font-size:180%">
                94.43%
                </div>
            </div>
        </div>


        <div class="col-sm-1">     
                <div class="panel panel-info">
                <div class="panel-heading" style="color:#142142;font-family:Century Gothic;font-size:130%;text-align:center"><b>OCT</div>
                <div class="panel-body" style="text-align:center;font-size:180%">
                94.43%
                </div>
            </div>
        </div>


        <div class="col-sm-1">     
                <div class="panel panel-info">
                <div class="panel-heading" style="color:#142142;font-family:Century Gothic;font-size:130%;text-align:center"><b>NOV</div>
                <div class="panel-body" style="text-align:center;font-size:180%">
                94.43%
                </div>
            </div>
        </div>


        <div class="col-sm-1">     
                <div class="panel panel-info">
                <div class="panel-heading" style="color:#142142;font-family:Century Gothic;font-size:130%;text-align:center"><b>DEC</div>
                <div class="panel-body" style="text-align:center;font-size:180%">
                94.43%
                </div>
            </div>
        </div>


      
</div>
<?php $this->registerJsFile("/js/services/services.js"); ?>
<div class="customer_satisfaction_feedback-index">

   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'ref_num',
            'name',
            [
                'attribute' => 'service',
                'label' => 'Laboratory',
                'value' => function($model) {
                    $lab = Lab::find()->where(['lab_id' => $model->service])->one();

                        if ($lab){
                            return $lab->labname;
                        }else{
                           return "None";
                        }
                       
                    
                    
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => $lablist,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
               ],
               'filterInputOptions' => ['placeholder' => 'Select Lab', 'testcategory_id' => 'grid-products-search-category_type_id']
            ],
            [
                'attribute' => 'r_date',
                'label' => 'Date and Time',
                'value' => function($model) {
                    if ($model){
                        return $model->r_date;
                    }else{
                       return "None";
                    }
                    
                },
            ],
            'nob',
            [
                'attribute' => 'service',
                'label' => 'Type of Market',
                'value' => function($model) {
                    $tom = Markettype::find()->where(['id' => $model->tom])->one();
                    if ($tom){
                        return $tom->type;
                    }else{
                       return "None";
                    }
                    
                    
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => $tomlist,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
               ],
               'filterInputOptions' => ['placeholder' => 'Select Market', 'id' => 'grid-products-search-category_type_id']
            ],
            ['class' => 'kartik\grid\ActionColumn',
            'contentOptions' => ['style' => 'width: 8.7%'],
            'template' => '{view}',
            'buttons'=>[
                'view'=>function ($url, $model) {
                    return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>Url::to(['/lab/csf/resultmodal','id'=>$model->id]), 'class' => 'btn btn-primary','onclick'=>'LoadModal(this.title, this.value);','title' => Yii::t('app', "View Results")]);
                },
               
            ],
        ],
        ],
    ]); ?>
</div>
