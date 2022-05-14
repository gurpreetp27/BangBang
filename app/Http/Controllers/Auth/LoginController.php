<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

      protected function authenticated(Request $request, $user)
    {

        
        User::where('id', $user->id)->update(['last_country_ip' => isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'']);
         Session::put('locale', 'en');
         if ($request->ajax() && $user)
        {
            return response()->json([
            'success' => true,
            'auth' => '1'
        ]);
            exit;
        }
       
        
        $is_admin = str_replace(url('/').'/', '', url()->previous());

        if($is_admin == 'admin/login'){
            return redirect('admin/home');
            exit;
        }

    }  
}
