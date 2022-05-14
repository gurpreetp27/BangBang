<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use Mail;
use Session;
use App\Sport;
use App\Competition;
use App\Player;
use App\Team;
use App\User;
use App\Membership;
use App\Tiptype;
use App\Plan;
use App\Payment;

class ManageAccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function updateInfo(Request $request){
     $user = Auth::user();
      if($request->isMethod('post')){
        $validatedData = $request->validate([
                'name' => 'required|string|min:4|max:255',
                'last_name' => 'required|string|min:4|max:255',
            ]);

        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->updated_at = date('Y-m-d H:i:s');
        $user->save();

        if($request->is_password == 1){
            $validatedData = $request->validate([
          'old_password' => 'required|min:6',
          'password' => 'required|string|min:6|confirmed',
          'old_password' => [
          'required', function ($attribute, $value, $fail) {
          if (!Hash::check($value, Auth::user()->password)) {
            $fail('Old Password didn\'t match');
          }
         },
         ],
        ]);


        $update_user_info = Auth::user();
        $update_user_info->password =  Hash::make($request['password']);
        $update_user_info->save();
        }

        if($request->new_email != ''){
           $validatedData = $request->validate([
          'new_email' => 'required|email|unique:users,email,:id',
        ]);

        do { $token = str_random(10); } 
            while (User::where("email_token", "=", $token)->first() instanceof User);

        $user = Auth::user();
        $user->new_email =  $request->new_email;
        $user->email_token =  $token;
        $user->save();

        $data = array();


        $content = "It is varification email form BangBang. You had added new email called ".$user->new_email.".Please click Confirm button then old email will be deleted from site and that email use for login and notifications.";
        $data['content'] = $content;
        $data['user'] = Auth::user();
        $data['subject'] = 'Change Email';
        $data['url'] = url('/')."/chnage/email/".$token."/".base64_encode($user->id);
        
        Mail::send('emails.blank', $data, function($message) use($user){
                    $message->subject('Change Email');
                    $message->to($user->email,$user->name);
        });
        }

       

        if($request->new_email != ''){
           return redirect()->back()->with('success', trans('member_js.user_success'));
         } else {
           return redirect()->back()->with('success', trans('member_js.user_success1'));
         }
         
      } else {
        return view('manage_account.update_info',compact('user'));
      }
        
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function getMembership(){
    $user = Auth::user();
    /* check recuring payments*/
    $re_payment = Payment::where('user_id',$user->id)->where('payment_for','Recurrency Membership')->where('status','paid')->first();

    return view('manage_account.get_membership',compact('user','re_payment'));
              
    }

    public function viewRecurrencyMembership(){
    $user = Auth::user();
    /* check recuring payments*/
    $re_payment = Payment::with('get_plan')->where('user_id',$user->id)->where('payment_for','Recurrency Membership')->where('status','paid')->first();
    return view('manage_account.view_recurrency_membership',compact('user','re_payment'));
              
    }


    public function deleteAccount(){
    $user = Auth::user();
    User::where('id',$user->id)->update(['status' => 'Delete']);
    $membership = Membership::where('user_id',$user->id)->orderBy('id','desc')->first();

    if($membership){
      Membership::where('id',$membership->id)->update(['status' => 'Canceled']);
    }

    Auth::logout();
    Session::flush();

    return redirect('/')->with('success', 'Your Account has been deleted,Suceessfully!');
    }

 



    public function changeEmail(Request $request){
        $validatedData = $request->validate([
          'email' => 'required|email|unique:users,email,:id',
        ]);

        $user = Auth::user();
        $user->new_email =  $request->email;
        $user->save();


        // $content = "It is varification email form BangBang site. You can add new email.Please click Confirm button then old email deleted from site and that email use for login and notification"
        // $data['content'] = $content;
        // $data['name'] = Auth::user()->name;
        // $data['subject'] = 'Change Email';
        
        // Mail::send('emails.notification', $data, function($message) use($email,$name){
        //             $message->subject('Add Creative');
        //             $message->to($email,$name);
        // });



        return back()->with('success', 'Varification email sent to New email, Please check link');
    }


    public function sportSave(Request $request) {
         $validatedData = $request->validate([
                'sportName' => 'required|max:255'
            ]);
         $new = new Sport;
         $new->name = $request->sportName;
         $new->status = 'active';
         $new->created_at = date('Y-m-d H:i:s');
         $new->updated_at = date('Y-m-d H:i:s');
         $new->save();
         return redirect()->back()->with('success', 'Sport Has been Added,Suceessfully!');
    }

