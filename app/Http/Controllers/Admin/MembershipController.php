<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\User;
use App\Membership;
use App\EmailTemplate;
use App\Payment;
use App\AlertEmail;
use Excel;
use Mail;

class MembershipController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
        public function users()
    {
        $users = User::where('role_id',"!=",1)->with('getMembership')->get();
        $active_menu = "membership";
        return view('admin.membership.users',compact('users','active_menu'));
    } 


   public function banUser($id){

    if(Auth::user()->role_id != '1'){
        return redirect()->back()->with('error', 'You have not to access this functionality');
    }

    User::where('id',$id)->update(['status' => 'Ban']);
    return redirect()->back()->with('success', 'User status Has been Updated,Suceessfully!');
    }

    public function unbanUser($id){

    if(Auth::user()->role_id != '1'){
        return redirect()->back()->with('error', 'You have not to access this functionality');
    }

    User::where('id',$id)->update(['status' => 'Active']);
    return redirect()->back()->with('success', 'User status Has been Updated,Suceessfully!');
    }


    public function deleteUser($id){

        if(Auth::user()->role_id != '1'){
            return redirect()->back()->with('error', 'You have not to access this functionality');
        }

        User::where('id',$id)->delete();
        Membership::where('user_id',$id)->delete();
        Payment::where('user_id',$id)->delete();
        AlertEmail::where('user_id',$id)->delete();
        return redirect()->back()->with('success', 'User has been deleted Suceessfully!');
    }


     public function edit($id){
        $user = User::where('id',$id)->with('getMembership')->first();
        return view('admin.membership.edit',compact('user'));
    }

    public function update(Request $request,$id){
      if($request->isMethod('post')){

        $validatedData = $request->validate([
                'name' => 'required|string|min:4|max:255',
                'last_name' => 'required|string|min:4|max:255',
        ]);

         $user = User::find($id);
         $user->name = $request->name;
         $user->last_name = $request->last_name;
         $user->updated_at = date('Y-m-d H:i:s');
         $user->save();

         return redirect()->back()->with('success', 'User Info Has been Updated,Suceessfully!');
      } 
        
    }


    public function updateMembership(Request $request,$id){
      if($request->isMethod('post')){
       
        $validatedData = $request->validate([
                'new_date' => 'required|date_format:d-m-Y|date|after:today',
        ]);

        $membership = Membership::find($request->membership_id); 
        if($membership){
            $membership->end_date = date("Y-m-d",strtotime($request->new_date));
            $membership->save();
        }
        
        return redirect()->back()->with('success', 'User Membership End Date Has been Updated,Suceessfully!');
      }
      else {
         $membership = Membership::where('user_id',$id)->orderBy('id','desc')->first();   
         return view('admin.membership.update_membership',compact('membership'));
      }
        
    }

       public function home(){
       return view('admin.screen.dashboard');
    }

   public function logout(){
        Auth::logout();
        Session::flush();
        return redirect('admin/login');
    }


    public function exportXls()
    {
        $column_name = array('Id','First Name','Last Name','Email','Account Created ON','Membership Status','Last membership','Total Income','Last Ip');
        $users = User::where('role_id',"!=",1)->with('getMembership')->get();
            $data = array();
            foreach($users as $key=>$user) {
                $p = array();

                $getincome = Membership::where('user_id', $user['id'])->pluck('amount')->toArray();
                    $p[] = $key+1;  
                    $p[] = $user['name'];  
                    $p[] = $user['last_name'];   
                    $p[] = $user['email'];   
                    $p[] = date('d M,Y',strtotime($user['created_at']));
                    $p[] = isset($user['getMembership']['status'])?$user['getMembership']['status']:"INACTIVE";
                    $p[] = $user['getMembership']['amount'];
                    $p[] = array_sum($getincome);
                    $p[] = $user['last_country_ip'];

                    $data[] = $p;
            }


            $file_name = 'membership_details';
            // Excel Function genrate csv fule;  
            return Excel::create($file_name, function($excel) use ($data,$column_name) {
            $excel->sheet('mySheet', function($sheet) use ($data,$column_name)
            {
                $sheet->row(1, $column_name);
                $i = 2;
                foreach ($data as $key => $value) {
                     $sheet->row($i, $value);
                     $i++;
                }
                                
            });
        })->download('XLS');

    }


    public function sendMessage(Request $request){

      if($request->isMethod('post')){

        $member_type = $request->member_type;
        $message = $request->message;

        if($member_type == 2){
            $users = User::where('role_id',"!=",1)->get();
        } else {
            $active_member = Membership::where('status','ACTIVE')->get()->pluck('user_id');
            $users = User::whereIn('id',$active_member)->get();
        }

        if(count($users) > 0){
            foreach ($users as $key => $user) {
       
        $data['content'] = $message;
        $data['user'] = $user;
        $data['subject'] = 'BangBang Message';
        
        Mail::send('emails.custom_msg', $data, function($message) use($user){
                    $message->subject('BangBang Message');
                    $message->to($user->email,$user->name);
        });
        }
            }
        return redirect()->back()->with('success', 'Custom Message send Suceessfully!');
     

        
      
      } else {
        return view('admin.membership.send_message');
      }

        
    }
    /* Add Member */

    public function addMember(Request $request)
    {
        if($request->isMethod('post')){
          
           $validatedData = $request->validate([
                'name' => 'required|string|min:4|max:255',
                'last_name' => 'required|string|min:4|max:255',
                'email' => 'required|email|unique:users,email,:id',
                'end_date' => 'required|date_format:d-m-Y|date|after:today',
                'password' => 'required|string|min:6|confirmed',
            ]);

              $user = new User();
              $user->name = $request->get('name');
              $user->last_name = $request->get('last_name');
              $user->email = $request->get('email');
              $user->role_id = 2;
              $user->password = bcrypt($request->get('password'));
              $user->save();

              $start_date = date("Y-m-d");
              $end_date = date("Y-m-d",strtotime($request->get('end_date')));


              /*Save data in Membersip table*/

              $mem = new Membership();
              $mem->user_id = $user->id;
              $mem->payment_id = 0;
              $mem->plan_id = 0;
              $mem->amount = 0;
              $mem->status = "ACTIVE";
              $mem->start_date = $start_date;
              $mem->end_date = $end_date;
              $mem->is_free = 1;
              $mem->save();


              /*Send Mail to user for*/
            $template = EmailTemplate::where('title','New Member')->first();

            if($template){
                $content = $template->content;
                $subject = $template->subject;
                $message = $request->message;
                $content = str_replace('{password}', $request->get('password'), $content);
                $content = str_replace('{name}', $user->name, $content);
                $content = str_replace('{email}', $user->email, $content);
                $content = str_replace('{end_date}', $end_date, $content);
                $content = str_replace('{start_date}', $start_date, $content);
                $content = str_replace('{site_url}', url('/'), $content);

            } else {
                $content = "Your are added in bangbang site.Your membership valid ".$start_date." To ". $end_date."<br><br>Your login details are:-, <br>Email: ".$user->email."<br>Password: ".$request->get('password');
                $subject = "Add Member";
            }
 
              $data['content'] = $content;
              $data['subject'] = $subject;
              $data['user'] = $user;
              
              Mail::send('emails.simple', $data, function($message) use($user,$subject){
                    $message->subject($subject);
                    $message->to($user->email,$user->name);
              });

              return redirect("/admin/memberships/users")->with("success","New member added successfuly");

      } else {
             return view('admin.membership.create');
           }     
    } 


}
