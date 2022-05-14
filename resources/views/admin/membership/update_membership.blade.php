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
                                <div class="ibox-title">Update Membership End Date</div>
                            </div>
                            <div class="ibox-body">
                            @if(!isset($membership))
                            <div class="alert1 alert-warning text-center"><strong>Warning!</strong> 
                             THIS USER NOT JOIN THE MEMBERSHIP
                            </div>

                            <div class="form-group">
                             <a class="btn btn-default" href="{{url('/admin/memberships/users')}}">Back</a>
                            </div>
                            @else
                            <form action="{{url('/admin/memberships/users/updatedate/'.$membership->id)}}" method="post">
                                 @csrf 
                                 <input type="hidden" name="membership_id" value="{{$membership->id}}">
                                    <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <label>End Date</label>
                                            <input class="form-control" readonly type="text" placeholder="Plan Name" value="{{date('d-m-Y',strtotime($membership->end_date))}}" name="name">
                                        </div>

                                        <div class="col-sm-6 form-group">
                                        <label>Change Date</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon bg-white"><i class="fa fa-calendar"></i></span>
                                        <input class="form-control required"  name="new_date" type="text" value="{{date('d-m-Y',strtotime($membership->end_date))}}">
                                    </div>
                                        </div>
                                       
                                      
                                    </div>
                                
                                    
                                    <div class="form-group">
                                     <a class="btn btn-default" href="{{url('/admin/memberships/users')}}">Back</a>
                                        <button class="btn btn-primary align-center" type="submit">Update</button>

                                    </div>
                                </form>
                            @endif
                                
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
    startDate: new Date(),
    // dateFormat: "m-d-Y",
}).on('changeDate', function(e){
    $(this).datepicker('hide');
});
</script>
@endpush