<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Review;



class ReviewController extends Controller
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
      public function review(){
          if(Auth::user()->name=='Admin'){
           $data = Review::orderBy('created_at','DESC')->where('is_active',1)->get()->toArray();
            
          }else{
            $dataxc = Review::where('user_id',Auth::id())->where('is_active',1)->orderBy('created_at','DESC')->first();
            $data = array();
            if($dataxc){
            $data[0]['id'] = $dataxc->id;
            $data[0]['name'] = $dataxc->name;
            $data[0]['star'] = $dataxc->star;
            $data[0]['comment'] = $dataxc->comment;
            $data[0]['created_at'] = $dataxc->created_at->format('d M,Y H:i');
            $data[0]['status'] = $dataxc->status;
          }
            //dd($data);

           /* echo "<pre>";
            print_r($data);
            die();  */
          }
          return view('admin.screen.review.review',['data'=>$data]);
      } 
      public function changeStatus(Request $request){
         $update = Review::find($request->id);
         $update->status = $request->status;
         $update->save();
         echo "success";
         exit();
      }
      public function deleteReview(Request $request){
         $update = Review::find($request->id);
         $update->is_active = 0;
         $update->save();
         echo "success";
         exit();
      }
      public function editReview($rid){
        $data = Review::find($rid);
        return view('admin.screen.review.editreview',['data'=>$data]);
      }

      public function editReviewSave(Request $request){
         $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'star' => 'required'
        ]);

        $new = Review::find($request->reviewid);
        $new->name = $request->firstName.' '. $request->lastName;
        $new->star = $request->star;
        $new->comment = $request->comment;
        $new->save();
        return redirect('admin/review/allreview')->with('success', 'Your Review Has been Successfully Updated!');

      }

      /*add review by admin*/

      public function create(Request $request){

        if(Auth::user()->role_id != 1){
          return redirect('admin/review/allreview');
          // return false;
        }

        if ($request->isMethod('post')) {
         $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'star' => 'required'
        ]);

        $new = new Review();
        $new->name = $request->firstName.' '. $request->lastName;
        $new->star = $request->star;
        $new->comment = $request->comment;
        $new->user_id = Auth::user()->id;
        $new->save();

        return redirect('admin/review/allreview')->with('success', 'Your Review Has been Successfully Added!');

      } else {
        return view('admin.screen.review.create');
      }


      }
      
    

    

}
