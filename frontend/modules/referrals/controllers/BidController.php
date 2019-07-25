<?php

namespace frontend\modules\referrals\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use common\components\ReferralComponent;


/**
 * BidController implements the CRUD actions for Bid model.
 */
class BidController extends Controller
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
     * Lists all Bid models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BidSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Bid model.
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

    //find referral request
    protected function findReferral($id)
    {
        $model = Referral::find()->where(['referral_id'=>$id])->one();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested Request its either does not exist or you have no permission to view it.');
        }
    }

    //find agency
    protected function findAgency($id)
    {
        $agency = Agency::find()->where(['agency_id'=>$id])->one();
        if($agency !== null){
            return $agency;
        } else {
            throw new NotFoundHttpException('The requested Request its either does not exist or you have no permission to view it.');
        }
    }

    /*public function actionReferralbidding()
    {
        $agencyId = (int) Yii::$app->user->identity->profile->rstl_id;
        $referralId = (int) Yii::$app->request->get('referral_id');
        //$noticeId = (int) Yii::$app->request->get('notice_id');
        //$seen = (int) Yii::$app->request->get('seen');
        $noticeCount = Bidnotification::find()->where('referral_id =:referralId AND recipient_agency_id =:agencyId AND seen =:seen',[':referralId'=>$referralId,':agencyId'=>$agencyId,':seen'=>1])->count();

        if($referralId > 0 && $noticeCount > 0){
            $referral = $this->findReferral($referralId);
            $bid = Bid::find()->where('referral_id =:referralId AND bidder_agency_id =:agencyId',[':referralId'=>$referralId,':agencyId'=>$agencyId])->count();
            $samples = Sample::find()->where('referral_id =:referralId',[':referralId'=>$referralId]);
            $agency = $this->findAgency($agencyId);
        } else {
            Yii::$app->session->setFlash('error', "Not a valid referral request!");
            return $this->redirect(['/referrals/bidnotification']);
        }

        $analysis = Analysis::find()
            ->joinWith('sample',false)
            ->where('tbl_sample.referral_id =:referralId',[':referralId'=>$referralId])
            ->orderBy('sample_id');

        $analysisDataprovider = new ActiveDataProvider([
            'query' => $analysis,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $sampleDataprovider = new ActiveDataProvider([
            'query' => $samples,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $list_testbid = 'test_bids_'.$referralId;
        $subtotal = 0;
        $discounted = 0;
        $total = 0;
        if(!isset($_SESSION[$list_testbid]) || empty($_SESSION[$list_testbid])){
            if($bid > 0){
                $testBids = Testbid::find()->where('referral_id =:referralId AND bidder_agency_id =:bidderAgencyId',[':referralId'=>$referralId,':bidderAgencyId'=>$agencyId]);

                $testbidDataProvider = new ActiveDataProvider([
                    'query' => $testBids,
                    'pagination' => false,
                ]);
                
                $subtotal = $testBids->sum('fee');
                $discounted = $subtotal * ($referral->discount_rate/100);
                $total = $subtotal - $discounted;
            } else {
                $testbidDataProvider = new ArrayDataProvider([
                    //'key'=>'analysis_id',
                    'allModels' => [],
                    'pagination' => [
                        'pageSize' => 10,
                    ],
                ]);
            }
        } else {
            $listTestbid = [];
            $sum_fees = [];
            //ksort($_SESSION[$list_testbid]); //sort array key in ascending order so that analysis_id will be sorted
            foreach($_SESSION[$list_testbid] as $testbid){
                $analysis = Analysis::find()->where('analysis_id =:analysisId',[':analysisId'=>$testbid['analysis_id']])->one();
                $raw = array(
                    'sample_id' => $analysis->sample_id,
                    'sample_name' => $analysis->sample->sample_name,
                    //'sample_code' => $analysis->sample->sample_code,
                    'analysis_id'=> $analysis->analysis_id,
                    'test_name' => $analysis->testname->test_name,
                    'method' => $analysis->methodreference->method,
                    'reference' => $analysis->methodreference->reference,
                    'fee' => $testbid['analysis_fee']
                );
                //asort($raw); //sort array key in ascending order so that analysis_id will be sorted
                array_push($listTestbid, $raw);
                array_push($sum_fees, $testbid['analysis_fee']);
            }
            asort($listTestbid);

            $subtotal = array_sum($sum_fees);
            $discounted = $subtotal * ($referral->discount_rate/100);
            $total = $subtotal - $discounted;

            $testbidDataProvider = new ArrayDataProvider([
                'key'=>'analysis_id',
                'allModels' => $listTestbid,
                'pagination' => false,
            ]);
        }

        return $this->render('viewbid', [
            //'model' => $model,
            'countBid' => $bid,
            'referralId' => $referralId,
            'sampleDataProvider'=> $sampleDataprovider,
            'analysisDataProvider'=> $analysisDataprovider,
            'testbidDataProvider'=> $testbidDataProvider,
            'subtotal' => $subtotal,
            'discounted' => $discounted,
            'total' => $total,
            'agencyCode' => $agency->code,
        ]);
    }*/

    public function actionViewnotice()
    {
        $agencyId = isset(Yii::$app->user->identity->profile->rstl_id) ? (int) Yii::$app->user->identity->profile->rstl_id : 0;
        $referralId = (int) Yii::$app->request->get('referral_id');
        $noticeId = (int) Yii::$app->request->get('notice_id');
        $seen = (int) Yii::$app->request->get('seen');
        //$noticeCount = Bidnotification::find()->where('referral_id =:referralId AND recipient_agency_id =:agencyId AND bid_notification_id =:noticeId',[':referralId'=>$referralId,':agencyId'=>$agencyId,':noticeId'=>$noticeId])->count();
        $refcomp = new ReferralComponent();
        $noticeDetail = json_decode($refcomp->getBidNoticeDetails($referralId,$agencyId,$noticeId,$seen),true);
        $noticeCount = $noticeDetail['noticeCount'];

        //echo "<pre>";
        //print_r($noticeDetail);
        //echo "</pre>";
        //exit;

        if(empty($noticeDetail)){
            Yii::$app->session->setFlash('error', "No bid details!");
            return $this->redirect(['/referrals/bidnotification']);
        }

        if($referralId > 0 && $noticeId > 0 && $agencyId > 0 && $seen == 1 &&  $noticeCount > 0){
            
            //$referral = $this->findReferral($referralId);
            $referral = $noticeDetail['referral_data'];
            $checkOwner = json_decode($refcomp->checkOwner($referralId,$agencyId),true);
            //$modelBidNotification = Bidnotification::findOne($noticeId);
            
            if($checkOwner == 1){
                //$queryBid = Bid::find()->where('referral_id =:referralId AND bidder_agency_id =:bidderAgencyId',[':referralId'=>$referralId,':bidderAgencyId'=>$modelBidNotification->postedby_agency_id]);
                //$countBid = $queryBid->count();
                //$bidding = $queryBid->one();
                $countBid = $noticeDetail['bidCount'];
                $bidding = $noticeDetail['bidding_data'];
                //echo "<pre>";
                //print_r($bidding0);
                //echo "</pre>";
                //exit;
                $bidProvider = new ArrayDataProvider([
                    //'key'=>'bid_id',
                    'allModels' => $bidding,
                    'pagination' => false,
                    //'pagination'=> [
                    //    'pageSize' => 10,
                    //],
                ]);
                
                //$testBids = Testbid::find()->where('referral_id =:referralId AND bidder_agency_id =:bidderAgencyId AND bid_id =:bidId',[':referralId'=>$referralId,':bidderAgencyId'=>$bidding->bidder_agency_id,':bidId'=>$bidding->bid_id]);
                $testBids = $noticeDetail['testbid_data'];
                $testbidDataProvider = new ArrayDataProvider([
                    'allModels' => $testBids,
                    'pagination' => false,
                ]);
                
                //$subtotal = $testBids->sum('fee');
                $subtotal = $bidding[0]['bid_amount'];
                $discounted = $subtotal * ($referral['discount_rate']/100);
                $total = $subtotal - $discounted;
                
                //$samples = Sample::find()->where('referral_id =:referralId AND receiving_agency_id =:receivingAgencyId',[':referralId'=>$referralId,':receivingAgencyId'=>$agencyId]);
                $samples = $noticeDetail['sample_data'];
                $sampleDataprovider = new ArrayDataProvider([
                    'allModels' => $samples,
                    'pagination' => false,
                ]);
                
            } else {
                Yii::$app->session->setFlash('error', "Error displaying the bid notification details!");
                return $this->redirect(['/referrals/bidnotification']);
            }

            /*if($modelBidNotification->seen == 0){
                $modelBidNotification->seen = 1;
                $modelBidNotification->seen_date = date('Y-m-d H:i:s');

                if(!$modelBidNotification->save(false)){
                    Yii::$app->session->setFlash('error', "Error displaying the referral request!");
                    return $this->redirect(['/referrals/bidnotification']);
                }
            }*/

            //$agency = $this->findAgency($modelBidNotification->postedby_agency_id);
            $agency = $noticeDetail['bidder_agency_data'];
            return $this->render('viewreq', [
                'referral' => $referral,
                'countBid' => $countBid,
                //'referralId' => $referralId,
                'sampleDataProvider'=> $sampleDataprovider,
                //'analysisDataProvider'=> $analysisDataprovider,
                'testbidDataProvider'=> $testbidDataProvider,
                'bidDataProvider'=> $bidProvider,
                'subtotal' => $subtotal,
                'discounted' => $discounted,
                'total' => $total,
                //'agencyCode' => $agency->code,
                'agency' => $agency,
                'checkOwner' => $checkOwner,
            ]);
        } else {
            Yii::$app->session->setFlash('error', "Not a valid referral request!");
            return $this->redirect(['/referrals/bidnotification']);
        }
    }

    /*public function actionAddbid_requirement(){

        $model = new Bid();

        if (Yii::$app->request->post()) {
            $bid = Yii::$app->request->post('Bid');
            $referralId = (int) Yii::$app->request->post('referral_id');

            if($referralId > 0){
                $session = Yii::$app->session;
                $bid_requirement = 'addbid_requirement_'.$referralId;
                $requirements = $session[$bid_requirement];
                //$testBids[$analysisId] = ['analysis_id'=>$analysisId,'analysis_fee'=> $fee];
                $requirements['bidder_agency_id'] = (int) Yii::$app->user->identity->profile->rstl_id;
                $requirements['sample_requirements'] = $bid['sample_requirements'];
                $requirements['remarks'] = $bid['remarks'];
                $requirements['estimated_due'] = date('Y-m-d',strtotime($bid['estimated_due']));
                $_SESSION[$bid_requirement] = $requirements;

                Yii::$app->session->setFlash('success', "Bid requirements added.");
                return $this->redirect(['/referrals/bid/referralbidding?referral_id='.$referralId]);
            } else {
                return 'Not a valid referral ID!';
            }
        }

        return $this->renderAjax('_form', [
            'model' => $model,
            'referralId' => (int) Yii::$app->request->get('referral_id'),
       ]);
    }*/

    /*public function actionUpdatebid_requirement(){

        $model = new Bid();

        if (Yii::$app->request->post()) {
            $bid = Yii::$app->request->post('Bid');
            $referralId = (int) Yii::$app->request->post('referral_id');
            if($referralId > 0){
                $session = Yii::$app->session;
                $bid_requirement = 'addbid_requirement_'.$referralId;
                $requirements = $session[$bid_requirement];
                $requirements['bidder_agency_id'] = (int) Yii::$app->user->identity->profile->rstl_id;
                $requirements['sample_requirements'] = $bid['sample_requirements'];
                $requirements['remarks'] = $bid['remarks'];
                $requirements['estimated_due'] = date('Y-m-d',strtotime($bid['estimated_due']));
                $_SESSION[$bid_requirement] = $requirements;

                Yii::$app->session->setFlash('success', "Bid requirements updated.");
                return $this->redirect(['/referrals/bid/referralbidding?referral_id='.$referralId]);
            } else {
                return 'Not a valid referral ID!';
            }
        }
        $bid_requirement = Yii::$app->session->get('addbid_requirement_'.Yii::$app->request->get('referral_id'));
        $model->estimated_due = $bid_requirement['estimated_due'];
        return $this->renderAjax('_form', [
            'model' => $model,
            'referralId' =>  (int) Yii::$app->request->get('referral_id'),
       ]);
    } */

    public function actionViewbid_requirement()
    {
        $rstlId = isset(Yii::$app->user->identity->profile->rstl_id) ? (int) Yii::$app->user->identity->profile->rstl_id : 0;
        $referralId = (int) Yii::$app->request->get('referral_id');
        $bidderAgencyId = (int) Yii::$app->request->get('bidder_agency_id');
        $bidId = (int) Yii::$app->request->get('bid_id');
        //$bidId = 0;

        if($referralId > 0 && $rstlId > 0 && $bidderAgencyId > 0 && $bidId > 0){

            $refcomp = new ReferralComponent();
            $bidDetail = json_decode($refcomp->getBidDetails($referralId,$rstlId,$bidderAgencyId,$bidId),true);
            $checkOwner = json_decode($refcomp->checkOwner($referralId,$rstlId),true);
            
            if($checkOwner == 1){
                $referral = $bidDetail['referral_data'];
                $countBid = $bidDetail['countBid'];

                $bidding = $bidDetail['bidding_data'];
                $bidProvider = new ArrayDataProvider([
                    'allModels' => $bidding,
                    'pagination' => false,
                ]);
                
                $testBids = $bidDetail['testbid_data'];
                $testbidDataProvider = new ArrayDataProvider([
                    'allModels' => $testBids,
                    'pagination' => false,
                ]);

                $subtotal = $bidding[0]['bid_amount'];
                $discounted = $subtotal * ($referral['discount_rate']/100);
                $total = $subtotal - $discounted;

                $agency = $bidDetail['bidder_agency_data'];
                return $this->renderAjax('view_bid_req', [
                    'referralId' => $referralId,
                    'countBid' => $countBid,
                    'testbidDataProvider'=> $testbidDataProvider,
                    'bidDataProvider'=> $bidProvider,
                    'subtotal' => $subtotal,
                    'discounted' => $discounted,
                    'total' => $total,
                    'checkOwner' => $checkOwner,
                    'agency' => $agency,
                ]);
            } else {
                Yii::$app->session->setFlash('error', "Error displaying the bid details!");
                return $this->redirect(['/lab/request/view/','id'=>Yii::$app->request->get('request_id')]);
            }
        } else {
            Yii::$app->session->setFlash('error', "Can't view bid details!");
            return $this->redirect(['/lab/request/view/','id'=>Yii::$app->request->get('request_id')]);
        }
    }

    /*public function actionInserttest_bid(){

        $analysisId = (int) Yii::$app->request->get('analysis_id');
        $referralId = (int) Yii::$app->request->get('referral_id');

        if($analysisId > 0 && $referralId > 0){
            $model = Analysis::find()->where('analysis_id =:analysisId',[':analysisId'=>$analysisId])->one();

            if (Yii::$app->request->post()) {
                $fee = Yii::$app->request->post('analysis_fee');
                if(is_numeric($fee) == 1 && $fee > 0 && !empty($fee)){
                    $session = Yii::$app->session;
                    $list_testbid = 'test_bids_'.$referralId;
                    $testBids = $session[$list_testbid];
                    //$testBids[$analysisId] = $analysisId;
                    $testBids[$analysisId] = ['analysis_id'=>$analysisId,'analysis_fee'=> $fee];
                    $_SESSION[$list_testbid] = $testBids;

                    Yii::$app->session->setFlash('success', 'Adding fee successful!');
                    return $this->redirect(['/referrals/bid/referralbidding?referral_id='.$referralId]);

                } else {
                    //return "<span style='color:#FF0000;'>Please input a valid </span>";
                    Yii::$app->session->setFlash('error', "Please input a valid analysis fee!");
                    return $this->redirect(['/referrals/bid/referralbidding?referral_id='.$referralId]);
                }
            }

            return $this->renderAjax('_form_testbid', [
                'model' => $model,
                'analysisId' => $analysisId,
                'referralId' => $referralId,
            ]);
        } else {
            return "<span style='color:#FF0000;'>Not a valid referral ID</span>";
        }
    }*/

    /*public function actionRemove_testbid(){

        $referralId = (int) Yii::$app->request->get('referral_id');
        $analysisId = (int) Yii::$app->request->get('analysis_id');
        $testbidRefId = 'test_bids_'.$referralId;
        $test_bids = Yii::$app->session->get($testbidRefId);

        if($analysisId > 0 && $referralId > 0 && count($test_bids) > 0){
            foreach ($test_bids as $key => $value) {
                if($value["analysis_id"] == $analysisId){
                    unset($_SESSION[$testbidRefId][$key]);
                    if(count($test_bids) == 0 && empty($test_bids)){
                        unset($_SESSION[$testbidRefId]);
                        //Yii::$app->session->remove($testbidRefId);
                    }
                    Yii::$app->session->setFlash('success', 'Successfully removed.');
                    return $this->redirect(['/referrals/bid/referralbidding?referral_id='.$referralId]);
                } else {
                    Yii::$app->session->setFlash('error', 'Fail to remove!');
                    //print_r(Yii::$app->session->get($testbidRefId));
                    return $this->redirect(['/referrals/bid/referralbidding?referral_id='.$referralId]);
                }
            }
        } else {
            Yii::$app->session->setFlash('error', 'Not a valid action!');
            return $this->redirect(['/referrals/bid/referralbidding?referral_id='.$referralId]);
        }
    }*/

    /*public function actionUpdate_analysis_fee(){

        $referralId = (int) Yii::$app->request->get('referral_id');
        if (Yii::$app->request->post()) {
            $analysisId = (int) Yii::$app->request->post('editableKey');
            $fee = Yii::$app->request->post('analysis_fee');
            $output = '';
            $message = '';

            if(is_numeric($fee) == 1 && $fee > 0 && !empty($fee)){
                $session = Yii::$app->session;
                $list_testbid = 'test_bids_'.$referralId;
                $testBids = $session[$list_testbid];
                $testBids[$analysisId] = $analysisId;
                $testBids[$analysisId] = ['analysis_id'=>$analysisId,'analysis_fee'=> $fee];
                $_SESSION[$list_testbid] = $testBids;
                $output = $fee;
            } else {
                $output = "<span style='color:#FF0000;'>Invalid input!</span>";
                $message = 'Invalid input';
            }
            $out = Json::encode(['output' => $output, 'message' => $message]);
            echo $out;
        }

    }*/
}
