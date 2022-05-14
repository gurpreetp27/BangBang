@extends('layouts.main')
@section('content')
@section('css_file')
<link href="{{asset('public/css/jquery-confirm.css')}}" rel="stylesheet" />
@endsection

<section class="wi-full py-5 text-center all-margin">
      <div class="container">
         <div class="title-main wi-full">
            <h2>{{__('member.update_info1')}}</h2>
         </div>
      </div>
   </section>

   <section class="wi-full py-5 update-page text-center">
      <div class="container">

         <form action="{{url('/manageaccount/user')}}" method="post">
         @csrf 
         <?php
         $chng_pass = 'none';
         if(old('is_password') == 1){
            $chng_pass = 'block';
         }
          ?>
         
         <div class="row">
            <div class="col-md-12">
               <div class="account-section contact-page update-page text-left">
                  @if (session('success'))
                
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ session('success') }}
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                 </button>
            
                </div>
            @endif
              


                  <div class="border-div">
                     <h5>{{__('member.info')}}</h5>
                     <a href="javascript:void(0);" onclick="deleteOwnAccount();" class="btn btn-submit ml-auto">{{__('member.delete_acc_btn')}}</a>
                  </div>
                  <div class="form-row mt-4">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label>{{__('member.name')}}</label>
                           <input class="form-control" type="text" placeholder="Name" value="{{$user['name']}}" name="name">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label>{{__('member.lastname')}}</label>
                           <input class="form-control" type="text" placeholder="Last Name" name="last_name" value="{{$user['last_name']}}">
                        </div>
                     </div>
                     <div class="col-sm-12">
                        <div class="form-group">
                           <label>{{__('member.change_password')}}</label><label><input type="checkbox" name="is_password" {{old('is_password') == 1?'checked':''}}  value="1" class="ml-2 is_password"></label>
                        </div>
                     </div>

                     <div class="col-sm-12 chng_pass" style="display: {{$chng_pass}};">
                        <div class="form-group">
                           <label>{{__('member.old_password')}}</label><label></label>
                            <input class="form-control" type="password" placeholder="Old Password" value=""  name="old_password">
                                       @if ($errors->has('old_password'))
                                       <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('old_password') }}</strong>
                                       </span>
                                       @endif
                        </div>
                     </div>
                     
                     <div class="col-sm-6 box chng_pass" style="display: {{$chng_pass}};">
                        <div class="form-group">
                           <label>{{__('member.new_password')}}</label>
                            <input class="form-control" type="password" placeholder="Password" name="password" value="">
                                       @if ($errors->has('password'))
                                       <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('password') }}</strong>
                                       </span>
                                       @endif
                        </div>
                     </div>
                     <div class="col-sm-6 box chng_pass" style="display: {{$chng_pass}};">
                        <div class="form-group">
                           <label>{{__('member.c_password')}}</label>
                            <input class="form-control" type="password" placeholder="Confirmation Password" name="password_confirmation" value="">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label>{{__('member.old_email')}}</label>
                           <input class="form-control" type="text" placeholder="Amount" name="email" disabled value="{{$user['email']}}">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label>{{__('member.new_email')}}</label>
                            <input class="form-control" type="text" placeholder="New Email" value="{{ old('new_email') }}" name="new_email">
                        </div>
                     </div>
                     <button type="submit" class="btn btn-submit mr-auto">{{__('member.submit_btn')}}</button>
                  </div>
               </div>
            </div>
            </div>
         </form>
      </div>
   </section>
@endsection

@section('js_file')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script>
 function deleteOwnAccount(){
       $.confirm({
        title: 'Confirm!',
        content: 'Are you Sure to delete own account? If you Delete the account then membership will be canceled if active - no refund.',
          buttons: {
              confirm: function () {
                  window.location.href = site_url+"/manageaccount/user/delete";
              },
              cancel: function () {
                 // return false;
              },
          }
        });
  }
(function($) {


    $(document).ready(function(){
      $(".is_password").click(function(){
         if($(".is_password").prop("checked") == true){
            $(".chng_pass").show();
         } else {
            $(".chng_pass").hide();
         }

      });
        // Add minus icon for collapse element which is open by default
        $(".collapse.show").each(function(){
         $(this).prev(".card-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");
        });
        
        // Toggle plus minus icon on show hide of collapse element
        $(".collapse").on('show.bs.collapse', function(){
         $(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");
        }).on('hide.bs.collapse', function(){
         $(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");
        });
    });
})(jQuery);
</script>
@endsection