@extends('layouts.main')
@section('content')
<style>
.testimonial-part{
    height: 480px;
}
@media (max-width: 1199px){
.testimonial-part{
    height: 450px;
}
}
@media (max-width: 767px){
.testimonial-part {
    height: auto;
}
}
</style>
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

        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="title-main wi-full text-center mb-5">
                <h2>{{__('member.reviews_menu')}}</h2>
            </div>
            <div class="testimonial-section wi-full">
                <div class="row">
                  @if($data)
                   @foreach($data as $rev)
                    <div class="col-md-4 item text-center">
                        <div class="testimonial-part">
                            <div class="rating2">
                               @for($i = 1; $i < 6;$i++)
                                  @if($i <= $rev->star)
                                     <span class="active">☆</span>
                                  @else
                                  <span>☆</span>
                                  @endif 
                                @endfor
                            </div>
                           
                            <p>{{trim($rev->comment)}}</p>
                          
                            <h5>{{$rev->name}}</h5>
                            <!-- <h6>Phelps</h6> -->
                            
                        </div>
                    </div>
                    @endforeach
                   @endif 
                
                </div>
                <nav class="mt-3">
                {{ $data->links() }}
                </nav>
            </div>
        </div>
    </section>
   @if($isreviewed < 1)
   @if(Auth::check() && Auth::user()->role_id == 2)
    <section class="wi-full py-5">
        <div class="container">
            <div class="row">
            <div class="col-md-12">
                    <div class="account-section contact-page text-left m-auto">
                        <h5>{{__('member.review_title1')}}</h5>
                        <form action="{{url('reviews/savereview')}}" method="post">
                         @csrf
                            <div class="form-row mt-4">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>{{__('member.name')}}*</label>
                                        <input type="text" class="form-control" name="firstName">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>{{__('member.lastname')}}</label>
                                        <input type="text" class="form-control" name="lastName">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>{{__('member.comment')}}</label>
                                        <textarea class="form-control" name="comment"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="rating">
                                        <input id="star5" name="star" type="radio" value="5" class="radio-btn hide" required="">
                                        <label for="star5">☆</label>
                                        <input id="star4" name="star" type="radio" value="4" class="radio-btn hide">
                                        <label for="star4">☆</label>
                                        <input id="star3" name="star" type="radio" value="3" class="radio-btn hide">
                                        <label for="star3">☆</label>
                                        <input id="star2" name="star" type="radio" value="2" class="radio-btn hide">
                                        <label for="star2">☆</label>
                                        <input id="star1" name="star" type="radio" value="1" class="radio-btn hide">
                                        <label for="star1">☆</label>
                                        <div class="clear"></div>
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
    @endif
   @endif 
    @endsection
    @section('js_file')
     <script src="{{asset('public/front/js/auth.js')}}"></script>
     <script src="{{asset('public/front/js/dashboard.js')}}"></script>
    @endsection