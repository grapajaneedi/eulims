<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\web\JsExpression;

?>
<div class="lab-testschedule-view">
	<div class="row">
		<div class="alert alert-warning">
	         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	         <h2><i class="icon fa fa-warning"></i>Workboard</h2>
	         Analyses and their Recommended Maximum Storage
	    </div>
	</div>
	<div class="row">
	<?= \yii2fullcalendar\yii2fullcalendar::widget(array(
	      'events'=> Url::to(['/lab/testschedule/schedules']),
	      'clientOptions' => [
	      				'weekends'=>true,
	                    'selectable' => false,
	                    'selectHelper' => false,
	                    'droppable' => false,
	                    'editable' => false,
	                    'contentHeight'=>800,
	                    // 'select' => new JsExpression($JSCode),
	                    // 'drop' => new JsExpression($JSDropEvent),
	                    // 'eventClick' => new JsExpression($JSEventClick),
	                    // 'dayClick'=>new \yii\web\JsExpression($JSDayClick),
	                    'defaultDate' => date('Y-m-d')
	              ],
	  ));
	?>
	</div>
</div>

