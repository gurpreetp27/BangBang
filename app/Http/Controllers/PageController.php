<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Plan;
use App\Payment;
use App\Membership;
use Auth;

class PageController extends Controller
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
 

    public function termsCondition(){
        return view('pages.terms-conditions');
    }


    public function privacyPolicy(){
        return view('pages.privacy_policy');
    }

    public function gdpr(){
        return view('pages.gdpr');
    }


}
