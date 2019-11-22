
<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use common\models\system\Profile;
use yii\helpers\ArrayHelper;

$GLOBALS['user_id']=Yii::$app->user->identity->profile->user_id;



$profile = Profile::find()->where(['user_id'=> $GLOBALS['user_id']])->one();



$analyst= ArrayHelper::map(Profile::find()->where(['lab_id'=>$profile->lab_id])->all(),'user_id','fullname');

    

// $profile = Profile::find()->where(['user_id'=> $taggingmodel->user_id])->one();

// $fullname = $profile->firstname.' '. strtoupper(substr($profile->middleinitial,0,1)).'. '.$profile->lastname;

// echo $fullname;

?>



<?php $form = ActiveForm::begin(); ?> 

                    <?= $form->field($taggingmodel,'user_id')->widget(Select2::classname(),[
                                        'data' => $analyst,
                                        'theme' => Select2::THEME_KRAJEE,
                                        'options' => ['id'=>'tagging-user_id'],
                                        'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Analyst'],
                                ])->label('Analyst')
                        ?>


                    <?= $form->field($taggingmodel, 'analysis_id')->hiddenInput(['maxlength' => true])->label(false) ?>       
                    <?php
                    echo $form->field($taggingmodel, 'start_date')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Select Date ...',
                    'autocomplete'=>'off'],
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                            'autoclose'=>true,
                            // 'startDate' => date('Y-m-d'),
                            // 'endDate' => date('Y-m-d')
                            
                        ]
                    ]);
                    ?>
                    <?php
                    echo $form->field($taggingmodel, 'end_date')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Select Date ...',
                    'autocomplete'=>'off'],
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                            'autoclose'=>true,
                            // 'startDate' => date('Y-m-d'),
                            // 'endDate' => date('Y-m-d')
                            
                        ]
                    ]);
                    ?>

                    <div class="row" style="float: right;padding-right: 15px">
                    <?php  echo Html::button('<i class="glyphicon glyphicon-pencil"></i> Update Analysis', ['disabled'=>false,'value' => Url::to(['tagging/updateana']), 'onclick'=>'updateanalysis()','title'=>'Start Analysis', 'class' => 'btn btn-primary','id' => 'btn_start_analysis']); ?>
                    <?php //echo Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>

         </div>
                    <?php ActiveForm::end(); ?>

<script type="text/javascript">
   function updateanalysis() {

         jQuery.ajax( {
            type: 'POST',
            url: 'tagging/updateana',
            data: { start_date: $('#tagging-start_date').val(), end_date: $('#tagging-end_date').val(), id: $('#tagging-analysis_id').val(), user_id: $('#select2-tagging-user_id-container').attr('title')},
            success: function ( response ) {

                 $("#xyz").html(response);
               },
            error: function ( xhr, ajaxOptions, thrownError ) {
                alert( thrownError );
            }
        });
    }

</script>
