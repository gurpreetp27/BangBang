<header>
<?php
use Illuminate\Support\Facades\Route;
$current_r = Route::getFacadeRoot()->current()->uri();

?>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
              <a class="navbar-brand" href="{{url('/')}}"><img src="{{asset('public/front/images/logo_bang_bang.png')}}"></a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>

              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                  <li class="nav-item @if($current_r == '/' || $current_r == 'home') active @endif"">
                    <a class="nav-link" href="{{url('/')}}">{{__('member.home_menu')}}</a>
                  </li>
                  <li class="nav-item @if($current_r == 'bets-day') active @endif">
                    <a class="nav-link" href="{{url('/bets-day')}}">{{__('member.bet_menu')}}</a>
                  </li>
                  <li class="nav-item @if($current_r == 'results') active @endif">
                    <a class="nav-link" href="{{url('/results')}}">{{__('member.results_menu')}}</a>
                  </li>
                  <li class="nav-item @if($current_r == 'reviews') active @endif">
                    <a class="nav-link" href="{{url('/reviews')}}">{{__('member.reviews_menu')}}</a>
                  </li>
                  
                  <li class="nav-item @if($current_r == 'contact') active @endif">
                    <a class="nav-link" href="{{url('/contact')}}">{{__('member.contact_menu')}}</a>
                  </li>  
                @if(Auth::check() && Auth::user()->role_id == 2)  
                <li class="nav-item dropdown @if(Request::segment(1)=='manageaccount') active @endif">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{__('member.my_account_menu')}}</a>
                <div class="dropdown-menu">
                  <a class="dropdown-item @if(Request::segment(1)=='manageaccount' && Request::segment(2)=='user') active @endif" href="{{url('/manageaccount/user')}}">{{__('member.my_account_menu1')}}</a>
                  <a class="dropdown-item @if(Request::segment(1)=='manageaccount' && Request::segment(2)=='membership') active @endif" href="{{url('/manageaccount/membership')}}">{{__('member.my_account_menu2')}}</a>
                  <a class="dropdown-item" href="{{url('/bets-day')}}">{{__('member.my_account_menu3')}}</a>
                  <a class="dropdown-item" href="{{url('/results')}}">{{__('member.my_account_menu4')}}</a>
                  <a class="dropdown-item @if(Request::segment(1)=='review' && Request::segment(2)=='allreview') active @endif" href="{{url('/review/allreview')}}">{{__('member.my_account_menu5')}}</a>
                </div>
              </li>
              @endif                                                     
                </ul>
              </div>

              <div class="headerbtn-signup">
                <ul>
                    @if(!Auth::check())
                        <li class="active"><a href="{{url('/bets-day')}}">{{__('member.sign_up_menu')}}</a></li>
                        <li><a href="#myModal" data-toggle="modal">{{__('member.login_menu')}}</a></li>
                    @else
                        <li><a href="{{url('/user/logout')}}">{{__('member.logout_menu')}}</a></li>
                    @endif
                </ul>
              </div>

               <div class="header-language">
                <ul>
                    <li class="@if(Session::get('locale') == 'en' || Session::get('locale') == '') active @endif"><a href="{{url('/en')}}">EN</a></li>
                    <li class="@if(Session::get('locale') == 'de') active @endif"><a href="{{url('/de')}}">DE</a></li>
                    <li class="@if(Session::get('locale') == 'ro') active @endif"><a href="{{url('/ro')}}">RO</a></li>
                </ul>
              </div>
            </div>
        </nav>
    </header>