    public function removesport(Request $request) {
        Sport::where('id', $request->id)->delete();
        echo "sucess";
        exit;
    }

   public function editsport($id){
       $sport = Sport::find($id);
       return view('admin.screen.addcontent.sport.editSport',['sport'=>$sport]);
   }
    public function editSavesport(Request $request){
        $validatedData = $request->validate([
            'sportName' => 'required|max:255'
        ]);
       $sport = Sport::find($request->aityd);
       $sport->name = $request->sportName;
       $sport->save();
       return redirect('/admin/addcontent/sport')->with('success', 'Sport Has been Updated,Suceessfully!');
   }

   public function addCompetition(){
        $sports = Competition::orderBy('created_at','DESC')->get()->toArray(); 
        return view('admin.screen.addcontent.competition.addCompetition',['sports'=>$sports]);
    }

    public function competitionSave(Request $request) {
          $validatedData = $request->validate([
                'competitionName' => 'required|max:255'
            ]);
         $new = new Competition;
         $new->name = $request->competitionName;
         $new->status = 'active';
         $new->created_at = date('Y-m-d H:i:s');
         $new->updated_at = date('Y-m-d H:i:s');
         $new->save();
         return redirect()->back()->with('success', 'Competition Has been Added,Suceessfully!');
    }
    public function removecompetition(Request $request) {
        Competition::where('id', $request->id)->delete();
        echo "sucess";
        exit;
    }
    public function editCompetition($id){
       $sport = Competition::find($id);
       return view('admin.screen.addcontent.competition.editCompetition',['sport'=>$sport]);
   }
   public function editSaveCompetition(Request $request){
        $validatedData = $request->validate([
            'CompetitionName' => 'required|max:255'
        ]);
       $sport = Competition::find($request->aityd);
       $sport->name = $request->CompetitionName;
       $sport->save();
       return redirect('/admin/addcontent/competition')->with('success', 'Competition Has been Updated,Suceessfully!');
   }



   public function addplayer(){
        $sports = Player::orderBy('created_at','DESC')->get()->toArray(); 
        return view('admin.screen.addcontent.player.addPlayer',['sports'=>$sports]);
    }

    public function playerSave(Request $request) {
          $validatedData = $request->validate([
                'PlayerName' => 'required|max:255'
            ]);
         $new = new Player;
         $new->name = $request->PlayerName;
         $new->status = 'active';
         $new->created_at = date('Y-m-d H:i:s');
         $new->updated_at = date('Y-m-d H:i:s');
         $new->save();
         return redirect()->back()->with('success', 'Player Has been Added,Suceessfully!');
    }
    public function removeplayer(Request $request) {
        Player::where('id', $request->id)->delete();
        echo "sucess";
        exit;
    }
    public function editplayer($id){
       $sport = Player::find($id);
       return view('admin.screen.addcontent.player.editPlayer',['sport'=>$sport]);
   }
   public function editSaveplayer(Request $request){
        $validatedData = $request->validate([
            'PlayerName' => 'required|max:255'
        ]);
       $sport = Player::find($request->aityd);
       $sport->name = $request->PlayerName;
       $sport->save();
       return redirect('/admin/addcontent/player')->with('success', 'Player Has been Updated,Suceessfully!');
   }





   public function addteam(){
        $sports = Team::orderBy('created_at','DESC')->get()->toArray(); 
        return view('admin.screen.addcontent.team.addteam',['sports'=>$sports]);
    }

    public function teamSave(Request $request) {
          $validatedData = $request->validate([
                'teamName' => 'required|max:255'
            ]);
         $new = new Team;
         $new->name = $request->teamName;
         $new->status = 'active';
         $new->created_at = date('Y-m-d H:i:s');
         $new->updated_at = date('Y-m-d H:i:s');
         $new->save();
         return redirect()->back()->with('success', 'Team Has been Added,Suceessfully!');
    }
    public function removeteam(Request $request) {
        Team::where('id', $request->id)->delete();
        echo "sucess";
        exit;
    }
    public function editteam($id){
       $sport = Team::find($id);
       return view('admin.screen.addcontent.team.editteam',['sport'=>$sport]);
   }
   public function editSaveteam(Request $request){
        $validatedData = $request->validate([
            'teamName' => 'required|max:255'
        ]);
       $sport = Team::find($request->aityd);
       $sport->name = $request->teamName;
       $sport->save();
       return redirect('/admin/addcontent/team')->with('success', 'Team Has been Updated,Suceessfully!');
   }




