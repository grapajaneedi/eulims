<?php

namespace frontend\modules\lab\controllers;

use frontend\modules\lab\components\_class\Schedule;
use common\models\lab\Request;
use common\models\lab\Analysis;

class TestscheduleController extends \yii\web\Controller
{
    public function actionIndex()
    {

    	//  $Requests = Request::find()->with('analyses')->andWhere(['not',['request_ref_num'=>null]])->limit(10)->all();
	    // foreach ($Requests AS $req){
	    // 	foreach ($req->analyses as $schedule) {
	    // 		$Event= new Schedule();
		   //      $Event->id = $schedule->analysis_id;
		   //      $Event->title =$schedule->testname;
		   //      $Event->start =$schedule->date_analysis;

		   //      $date = $schedule->date_analysis;
		   //      $date1 = str_replace('-', '/', $date);
		   //      $newdate = date('Y-m-d',strtotime($date1 . "+7 days"));
		   //      $Event->end = $newdate;
		   //      $events[] = $Event;
	    // 	}
	    // }

	    // var_dump($events); exit;




        return $this->render('index');
    }

    public function actionSchedules(){
    	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;   

	    $events = array();

	    //get the request and its sample and analysis for the initial schedule

	    // $Requests = Request::find()->with('analyses')->andWhere(['not',['request_ref_num'=>null]])->limit(10)->all();

	    $date = date('Y-m-d');
        $date1 = str_replace('-', '/', $date);
        $date1 = date('Y-m-d',strtotime($date1 . "-30 days"));

	    
        $date2 = str_replace('-', '/', $date);
        $date2 = date('Y-m-d',strtotime($date2 . "+30 days")); //adding days should be accompanied by the standards of REcommended Maximum storage

	    $analyses =Analysis::find()->where(['between','date_analysis',"2017-01-01",$date2])->all();
	 
    	foreach ($analyses as $schedule) {
    		$Event= new Schedule();
	        $Event->id = $schedule->analysis_id;
	        $Event->title =$schedule->sample->samplename."(".$schedule->sample->sample_code.") -".$schedule->testname;
	        $Event->start =$schedule->date_analysis;

	        $date = $schedule->date_analysis;
	        $date1 = str_replace('-', '/', $date);
	        $newdate = date('Y-m-d',strtotime($date1 . "+7 days"));
	        $Event->end = $newdate;
	        $Event->textColor='#565656';
	        $Event->backgroundColor='#fff';
	        $events[] = $Event;
    	}
	    

	    return $events;
    }
}
