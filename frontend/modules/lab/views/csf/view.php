
<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use common\models\lab\Markettype;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Csf */


?>
<div class="csf-view">

    <h1><?= Html::encode($this->title) ?></h1>

   

    <div class="panel panel-info">
                            <div class="panel-heading" style="color:#142142;font-family:Century Gothic;font-size:200%;"><b>Customer Satisfaction Feedback Results</b></div>
                            <div class="panel-body">
                            <h1 style="color:#1a4c8f;font-family:Century Gothic;text-align:center;font-size:500%;text-shadow: 
      4px 4px 0px #d5d5d5, 
      7px 7px 0px rgba(0, 0, 0, 0.2);"><b>Thank you!</b></h1>
       <h1 style="color:black;font-family:Century Gothic;text-align:center;font-size:200%;text-shadow: 
      4px 4px 0px #d5d5d5, 
      7px 7px 0px rgba(0, 0, 0, 0.2);"><b><?php echo $model->name?></b></h1>

                    
                                      <h4 style="text-align:center;">You recently gave us some really helpful ratings and comments about our services. We wanted to let you know that we will use your feedback for our future improvements.<br>
                                      We really appreciate the time you took to answer the survey.<br></h4>

                                    


                        
                        </div>
                </div>

        <?php
        
            echo DetailView::widget([
            'model'=>$model,
            'responsive'=>true,
            'hover'=>true,
            'mode'=>DetailView::MODE_VIEW,
            'panel'=>[
                'heading'=>'<i class="glyphicon glyphicon-info-sign"></i> Information',
                'type'=>DetailView::TYPE_PRIMARY,
            ],
            'attributes'=>[
                [
                    'columns' => [
                        [
                            'label'=>'Date',
                            'value'=>$model->r_date,
                            'displayOnly'=>true,
                         
                        ],
                      
                    ],
                ],
                [
                    'columns' => [
                        [
                            'label'=>'Customer Name',
                            'format'=>'raw',
                            'value'=>$model->name,
                            'displayOnly'=>true
                        ],
                    ],
                    
                ],
                [
                    'columns' => [
                        [
                            'label'=>'Nature of Business',
                            'value'=>$model->nob,
                            'displayOnly'=>true,
                        ],
                      
                    ],
                ],
                [
                    'columns' => [
                        [
                            'label'=>'Type of Market',
                            'value'=> $model->markettype ? $model->markettype->type : "",
                            'displayOnly'=>true,
                        ],
                      
                    ],
                ],
                [
                    'columns' => [
                        [
                            'label'=>'What services of the RSTL have you availed?',
                            'format'=>'raw',
                            'value'=> $model->lab ? $model->lab->labname : "",
                            'displayOnly'=>true
                        ],
                    ],
                ],
            ],


        ]);
        ?>

<?php
        
        echo DetailView::widget([
        'model'=>$model,
        'responsive'=>true,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'<i class="glyphicon glyphicon-info-sign"></i> Delivery of Service',
            'type'=>DetailView::TYPE_PRIMARY,
        ],
        'attributes'=>[
            [
                'columns' => [
                    [
                        'label'=>'Delivery Time',
                        'value'=>$model->d_deliverytime."/5",
                        'displayOnly'=>true,
                     
                    ],
                    [
                        'label'=>'Correctness and accuracy of test results',
                        'format'=>'raw',
                        'value'=>$model->d_accuracy."/5",
                        'displayOnly'=>true
                    ],
                  
                ],
            ],
            [
                'columns' => [
                    [
                        'label'=>'Speed of service',
                        'value'=>$model->d_speed."/5",
                        'displayOnly'=>true,
                    ],
                    [
                        'label'=>'Cost',
                        'value'=>$model->d_cost."/5",
                        'displayOnly'=>true,
                    ],
                  
                ],
            ],
            [
                'columns' => [
                    [
                        'label'=>'Attitude of Staff',
                        'value'=>$model->d_attitude."/5",
                        'displayOnly'=>true,
                    ],
                    [
                        'label'=>'Over-all customer experience',
                        'value'=>$model->d_overall."/5",
                        'displayOnly'=>true,
                    ],
                  
                ],
            ],
          
        ],


    ]);
    ?>

<?php
        
        echo DetailView::widget([
        'model'=>$model,
        'responsive'=>true,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'<i class="glyphicon glyphicon-info-sign"></i> How important are these items to you?',
            'type'=>DetailView::TYPE_PRIMARY,
        ],
        'attributes'=>[
            [
                'columns' => [
                    [
                        'label'=>'Delivery Time',
                        'value'=>$model->i_deliverytime."/5",
                        'displayOnly'=>true,
                     
                    ],
                    [
                        'label'=>'Correctness and accuracy of test results',
                        'format'=>'raw',
                        'value'=>$model->i_accuracy."/5",
                        'displayOnly'=>true
                    ],
                  
                ],
            ],
            [
                'columns' => [
                    [
                        'label'=>'Speed of service',
                        'value'=>$model->i_speed."/5",
                        'displayOnly'=>true,
                    ],
                    [
                        'label'=>'Cost',
                        'value'=>$model->i_cost."/5",
                        'displayOnly'=>true,
                    ],
                  
                ],
            ],
            [
                'columns' => [
                    [
                        'label'=>'Attitude of Staff',
                        'value'=>$model->i_attitude."/5",
                        'displayOnly'=>true,
                    ],
                    [
                        'label'=>'Over-all customer experience',
                        'value'=>$model->i_overall."/5",
                        'displayOnly'=>true,
                    ],
                  
                ],
            ],
          
        ],


    ]);
    ?>

<?php
        
        echo DetailView::widget([
        'model'=>$model,
        'responsive'=>true,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'<i class="glyphicon glyphicon-info-sign"></i> Recommendations',
            'type'=>DetailView::TYPE_PRIMARY,
        ],
        'attributes'=>[
            [
                'columns' => [
                    [
                        'label'=>'How likely is it that you would recommend our service to others',
                        'value'=>$model->recommend."/10",
                        'displayOnly'=>true,
                     
                    ],
                  
                ],
            ],
            [
                'columns' => [
                    [
                        'label'=>'Comments and Suggestions',
                        'format'=>'raw',
                        'value'=>$model->name,
                        'displayOnly'=>true
                    ],
                ],
                
            ],
        ],


    ]);
    ?>

</div>
