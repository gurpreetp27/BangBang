@extends('layouts.main')
@section('content')

<section class="wi-full py-5 all-margin">
        <div class="container">
            <div class="title-main wi-full text-center">
                <h2>EDIT REVIEWS</h2>
            </div>
            <div class="wi-full pt-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="account-section contact-page text-left m-auto">
                        <h5>Testimonial Reviews Form</h5>
                        <form action="{{url('review/edit/save')}}" method="post">
                        @csrf
                         <?php
                              $explod = explode(' ', $data->name);

                            ?>
                            <div class="form-row mt-4">
                            <input type="hidden" name="reviewid" value="{{$data->id}}">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>First Name*</label>
                                        <input type="text" class="form-control" value="{{$explod[0]}}" name="firstName">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Last Name*</label>
                                        <input type="text" class="form-control" value="{{$explod[1]}}" name="lastName">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Comment*</label>
                                        <textarea class="form-control" name="comment">{{$data->comment}}</textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Star</label>
                                        <select class="form-control" name="star">
                                           <option value="1" @if($data->star==1) selected @endif>1</option>
                                            <option value="2" @if($data->star==2) selected @endif>2</option>
                                            <option value="3" @if($data->star==3) selected @endif>3</option>
                                            <option value="4" @if($data->star==4) selected @endif>4</option>
                                            <option value="5" @if($data->star==5) selected @endif>5</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mr-auto">SUBMIT</button>
                            </div>
                        </form>
                    </div>
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