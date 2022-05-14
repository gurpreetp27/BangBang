<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Membership;
use App\Bets;
use App\User;

class AdminLoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth',['except' => ['login']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
        public function login()
    {
        
        if(Auth::check()){
             if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {

                return redirect('/admin/home');
            }
            else {
                Auth::logout();
                Session::flush();
            }
        }
        return view('admin.login');
    } 


   public function home(){
        // die("here");
        $this->inactiveBet();

       $now = date('Y-m-d H:i:s');  
       $then = date('Y-m-d H:i:s',strtotime('-24 hours'));
       
       // $alldata = Membership::where('status','active')->get()->all(); 
       $alldata = Membership::get()->all(); 
       $totalmem = Membership::where('created_at','<=',$now)->where('created_at','>=',$then)->count('id');
       $thismonthactivemember = Membership::where('status','active')->whereYear('created_at',date('Y'))->whereMonth('created_at',date('m'))->get()->toArray();

        $dataArray = array();
        $sum = 0;
        $counter = 0;
        if(isset($alldata)){
            foreach ($alldata as $key => $value) {
                 $sum = $sum + $value['amount'];
                 if($value['status'] == "ACTIVE"){
                 $counter++;
                 }
             }
         } 
         $dataArray = array(
              'total' => number_format($sum,2),
              'totalmem' => number_format($counter)
            ); 
         $thisMonthArray = array();
         $cnt = 0;
         $chartArray = array();
         if(isset($thismonthactivemember)){
            foreach ($thismonthactivemember as $key => $value) {
                 $cnt++;
                 $chartArray[] = array(
                     'date' => date('Y-m-d',strtotime($value['created_at'])),
                     'value' => number_format($value['amount'],2)
                    );
             }
         }
        
        $thisMonthArray = array(
                'counter' => $cnt,
                'chartData' => $chartArray  
            );


        //==========Get this month==============//
        $this_moth_member = User::whereYear('created_at',date('Y'))->whereMonth('created_at',date('m'))->get()->count();
        //========================//


         //==========Get last 24hour member==============//
        $last24 = date("Y-m-d h:i:s",strtotime('-24 hours'));
        $last24hour_member = User::whereYear('created_at',date('Y'))->whereMonth('created_at',date('m'))->where('created_at','>=',$last24)->get()->count();

        //========================//
        $data = array(
             'completeData' => $dataArray,
             'thismonthData' => $thisMonthArray,
             'totalm' =>$totalmem,
             'this_moth_member' => $this_moth_member,
             'last24hour_member' => $last24hour_member,
            );
       /* echo "<pre>";
        print_r($data);
        die();*/

       return view('admin.screen.dashboard',['data'=>$data]);
    }


     /*Inactive bet after 3 hours*/
    public function inactiveBet(){
        $active_bets = Bets::where('active',1)->where('status', 'Pending')
            ->where('betdate','<=',date("Y-m-d H:i:s"))->get()->toArray();

          foreach ($active_bets as $key => $a) {
              $check_date = date("Y-m-d H:i:s",strtotime("+3 hours",strtotime($a['betdate'])));
              if(date("Y-m-d H:i:s") >= $check_date){
                Bets::where('id',$a['id'])->update(['active' => 0]);
              }
          }

    }

   public function logout(){
        Auth::logout();
        Session::flush();
        return redirect('admin/login');
    }

}
