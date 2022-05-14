<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\memberRegister;
use App\User;
use App\Plan;
use App\Membership;
use App\Payment;
use App\PaymentMode;
use App\AlertEmail;
use App\EmailTemplate;
use DB;
use Auth;
use Session;
use Mail;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $start_date = date('Y-m-d', strtotime('+1 day'));

        echo $start_date;


        die;
        //
       // echo date("Y-m-d H:i:s");
       // $this->sendEmailAdmin('Renew Membership','37');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('member.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(memberRegister $request)
    {

            if(!Auth::check()){
                $user = new User();
                $user->name = $request->get('name');
                $user->last_name = $request->get('last_name');
                $user->email = $request->get('email');
                $user->role_id = 2;
                $user->password = bcrypt($request->get('password'));
                $user->save();
                Auth::loginUsingId($user->id);

                $alert_email = new AlertEmail();
                $alert_email->type = 'no_pay_user';
                $alert_email->user_id = $user->id;
                $alert_email->send_date = date("Y-m-d",strtotime("+ 1 day"));
                $alert_email->save();

            } else {
                $user = Auth::user();
            }

            
            $payment_type = $request->get('payment_type');
            $plan_id = $request->get('plan_id');

            if($payment_type == 'paypal'){
                $paymentGateway = 'Paypal';
            } else {
                $paymentGateway = 'Klik';
            }


            /*Get selected plan info*/
            $plan_info = Plan::find($plan_id);
            $invoice = $this->get_unique_invoice();

            /*Get membership start date and end date usign plan info*/
            $start_date = date('Y-m-d');
            if($plan_info->duration == '1'){
                $end_date = date('Y-m-d', strtotime('+1 month'));
            } else if($plan_info->duration == '3'){
                $end_date = date('Y-m-d', strtotime('+3 months'));
            } else if($plan_info->duration == '12'){
                $end_date = date('Y-m-d', strtotime('+1 year'));
            } else {
                $end_date = date('Y-m-d', strtotime('+'.$plan_info->duration.' months'));
            }

            $paymentData = [
                    'invoice_no' => $invoice,
                    'user_id' => $user->id,
                    'plan_id' => $plan_info->id,
                    'actual_amount' => $plan_info->amount,
                    'paid_amount' => $plan_info->amount,
                    'payment_for' => 'Subscription',
                    'status' => 'Pending',
                    'gateway' => $paymentGateway,
                    'mode' => 'Online',
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'plan_title' => $plan_info->title,
                    'name' => $request->get('name'),
                    'last_name' => $request->get('last_name'),
                    'email' => $request->get('email'),
            ];
        
            $paymentResp = Payment::create($paymentData);

            if($paymentGateway == 'Paypal'){

                $urlData = $this->paypal_url($paymentData);
                if(isset($urlData['status']) && $urlData['status'] == 1){
                    $res = array('status' => 1,'payment_gateway' => $paymentGateway, 'url' => $urlData['url'],'messsage' => 'Paypal redirect..');
                } else {
                    $res = array('status' => 0, 'url' => $urlData['url'],'messsage' => $urlData['message']);
                }
            
            } else {
                $card_form = $this->klik_payment($paymentData);
                $res = array('status' => 1,'payment_gateway' => $paymentGateway, 'card_form' => $card_form,'messsage' => 'Klik&Pay redirect..');
            }
            

        
        return response()->json($res);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

            $user = User::find($id);
                      
            $payment_type = $request->get('payment_type');
            $plan_id = $request->get('plan_id');

            if($payment_type == 'paypal'){
                $paymentGateway = 'Paypal';
            } else {
                $paymentGateway = 'Klik';
            }

            /*Get selected plan info*/
            $plan_info = Plan::find($plan_id);
            $invoice = $this->get_unique_invoice();

            /*Get membership start date and end date usign plan info*/
            $start_date = date('Y-m-d');
            if($plan_info->duration == '1'){
                $end_date = date('Y-m-d', strtotime('+1 month'));
            } else if($plan_info->duration == '3'){
                $end_date = date('Y-m-d', strtotime('+3 months'));
            } else if($plan_info->duration == '12'){
                $end_date = date('Y-m-d', strtotime('+1 year'));
            } else {
                $end_date = date('Y-m-d', strtotime('+'.$plan_info->duration.' months'));
            }

            $paymentData = [
                    'invoice_no' => $invoice,
                    'user_id' => $user->id,
                    'plan_id' => $plan_info->id,
                    'actual_amount' => $plan_info->amount,
                    'paid_amount' => $plan_info->amount,
                    'payment_for' => 'Subscription',
                    'status' => 'Pending',
                    'gateway' => $paymentGateway,
                    'mode' => 'Online',
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'plan_title' => $plan_info->title,
                    'name' => $request->get('name'),
                    'last_name' => $request->get('last_name'),
                    'email' => $request->get('email'),
            ];
        
            $paymentResp = Payment::create($paymentData);

            if($paymentGateway == 'Paypal'){
                $urlData = $this->paypal_url($paymentData);
                if(isset($urlData['status']) && $urlData['status'] == 1){
                    $res = array('status' => 1,'payment_gateway' => $paymentGateway, 'url' => $urlData['url'],'messsage' => 'Paypal redirect..');
                } else {
                    $res = array('status' => 0, 'url' => $urlData['url'],'messsage' => $urlData['message']);
                }
            
            } else {
                $card_form = $this->klik_payment($paymentData);
                $res = array('status' => 1,'payment_gateway' => $paymentGateway, 'card_form' => $card_form,'messsage' => 'Klik&Pay redirect..');
            }     
        return response()->json($res);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function logout(){
        Auth::logout();
        Session::flush();
        return redirect('/');
    }

    /* Get uniqe next invoice number */
    public function get_unique_invoice(){
        return time()."-".Auth::user()->id;
    }

    public function klik_payment($data){


        if(isset($data['sub_id']) && $data['sub_id'] != ''){
            $html = view('member.klik_sub_payment_form',compact('data'))->render();
        return $html;
        } else {
            $html = view('member.klik_payment_form',compact('data'))->render();
        return $html;
        }
        
    }

     public function paypal_url($data){

        $this->PaymentLog("paypal_url_1: ", $data);

        $urlData = array();
        $returnurl = action('MemberController@return_paypal');
        $cancelurl = action('MemberController@cancel_paypal');
        $paymentMode = \App\PaymentMode::where('gateway', 'Paypal')->first();
        $paymentMode = $paymentMode->toArray();
        // if(isset($paymentMode['status']) && ($paymentMode['status'] == "Inactive")){
        //     $urlData = ['status' => 0, 'url' => '', 'message' => "Payment gateway disabled. Please contact administration."];
        //     return $urlData;
        // }

        $is_membership = 0;
        $is_preauth = 0;
        if(isset($data['payment_for']) && $data['payment_for'] == "Recurrency Membership"){
            $is_membership = 1;
            $returnurl .= "?invoice=".$data['invoice_no']."&membership=1"."&is_preauth=".$is_preauth."&plan=".base64_encode($data['plan_id']);
            $cancelurl .= "?invoice=".$data['invoice_no']."&membership=1"."&is_preauth=".$is_preauth."&plan=".base64_encode($data['plan_id']);
        }else{
            $returnurl .= "?invoice=".$data['invoice_no']."&plan=".base64_encode($data['plan_id']);
            $cancelurl .= "?invoice=".$data['invoice_no']."&plan=".base64_encode($data['plan_id']);
        }

        $nvp = array(
            'PAYMENTREQUEST_0_AMT'              => $data['paid_amount'],
            'PAYMENTREQUEST_0_CURRENCYCODE'      => 'EUR',
            'PAYMENTREQUEST_0_PAYMENTACTION'     => 'Sale',
            'RETURNURL'                         => $returnurl,
            'CANCELURL'                         => $cancelurl,
            'METHOD'                            => 'SetExpressCheckout',
            'VERSION'                           => '93.0',
            'PWD'                               => $paymentMode['api_password'],
            'USER'                              => $paymentMode['api_username'],
        'SIGNATURE'                         => $paymentMode['api_signature'],
        'LOCALECODE'                        => 'en_US'
        );

        if($is_preauth == 1){
            $nvp['PAYMENTREQUEST_0_PAYMENTACTION'] = 'Authorization';
        }

        if($is_membership == 1){
            $nvp['L_BILLINGTYPE0'] = 'RecurringPayments';
            $nvp['L_BILLINGAGREEMENTDESCRIPTION0'] = 'Bangbang';
        }
         
        $curl = curl_init();
        if(isset($paymentMode['account_type']) && ($paymentMode['account_type'] == "Live")){
            $paypalApiUrl = 'https://api-3t.paypal.com/nvp';
        }else{
            $paypalApiUrl = 'https://api-3t.sandbox.paypal.com/nvp';
        }


        $this->PaymentLog("paypal_url_2: ", $nvp);


        curl_setopt( $curl , CURLOPT_URL , $paypalApiUrl );
        curl_setopt( $curl , CURLOPT_SSL_VERIFYPEER , false );
        curl_setopt( $curl , CURLOPT_RETURNTRANSFER , 1 );
        curl_setopt( $curl , CURLOPT_POST , 1 );
        curl_setopt( $curl , CURLOPT_POSTFIELDS , http_build_query( $nvp ) );
        $paypalRes = curl_exec( $curl );
        $response = urldecode( $paypalRes );
        curl_close( $curl );
        $responseNvp = array();
        if ( preg_match_all( '/(?<name>[^\=]+)\=(?<value>[^&]+)&?/' , $response , $matches ) ) {
            foreach ( $matches[ 'name' ] as $offset => $name ) {
                $responseNvp[ $name ] = $matches[ 'value' ][ $offset ];
            }
        }
        //echo "<pre>";print_r($responseNvp);exit;
        
        if ( isset( $responseNvp[ 'ACK' ] ) && $responseNvp[ 'ACK' ] == 'Success' ) {

            if(isset($paymentMode['account_type']) && ($paymentMode['account_type'] == "Live")){
                $paypalURL = 'https://www.paypal.com/cgi-bin/webscr';
            }else{
                $paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
            }
            

            $query = array(
                'cmd'   => '_express-checkout',
                'token' => $responseNvp[ 'TOKEN' ]
            );
            $url = $paypalURL . '?' . http_build_query( $query );
            $urlData = ['status' => 1, 'url' => $url, 'message' => ''];

            $this->PaymentLog("paypal_url_3: ", $responseNvp);
        } else {
            $message = 'Something went wrong to generate redirect url. please try again!';
            if(isset($responseNvp['L_LONGMESSAGE0']) && !empty($responseNvp['L_LONGMESSAGE0'])){
                $message = $responseNvp['L_LONGMESSAGE0'];
                $this->update_error_message($data['invoice_no'], $message);
            }
            $urlData = ['status' => 0, 'url' => '', 'message' => $message];
           
        }
        return $urlData;
    }

    public function return_paypal(){
         if ( isset( $_GET[ 'token' ] ) ) {


            $this->PaymentLog("return_paypal_1: ", $_GET);


                $paymentMode = PaymentMode::where('gateway', 'Paypal')
                        ->where('status', 'Active')->first()->toArray();
                $token = $_GET[ 'token' ];
                $payerId = $_GET[ 'PayerID' ];
                $is_subscription = 0;
                $plan_id = 0;
                    if(isset($_GET[ 'plan' ])){
                                $plan_id = base64_decode($_GET[ 'plan' ]);
                            }
               $plan_info = Plan::find($plan_id);

                if(isset($_GET['membership']) && $_GET['membership']){
                    $is_subscription = 1;
                }
                $nvp = array(
                    'TOKEN'                             => $token,
                    'METHOD'                            => 'GetExpressCheckoutDetails',
                    'VERSION'                           => '93.0',
                    'PWD'                               => $paymentMode['api_password'],
                    'USER'                              => $paymentMode['api_username'],
                    'SIGNATURE'                         => $paymentMode['api_signature'],
                    'LOCALECODE'                        => 'en_US'
                );
                $curl = curl_init();
                if(isset($paymentMode['account_type']) && ($paymentMode['account_type'] == "Live")){
                    $paypalApiUrl = 'https://api-3t.paypal.com/nvp';
                }else{
                    $paypalApiUrl = 'https://api-3t.sandbox.paypal.com/nvp';
                }
                
                try {
                
                curl_setopt( $curl , CURLOPT_URL , $paypalApiUrl );
                curl_setopt( $curl , CURLOPT_SSL_VERIFYPEER , false );
                curl_setopt( $curl , CURLOPT_RETURNTRANSFER , 1 );
                curl_setopt( $curl , CURLOPT_POST , 1 );
                curl_setopt( $curl , CURLOPT_POSTFIELDS , http_build_query( $nvp ) );
                $response = urldecode( curl_exec( $curl ) );

                $responseNvp = array();
                if ( preg_match_all( '/(?<name>[^\=]+)\=(?<value>[^&]+)&?/' , $response , $matches ) ) {
                    foreach ( $matches[ 'name' ] as $offset => $name ) {
                        $responseNvp[ $name ] = $matches[ 'value' ][ $offset ];
                    }
                }
                
                }
                catch (\Exception $e) {

                    // return $e->getMessage();
                    
                    return view('member.paypal_error');
                }
                
                
                
              
               $this->PaymentLog("return_paypal_GetExpressCheckoutDetails_: ", $responseNvp);


                $invoiceNo = $_GET[ 'invoice' ];
                $payObj = Payment::where('invoice_no', $invoiceNo)->select('id','start_date','actual_amount', 'paid_amount')->first();
                

                if ( isset( $responseNvp[ 'TOKEN' ] ) && isset( $responseNvp[ 'ACK' ] ) ) {
                    if ( $responseNvp[ 'TOKEN' ] == $token && $responseNvp[ 'ACK' ] == 'Success' ) {
                         $nvp[ 'PAYERID' ] = $responseNvp[ 'PAYERID' ];

                            $sdate = date("Y-m-d",strtotime($payObj->start_date));
                           $startDate = $sdate . 'T' . date("00:00:01") . 'Z';

                           if($plan_info->id == 3){
                            $BILLINGPERIOD = 'Year';
                           } else {
                            $BILLINGPERIOD = 'Month';
                           }

                           if($is_subscription == 1){
                            
                            $nvp[ 'METHOD' ]  = 'CreateRecurringPaymentsProfile';
                            $nvp['L_BILLINGTYPE0'] = 'RecurringPayments';
                            $nvp['L_BILLINGAGREEMENTDESCRIPTION0'] = $plan_info->name.' Membership';
                            $nvp['PROFILESTARTDATE'] = $startDate;
                            $nvp['DESC'] = 'Bangbang';
                            $nvp['BILLINGPERIOD'] = $BILLINGPERIOD;

                            if($plan_info->id == 2){
                                $nvp['BILLINGFREQUENCY'] = '3';
                            } else {
                                $nvp['BILLINGFREQUENCY'] = '1';
                            }
                            
                            $nvp['CURRENCYCODE'] = 'EUR';
                            $nvp['COUNTRYCODE'] = 'EU';
                            $nvp['AMT'] = $payObj->actual_amount;
                            /*if(isset($payObj->discount) && ($payObj->discount > 0)){
                                $nvp['INITAMT'] = $payObj->paid_amount; // for discount
                            }*/

                        }else{

                            $nvp['PAYMENTREQUEST_0_AMT' ]  = $responseNvp['PAYMENTREQUEST_0_AMT'];
                            $nvp[ 'PAYMENTREQUEST_0_CURRENCYCODE' ] = $responseNvp['PAYMENTREQUEST_0_CURRENCYCODE' ];
                            $nvp[ 'METHOD' ] = 'DoExpressCheckoutPayment';
                            $nvp[ 'PAYMENTREQUEST_0_PAYMENTACTION' ] = 'Sale';
                            $nvp['COUNTRYCODE'] = 'EU';

                        }   

                        $this->PaymentLog("return_paypal_before_DoExpressCheckoutPayment_nvp_: ", $nvp);

                        try {
                        curl_setopt( $curl , CURLOPT_POSTFIELDS , http_build_query( $nvp ) );
                        $response = urldecode( curl_exec( $curl ) );
                        $responseNvp = array();

                        if ( preg_match_all( '/(?<name>[^\=]+)\=(?<value>[^&]+)&?/' , $response , $matches ) ) {
                            foreach ( $matches[ 'name' ] as $offset => $name ) {
                                $responseNvp[ $name ] = $matches[ 'value' ][ $offset ];
                            }
                        }
                        
                        }
                        catch (\Exception $e) {

                    // return $e->getMessage();
                    return view('member.paypal_error');
                }


            $this->PaymentLog("return_paypal_after_DoExpressCheckoutPayment_nvp_: ",$responseNvp);
            
             

                       if(isset($responseNvp['ACK']) && ($responseNvp['ACK'] == 'Success')){
                            /*update payment record with payerId and response and make status completed*/
                            $payerId = $_GET[ 'PayerID' ];
                            $newInvoiceNumber = $invoiceNo;
                            
                            $plan_id = 0;
                            if(isset($_GET[ 'plan' ])){
                                $plan_id = base64_decode($_GET[ 'plan' ]);
                            }
                            if(isset($payObj->id)){
                                $newInvoiceNumber = "INV-".$payObj->id;
                            }

                            $plan_info = Plan::find($plan_id);

                            $start_date = date('Y-m-d');
                            $payment_info = Payment::where('invoice_no', $invoiceNo)->first();

                            $check_membership = Membership::where('user_id',$payment_info['user_id'])->first();

                            $is_renew = 0;
                            if($check_membership && $is_subscription == 0){
                                $is_renew = 1;
                            }
                                
                            $payment_in = [
                                    'user_id' => $payment_info['user_id'],
                                    'payment_id' => $payment_info['id'],
                                    'plan_id' => $plan_info->id,
                                    'amount' => $plan_info->amount,
                                    'status' => 'ACTIVE',
                                    'is_renew' => $is_renew,
                                    'start_date' => $payment_info['start_date'],
                                    'end_date' => $payment_info['end_date']
                            ];
                            $end_date = $payment_info['end_date'];

                            if($is_subscription == 1){
                                $membership = Membership::create($payment_in);
                                $this->sendEmailAdmin('Recurrency Membership',$payment_info['user_id']);
                            } else {

                                if($is_renew == 1){
                                $this->sendEmailAdmin('Renew Membership',$payment_info['user_id']); 
                                   $membership = Membership::create($payment_in);
                                } else {
                                    $membership = Membership::create($payment_in);
                                    $this->sendEmailAdmin('New Member Register',$payment_info['user_id']); 
                                }

                            }
                            $payObjUpdate = Payment::where('invoice_no', $invoiceNo)
                                        ->update(['paypal_payerid' => $payerId,
                                                 'invoice_no' => $newInvoiceNumber,
                                                 'status' => 'Paid',
                                                 'gateway_customer_id' => isset($responseNvp['PROFILEID'])?$responseNvp['PROFILEID']:"",
                                                 'gateway_json_response' => json_encode($responseNvp),
                                                 'transaction_id' => isset($responseNvp['PAYMENTINFO_0_TRANSACTIONID'])?$responseNvp['PAYMENTINFO_0_TRANSACTIONID']:""
                                                    ]);

                             AlertEmail::where('type','no_pay_user')->where('user_id',$payment_info['user_id'])->update(['status'=>'closed']);          

                            if($is_subscription == 1){
                            return view('member.recurring_thanku');
                            } else {
                                return view('member.paypal_thanku',compact('end_date'));
                            }
                            
                            
                           } else {

                         
                           if(isset($responseNvp['L_ERRORCODE0']) && ($responseNvp['L_ERRORCODE0'] == '10486')){
                               return view('member.paypal_error_code');
                            } else {
                               
                            $message = 'Payment failed';
                            $this->update_error_message($invoiceNo, $message);
                            return view('member.paypal_error');
                           }
                            
                           

                           }

                            
                        
                    } else {
                        $message = 'Payment failed';
                        $this->update_error_message($invoiceNo, $message);
                        // echo $message;
                        return view('member.paypal_error');
                    }
                } else {
                     $this->update_error_message($invoiceNo, "No Token Payment failed");
                     echo 'No Token Payment failed';
                     return view('member.paypal_error');
                }
                curl_close( $curl );
            }
    }


        /* here returns if user cancel and return to site for cancel payment */
    public function cancel_paypal(){
        if(isset($_GET['invoice']) && !empty($_GET['invoice'])){
            $this->update_error_message($_GET['invoice'], 'Payment cancelled and return to site.');
        }
        $cancelled = 1;
        return view('member.paypal_thanku',compact('cancelled'));
    }

        /* This function call back is used to update error message appears during payment */
    public function update_error_message($invoice, $messsage, $table = "payments"){
        if(!empty($invoice) && !empty($messsage)){
            $tableName = "payments";
            $res = DB::table($tableName)
                ->where('invoice_no', $invoice)
                ->update(['failed_message' => $messsage]);
            return $res;
        }
        return null;
    }

   public function renew(Request $request)
    {     
          $user = Auth::user();
          $membership = Membership::where('user_id',$user->id)->orderBy('id','desc')->first();

          if(!$membership){
            return redirect('/bets-day');
            exit;
          }
            
            $payment_type = $request->get('payment_type');
            $plan_id = $request->get('plan_id');

            if($payment_type == 'paypal'){
                $paymentGateway = 'Paypal';
            } else {
                $paymentGateway = 'Klik';
            }

            /*Get selected plan info*/
            $plan_info = Plan::find($plan_id);
            $invoice = $this->get_unique_invoice();

            // if($membership->end_date)


            if(strtotime($membership->end_date) > strtotime(date("Y-m-d"))){
                $start_date = date('Y-m-d', strtotime('+1 day',strtotime($membership->end_date)));
          
                if($plan_info->duration == '1'){
                  $end_date = date('Y-m-d', strtotime('+1 month',strtotime($membership->end_date)));
                } else if($plan_info->duration == '3'){
                  $end_date = date('Y-m-d', strtotime('+3 month',strtotime($membership->end_date)));
                } else if($plan_info->duration == '12'){
                  $end_date = date('Y-m-d', strtotime('+1 year',strtotime($membership->end_date)));
                } 
                else {
                $end_date = date('Y-m-d', strtotime('+'.$plan_info->duration.' months',strtotime($membership->end_date)));
            }

            } else {
                /*Get membership start date and end date usign plan info*/
                $start_date = date('Y-m-d');
                if($plan_info->duration == '1'){
                    $end_date = date('Y-m-d', strtotime('+1 month'));
                } else if($plan_info->duration == '3'){
                    $end_date = date('Y-m-d', strtotime('+3 months'));
                } else if($plan_info->duration == '12'){
                    $end_date = date('Y-m-d', strtotime('+1 year'));;
                }
                else {
                $end_date = date('Y-m-d', strtotime('+'.$plan_info->duration.' months'));
            }
            }

            $paymentData = [
                    'invoice_no' => $invoice,
                    'user_id' => $user->id,
                    'plan_id' => $plan_info->id,
                    'actual_amount' => $plan_info->amount,
                    'paid_amount' => $plan_info->amount,
                    'payment_for' => 'Subscription',
                    'status' => 'Pending',
                    'gateway' => $paymentGateway,
                    'mode' => 'Online',
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'plan_title' => $plan_info->title,
                    'name' => $request->get('name'),
                    'last_name' => $request->get('last_name'),
                    'email' => $request->get('email'),
            ];
        
            $paymentResp = Payment::create($paymentData);

            if($paymentGateway == 'Paypal'){
                $urlData = $this->paypal_url($paymentData);
                if(isset($urlData['status']) && $urlData['status'] == 1){
                    $res = array('status' => 1,'payment_gateway' => $paymentGateway, 'url' => $urlData['url'],'messsage' => 'Paypal redirect..');
                } else {
                    $res = array('status' => 0, 'url' => $urlData['url'],'messsage' => $urlData['message']);
                }
            
            } else {
                $card_form = $this->klik_payment($paymentData);

                $res = array('status' => 1,'payment_gateway' => $paymentGateway, 'card_form' => $card_form,'messsage' => 'Klik&Pay redirect..');
            }     
        return response()->json($res);
    } 


    /*It is used to do recuring payments*/
     public function recurrencyMembership(Request $request)
    {     
          $user = Auth::user();
          $membership = Membership::where('user_id',$user->id)->orderBy('id','desc')->first();

          
          $re_payment = Payment::with('get_plan')->where('user_id',$user->id)->where('payment_for','Recurrency Membership')->where('status','paid')->first();
          if($re_payment){
            return view('manage_account.view_recurrency_membership',compact('user','re_payment'));
            exit;
          }


          if(!$membership){
            return redirect('/bets-day');
            exit;
          }
            
            $payment_type = $request->get('payment_type');
            $plan_id = $request->get('plan_id');

            if(!$plan_id || $plan_id == 0){
                return redirect()->back()->with('error', 'Please select any one plan');
            }

            if($payment_type == 'paypal'){
                $paymentGateway = 'Paypal';
            } else {
                $paymentGateway = 'Klik';
            }

            /*Get selected plan info*/
            $plan_info = Plan::find($plan_id);
            $invoice = $this->get_unique_invoice();

            // if($membership->end_date)


            if(strtotime($membership->end_date) > strtotime(date("Y-m-d"))){
             
                $start_date = date('Y-m-d', strtotime('+1 day',strtotime($membership->end_date)));
          
                if($plan_info->duration == '1'){
                  $end_date = date('Y-m-d', strtotime('+1 month',strtotime($start_date)));
                } else if($plan_info->duration == '3'){
                  $end_date = date('Y-m-d', strtotime('+3 month',strtotime($start_date)));
                } else if($plan_info->duration == '12'){
                  $end_date = date('Y-m-d', strtotime('+1 year',strtotime($start_date)));
                } else {
                  $end_date = date('Y-m-d', strtotime('+'.$plan_info->duration.' months',strtotime($start_date)));
                }
            } else {
                /*Get membership start date and end date usign plan info*/
                $start_date = date('Y-m-d');
                if($plan_info->duration == '1'){
                    $end_date = date('Y-m-d', strtotime('+1 month'));
                } else if($plan_info->duration == '3'){
                    $end_date = date('Y-m-d', strtotime('+3 months'));
                } else if($plan_info->duration == '12'){
                    $end_date = date('Y-m-d', strtotime('+1 year'));;
                } else {
                $end_date = date('Y-m-d', strtotime('+'.$plan_info->duration.' months'));
                }
            }

          

            $paymentData = [
                    'invoice_no' => $invoice,
                    'user_id' => $user->id,
                    'plan_id' => $plan_info->id,
                    'actual_amount' => $plan_info->amount,
                    'paid_amount' => $plan_info->amount,
                    'payment_for' => 'Recurrency Membership',
                    'status' => 'Pending',
                    'gateway' => $paymentGateway,
                    'mode' => 'Online',
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'plan_title' => $plan_info->title,
                    'name' => $request->get('name'),
                    'last_name' => $request->get('last_name'),
                    'email' => $request->get('email'),
                    'sub_id' => $plan_info->klik_subscription_id,
            ];


        
            $paymentResp = Payment::create($paymentData);

            if($paymentGateway == 'Paypal'){
                $urlData = $this->paypal_url($paymentData);
                if(isset($urlData['status']) && $urlData['status'] == 1){
                    $res = array('status' => 1,'payment_gateway' => $paymentGateway, 'url' => $urlData['url'],'messsage' => 'Paypal redirect..');
                } else {
                    $res = array('status' => 0, 'url' => $urlData['url'],'messsage' => $urlData['message']);
                }
            
            } else {
                $card_form = $this->klik_payment($paymentData);
                $res = array('status' => 1,'payment_gateway' => $paymentGateway, 'card_form' => $card_form,'messsage' => 'Klik&Pay redirect..');
            }     
        return response()->json($res);
    }

    // When user sign up,renew and start recurrening payment
    function sendEmailAdmin($type,$user_id){

            $user = User::where('id',$user_id)->first();
            $template = EmailTemplate::where('title',$type)->first();

            if($template){
                $content = $template->content;
                $subject = $template->subject;
            } else {
                $content = '<p>Hi Admin</p><p><br></p><p>New user add.</p><p><br></p><p>Thnaks.<br></p>';
                $subject = "New User Add";
            }

            $content = str_replace('{username}', $user->name, $content);

            $data['content'] = $content;
            $data['user'] = $user;
            $data['subject'] = $subject;

            try {

                   $admin_email = config('settings.admin_email');
                    Mail::send('emails.simple', $data, function($message) use($admin_email,$subject){
                        $message->subject($subject);
                        $message->to($admin_email,'Admin');
                    });

                } catch (\Exception $e) {

                    // return $e->getMessage();
                }
           
    }


        public function return_klik(){
            $invoiceNo = $_GET[ 'invoice'];
            $is_subscription = 0;
            $payObj = Payment::where('invoice_no', $invoiceNo)->first();

                $user = User::where('id',$payObj->user_id)->first();
                $plan_info = Plan::find($payObj->plan_id);

                // if(isset($_GET['membership']) && $_GET['membership']){
                //     $is_subscription = 1;
                // }
                $start_date = date('Y-m-d');
                $check_membership = Membership::where('user_id',$payObj->user_id)->first();

                $is_renew = 0;
                if($check_membership){
                    $is_renew = 1;
                }
                                
                $payment_in = [
                        'user_id' => $payObj->user_id,
                        'payment_id' => $payObj->id,
                        'plan_id' => $plan_info->id,
                        'amount' => $plan_info->amount,
                        'status' => 'ACTIVE',
                        'is_renew' => $is_renew,
                        'start_date' => $payObj->start_date,
                        'end_date' => $payObj->end_date,
                ];

                if(isset($payObj->id)){
                                $newInvoiceNumber = "INV-".$payObj->id;
                }


                
                $end_date = $payObj->end_date;

                 $payObjUpdate = Payment::where('invoice_no', $invoiceNo)
                            ->update(['invoice_no' => $newInvoiceNumber,
                                     'status' => 'Paid'
                                        ]);

                if($is_subscription == 1){
                    // $membership = Membership::create($payment_in);
                    $this->sendEmailAdmin('Recurrency Membership',$payObj->user_id);
                } else {
                    if($is_renew == 1){
                        $membership = Membership::create($payment_in);
                       $this->sendEmailAdmin('Renew Membership',$payObj->user_id); 
                    } else {
                        $this->sendEmailAdmin('New Member Register',$payObj->user_id); 
                    }

                }            
                            
                if($is_subscription == 1){
                    return view('member.recurring_thanku');
                    } else {
                        return view('member.paypal_thanku',compact('end_date'));
                }
                        
                  
                $message = 'Payment failed';
                $this->update_error_message($invoiceNo, $message);
                echo $message;
            
    }


    static function PaymentLog($message,$data = array()){
        $userId = "Guest";
        if(Auth::check()){
            $userId = Auth::user()->id;
        }
       $paymentLog = new Logger('PaymentLog['.$userId.']');
       $paymentLog->pushHandler(new StreamHandler(storage_path('logs/payment.log')), Logger::INFO);
       $paymentLog->info($message, $data);
    }



}