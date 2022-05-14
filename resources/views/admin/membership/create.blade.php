@extends('admin.layout.main')
@section('title','BangBang DashBoard')
@push('styles')

  <link href="{{asset('public/adminn/assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" />
  <link href="{{asset('public/adminn/assets/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" />
 <style>
   .btn-group.open ul.dropdown-menu {
    top: -11px!important;
}

.alert1 {
    padding: .75rem 1.25rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: .25rem;
}
 </style>
@endpush
@section('content')
            <div class="page-content fade-in-up">
                <div class="row">
                    <div class="col-md-6">
                        <div class="ibox">
                            <div class="ibox-head">
                                <div class="ibox-title">Add Member</div>
                            </div>
                            <div class="ibox-body">
                                <form action="{{url('admin/memberships/add/user')}}" method="post">
                                 @csrf 
                                  <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <label>Name</label>
                                            <input class="form-control" type="text" placeholder="Name" value="{{old('name')}}" name="name" autocomplete="off">
                                             @if ($errors->has('name'))
                                               <span class="invalid-feedback" role="alert">
                                               <strong>{{ $errors->first('name') }}</strong>
                                               </span>
                                            @endif
                                        </div>

                                        <div class="col-sm-6 form-group">
                                            <label>Last Name</label>
                                            <input class="form-control" type="text" placeholder="Last Name" name="last_name" value="{{old('last_name')}}" autocomplete="off">
                                             @if ($errors->has('last_name'))
                                               <span class="invalid-feedback" role="alert">
                                               <strong>{{ $errors->first('last_name') }}</strong>
                                               </span>
                                            @endif
                                        </div>

                                        <div class="col-sm-6 form-group">
                                            <label>Email</label>
                                            <input class="form-control" type="text" placeholder="Email" name="email" value="{{old('email')}}" autocomplete="off">
                                            @if ($errors->has('email'))
                                               <span class="invalid-feedback" role="alert">
                                               <strong>{{ $errors->first('email') }}</strong>
                                               </span>
                                            @endif
                                        </div>

                                        <div class="col-sm-6 form-group">
                                         <label>Membership End Date</label>
                                            <div class="input-group date">
                                                <span class="input-group-addon bg-white"><i class="fa fa-calendar"></i></span>
                                                <input class="form-control required date" name="end_date" type="text" placeholder="End date" value="{{old('end_date')}}" autocomplete="false">

                                                @if ($errors->has('end_date'))
                                               <span class="invalid-feedback" role="alert">
                                               <strong>{{ $errors->first('end_date') }}</strong>
                                               </span>
                                            @endif
                                            </div>
                                        </div>
                                      
                                        <div class="col-sm-6 form-group">
                                            <label>Password</label>
                                            <input type="password" id="password" name="password" value="{{old('password')}}" class="form-control" autocomplete="off">
                                            @if ($errors->has('password'))
                                               <span class="invalid-feedback" role="alert">
                                               <strong>{{ $errors->first('password') }}</strong>
                                               </span>
                                            @endif
                                        </div> 

                                        <div class="col-sm-6 form-group">
                                            <label>Confirm Password</label>
                                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" autocomplete="off">
                                             @if ($errors->has('password_confirmation'))
                                               <span class="invalid-feedback" role="alert">
                                               <strong>{{ $errors->first('password_confirmation') }}</strong>
                                               </span>
                                            @endif
                                        </div>
                                     
                                    </div>
                                                                    
                                    <div class="form-group">
                                        <a class="btn btn-default" href="{{Route('memberships')}}">Back</a>
                                        <button class="btn btn-primary align-center" type="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
@push('script')
<script src="{{asset('public/adminn/assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>



<script type="text/javascript">
$(".date").datepicker({
    format: 'dd-mm-yyyy',
    // startDate: new Date(),
    startDate: '+1d',
    // dateFormat: "m-d-Y",
}).on('changeDate', function(e){
    $(this).datepicker('hide');
});
</script>
@endpush