    public function addtiptype(){
        $sports = Tiptype::orderBy('created_at','DESC')->get()->toArray(); 
        return view('admin.screen.addcontent.tiptype.addtiptype',['sports'=>$sports]);
    }

    public function tiptypeSave(Request $request) {
          $validatedData = $request->validate([
                'tiptypeName' => 'required|max:255'
            ]);
         $new = new Tiptype;
         $new->name = $request->tiptypeName;
         $new->status = 'active';
         $new->created_at = date('Y-m-d H:i:s');
         $new->updated_at = date('Y-m-d H:i:s');
         $new->save();
         return redirect()->back()->with('success', 'Tiptype Has been Added,Suceessfully!');
    }
    public function removetiptype(Request $request) {
        Tiptype::where('id', $request->id)->delete();
        echo "sucess";
        exit;
    }
    public function edittiptype($id){
       $sport = Tiptype::find($id);
       return view('admin.screen.addcontent.tiptype.edittiptype',['sport'=>$sport]);
   }
   public function editSavetiptype(Request $request){
        $validatedData = $request->validate([
            'tiptypeName' => 'required|max:255'
        ]);
       $sport = Tiptype::find($request->aityd);
       $sport->name = $request->tiptypeName;
       $sport->save();
       return redirect('/admin/addcontent/tiptype')->with('success', 'Tiptype Has been Updated,Suceessfully!');
   }


   public function addplan(){
        $sports = Plan::orderBy('created_at','DESC')->get()->toArray(); 
        return view('admin.screen.addcontent.plan.addplan',['sports'=>$sports]);
   }

   public function planSave(Request $request){
         $validatedData = $request->validate([
                'planName' => 'required|max:255',
                'amount' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                'duration' => 'required|integer|min:1|digits_between: 1,8' 
            ]);
         $new = new Plan;
         $new->name = $request->planName;
         $new->amount = $request->amount;
         $new->duration = $request->duration;
         $new->status = 'active';
         $new->stats = $request->stats;
         $new->created_at = date('Y-m-d H:i:s');
         $new->updated_at = date('Y-m-d H:i:s');
         $new->save();
         return redirect()->back()->with('success', 'Plan Has been Added,Suceessfully!');
   }

   public function removeplan(Request $request){
        Plan::where('id', $request->id)->delete();
        echo "sucess";
        exit;
   }

   public function editplan($id){
       $sport = Plan::find($id);
       return view('admin.screen.addcontent.plan.editplan',['sport'=>$sport]);
   }

   public function editSaveplan(Request $request){
         $validatedData = $request->validate([
                'planName' => 'required|max:255',
                'amount' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                'duration' => 'required|integer|min:1|digits_between: 1,8' 
            ]);
         $new = Plan::find($request->aityd);
         $new->name = $request->planName;
         $new->amount = $request->amount;
         $new->duration = $request->duration;
         $new->status = 'active';
         $new->stats = $request->stats;
         $new->created_at = date('Y-m-d H:i:s');
         $new->updated_at = date('Y-m-d H:i:s');
         $new->save();
         return redirect('/admin/addcontent/plan')->with('success', 'Plan Has been Updated,Suceessfully!');
   }


   public function getRenew(){

      $user = Auth::user();
      $membership = Membership::where('user_id',$user->id)->orderBy('id','desc')->first();
      $plans = Plan::where('status','active')->get();
      $user = Auth::user();
      return view('manage_account.renew',compact('plans','user'));
   }

   /*It used to add user in */
   public function recurrencyMembership($type){
      $user = Auth::user();
      $membership = Membership::where('user_id',$user->id)->orderBy('id','desc')->first();
      $plans = Plan::where('status','active')->get();
      if($type == 'current'){
        $plan = Plan::where('id',$membership->plan_id)->first();
      }

       $re_payment = Payment::with('get_plan')->where('user_id',$user->id)->where('payment_for','Recurrency Membership')->where('status','paid')->first();
          
          if($re_payment){
            return view('manage_account.view_recurrency_membership',compact('user','re_payment'));
            exit;
          }

      return view('manage_account.recurrency_membership',compact('plans','plan','user','type'));
   }

  



   

}
