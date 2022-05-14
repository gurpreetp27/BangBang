<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Plan;
use App\Payment;
use App\Membership;
use Auth;
use App\Bets;
use App\BetManager;
use App\Team;
use App\Player;
use App\Review;
use App\User;
use DB;
use App\BetCategory;
use App\EmailTemplate;
use Mail;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except' => ['index','changeLanguage','contact','betsDay','changeEmail','results','reviews','searchbymonth']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function setLocale(){
        $lang = Session::get ('locale');
        \App::setLocale($lang);

    }
    public function index()
    {   




        $plans = Plan::where('status','active')->get();
        $not_pay_membership = 0;

    if(Auth::check()){
        $check_member_ship = Membership::where('user_id',Auth::user()->id)->orderBy('id','desc')->first();
        if(!$check_member_ship) {
            $not_pay_membership = 1;
        } 
    }

    // if(Auth::check()){
      $data = $this->getbetResultpast30days();
      $catArray = array();
      $profitcat1 = $profitcat2 = $profitcat3 = 0;
      foreach ($data as $key => $bets) {
         $mincat1 = $pluscat1 = 0;
          if($bets['betcatid']==1){
            if($bets['status']=='Won'){
              $p = ($bets['odds'] * 100);
              $ps = ($p - 100);
              $profitcat1 = $profitcat1 + $ps;
            }else{
                 $profitcat1 = $profitcat1 -100;
            }

          }
          if($bets['betcatid']==2){
             if($bets['status']=='Won'){
              $p = ($bets['odds'] * 100);
              $ps = ($p - 100);
              $profitcat2 = $profitcat2 + $ps;
            }else{
                 $profitcat2 = $profitcat2 -100;
            }
            
          }
         if($bets['betcatid']==3){
             if($bets['status']=='Won'){
              $p = ($bets['odds'] * 100);
              $ps = ($p - 100);
              $profitcat3 = $profitcat3 + $ps;
            }else{
                 $profitcat3 = $profitcat3 -100;
            }

          }
      }

      $totalsumpass30days = array(
          'cat1'=> number_format($profitcat1,2),
          'cat2'=> number_format($profitcat2,2),
          'cat3'=> number_format($profitcat3,2),
        );
     return view('login_user_dashboard',['data'=>$data,'totalsumpass30days'=>$totalsumpass30days],compact('plans','not_pay_membership'));

   // } else {
   //   $plans = Plan::where('status','active')->get();
   //            $data = $this->getbetResult();
   //            $betcategory = BetCategory::all()->toArray();


   //            $systemdates1 = $this->getbetMonth(1);
   //            $systemdates2 = $this->getbetMonth(2);
   //            $systemdates3 = $this->getbetMonth(3);
               
   //            return view('dashboard',['data'=>$data,'betcategory'=>$betcategory,'systemdates1'=>$systemdates1,'systemdates2'=>$systemdates2,'systemdates3'=>$systemdates3],compact('plans'));
   // }


        
        
    }


    public function changeLanguage($locale)
    {
        Session::put('locale', $locale);
        return redirect()->back();
    }

    public function betsDay(){
        $this->inactiveBet();

        $plans = Plan::where('status','active')->get();
        if(!Auth::check()){
            //not loged in
            return view('sign_up',compact('plans'));

        } else if(Auth::check() && Auth::user()->role_id == 1){
           $data = $this->getbetData();
            $last5daysResult1 = $this->getbetResultpast5days(1);
            $last5daysResult2 = $this->getbetResultpast5days(2);
            $last5daysResult3 = $this->getbetResultpast5days(3);
            return view('bets_day',['data'=>$data,'last5daysResult1'=>$last5daysResult1,'last5daysResult2'=>$last5daysResult2,'last5daysResult3'=>$last5daysResult3],compact('plans'));

        }else if(Auth::check()){

            $check_member_ship = Membership::where('user_id',Auth::user()->id)->orderBy('id','desc')->first();

            if($check_member_ship && $check_member_ship->end_date <= date('Y-m-d')){
                // echo "membership expire";
                $user = Auth::user();
                return view('login_user',compact('plans','user'));

            } else if(!$check_member_ship) {
                // echo "not membership";
                $user = Auth::user();
                $not_pay_membership = 1;
                return view('login_user',compact('plans','user','not_pay_membership'));

            } else if($check_member_ship && $check_member_ship->end_date >= date('Y-m-d')){
                // echo "membership aval";
                $data = $this->getbetData();
                $last5daysResult1 = $this->getbetResultpast5days(1);
                $last5daysResult2 = $this->getbetResultpast5days(2);
                $last5daysResult3 = $this->getbetResultpast5days(3);
                return view('bets_day',['data'=>$data,'last5daysResult1'=>$last5daysResult1,'last5daysResult2'=>$last5daysResult2,'last5daysResult3'=>$last5daysResult3],compact('plans'));

            }
            // return view('dashboard',compact('plans'));
        }
    }

    public function contact(Request $request){

        if($request->isMethod('post')){
           $validatedData = $request->validate([
                'name' => 'required|string|min:4|max:255',
                'last_name' => 'required|string|min:2|max:255',
                'subject' => 'required|string|min:2|max:255',
                'message' => 'required|string|min:5',
                'email' => 'required|email',
            ]);
              $data = array();

            $template = EmailTemplate::where('title','Contact Form')->first();
            $from_name = $request->name." ".$request->last_name;
            $from_email = $request->email;
            $subject1 = $request->subject;

            if($template){
                $content = $template->content;
                $subject = $template->subject;
                $message = $request->message;
                $content = str_replace('{message}', $message, $content);
                $content = str_replace('{name}', $from_name, $content);
                $content = str_replace('{email}', $from_email, $content);
                $content = str_replace('{subject}', $subject1, $content);

            } else {
                $content = $request->message;
                $subject = $request->subject;
            }

            

              $data['content'] = $content;
              $data['subject'] = $subject;
              $data['from_name'] = $request->name." ".$request->last_name;
              $data['from_email'] = $request->email;
              $admin_email = config('settings.admin_email_for_contact_form');
              
              Mail::send('emails.contact', $data, function($message) use($admin_email,$subject){
                          $message->subject($subject);
                          $message->to($admin_email,'Admin');
              });
              return redirect()->back()->with('success', trans('member_js.contact_success'));
         } else {
           return view('contact');
         }
    }


    public function reviews(){
    	//echo "<pre>";
    	$data = Review::where('status','Approved')->where('is_active',1)->paginate(6);
    	$check = Review::where('user_id',Auth::id())->where('is_active',1)->count();
    	
        return view('reviews',['data'=>$data,'isreviewed'=> $check]);
    }

    public function getbetData(){
      // where('betdate','<=',date("Y-m-d H:i:s"))
  $BetManager = Bets::where('active',1)->where('status', 'Pending')
  // $BetManager = Bets::where('active',1)->where('status', 'Pending')->whereIn('parent_id',array(0,-1))
            ->with('whoisPlaying1','competion','sport','competion','tiptype')->with('betcategory1')->orderByRaw("FIELD(status , 'Pending', 'Won', 'Lost') ASC")->get()->toArray();
        
        // $BetManager = Bets::where('active',1)->where('status', 'Pending')
        //     ->where('betdate','>=',date("Y-m-d 00:00:00"))->where('betdate','<=',date("Y-m-d 23:59:59"))->with('whoisPlaying1','competion','sport','competion','tiptype')->with('betcategory1')->orderByRaw("FIELD(status , 'Pending', 'Won', 'Lost') ASC")->get()->toArray();
         $data = array();
         foreach ($BetManager as $key => $val) {
          $key = $val['id'];
          if(in_array($val['parent_id'],array(0,-1))){
           $explode = explode(' ', $val['betdate']);
           $data[$key]['betdate'] = $explode[0];
           $data[$key]['bettime'] = $explode[1];
           $data[$key]['status'] = $val['status'];
           $data[$key]['betcatid'] = $val['betcategory_id'];
           $data[$key]['betcatname'] = $val['betcategory1']['name'];
           $data[$key]['competion'] = $val['competion']['name'];
           $data[$key]['tiptype'] = $val['tiptype']['name'];
           $data[$key]['tiptypeid'] = $val['tiptype']['id'];
           $data[$key]['sport'] = $val['sport']['name'];
           $data[$key]['odds'] = $val['finalodds'];
           $data[$key]['odd'] = $val['odds'];
           $data[$key]['parent_id'] = $val['parent_id'];
           $data[$key]['trustnote'] = $val['trustnote'];
           $data[$key]['actualtip'] = $val['actualtip'];
           if($val['whois_playing1']['type']=='Team' || $val['whois_playing1']['type']=='team'){

                   $data[$key]['wostype'] = 'Team';
                   $teamnamea = Team::where('id',$val['whois_playing1']['teama'])->value('name'); 
                   $teamnameb = Team::where('id',$val['whois_playing1']['teamb'])->value('name'); 
                   $data[$key]['teama'] = $teamnamea;
                   $data[$key]['teamb'] = $teamnameb;
               }else{
                  $data[$key]['wostype'] = 'Individual';
                   $playera = Player::where('id',$val['whois_playing1']['playera'])->value('name'); 
                   $playerb = Player::where('id',$val['whois_playing1']['playerb'])->value('name'); 
                   $data[$key]['teama'] = $playera;
                   $data[$key]['teamb'] = $playerb;
               }

               if($val['parent_id'] == 0){
               $data[$key]['child_bet'] = array();
               } else {
                $data[$key]['child_bet'][] = $data[$key];
               }
               
         }

        } 

         foreach ($BetManager as $key => $val) {
         if(!in_array($val['parent_id'],array(0,-1))){
               $explode = explode(' ', $val['betdate']);
               $data1['betdate'] = $explode[0];
               $data1['bettime'] = $explode[1];
               $data1['status'] = $val['status'];
               $data1['betcatid'] = $val['betcategory_id'];
               $data1['betcatname'] = $val['betcategory1']['name'];
               $data1['competion'] = $val['competion']['name'];
               $data1['tiptype'] = $val['tiptype']['name'];
               $data1['tiptypeid'] = $val['tiptype']['id'];
               $data1['sport'] = $val['sport']['name'];
               $data1['odds'] = $val['odds'];
               $data1['odd'] = $val['odds'];
               $data1['trustnote'] = $val['trustnote'];
               $data1['actualtip'] = $val['actualtip'];
               if($val['whois_playing1']['type']=='Team' || $val['whois_playing1']['type']=='team'){
                       $data1['wostype'] = 'Team';
                       $teamnamea = Team::where('id',$val['whois_playing1']['teama'])->value('name'); 
                       $teamnameb = Team::where('id',$val['whois_playing1']['teamb'])->value('name'); 
                       $data1['teama'] = $teamnamea;
                       $data1['teamb'] = $teamnameb;
                   }else{
                      $data1['wostype'] = 'Individual';
                       $playera = Player::where('id',$val['whois_playing1']['playera'])->value('name'); 
                       $playerb = Player::where('id',$val['whois_playing1']['playerb'])->value('name'); 
                       $data1['teama'] = $playera;
                       $data1['teamb'] = $playerb;
                   }

                   $data[$val['parent_id']]['child_bet'][] = $data1;
         }
       }
         return $data;

    }


    public function results(){
        $plans = Plan::where('status','active')->get();
                $data = $this->getbetResult();
                $betcategory = BetCategory::all()->toArray();

                // $data = $this->getbetResultpast30days();

             
               
              $profitcat1 = $profitcat2 = $profitcat3 = 0;

              foreach ($data as $key => $bets) {
                 $mincat1 = $pluscat1 = 0;
                  if($bets['betcatid']==1){
                    if($bets['status']=='Won'){
                      $p = ($bets['odds'] * 100);
                      $ps = ($p - 100);
                      $profitcat1 = $profitcat1 + $ps;
                    }else{
                         $profitcat1 = $profitcat1 -100;
                    }

                  }
                  if($bets['betcatid']==2){
                     if($bets['status']=='Won'){
                      $p = ($bets['odds'] * 100);
                      $ps = ($p - 100);
                      $profitcat2 = $profitcat2 + $ps;
                    }else{
                         $profitcat2 = $profitcat2 -100;
                    }
                    
                  }
                 if($bets['betcatid']==3){
                     if($bets['status']=='Won'){
                      $p = ($bets['odds'] * 100);
                      $ps = ($p - 100);
                      $profitcat3 = $profitcat3 + $ps;
                    }else{
                         $profitcat3 = $profitcat3 -100;
                    }

                  }
              }

              $totalsumbyCat = array(
                  'cat1'=> number_format($profitcat1,2),
                  'cat2'=> number_format($profitcat2,2),
                  'cat3'=> number_format($profitcat3,2),
                );


    



                // $dates = DB::table('bet')
                //             ->distinct()
                //             ->get([
                //                 DB::raw('YEAR(`created_at`) AS `year`'),
                //                 DB::raw('MONTH(`created_at`) AS `month`'),
                //             ])->toArray();

                $systemdates1 = $this->getbetMonth(1);
                $systemdates2 = $this->getbetMonth(2);
                $systemdates3 = $this->getbetMonth(3);
               
                return view('results',['data'=>$data,'betcategory'=>$betcategory,'systemdates1'=>$systemdates1,'systemdates2'=>$systemdates2,'systemdates3'=>$systemdates3,'totalsumbyCat'=>$totalsumbyCat],compact('plans'));
      }
       


    public function getbetResult(){
         $BetManager = Bets::with('whoisPlaying1','competion','sport','competion','tiptype')->with('betcategory1')
              ->where(function($query){
            $query->where('status', 'Lost');
            $query->orWhere('status','Won');
          })->orderBy('betdate','DESC')->get()->toArray();
          // })->whereIn('parent_id',array(0,-1))->orderBy('betdate','DESC')->get()->toArray();

         $data = array();
         foreach ($BetManager as $key => $val) {
          $key = $val['id'];
          if(in_array($val['parent_id'],array(0,-1))){
           $explode = explode(' ', $val['betdate']);
           $data[$key]['betdate'] = $explode[0];
           $data[$key]['bettime'] = $explode[1];
           $data[$key]['status'] = $val['status'];
           $data[$key]['betcatid'] = $val['betcategory_id'];
           $data[$key]['betcatname'] = $val['betcategory1']['name'];
           $data[$key]['competion'] = $val['competion']['name'];
           $data[$key]['tiptype'] = $val['tiptype']['name'];
           $data[$key]['tiptypeid'] = $val['tiptype']['id'];
           $data[$key]['sport'] = $val['sport']['name'];
           $data[$key]['odds'] = $val['finalodds'];
           $data[$key]['odd'] = $val['odds'];
           $data[$key]['parent_id'] = $val['parent_id'];
           $data[$key]['trustnote'] = $val['trustnote'];
           $data[$key]['actualtip'] = $val['actualtip'];
           if($val['whois_playing1']['type']=='Team' || $val['whois_playing1']['type']=='team'){

                   $data[$key]['wostype'] = 'Team';
                   $teamnamea = Team::where('id',$val['whois_playing1']['teama'])->value('name'); 
                   $teamnameb = Team::where('id',$val['whois_playing1']['teamb'])->value('name'); 
                   $data[$key]['teama'] = $teamnamea;
                   $data[$key]['teamb'] = $teamnameb;
               }else{
                  $data[$key]['wostype'] = 'Individual';
                   $playera = Player::where('id',$val['whois_playing1']['playera'])->value('name'); 
                   $playerb = Player::where('id',$val['whois_playing1']['playerb'])->value('name'); 
                   $data[$key]['teama'] = $playera;
                   $data[$key]['teamb'] = $playerb;
               }

               if($val['parent_id'] == 0){
               $data[$key]['child_bet'] = array();
               } else {
                $data[$key]['child_bet'][] = $data[$key];
               }
               
         }

        } 

         foreach ($BetManager as $key => $val) {
         if(!in_array($val['parent_id'],array(0,-1))){
               $explode = explode(' ', $val['betdate']);
               $data1['betdate'] = $explode[0];
               $data1['bettime'] = $explode[1];
               $data1['status'] = $val['status'];
               $data1['betcatid'] = $val['betcategory_id'];
               $data1['betcatname'] = $val['betcategory1']['name'];
               $data1['competion'] = $val['competion']['name'];
               $data1['tiptype'] = $val['tiptype']['name'];
               $data1['tiptypeid'] = $val['tiptype']['id'];
               $data1['sport'] = $val['sport']['name'];
               $data1['odds'] = $val['odds'];
               $data1['odd'] = $val['odds'];
               $data1['trustnote'] = $val['trustnote'];
               $data1['actualtip'] = $val['actualtip'];
               if($val['whois_playing1']['type']=='Team' || $val['whois_playing1']['type']=='team'){
                       $data1['wostype'] = 'Team';
                       $teamnamea = Team::where('id',$val['whois_playing1']['teama'])->value('name'); 
                       $teamnameb = Team::where('id',$val['whois_playing1']['teamb'])->value('name'); 
                       $data1['teama'] = $teamnamea;
                       $data1['teamb'] = $teamnameb;
                   }else{
                      $data1['wostype'] = 'Individual';
                       $playera = Player::where('id',$val['whois_playing1']['playera'])->value('name'); 
                       $playerb = Player::where('id',$val['whois_playing1']['playerb'])->value('name'); 
                       $data1['teama'] = $playera;
                       $data1['teamb'] = $playerb;
                   }

                   $data[$val['parent_id']]['child_bet'][] = $data1;
         }
       }
         return $data;

    }

    /*public function getmonthresult(){
        $data = BetManager::where(function($query){
				    $query->where('status', 'Lost');
				    $query->orWhere('status','Won');
			  	})->select(
            DB::raw('sum(finalodds) as sums'), 
            DB::raw('count(id) as number'),
            DB::raw('avg(finalodds) as averageodds'), 
            DB::raw("DATE_FORMAT(created_at,'%M') as months"),'status','betcategory_id'
            )
          ->groupBy('months','status','betcategory_id')
          ->get()->toArray();
          $dtArray = array();
          foreach ($data as $key => $value) {
             $dtArray[$value['betcategory_id']][date("n", strtotime($value['months']))][] = array(
                   'numberofbets' => $value['number'],
                   'averageodds' => $value['averageodds'],
                   'status' => $value['status'],
                   'sums' => $value['sums'],
                   'betcat' => $value['betcategory_id']
              );
          }
          /*echo "<pre>";
          print_r($dtArray);
          die();
        $updatedArray = array();
        if(isset($dtArray[1])){
        foreach ($dtArray[1] as $key => $value) {
           $counterWin = $counterLoss = $betsnumber  = $sum = $aveodds = 0; 
           foreach ($value as $ke => $val) {
             if($val['status']=='Won' || $val['status']=='won'){
              $counterWin++;
             }else{
               $counterLoss++;
             }
             $betsnumber = $betsnumber + $val['numberofbets'];
             $sum = $sum + $val['sums']; 
             $aveodds = $aveodds + $val['averageodds'];  
           }
           $winpercent = ($counterWin * 100/ $betsnumber);
           $losspercent = ($counterLoss * 100/ $betsnumber);
           $p = (($sum * 100) - 100);
           $pr = (($counterWin * $p) - ($counterLoss * $p));
           $updatedArray[$key] = array(
                 'total' => $betsnumber,
                 'sum' => $sum,
                 'totalAverageOdds' => $aveodds,
                 'winpercent' => number_format($winpercent,2),
                 'losspercent' =>  number_format($losspercent,2),
                 'profit' => number_format($pr,2), 
               );

        }
      }
        $updatedArray1 = array();
        if(isset($dtArray[2])){
        foreach ($dtArray[2] as $key => $value) {
           $counterWin = $counterLoss = $betsnumber  = $sum = $aveodds = 0; 
           foreach ($value as $ke => $val) {
             if($val['status']=='Won' || $val['status']=='won'){
              $counterWin++;
             }else{
               $counterLoss++;
             }
             $betsnumber = $betsnumber + $val['numberofbets'];
             $sum = $sum + $val['sums']; 
             $aveodds = $aveodds + $val['averageodds'];  
           }
           $winpercent = ($counterWin * 100/ $betsnumber);
           $losspercent = ($counterLoss * 100/ $betsnumber);
           $p = (($sum * 100) - 100);
           $pr = (($counterWin * $p) - ($counterLoss * $p));
           $updatedArray1[$key] = array(
                 'total' => $betsnumber,
                 'sum' => $sum,
                 'totalAverageOdds' => $aveodds,
                 'winpercent' => number_format($winpercent,2),
                 'losspercent' => number_format($losspercent,2),
                 'profit' => number_format($pr,2), 
               );

        }
      }
        $updatedArray2 = array();
        if(isset($dtArray[3])){
        foreach ($dtArray[3] as $key => $value) {
           $counterWin = $counterLoss = $betsnumber  = $sum = $aveodds = 0; 
           foreach ($value as $ke => $val) {
             if($val['status']=='Won' || $val['status']=='won'){
              $counterWin++;
             }else{
               $counterLoss++;
             }
             $betsnumber = $betsnumber + $val['numberofbets'];
             $sum = $sum + $val['sums']; 
             $aveodds = $aveodds + $val['averageodds'];  
           }
           $winpercent = ($counterWin * 100/ $betsnumber);
           $losspercent = ($counterLoss * 100/ $betsnumber);
           $p = (($sum * 100) - 100);
           $pr = (($counterWin * $p) - ($counterLoss * $p));
           $updatedArray2[$key] = array(
                 'total' => $betsnumber,
                 'sum' => $sum,
                 'totalAverageOdds' => $aveodds,
                 'winpercent' => number_format($winpercent,2),
                 'losspercent' => number_format($losspercent,2),
                 'profit' => number_format($pr,2), 
               );

        }
      }

      $finalarray = array(
          'cat1' => $updatedArray,
          'cat2' => $updatedArray1,
          'cat3' => $updatedArray2
        );
      return $finalarray;
    }*/

    public function changeEmail($token,$id){
        $id = base64_decode($id);
        $user = User::where('id',$id)->where('email_token',$token)->first();
        if($user){

            if($user->new_email){
                User::where('id',$id)->update(['email' => $user->new_email,'new_email' => '','email_token' => '']);
                return redirect('/');
            } else {
                echo "url is invalid,Please update new email again";
            }

        } else {
            echo "url is invalid,Please update new email again";
        }
    }


    public function searchbymonth(Request $request){
    	 $BetManager = Bets::where('active',1)
            ->where('betcategory_id',$request->cat)
    	      ->whereYear('betdate','=',trim($request->year))
    	      ->whereMonth('betdate','=',date('m',strtotime($request->month)))
           ->with('whoisPlaying1','competion','sport','competion','tiptype')
            ->with('betcategory1')
    	      ->where(function($query){
  				    $query->where('status', 'Lost');
  				    $query->orWhere('status','Won');
          })
              // ->whereIn('parent_id',array(0,-1))
    	      ->orderBy('betdate','DESC')
    	      ->get()
    	      ->toArray();

         $profitcat1 = 0;
         $data = array();
        
             foreach ($BetManager as $keys => $val) {
               $keys = $val['id'];
            if(in_array($val['parent_id'],array(0,-1))){
               $explode = explode(' ', $val['betdate']);
               $data[$keys]['betdate'] = $explode[0]; 
               $data[$keys]['bettime'] = $explode[1]; 
               $data[$keys]['competion'] = $val['competion']['name']; 
               $data[$keys]['tiptype'] = $val['tiptype']['name']; 
               $data[$keys]['tiptypeid'] = $val['tiptype']['id']; 
               $data[$keys]['sport'] = $val['sport']['name']; 
               $data[$keys]['odds'] = number_format($val['finalodds'],2);
               $data[$keys]['odd'] = $val['odds'];
               $data[$keys]['parent_id'] = $val['parent_id'];
               $data[$keys]['status'] = $val['status']; 
               $data[$keys]['trustnote'] = $val['trustnote'];
               $data[$keys]['actualtip'] = $val['actualtip'];
               if($val['whois_playing1']['type']=='Team' || $val['whois_playing1']['type']=='team'){

                   $data[$keys]['wostype'] = 'Team';
                   $teamnamea = Team::where('id',$val['whois_playing1']['teama'])->value('name'); 
                   $teamnameb = Team::where('id',$val['whois_playing1']['teamb'])->value('name'); 
                   $data[$keys]['teama'] = $teamnamea;
                   $data[$keys]['teamb'] = $teamnameb;
               }else{
                  $data[$keys]['wostype'] = 'Individual';
                   $playera = Player::where('id',$val['whois_playing1']['playera'])->value('name'); 
                   $playerb = Player::where('id',$val['whois_playing1']['playerb'])->value('name'); 
                   $data[$keys]['teama'] = $playera;
                   $data[$keys]['teamb'] = $playerb;
               }

               if($val['parent_id'] == 0){
               $data[$keys]['child_bet'] = array();
               } else {
                $data[$keys]['child_bet'][] = $data[$keys];
               }

            }

          }

          foreach ($BetManager as $keys => $val) {
            if(!in_array($val['parent_id'],array(0,-1))){
               $explode = explode(' ', $val['betdate']);
               $data1['betdate'] = $explode[0]; 
               $data1['bettime'] = $explode[1]; 
               $data1['competion'] = $val['competion']['name']; 
               $data1['tiptype'] = $val['tiptype']['name']; 
               $data1['tiptypeid'] = $val['tiptype']['id']; 
               $data1['sport'] = $val['sport']['name']; 
               $data1['odds'] = number_format($val['finalodds'],2);
               $data1['odd'] = $val['odds'];
               $data1['status'] = $val['status']; 
               $data1['trustnote'] = $val['trustnote'];
               $data1['actualtip'] = $val['actualtip'];
               
               if($val['whois_playing1']['type']=='Team' || $val['whois_playing1']['type']=='team'){

                   $data1['wostype'] = 'Team';
                   $teamnamea = Team::where('id',$val['whois_playing1']['teama'])->value('name'); 
                   $teamnameb = Team::where('id',$val['whois_playing1']['teamb'])->value('name'); 
                   $data1['teama'] = $teamnamea;
                   $data1['teamb'] = $teamnameb;
               }else{
                  $data1['wostype'] = 'Individual';
                   $playera = Player::where('id',$val['whois_playing1']['playera'])->value('name'); 
                   $playerb = Player::where('id',$val['whois_playing1']['playerb'])->value('name'); 
                   $data1['teama'] = $playera;
                   $data1['teamb'] = $playerb;
               }

               $data[$val['parent_id']]['child_bet'][] = $data1;

            }

          }



            foreach ($data as $key => $bets) {
                 $mincat1 = $pluscat1 = 0;
                    if($bets['status']=='Won'){
                      $p = ($bets['odds'] * 100);
                      $ps = ($p - 100);
                      $profitcat1 = $profitcat1 + $ps;
                    }else{
                         $profitcat1 = $profitcat1 -100;
                    }
              
              }

          $finalarray = array(
                'serachedArray' => $data,
                'sumbycat' => number_format($profitcat1 ,2),                
              );

            //  $data['sumbycat'] = $profitcat1;

         return $finalarray;
    }

    public function getbetResultpast30days(){
        $today = date('Y-m-d H:i:s');
        $past = date('Y-m-d H:i:s', strtotime('-30 days'));
         $BetManager = Bets::with('whoisPlaying1','competion','sport','competion','tiptype')->with('betcategory1')
              ->where(function($query){
            $query->where('status', 'Lost');
            $query->orWhere('status','Won');
            })
              // ->whereIn('parent_id',array(0,-1))
            ->whereMonth('betdate',date('m'))->whereYear('betdate',date('Y'))->orderBy('betdate','DESC')->get()->toArray();
        
        $data = array();
         foreach ($BetManager as $key => $val) {
          $key = $val['id'];
          if(in_array($val['parent_id'],array(0,-1))){
           $explode = explode(' ', $val['betdate']);
           $data[$key]['betdate'] = $explode[0];
           $data[$key]['bettime'] = $explode[1];
           $data[$key]['status'] = $val['status'];
           $data[$key]['betcatid'] = $val['betcategory_id'];
           $data[$key]['betcatname'] = $val['betcategory1']['name'];
           $data[$key]['competion'] = $val['competion']['name'];
           $data[$key]['tiptype'] = $val['tiptype']['name'];
           $data[$key]['tiptypeid'] = $val['tiptype']['id'];
           $data[$key]['sport'] = $val['sport']['name'];
           $data[$key]['odds'] = $val['finalodds'];
           $data[$key]['odd'] = $val['odds'];
           $data[$key]['parent_id'] = $val['parent_id'];
           $data[$key]['trustnote'] = $val['trustnote'];
           $data[$key]['actualtip'] = $val['actualtip'];
           if($val['whois_playing1']['type']=='Team' || $val['whois_playing1']['type']=='team'){

                   $data[$key]['wostype'] = 'Team';
                   $teamnamea = Team::where('id',$val['whois_playing1']['teama'])->value('name'); 
                   $teamnameb = Team::where('id',$val['whois_playing1']['teamb'])->value('name'); 
                   $data[$key]['teama'] = $teamnamea;
                   $data[$key]['teamb'] = $teamnameb;
               }else{
                  $data[$key]['wostype'] = 'Individual';
                   $playera = Player::where('id',$val['whois_playing1']['playera'])->value('name'); 
                   $playerb = Player::where('id',$val['whois_playing1']['playerb'])->value('name'); 
                   $data[$key]['teama'] = $playera;
                   $data[$key]['teamb'] = $playerb;
               }

               if($val['parent_id'] == 0){
               $data[$key]['child_bet'] = array();
               } else {
                $data[$key]['child_bet'][] = $data[$key];
               }
               
         }

        } 

         foreach ($BetManager as $key => $val) {
         if(!in_array($val['parent_id'],array(0,-1))){
               $explode = explode(' ', $val['betdate']);
               $data1['betdate'] = $explode[0];
               $data1['bettime'] = $explode[1];
               $data1['status'] = $val['status'];
               $data1['betcatid'] = $val['betcategory_id'];
               $data1['betcatname'] = $val['betcategory1']['name'];
               $data1['competion'] = $val['competion']['name'];
               $data1['tiptype'] = $val['tiptype']['name'];
               $data1['tiptypeid'] = $val['tiptype']['id'];
               $data1['sport'] = $val['sport']['name'];
               $data1['odds'] = $val['odds'];
               $data1['odd'] = $val['odds'];
               $data1['trustnote'] = $val['trustnote'];
               $data1['actualtip'] = $val['actualtip'];
               if($val['whois_playing1']['type']=='Team' || $val['whois_playing1']['type']=='team'){
                       $data1['wostype'] = 'Team';
                       $teamnamea = Team::where('id',$val['whois_playing1']['teama'])->value('name'); 
                       $teamnameb = Team::where('id',$val['whois_playing1']['teamb'])->value('name'); 
                       $data1['teama'] = $teamnamea;
                       $data1['teamb'] = $teamnameb;
                   }else{
                      $data1['wostype'] = 'Individual';
                       $playera = Player::where('id',$val['whois_playing1']['playera'])->value('name'); 
                       $playerb = Player::where('id',$val['whois_playing1']['playerb'])->value('name'); 
                       $data1['teama'] = $playera;
                       $data1['teamb'] = $playerb;
                   }

                   $data[$val['parent_id']]['child_bet'][] = $data1;
         }
       }
         return $data;

    }

    public function getbetResultpast5days($betcategoryid){
        $today = date('Y-m-d H:i:s');
        $past = date('Y-m-d H:i:s', strtotime('-5 days'));
         $BetManager = Bets::with('whoisPlaying1','competion','sport','competion','tiptype')->with('betcategory1')
              ->where(function($query){
            $query->where('status', 'Lost');
            $query->orWhere('status','Won');
          })->where('betcategory_id',$betcategoryid)->whereBetween('betdate', [$past, $today])->orderBy('betdate','DESC')->get()->toArray();
          // })->whereIn('parent_id',array(0,-1))->whereBetween('betdate', [$past, $today])->orderBy('betdate','DESC')->get()->toArray();
              
         $data = array();
         foreach ($BetManager as $key => $val) {
          $key = $val['id'];
          if(in_array($val['parent_id'],array(0,-1))){
           $explode = explode(' ', $val['betdate']);
           $data[$key]['betdate'] = $explode[0];
           $data[$key]['bettime'] = $explode[1];
           $data[$key]['status'] = $val['status'];
           $data[$key]['betcatid'] = $val['betcategory_id'];
           $data[$key]['betcatname'] = $val['betcategory1']['name'];
           $data[$key]['competion'] = $val['competion']['name'];
           $data[$key]['tiptype'] = $val['tiptype']['name'];
           $data[$key]['tiptypeid'] = $val['tiptype']['id'];
           $data[$key]['sport'] = $val['sport']['name'];
           $data[$key]['odds'] = $val['finalodds'];
           $data[$key]['odd'] = $val['odds'];
           $data[$key]['trustnote'] = $val['trustnote'];
           $data[$key]['actualtip'] = $val['actualtip'];
           $data[$key]['parent_id'] = $val['parent_id'];
           if($val['whois_playing1']['type']=='Team' || $val['whois_playing1']['type']=='team'){

                   $data[$key]['wostype'] = 'Team';
                   $teamnamea = Team::where('id',$val['whois_playing1']['teama'])->value('name'); 
                   $teamnameb = Team::where('id',$val['whois_playing1']['teamb'])->value('name'); 
                   $data[$key]['teama'] = $teamnamea;
                   $data[$key]['teamb'] = $teamnameb;
               }else{
                  $data[$key]['wostype'] = 'Individual';
                   $playera = Player::where('id',$val['whois_playing1']['playera'])->value('name'); 
                   $playerb = Player::where('id',$val['whois_playing1']['playerb'])->value('name'); 
                   $data[$key]['teama'] = $playera;
                   $data[$key]['teamb'] = $playerb;
               }

               if($val['parent_id'] == 0){
               $data[$key]['child_bet'] = array();
               } else {
                $data[$key]['child_bet'][] = $data[$key];
               }
               
         }

        } 

         foreach ($BetManager as $key => $val) {
         if(!in_array($val['parent_id'],array(0,-1))){
               $explode = explode(' ', $val['betdate']);
               $data1['betdate'] = $explode[0];
               $data1['bettime'] = $explode[1];
               $data1['status'] = $val['status'];
               $data1['betcatid'] = $val['betcategory_id'];
               $data1['betcatname'] = $val['betcategory1']['name'];
               $data1['competion'] = $val['competion']['name'];
               $data1['tiptype'] = $val['tiptype']['name'];
               $data1['tiptypeid'] = $val['tiptype']['id'];
               $data1['sport'] = $val['sport']['name'];
               $data1['odds'] = $val['odds'];
               $data1['odd'] = $val['odds'];
               $data1['trustnote'] = $val['trustnote'];
               $data1['actualtip'] = $val['actualtip'];
               if($val['whois_playing1']['type']=='Team' || $val['whois_playing1']['type']=='team'){
                       $data1['wostype'] = 'Team';
                       $teamnamea = Team::where('id',$val['whois_playing1']['teama'])->value('name'); 
                       $teamnameb = Team::where('id',$val['whois_playing1']['teamb'])->value('name'); 
                       $data1['teama'] = $teamnamea;
                       $data1['teamb'] = $teamnameb;
                   }else{
                      $data1['wostype'] = 'Individual';
                       $playera = Player::where('id',$val['whois_playing1']['playera'])->value('name'); 
                       $playerb = Player::where('id',$val['whois_playing1']['playerb'])->value('name'); 
                       $data1['teama'] = $playera;
                       $data1['teamb'] = $playerb;
                   }

                   $data[$val['parent_id']]['child_bet'][] = $data1;
         }
       }
         return $data;

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

    /*Show which include bet data*/

    public function getbetMonth($betcatid){
        $dates = DB::table('bet')->where('betcategory_id',$betcatid)
                  ->where(function($query){
                  $query->where('status', 'Lost');
                  $query->orWhere('status','Won');
                })->whereIn('parent_id',array(0,-1))->distinct()
                            ->get([
                                DB::raw('YEAR(`betdate`) AS `year`'),
                                DB::raw('MONTH(`betdate`) AS `month`'),
                            ])->toArray();

                    $systemdates = array();
                    if(count($dates) > 0){
                    foreach (json_decode(json_encode($dates), True) as $key => $value) {
                      $systemdates[$key]  = array(
                              'monthname' => date('F',strtotime(date('Y-'.$value['month'].'-d'))),
                              'month' => date('m',strtotime(date('Y-'.$value['month'].'-d'))),
                              'year' => $value['year']
                        );
                    }
                  }
          return $systemdates;        
    }
}
