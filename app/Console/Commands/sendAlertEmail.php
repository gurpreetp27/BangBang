<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Plan;
use App\Payment;
use App\Membership;
use Auth;
use App\Review;
use App\AlertEmail;
use App\EmailTemplate;
use Mail;

class sendAlertEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:alertemail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It used to send alert email, which user not pay fee';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $alert_email = AlertEmail::with('user_info')->where('type','no_pay_user')->where('status','pending')->where('send_date',date("Y-m-d"))->get();

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
}
