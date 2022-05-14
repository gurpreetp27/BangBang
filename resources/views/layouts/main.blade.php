<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/png" href="{{asset('public/front/images/favicon.png')}}"/>
    <link rel="shortcut icon" type="image/png" href="{{asset('public/front/images/favicon.png')}}"/>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('public/front/font.css')}}">
    <link rel="stylesheet" href="{{asset('public/front/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('public/front/css/responsive.css')}}">

     <!-- Owl Stylesheets -->
    <link rel="stylesheet" href="{{asset('public/front/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/front/css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

      @yield('css_file')
    <title>Bang! Bang!</title>
  </head>
  <style>
  .invalid-feedback{
    display: block;
  }
  </style>

  <body class="{{Session::get('locale') == ''?'en':Session::get('locale')}}">
@include('header')
@yield('content')


<div class="modal fade loginpopup" id="myModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('member.login_title') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="sign-in-form" class="sign-in-form" method="POST" action="{{ route('login') }}">
                    @csrf
                        <div class="form-group">
                            <label>{{ __('member.email') }} *</label>
                            <input type="text" name="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>{{ __('member.password') }} *</label> 
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="remember-me"><span><input id="remember-me" name="remember-me" type="checkbox"></span><span>{{ __('member.remember_me') }}</span> </label><br>

                            <button type="submit" id="btnAgentLogin" value="" class="btn btn-primary sign-in-form-button">{{ __('member.login_btn') }}</button>


                            <label class="regiter-link" style="display: block;"><a href="{{url('/')}}">{{ __('member.sign_up_btn') }}</a></label>
                        </div>
                        <div id="forgot-link">
                            <a href="{{url('/')}}/password/reset">{{ __('member.forgot_password') }}</a>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>

@include('footer')

@if(isset($not_pay_membership) && $not_pay_membership == 1 && Auth::user()->role_id == 2)
<div class="alert alert-danger alert-dismissible fade show hm-alert" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Alert!</strong><br/> You have not pay membership fee.
</div>
@endif
<script>
var site_url = "{{url('/')}}";
</script>

<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
     <script src="{{asset('public/js/jquery-3.4.1.js')}}"></script>
     <script src="{{asset('public/front/js/owl.carousel.js')}}"></script>
     <script src="{{asset('public/front/js/custom-app.js')}}"></script>

    @yield('js_file')


   
  </body>
</html>