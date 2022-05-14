@extends('admin.layout.main')
@section('title','Memberships')
@push('styles')
 <link href="{{asset('public/adminn/assets/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
 <style>
   .btn-group.open ul.dropdown-menu {
    top: -11px!important;
}
 </style>
@endpush
@section('content')
            <div class="page-content fade-in-up">
                <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Membership Users</div>
                    </div>
                      <div class="ibox">
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
                                      <td>{{isset($user['getMembership']['status'])?$user['getMembership']['status']:"deactive"}}</td>
                                      <td>{{$user['getMembership']['amount']}}</td>
                                      <td>{{array_sum($getincome)}}</td>
                                      <td>{{$user['last_country_ip']}}</td>
                                      <td>
                                      <input type="hidden" name="" value="{{$user['id']}}" class="gamerId">
                                      <a href="{{url('admin/memberships/users/edit',$user['id'])}}" class="btn btn-default btn-xs m-r-5" data-original-title="Edit">    <i class="fa fa-pencil font-14"></i>
                                      </a>

                                      <a href="{{url('admin/memberships/users/ban',$user['id'])}}" class="btn btn-default btn-xs m-r-5" data-original-title="Edit">    <i class="fa fa-ban font-14"></i>
                                      </a>

                                       <a href="javascript:void(0)" class="btn btn-default btn-xs deletes" data-original-title="Delete"> 
                                         <i class="fa fa-trash font-14"></i>
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
                </div>
            </div>
@endsection
@push('script')
<script src="{{asset('public/adminn/assets/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
  $(function() {
            $('#example-table').DataTable({
            });
        })

</script>
@endpush