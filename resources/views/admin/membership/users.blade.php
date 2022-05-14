@extends('admin.layout.main')
@section('title','Memberships')
@push('styles')
 <link href="{{asset('public/adminn/assets/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
 <link href="{{asset('public/css/jquery-confirm.css')}}" rel="stylesheet" />
 <style>
   .btn-group.open ul.dropdown-menu {
    top: -11px!important;
}
.table-responsive table {
    display: block;
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    -ms-overflow-style: -ms-autohiding-scrollbar;
}
.addcircle-img img {
    max-width: 14px;
    margin-right: 4px;
    margin-top: -2px;
}
.addcircle-img {
    margin-left: auto;
    margin-right: 13px;
}
 </style>
@endpush
@section('content')
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Membership Users</div>
                        <a href="{{url('/admin/memberships/users/send/message')}}" class="btn btn-primary ml-auto" aria-pressed="true"><i class="fa fa-envelope-o" aria-hidden="true"></i> Send Message</a>
                         <a href="{{url('/admin/memberships/add/user')}}" class="btn btn-success addcircle-img" aria-pressed="true"><img src="{{asset('public/adminn/assets/img/circle-add.png')}}" class="btn-success"> Add New Membership</img></a>
                        <a href="{{url('/admin/memberships/users/exportxls')}}" class="btn btn-success" aria-pressed="true"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Xls</a>
                    </div>
                    <div class="ibox-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                                <thead>

                                    <tr>
                                        <th>#</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email Address</th>
                                        <th>Account Created on</th>
                                        <th>Membership status</th>
                                        <th>User Status</th>
                                        <th>Last membership</th>
                                        <th>Total income</th>
                                        <th>Last IP</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @if(count($users) > 0)
                                     @php
                                      $counter = 1;
                                     
                                     @endphp
                                     @foreach($users as $key=>$user)
                                    
                                      <?php
                                      $getincome = App\Membership::where('user_id', $user['id'])->pluck('amount')->toArray();
                                     ?>
                                     <tr>
                                      <td>{{($key+1)}}</td>   
                                      <td>{{$user['name']}}</td>   
                                      <td>{{$user['last_name']}}</td>   
                                      <td>{{$user['email']}}</td>   
                                      <td>{{date('d M,Y',strtotime($user['created_at']))}}</td>
                                      <td>{{isset($user['getMembership']['status'])?$user['getMembership']['status']:"INACTIVE"}}</td>
                                      <td>{{$user['status']}}</td>  
                                      <td>{{$user['getMembership']['amount']}}</td>
                                      <td>{{array_sum($getincome)}}</td>
                                      <td>{{$user['last_country_ip']}}</td>
                                      <!-- <td></td> -->
                                      <td>
                                      <input type="hidden" name="" value="{{$user['id']}}" class="gamerId">
                                      <a href="{{url('admin/memberships/users/edit',$user['id'])}}" class="btn btn-default btn-xs m-r-5" data-original-title="Edit">    <i class="fa fa-edit font-14"></i>
                                      </a>
                                      @if($user['status'] != 'Ban')
                                      <a href="javascript:void(0);" class="btn btn-default btn-xs m-r-5 ban_user_account" data-user_id="{{$user['id']}}" title="Ban User Account">    <i class="fa fa-ban font-14" style="color: green;"></i>
                                      </a>
                                      @else 
                                      <a href="javascript:void(0);" class="btn btn-default btn-xs m-r-5 unban_user_account" data-user_id="{{$user['id']}}" title="Un Ban User Account">    <i class="fa fa-ban font-14" style="color: red;"></i>
                                      </a>
                                      @endif
                                      <br>

                                      <a href="javascript:void(0);" class="btn btn-default btn-xs deletes delete_user_account m-r-4" data-user_id="{{$user['id']}} data-original-title="Delete"> 
                                         <i class="fa fa-trash font-14"></i>
                                      </a>


                                      <a href="{{url('admin/memberships/users/updatedate',$user['id'])}}" class="btn btn-default btn-xs deletes" title="Add Membership"> 
                                         <i class="fa fa-plus font-14"></i>
                                      </a>
                                    </td>
                                    </tr>
                                 
                                     @endforeach
                                   @endif 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
@endsection
@push('script')
<script src="{{asset('public/adminn/assets/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script type="text/javascript">
var site_url = "{{url('/')}}";
  $(function() {
            $('#example-table').DataTable({
            });

   $("#example-table").on("click", ".ban_user_account", function(){
              var user_id = $(this).data('user_id');
        $.confirm({
        title: 'Confirm!',
        content: 'A banned account means that we freeze the account and there is no way a new   account with this email address can be created.',
          buttons: {
              confirm: function () {
                  window.location.href = site_url+"/admin/memberships/users/ban/"+user_id;
              },
              cancel: function () {
                 // return false;
              },
          }
        });

    }); 

       $("#example-table").on("click", ".unban_user_account", function(){
              var user_id = $(this).data('user_id');
        $.confirm({
        title: 'Confirm!',
        content: 'Are you sure unban this user?',
          buttons: {
              confirm: function () {
                  window.location.href = site_url+"/admin/memberships/users/unban/"+user_id;
              },
              cancel: function () {
                 // return false;
              },
          }
        });

    });


    $("#example-table").on("click", ".delete_user_account", function(){
        var user_id = $(this).data('user_id');
        $.confirm({
        title: 'Confirm!',
        content: 'Are you sure to delete this account ?',
          buttons: {
              confirm: function () {
                  window.location.href = site_url+"/admin/memberships/users/delete/"+user_id;
              },
              cancel: function () {
                 // return false;
              },
          }
        });

    });
  });

</script>
@endpush