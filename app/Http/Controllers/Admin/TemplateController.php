<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\EmailTemplate;



class TemplateController extends Controller
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
      public function getAll(){
         
          $data = EmailTemplate::all()->toArray();
          return view('admin.screen.template.alltemplate',['data'=>$data]);
      } 

      public function addnew(){
         return view('admin.screen.template.addnew');
      }
      public function addnewSave(Request $request){
         $request->validate([
            'title' => 'required',
            'subject' => 'required',
            'content' => 'required',
        ]);
         $new = new EmailTemplate;
         $new->title = $request->title;
         $new->subject = $request->subject;
         $new->content = $request->content;
         $new->save();
          return redirect('admin/template/alltemplate')->with('success', 'Your Template Has been Successfully Updated!');
        
      }
     
      public function deletetemplate(Request $request){
         $update = EmailTemplate::find($request->id)->delete();
         echo "success";
         exit();
      }
      public function editTemplate($rid){
        $data = EmailTemplate::find($rid);
        return view('admin.screen.template.edittemplate',['data'=>$data]);
      }

      public function editSave(Request $request){
         $request->validate([
            'content' => 'required',
            'subject' => 'required'
          ]);

        $new = EmailTemplate::find($request->tid);
        $new->content = $request->content;
        $new->subject = $request->subject;
        $new->save();
        return redirect('admin/template/alltemplate')->with('success', 'Your Template Has been Successfully Updated!');

      }
      
    

    

}
