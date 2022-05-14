@extends('layouts.main')
@section('content')
@section('css_file')
<link href="{{asset('public/css/jquery-confirm.css')}}" rel="stylesheet" />
@endsection

<section class="wi-full py-5 text-center all-margin">
    <div class="container">
      <div class="title-main wi-full">
        <h2>{{__('member.membership')}}</h2>
      </div>
       <?php $days = 0; ?>
      @if(isset($user['getMembership']))
      <?php
      $date1 = date("Y-m-d");
      $date2 = date("Y-m-d",strtotime($user['getMembership']['end_date']));

      $date1=date_create($date1);
      $date2=date_create($date2);

      $diff=date_diff($date1,$date2);
      $days = $diff->format("%R%a");


       ?>
      <div class="wi-full membership-frontend pt-5">
        <div class="row">
          <div class="col-sm-12">
          @if($days > 0)
          <?php $days = str_replace("+",'',$days); ?>
            <?php echo __('member.your_mem_'); ?>
            {{$user['getMembership']['end_date']}}</strong> 
            <span class="badge badge-danger">{{$days}} <?php echo __('member.day_left'); ?></span>
            </p>
             
             @if($re_payment)
            <a href="{{url('/manageaccount/view/recurrency')}}" class="btn btn-renew btn-sucess">{{__('member.VIEWRECURRENCY')}}</a>
            @else

            <a href="javascript:void('0');" onclick=renewnow({{$days}}) class="btn btn-renew btn-sucess">{{__('member.renew_now')}}</a>
            
            @if($user['getMembership']['is_free'] == 1)
                <a href="javascript:void(0);" onclick=activeRecurrency2() class="btn btn-renew btn-sucess">{{__('member.ACTIVATERECURRENCY')}}</a>
             @else
                <a href="javascript:void(0);" onclick=activeRecurrency() class="btn btn-renew btn-sucess">{{__('member.ACTIVATERECURRENCY')}}</a>
             @endif


            @endif

          @else
         
             
          <?php echo __('member.has_exp'); ?>
            <!-- <span class="badge badge-danger">{{$days}} Days Left</span> -->
            </p>
             <a href="javascript:void('0');" onclick=renewnow("expire") class="btn btn-renew btn-sucess">{{__('member.renew_now')}}</a>
          @endif
          </div>
        </div>
      </div>
@else
      <div class="wi-full membership-frontend pt-5">
        <div class="row">
          <div class="col-sm-12">
            
          <?php echo __('member.no_ave_ab'); ?>
            <a href="{{url('/bets-day')}}" class="btn btn-renew btn-danger">{{__('member.let_start')}}</a>
          </div>
        </div>
      </div>
    </div>
 @endif   
  </section>

@endsection
@section('js_file')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script>
 function renewnow(days){


      if(days == 'expire'){
        var msg = "{{trans('member_js.renew1')}}";
        
      } else {
         var msg = "{{trans('member_js.renew2',['day' => $days])}}"; 
      }
       $.confirm({
        title: "{{trans('member_js.confirm')}}!",
        content: msg,
          buttons: {
              "{{trans('member_js.confirm')}}": function () {
                 window.location.href = site_url+"/manageaccount/renew/membership";
              },
              "{{trans('member_js.cancel')}}": function () {
                 // return false;
              },
          }
        });
  }


  function activeRecurrency(){
       $.confirm({
        title: "{{trans('member_js.confirm')}}!",
        content: "{{trans('member_js.renew3')}}",
          buttons: {
              "{{trans('member_js.continuous')}}": function () {
                window.location.href = site_url+"/manageaccount/recurrency/membership/current";
                           },
              Different_Membership: function () {
                window.location.href = site_url+"/manageaccount/recurrency/membership/other";
                               },
              "{{trans('member_js.cancel')}}": function () {
                 // return false;
              },

          }
        });
  }


    function activeRecurrency2(){
       $.confirm({
        title: "{{trans('member_js.confirm')}}!",
        content: "{{trans('member_js.renew3')}}",
          buttons: {
              Different_Membership: function () {
                window.location.href = site_url+"/manageaccount/recurrency/membership/other";
                               },
              "{{trans('member_js.cancel')}}": function () {
                 // return false;
              },

          }
        });
  }

</script>
@endsection