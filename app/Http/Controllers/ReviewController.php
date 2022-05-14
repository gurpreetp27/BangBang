<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Plan;
use App\Payment;
use App\Membership;
use Auth;
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
        $this->setLocale();
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

     public function review(){
          
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
        
          return view('review.allreview',['data'=>$data]);
      }

    public function saveReview(Request $request){
        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'star' => 'required'
        ]);

        $new = new Review;
        $new->user_id = Auth::id();
        $new->name = $request->firstName.' '. $request->lastName;
        $new->star = $request->star;
        $new->comment = $request->comment;
        $new->save();
        return redirect()->back()->with('success', 'Your Review Has been Successfully Submitted!');

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
        return view('review.editreview',['data'=>$data]);
      }

      public function editReviewSave(Request $request){
        // echo "<pre>";
        // print_r($request->all());
        // die();
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
        return redirect('review/allreview')->with('success', 'Your Review Has been Successfully Updated!');

      }



}
