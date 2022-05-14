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

  <section class="wi-full py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="account-section contact-page text-left m-auto">
                       
                       @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                          {{ session('success') }}
                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                         </button>
                        </div>
                        @endif

                        <h5>{{__('member.contact_title')}}</h5>
                         <form action="{{url('/contact')}}" method="post">
                         @csrf
                            <div class="form-row mt-4">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>{{__('member.name')}}*</label>
                                        <input type="text" name="name" class="form-control" value="{{old('name')}}">
                                        @if ($errors->has('name'))
                                       <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('name') }}</strong>
                                       </span>
                                       @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>{{__('member.lastname')}}*</label>
                                        <input type="text" name="last_name" value="{{old('last_name')}}" class="form-control">
                                        @if ($errors->has('last_name'))
                                       <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('last_name') }}</strong>
                                       </span>
                                       @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>{{__('member.email')}}*</label>
                                        <input type="email" name="email" value="{{old('email')}}" class="form-control">
                                         @if ($errors->has('email'))
                                       <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('email') }}</strong>
                                       </span>
                                       @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>{{__('member.subject')}}*</label>
                                        <input type="text" name="subject" value="{{old('subject')}}" class="form-control">
                                         @if ($errors->has('subject'))
                                       <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('subject') }}</strong>
                                       </span>
                                       @endif
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>{{__('member.message')}}*</label>
                                        <textarea class="form-control" name="message">{{old('message')}}</textarea>
                                         @if ($errors->has('message'))
                                       <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('message') }}</strong>
                                       </span>
                                       @endif
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mr-auto">{{__('member.submit_btn')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endsection
    @section('js_file')
     <script src="{{asset('public/front/js/auth.js')}}"></script>
     <script src="{{asset('public/front/js/dashboard.js')}}"></script>
    @endsection