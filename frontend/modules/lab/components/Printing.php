<?php

/*
 * Project Name: eulims_ * 
 * Copyright(C)2018 Department of Science & Technology -IX * 
 * Developer: Eng'r Nolan F. Sunico  * 
 * 08 14, 18 , 10:06:35 AM * 
 * Module: RequestPrinting * 
 */

namespace frontend\modules\lab\components;

use kartik\mpdf\Pdf;
use common\models\system\RstlDetails;
use common\components\Functions;
use rmrevin\yii\fontawesome\FA;
/**
 * Description of RequestPrinting
 *
 * @author OneLab
 */
class Printing {

    public function PrintRequest($id) {
        
        \Yii::$app->view->registerJsFile("css/pdf.css");
        $config= \Yii::$app->components['reports'];
        $ReportNumber=(int)$config['ReportNumber'];
       
        if($ReportNumber==1){
             $mTemplate = $this->RequestTemplate($id);
        }elseif($ReportNumber==2){
            $mTemplate=$this->FastReport($id);
        }else{// in case does not matched any
            $mTemplate="<div class='col-md-12 danger'><h3>Report Configuration is not properly set.</h3></div>";
        }
        $pdfFooter = [
            'L' => [
                'content' => '',
                'font-size' => 0,
                'font-style' => 'B',
                'color' => '#999999',
            ],
            'C' => [
                'content' => '{PAGENO}',
                'font-size' => 10,
                'font-style' => 'B',
                'font-family' => 'arial',
                'color' => '#333333',
            ],
            'R' => [
                'content' => '',
                'font-size' => 0,
                'font-style' => 'B',
                'font-family' => 'arial',
                'color' => '#333333',
            ],
            'line' => false,
        ];
        $mPDF = new Pdf(['cssFile' => 'css/pdf.css']);
        //$html = mb_convert_encoding($mTemplate, 'UTF-8', 'UTF-8');
        //$mPDF=$PDF->api;
        $mPDF->content = $mTemplate;
        $mPDF->orientation = Pdf::ORIENT_PORTRAIT;
        $mPDF->defaultFontSize = 9;
        $mPDF->defaultFont = 'Arial';
        $mPDF->format =Pdf::FORMAT_A4;
        $mPDF->destination = Pdf::DEST_BROWSER;
        $mPDF->methods =['SetFooter'=>['|{PAGENO}|']];
        $mPDF->render();
        exit;
    }
    private function FastReport($id){
        $Func = new Functions();
        $Proc = "spGetRequestService(:nRequestID)";
        $Params = [':nRequestID' => $id];
        $Connection = \Yii::$app->labdb;
        $RequestRows = $Func->ExecuteStoredProcedureRows($Proc, $Params, $Connection);
        $RequestHeader = (object) $RequestRows[0];
        $rstl_id = $RequestHeader->rstl_id;
        $RstlDetails = RstlDetails::find()->where(['rstl_id' => $rstl_id])->one();
        $border=0;//Border for adjustments
        if ($RstlDetails) {
            $RequestTemplate = "<table border='$border' style='font-size: 12px' width=100%>";
            $RequestTemplate .= "<thead><tr><td colspan='7' style='height: 110px;text-align: center'>&nbsp;</td></tr></thead>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td style='width: 50px;height: 15px'>&nbsp;</td>";
            $RequestTemplate .= "<td style='width: 50px'>&nbsp;</td>";
            $RequestTemplate .= "<td style='width: 190px'>&nbsp;</td>";
            $RequestTemplate .= "<td style='width: 170px'>&nbsp;</td>";
            $RequestTemplate .= "<td style='width: 85px'>&nbsp;</td>";
            $RequestTemplate .= "<td style='width: 85px'>&nbsp;</td>";
            $RequestTemplate .= "<td>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2'>&nbsp;</td>";
            $RequestTemplate .= "<td>Nolan Sunico</td>";
            $RequestTemplate .= "<td colspan='3'>&nbsp;</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>12345</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2'>&nbsp;</td>";
            $RequestTemplate .= "<td>Recodo Zamboanga City</td>";
            $RequestTemplate .= "<td colspan='3'>&nbsp;</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>11/14/2018</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2'>&nbsp;</td>";
            $RequestTemplate .= "<td>Tel Fax #</td>";
            $RequestTemplate .= "<td colspan='3'>&nbsp;</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>PR #/PO #</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2'>&nbsp;</td>";
            $RequestTemplate .= "<td>Project Name</td>";
            $RequestTemplate .= "<td colspan='3'>&nbsp;</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>TIN #</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2'>&nbsp;</td>";
            $RequestTemplate .= "<td>Address 2</td>";
            $RequestTemplate .= "<td colspan='3'>&nbsp;</td>";
            $RequestTemplate .= "<td>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2'>&nbsp;</td>";
            $RequestTemplate .= "<td>Tel Fax 2</td>";
            $RequestTemplate .= "<td colspan='3'>&nbsp;</td>";
            $RequestTemplate .= "<td>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2'>&nbsp;</td>";
            $RequestTemplate .= "<td>Email Address</td>";
            $RequestTemplate .= "<td colspan='3'>&nbsp;</td>";
            $RequestTemplate .= "<td>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr><td colspan='7' style='height: 45px;text-align: center'>&nbsp;</td></tr>";
            $CounterLimit=12;
            for($counter=1;$counter<=$CounterLimit;$counter++){
                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='text-align: center;height: 23px'>23</td>";
                $RequestTemplate .= "<td colspan='2'>Sample Description</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>Sample Code</td>";
                $RequestTemplate .= "<td colspan='2'>Analysis/Sampling Method</td>";
                $RequestTemplate .= "<td style='text-align: right;padding-right: 10px'>11234.00</td>";
                $RequestTemplate .= "</tr>";
            }
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='4'>&nbsp;</td>";
            $RequestTemplate .= "<td>&nbsp;</td>";
            $RequestTemplate .= "<td>&nbsp;</td>";
            $RequestTemplate .= "<td valign='bottom' style='text-align: right;padding-right: 10px;height: 15px'>tot.am</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='4' style='height: 10px;font-size: 8px;font-weight: bold'>";
            $RequestTemplate .= "<i class='fa fa-check'>/</i>";
            $RequestTemplate .= "</td>";
            $RequestTemplate .= "<td></td>";
            $RequestTemplate .= "<td></td>";
            $RequestTemplate .= "<td></td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='4'>&nbsp;</td>";
            $RequestTemplate .= "<td>&nbsp;</td>";
            $RequestTemplate .= "<td>&nbsp;</td>";
            $RequestTemplate .= "<td style='text-align: right;padding-right: 10px'>vat.am</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2'>&nbsp;</td>";
            $RequestTemplate .= "<td style='text-align: left;padding-left: 50px'>Nolan F. Sunico</td>";
            $RequestTemplate .= "<td style='text-align: right;padding-right: 10px'>11/14/2018 04:32 PM</td>";
            $RequestTemplate .= "<td>&nbsp;</td>";
            $RequestTemplate .= "<td></td>";
            $RequestTemplate .= "<td style='text-align: right;padding-right: 10px'></td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='4'>&nbsp;</td>";
            $RequestTemplate .= "<td colspan='2'>&nbsp;</td>";
            $RequestTemplate .= "<td valign='top' style='text-align: right;padding-right: 10px'>tot.pa</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='6' valign='top' style='padding-top: 30px' rowspan='2'>Special Instructions</td>";
            $RequestTemplate .= "<td style='text-align: right;padding-right: 10px;height: 25px'>Deposit O.R</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td style='text-align: right;padding-right: 10px;height: 25px'>Bal.00</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='7' style='padding-left: 5px;height: 25px'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='7' style='padding-left: 5px'>This is my Remarks</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='7'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "</table>";
            $RequestTemplate .= "<table border='$border' style='border-collapse: collapse;font-size: 12px' width=100%>";
            $RequestTemplate .= "<tr><td colspan='4' style='height: 50px;text-align: center'>&nbsp;</td></tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td style='padding-left: 10px'>Printed Name and Signature</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>Date and Time</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>Printed Name and Signature</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>Date and Time</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr><td colspan='4' style='height: 50px;text-align: center'>&nbsp;</td></tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td style='padding-left: 10px'>Printed Name and Signature</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>Date and Time</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>Printed Name and Signature</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>Date and Time</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "</table>";
        }
        return $RequestTemplate;
    }
    private function RequestTemplate($id) {

        $Func = new Functions();
        $Proc = "spGetRequestServices(:nRequestID)";
        $Params = [':nRequestID' => $id];
        $Form="OP-007-F1"."<br>"."Rev. 05 | 10.01.14";
        $Connection = \Yii::$app->labdb;
        
        $RequestRows = $Func->ExecuteStoredProcedureRows($Proc, $Params, $Connection);
        $RequestHeader = (object) $RequestRows[0];
       
        $rstl_id = $RequestHeader->rstl_id;
       
        $RstlDetails = RstlDetails::find()->where(['rstl_id' => $rstl_id])->one();
        if ($RstlDetails) {
            
            $RequestTemplate = "<table border='0' style='border-collapse: collapse;font-size: 12px' width=100%>";
            $RequestTemplate .= "<thead>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10' style='text-align: center;font-size: 12px'>$RstlDetails->name</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10' style='text-align: center;font-size: 12px;font-weight: bold'>REGIONAL STANDARDS AND TESTING LABORATORIES</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            //$RequestTemplate .= "<td colspan='3' style='width: 30%'></td>";
            $RequestTemplate .= "<td colspan='10' style='width: 100%;text-align: center;font-size: 12px;word-wrap: break-word'><div style='width: 100px;'>$RstlDetails->address</div></td>";
            //$RequestTemplate .= "<td colspan='3' style='width: 30%'></td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            //$RequestTemplate .= "<td colspan='3'></td>";
            $RequestTemplate .= "<td colspan='10' style='text-align: center;font-size: 12px'><div style='width: 100px;'>$RstlDetails->contacts</div></td>";
            //$RequestTemplate .= "<td colspan='3'></td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10' style='text-align: center;font-size: 12px'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10' style='text-align: center;font-weight: bold;font-size: 15px'>Request for " . strtoupper($RstlDetails->shortName) . " RSTL Services</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "</thead>";
            $RequestTemplate .= "<tbody>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td>Req. Ref. No.:</td>";
            $RequestTemplate .= "<td colspan='4' style='text-align: left'>$RequestHeader->request_ref_num</td>";
            $RequestTemplate .= "<td colspan='5'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td>Date and Time:</td>";
            $RequestTemplate .= "<td colspan='4' style='text-align: left'>" . date('m/d/Y h:i A', strtotime($RequestHeader->request_datetime)) . "</td>";
            $RequestTemplate .= "<td colspan='5'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10' style='height: 5px'></td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td style='border-top: 1px solid black;border-left: 1px solid black'>Customer:</td>";
            $RequestTemplate .= "<td colspan='6' style='border-top: 1px solid black;'>$RequestHeader->customer_name</td>";
            $RequestTemplate .= "<td style='border-top: 1px solid black;'>Tel #:</td>";
            $RequestTemplate .= "<td colspan='2' style='border-top: 1px solid black;border-right: 1px solid black'>$RequestHeader->tel</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td style='border-bottom: 1px solid black;border-left: 1px solid black'>Address:</td>";
            $RequestTemplate .= "<td colspan='6' style='border-bottom: 1px solid black;border-bottom: 1px solid black;'>$RequestHeader->address</td>";
            $RequestTemplate .= "<td style='border-bottom: 1px solid black;'>Fax #:</td>";
            $RequestTemplate .= "<td colspan='2' style='border-bottom: 1px solid black;border-right: 1px solid black'>$RequestHeader->fax</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<th colspan='10' class='text-left border-bottom-line'>1.0 TESTING OR CALIBRATION SERVICE</th>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<th colspan='2' class='text-left valign-bottom border-bottom-line border-left-line border-right-line padding-left-5' style=''>SAMPLE</th>";
            $RequestTemplate .= "<th class='text-left valign-bottom border-bottom-line border-right-line padding-left-5' style='width: 15%;'>Sample Code</th>";
            $RequestTemplate .= "<th colspan='2' class='text-left valign-bottom border-bottom-line border-right-line padding-left-5' style='width: 15%;'>TEST/CALIBRATION REQUESTED</th>";
            $RequestTemplate .= "<th colspan='2' class='text-left valign-bottom border-bottom-line border-right-line padding-left-5' style='width: 15%;'>TEST METHOD</th>";
            $RequestTemplate .= "<th class='text-center valign-bottom border-bottom-line border-right-line padding-left-5' style='width: 9%;'>No of Samples/ UNIT</th>";
            $RequestTemplate .= "<th class='text-right border-bottom-line border-right-line valign-bottom padding-right-5' style='width: 9%;'>UNIT COST</th>";
            $RequestTemplate .= "<th class='text-right border-bottom-line border-right-line valign-bottom border-right-line padding-right-5' style='width: 9%;'>TOTAL</th>";
            $RequestTemplate .= "</tr>";
            
            $CurSampleCode = "";
            $PrevSampleCode = "";
            foreach ($RequestRows as $RequestRow) {
                $RequestRow = (object) $RequestRow;
                $CurSampleCode = $RequestRow->sample_code;
                $RequestTemplate .= "<tr>";
                if ($CurSampleCode != $PrevSampleCode) {
                    $RequestTemplate .= "<td class='text-left border-left-line border-top-line border-bottom-line padding-left-5' colspan='2'>$RequestRow->samplename</td>";
                    $RequestTemplate .= "<td class='text-left border-left-line border-top-line border-right-line border-bottom-line padding-left-5'>$RequestRow->sample_code</td>";
                } else {
                    $RequestTemplate .= "<td class='text-left border-left-line border-top-line border-bottom-line' colspan='2'></td>";
                    $RequestTemplate .= "<td class='text-left border-right-line border-top-line border-left-line border-bottom-line'></td>";
                }
                $RequestTemplate .= "<td class='text-left border-bottom-line border-top-line border-right-line padding-left-5' colspan='2'>$RequestRow->testcalibration</td>";
                $html=$RequestRow->method;//$RequestRow->method;
                $RequestTemplate .= "<td style='word-wrap: break-word;' class='text-left border-bottom-line border-top-line border-right-line padding-left-5 padding-right-5' colspan='2'>$html</td>";
                $RequestTemplate .= "<td class='text-center border-bottom-line border-top-line border-right-line'>$RequestRow->NoSampleUnit</td>";
                $RequestTemplate .= "<td class='text-right border-bottom-line border-top-line border-right-line padding-right-5'>$RequestRow->UnitCost</td>";
                $RequestTemplate .= "<td class='text-right border-bottom-line border-top-line border-right-line padding-right-5'>$RequestRow->TotalAnalysis</td>";
                $RequestTemplate .= "</tr>";
                $PrevSampleCode = $CurSampleCode;
            }
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='8' style='border: 1px solid black;height: 0px' class='border-left-line border-bottom-line'></td>";
            $RequestTemplate .= "<td class='border-left-line border-bottom-line'></td>";
            $RequestTemplate .= "<td class='border-left-line border-bottom-line border-right-line'></td>";
            $RequestTemplate .= "</tr>";
            // SUB-TOTAL
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-right border-left-line' colspan='8'></td>";
            $RequestTemplate .= "<td class='text-right border-left-line border-bottom-line padding-right-5'>Sub-Total</td>";
            $RequestTemplate .= "<td class='text-right border-left-line border-bottom-line border-right-line padding-right-5'>".number_format($RequestHeader->SubTotal,2)."</td>";
            $RequestTemplate .= "</tr>";
            // Discount
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-right border-left-line' colspan='8'></td>";
            $RequestTemplate .= "<td class='text-right border-left-line border-bottom-line padding-right-5'>Discount</td>";
            $RequestTemplate .= "<td class='text-right border-left-line border-bottom-line border-right-line padding-right-5'>".number_format($RequestHeader->DiscountPrice,2)."</td>";
            $RequestTemplate .= "</tr>";
            // TOTAL
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-right border-left-line border-bottom-line' colspan='8'></td>";
            $RequestTemplate .= "<th class='text-right border-left-line border-bottom-line padding-right-5'>TOTAL</th>";
            $GTotal=$RequestHeader->SubTotal-$RequestHeader->DiscountPrice;
            $RequestTemplate .= "<th class='text-right border-left-line border-bottom-line border-right-line padding-right-5'>".number_format($GTotal,2)."</th>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10' class='text-left'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<th colspan='10' class='text-left border-bottom-line'>2. BRIEF DESCRIPTION OF SAMPLE/REMARKS</th>";
            $RequestTemplate .= "</tr>";
            //BRIEF DESCRIPTION
            $CurSampleCode2 = "";
            $PrevSampleCode2 = "";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left border-left-line border-top-line border-right-line padding-right-5 padding-left-5' colspan='10'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            foreach ($RequestRows as $RequestRow) {
                $RequestRow = (object) $RequestRow;
                $CurSampleCode2 = $RequestRow->sample_code;
                if ($CurSampleCode2 != $PrevSampleCode2) {
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td class='text-left border-left-line border-right-line padding-left-5' colspan='10'>$RequestRow->Remarks</td>";
                    $RequestTemplate .= "</tr>";
                }
                $PrevSampleCode2 = $CurSampleCode2;
            }
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left border-left-line border-bottom-line border-right-line padding-right-5 padding-left-5' colspan='10'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left' colspan='10'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-right padding-right-5 padding-left-5 text-bold' colspan='8'>TOTAL</td>";
            $RequestTemplate .= "<td colspan='2' class='text-right padding-right-5 text-bold border-bottom-line'>₱ ".number_format($GTotal,2)."</td>";
            $RequestTemplate .= "</tr>";
            //Footer
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left border-left-line border-top-line padding-left-5'>OR NO.:</td>";
            $RequestTemplate .= "<td class='text-left border-top-line padding-left-5' colspan='4'>$RequestHeader->OR_Numbers</td>";
            $RequestTemplate .= "<td class='text-right border-top-line padding-left-5' colspan='3'>AMOUNT RECEIVED:</td>";
            $RequestTemplate .= "<td colspan='2' class='text-right border-top-line padding-left-5 border-right-line padding-right-5'>".number_format($RequestHeader->TotalAmount,2)."</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left border-bottom-line border-left-line padding-left-5'>DATE:</td>";
            $RequestTemplate .= "<td class='text-left border-bottom-line padding-left-5' colspan='4'>$RequestHeader->ORDate</td>";
            $RequestTemplate .= "<td class='text-right border-bottom-line padding-left-5' colspan='3'>UNPAID BALANCE:</td>";
            $RequestTemplate .= "<td colspan='2' class='text-right border-bottom-line padding-left-5 border-right-line padding-right-5'>₱ ".number_format($GTotal-$RequestHeader->TotalAmount,2)."</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left' colspan='10'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
             //Report Due
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left border-bottom-line border-left-line border-top-line padding-left-5'>REPORT DUE:</td>";
            $RequestTemplate .= "<td class='text-left border-bottom-line border-top-line padding-left-5' colspan='4'>".date('m/d/Y', strtotime($RequestHeader->report_due))."</td>";
            $RequestTemplate .= "<td class='text-right border-bottom-line border-top-line padding-left-5' colspan='3'>MODE OF RELEASE:</td>";
            $RequestTemplate .= "<td colspan='2' class='text-right border-bottom-line border-top-line padding-left-5 border-right-line padding-right-5'>$RequestHeader->ModeOfRelease</td>";
            $RequestTemplate .= "</tr>";
             //Divider
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left' colspan='10'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
             //
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left border-left-line border-bottom-line border-top-line padding-left-5 border-right-line padding-right-5' colspan='10'>DISCUSSED WITH CUSTOMER</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left border-left-line border-top-line padding-left-5 border-right-line padding-right-5' colspan='4'>CONFORME:</td>";
            $RequestTemplate .= "<td class='text-left border-left-line border-top-line padding-left-5 border-right-line padding-right-5' colspan='3'></td>";
            $RequestTemplate .= "<td class='text-left border-left-line border-top-line padding-left-5 border-right-line padding-right-5' colspan='3'></td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-center valign-bottom text-bold border-left-line border-bottom-line padding-left-5 border-right-line padding-right-5' colspan='4' style='height: 35px'>".ucwords($RequestHeader->conforme)."</td>";
            $RequestTemplate .= "<td class='text-center valign-bottom text-bold border-left-line border-bottom-line padding-left-5 border-right-line padding-right-5' colspan='3'>".ucwords($RequestHeader->receivedBy)."</td>";
            $RequestTemplate .= "<td class='text-center valign-bottom text-bold border-left-line border-bottom-line padding-left-5 border-right-line padding-right-5' colspan='3'>".ucwords($RequestHeader->LabManager)."</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-center border-bottom-line border-left-line border-top-line padding-left-5 border-right-line padding-right-5' colspan='4'>Customer/Authorized Representative</td>";
            $RequestTemplate .= "<td class='text-center border-bottom-line border-left-line border-top-line padding-left-5 border-right-line padding-right-5' colspan='3'>Sample/s Received By:</td>";
            $RequestTemplate .= "<td class='text-center border-bottom-line border-left-line border-top-line padding-left-5 border-right-line padding-right-5' colspan='3'>Sample/s Reviewed By:</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left border-left-line border-bottom-line border-top-line padding-left-5 border-right-line padding-right-5' colspan='10'>REPORT NO.:</td>";
            $RequestTemplate .= "</tr>";
            
            $RequestTemplate .= "</tbody>";
            $RequestTemplate .= "<tfoot>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10' style='text-align: right;font-size: 7px'>$Form</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "</tfoot>";
            $RequestTemplate .= "</table>";
        } else {
            $RequestTemplate = "<table border='0' width=100%>";
            $RequestTemplate .= "</table>";
        }
        return $RequestTemplate;
    }

}
