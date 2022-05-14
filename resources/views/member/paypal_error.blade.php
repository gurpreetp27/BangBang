@extends('layouts.main')
@section('content')

    <section class="banner-section wi-full all-margin" style="background-image: url({{url('/public/front')}}/images/banner-new.jpg);">
        <div class="container">
            <div class="banner-text">
                <h1>Spargem <br/>
                    casieriaaa!</h1>
            </div>
        </div>
    </section>

 <section class="wi-full py-5 thankyou-page">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <img src="{{asset('public/front/images/tick.png')}}">
                   
                     <h2>Error!</h2>
                     <p>Something went wrong please try again.</p>
                    
                   
                
                    <a class="btn btn-backhome" href="{{url('/')}}"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> BACK TO DASHBOARD</a>
                </div>
            </div>
        </div>
    </section>
    @endsection