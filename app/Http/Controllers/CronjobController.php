<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Plan;
use App\Payment;
use App\Membership;
use Auth;
use App\Review;
use App\AlertEmail;
use App\EmailTemplate;
use Mail;

class CronjobController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
 

    public function sendAlertEmail(){
            
            $alert_email = AlertEmail::with('user_info')->where('type','no_pay_user')->where('status','pending')->where('send_date','>=',date("Y-m-d"))->get();

            $template = EmailTemplate::where('title','No Payment User')->first();

            if($template){
                $content = $template->content;
            } else {
                $content = '<p>Hi {username}</p><p><br></p><p>you are not pay the subscription.</p><p><br></p><p>Thnaks.<br></p>';
            }

        if($alert_email){
            foreach ($alert_email as $key => $a) {
                if(isset($a['user_info'])) {
                    $content = str_replace('{username}', $a['user_info']->name, $content);
                    $data['content'] = $content;
                    $data['user'] = $a['user_info'];
                    $data['subject'] = 'No Pay Fee';
                    $user = $a['user_info'];

                             
                    Mail::send('emails.simple', $data, function($message) use($user){
                                $message->subject('No Pay Fee');
                                $message->to($user->email,$user->name);
                    });

                    $check_total_email = AlertEmail::where('type','no_pay_user')->where('user_id',$a->user_id)->get()->count();

                    AlertEmail::where('id',$a->id)->update(['status' => 'send']);

                    if($check_total_email == 1){
                        $alert_email = new AlertEmail();
                        $alert_email->type = 'no_pay_user';
                        $alert_email->user_id = $a->user_id;
                        $alert_email->send_date = date("Y-m-d",strtotime("+ 2 day"));
                        $alert_email->save();
                    }



                }
            }

        }

    }


    public function checkMembership(){
    $membership = Membership::where('end_date','<=',date("Y-m-d"))->where('status','ACTIVE')->with('get_payment')->get();

    $next_payment = 0;
        foreach ($membership as $key => $m) {

            /*check recurring payment,If user payment_for = Recurrency Mebbersjip so that it is called recurreng payment*/
            $check_recurring = Payment::where("user_id",$m->user_id)->where('payment_for','Recurrency Membership')->where('status','Paid')->first();

            if($check_recurring){
                
                    if($m['get_payment']->gateway == 'Paypal'){
                        /*Work on this function*/
                            $payment_data = $this->paypalMembership($m['get_payment']['gateway_customer_id']);

                    if($payment_data['status'] == 'active'){
                        $next_payment = 1;
                        $payment = \App\Payment::find($m['get_payment']['id']);
                        $new_payment = $payment->replicate();
                        $new_payment->payment_source = 'crone';
                        $new_payment->payment_for = 'Recurrency Paid Ins Membership';
                        $new_payment->save();

                        $plan_info = Plan::find($m['get_payment']['plan_id']);

                    if(strtotime($m->end_date) > strtotime(date("Y-m-d"))){
                        $start_date = date('Y-m-d', strtotime('+1 day',strtotime($m->end_date)));
                        if($plan_info->duration == '1 Month'){
                          $end_date = date('Y-m-d', strtotime('+1 month',strtotime($start_date)));
                        } else if($plan_info->duration == '3 Month'){
                          $end_date = date('Y-m-d', strtotime('+3 month',strtotime(start_date)));
                        } else if($plan_info->duration == '1 Year'){
                          $end_date = date('Y-m-d', strtotime('+1 year',strtotime($start_date)));
                        }

                    } else {
                        /*Get membership start date and end date usign plan info*/
                        $start_date = date('Y-m-d');
                        if($plan_info->duration == '1 Month'){
                            $end_date = date('Y-m-d', strtotime('+1 month'));
                        } else if($plan_info->duration == '3 Month'){
                            $end_date = date('Y-m-d', strtotime('+3 months'));
                        } else if($plan_info->duration == '1 Year'){
                            $end_date = date('Y-m-d', strtotime('+1 year'));;
                        }
                    }
                    /*It used to add payment*/
                        $membership = Membership::find($m->id);
                        $new_membership = $membership->replicate();
                        $new_membership->start_date = $start_date;
                        $new_membership->end_date = $end_date;
                        $new_membership->plan_id = $m['get_payment']['plan_id'];
                        $new_membership->amount = $m['get_payment']['paid_amount'];
                        $new_membership->save();
                                    
                    }
       
                    } else if($m['get_payment']->gateway == 'Klik') {
                        /*Add code klik payment gateway*/

                    }

                    if($next_payment == 0){
                       Membership::where('id',$m->id)->update(['status' => 'INACTIVE']);
                    }

            } else {
                Membership::where('id',$m->id)->update(['status' => 'INACTIVE']);
            }

        }


    }

          /**=====================================================
     *Check Membership next payment status in Paypal. If user pay automatic payment with paypal then fucntion execute. 
     *
     * @return \Illuminate\Http\Response
     */

    static function paypalMembership($PROFILEID){


        $paymentMode = \App\PaymentMode::where('gateway', 'Paypal')
                        ->where('status', 'Active')->first()->toArray();
            try {
                $nvp = array(
                    'METHOD'                            => 'GetRecurringPaymentsProfileDetails',
                    'VERSION'                           => '108',
                    'PWD'                               => $paymentMode['api_password'],
                    'USER'                              => $paymentMode['api_username'],
                    'SIGNATURE'                         => $paymentMode['api_signature'],
                    'PROFILEID'                         => $PROFILEID
                );
                $curl = curl_init();
                if(isset($paymentMode['account_type']) && ($paymentMode['account_type'] == "Live")){
                    $paypalApiUrl = 'https://api-3t.paypal.com/nvp';
                }else{
                    $paypalApiUrl = 'https://api-3t.sandbox.paypal.com/nvp';
                }
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
           

                if($responseNvp['STATUS'] == "Active"){
                    $next_date_detail = $responseNvp['NEXTBILLINGDATE'];
                    $next_date = date("Y-m-d",strtotime($next_date_detail));
                    
                   if($next_date >= date('Y-m-d')){
                        $data['status'] = 'active';
                        $data['expire_date'] = $next_date.' 23:59:00';
                   } else {
                    $data['status'] = 'inactive';
                   }


                } else {
                    $data['status'] = 'inactive';
                }

            } catch(\Exception $e){
                    $log = ['error_content' => $e->getMessage()];
                $date['status'] = 'inactive';
                return $date;
                exit;
             }
            
            return $data;
    }


        





}
