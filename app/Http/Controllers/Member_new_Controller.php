<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\memberRegister;
use App\User;
use App\Plan;
use App\Membership;
// use App\Payment;
use App\PaymentMode;
use App\AlertEmail;
use App\EmailTemplate;
use DB;
use Auth;
use Session;
use Mail;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use App\Http\Controllers\PaymentController;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PayPal\Exception\PayPalConnectionException;

class Member_new_Controller extends Controller
{


      public function __construct()
    {
        $this->api_context = new ApiContext(
            new OAuthTokenCredential(config('paypal.client_id'), config('paypal.secret'))
        );
        $this->api_context->setConfig(config('paypal.settings'));
    }
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

            
            
            $plan_id = $request->get('plan_id');
            $paymentGateway = 'Paypal';


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
        
            $paymentResp = \App\Payment::create($paymentData);

            $urlData = $this->paypal_url($paymentData);

            
            if(isset($urlData['status']) && $urlData['status'] == 1){
                $res = array('status' => 1,'payment_gateway' => $paymentGateway, 'url' => $urlData['url'],'messsage' => 'Paypal redirect..');
            } else {
                $res = array('status' => 0, 'url' => $urlData['url'],'messsage' => $urlData['message']);
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
        
            $paymentResp = \App\Payment::create($paymentData);

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


        $returnurl = action('MemberController@return_paypal');
        $cancelurl = action('MemberController@cancel_paypal');
        

        // $request->validate(['amount' => 'required|numeric']);
        $pay_amount = $data['paid_amount'];

        // We create the payer and set payment method, could be any of "credit_card", "bank", "paypal", "pay_upon_invoice", "carrier", "alternate_payment". 
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        // Create and setup items being paid for.. Could multiple items like: 'item1, item2 etc'.
        $item = new Item();
        $item->setName('Bangbang Membership')->setCurrency('EUR')->setQuantity(1)->setPrice($pay_amount);

        // Create item list and set array of items for the item list.
        $itemList = new ItemList();
        $itemList->setItems(array($item));

        // Create and setup the total amount.
        $amount = new Amount();
        $amount->setCurrency('EUR')->setTotal($pay_amount);

        // Create a transaction and amount and description.
        $transaction = new Transaction();
        $transaction->setAmount($amount)->setItemList($itemList)
        ->setDescription('Bangbang Membership');
        //You can set custom data with '->setCustom($data)' or put it in a session.

        // Create a redirect urls, cancel url brings us back to current page, return url takes us to confirm payment.

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



        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl($returnurl)
        ->setCancelUrl($cancelurl);

        $payment = new Payment();
        $payment->setIntent('Sale')->setPayer($payer)->setRedirectUrls($redirect_urls)
        ->setTransactions(array($transaction));

        // Put the payment creation in try and catch in case of exceptions.
        try {
            $payment->create($this->api_context);
        } catch (PayPalConnectionException $ex){
            return back()->withError('Some error occur, sorry for inconvenient');
        } catch (Exception $ex) {
            return back()->withError('Some error occur, sorry for inconvenient');
        }

        // We get 'approval_url' a paypal url to go to for payments.
       foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }


        if(isset($redirect_url)) {
           $urlData = ['status' => 1, 'url' => $redirect_url, 'message' => ''];
          
        } else {
            $message = 'Something went wrong to generate redirect url. please try again!';
            $urlData = ['status' => 0, 'url' => '', 'message' => $message];
            // return redirect()->back()->withError('Unknown error occurred');
        }


         return $urlData;

        // If we don't have redirect url, we have unknown error.
       
        exit;

    }

    public function return_paypal(Request $request){


         if (empty($request->query('paymentId')) || empty($request->query('PayerID')) || empty($request->query('token')))
               return redirect('/checkout')->withError('Payment was not successful.');


        $is_subscription = 0;
        // We retrieve the payment from the paymentId.
        $payment = Payment::get($request->query('paymentId'), $this->api_context);

        // We create a payment execution with the PayerId
        $execution = new PaymentExecution();
        $execution->setPayerId($request->query('PayerID'));

        // Then we execute the payment.
        $result = $payment->execute($execution, $this->api_context);


        

        // Get value store in array and verified data integrity
        // $value = $request->session()->pull('key', 'default');

        // Check if payment is approved

        $p = array($result);

        $this->PaymentLog("===result: ", $p);

        if ($result->getState() == 'approved'){

             $plan_id = 0;
            if(!empty($request->query('plan'))){
                $plan_id = base64_decode($request->query('plan'));
            } else {
                $plan_id = 1;
            }


               $plan_info = Plan::find($plan_id);
               
               $invoiceNo = $request->query('invoice');
               $payObj = \App\Payment::where('invoice_no', $invoiceNo)->select('id','start_date','actual_amount', 'paid_amount')->first();


                            $payerId = $request->query('PayerID');
                            $newInvoiceNumber = $invoiceNo;
                            
                           
                            if(isset($payObj->id)){
                                $newInvoiceNumber = "INV-".$payObj->id;
                            }

                          
                            $start_date = date('Y-m-d');
                            $payment_info = \App\Payment::where('invoice_no', $invoiceNo)->first();

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
                            $payObjUpdate = \App\Payment::where('invoice_no', $invoiceNo)
                                        ->update(['paypal_payerid' => $payerId,
                                                 'invoice_no' => $newInvoiceNumber,
                                                 'status' => 'Paid',
                                                 'gateway_customer_id' => isset($responseNvp['PROFILEID'])?$responseNvp['PROFILEID']:"",
                                                 'gateway_json_response' => "",
                                                 'transaction_id' => isset($responseNvp['PAYMENTINFO_0_TRANSACTIONID'])?$responseNvp['PAYMENTINFO_0_TRANSACTIONID']:""
                                                    ]);

                            AlertEmail::where('type','no_pay_user')->where('user_id',$payment_info['user_id'])->update(['status'=>'closed']);          

                            if($is_subscription == 1){
                            return view('member.recurring_thanku');
                            } else {
                                return view('member.paypal_thanku',compact('end_date'));
                            }
                            
                            
                           } else {
                            $message = 'Payment failed';
                            $this->update_error_message($invoiceNo, $message);
                            // echo $message;
                            return view('member.paypal_error');

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

            $paymentGateway = 'Paypal';
             

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
        
            $paymentResp = \App\Payment::create($paymentData);

          
                $urlData = $this->paypal_url($paymentData);
                if(isset($urlData['status']) && $urlData['status'] == 1){
                    $res = array('status' => 1,'payment_gateway' => $paymentGateway, 'url' => $urlData['url'],'messsage' => 'Paypal redirect..');
                } else {
                    $res = array('status' => 0, 'url' => $urlData['url'],'messsage' => $urlData['message']);
                }
            
              
        return response()->json($res);
    } 


    /*It is used to do recuring payments*/
     public function recurrencyMembership(Request $request)
    {     
          $user = Auth::user();
          $membership = Membership::where('user_id',$user->id)->orderBy('id','desc')->first();

          
          $re_payment = \App\Payment::with('get_plan')->where('user_id',$user->id)->where('payment_for','Recurrency Membership')->where('status','paid')->first();
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


        
            $paymentResp = \App\Payment::create($paymentData);

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
            $payObj = \App\Payment::where('invoice_no', $invoiceNo)->first();

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

                 $payObjUpdate = \App\Payment::where('invoice_no', $invoiceNo)
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