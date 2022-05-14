@extends('admin.layout.main')
@section('title','BangBang DashBoard')
@push('styles')
<!--  <link href="{{asset('public/adminn/assets/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" /> -->
 <style>
   .btn-group.open ul.dropdown-menu {
    top: -11px!important;
}
.modal.fade.in{
  opacity: 1;
}
#myModal .modal-dialog {
    -webkit-transform: translate(0,-50%);
    -o-transform: translate(0,-50%);
    transform: translate(0,-50%);
    top: 50%;
    margin: 0 auto;
}
#myModal{
  background-color: rgba(0,0,0,0.6);
}
.rating2 span.active:after {
    content: "\2605";
    position: absolute;
    left: 0;
    color: #d82211;
}
.rating2 span {
    position: relative;
    font-size: 34px;
}
.rating2 span.active.half:after {
   width: 50%;
   overflow: hidden;
}
 </style>
@endpush
@section('content')
            <div class="page-content fade-in-up">
                <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">All Email Template</div>
                        <a href="{{url('admin/template/addnew')}}" class="btn btn-default">Add New</a>
                    </div>
                    <div class="ibox">       
                            <div class="ibox-body">
                                <div class="table-responsive">
                                   <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                                  <thead>
                                      <tr>
                                          <th width="2">#</th>
                                          <th width="20">Title</th>
                                          <th width="20">Subject</th>
                                          <th width="15">Status</th>
                                          <th width="15">Last Updated</th>
                                          <th width="20">Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @if(count($data) > 0)
                                    @php 
                                      $counter=1;
                                    @endphp
                                     @foreach($data as $review)
                                      <tr>
                                        <td>{{$counter++}}</td>
                                        <td>{{$review['title']}}</td>
                                        <td>{{$review['subject']}}</td>
                                       
                                         <input type="hidden" name="" value="{{$review['id']}}" class="betId">
                                         <td class="statustd">
                                           @if($review['status']=='inactive')
                                            <span class="badge badge-warning badge-pill m-b-5">Inactive</span>
                                           @endif
                                           @if($review['status']=='active')
                                            <span class="badge badge-success badge-pill m-b-5">Active</span>
                                           @endif
                                          <td>{{date('d M,Y H:i',strtotime($review['updated_at']))}}</td>
                                         <td>
                                                                                  
                                           <a href="{{url('admin/template/edit',$review['id'])}}" class="btn btn-default btn-xs m-r-5 editReview" data-original-title="Edit"> 
                                               <i class="fa fa-pencil font-14"></i>
                                            </a>
                                          <a href="javascript:void(0)" class="btn btn-default btn-xs deleteReview" data-original-title="Delete"> 
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
<!-- <script src="{{asset('public/adminn/assets/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script> -->
<script type="text/javascript">
 @if(Auth::user()->name=='Admin')
  /*$(function() {
            $('#example-table').DataTable({
                pageLength: 10,
            });
        })*/

  $('.statuschanger').click(function(){
       var parent = $(this).parent().parent().parent().parent().parent();
       var id = parent.find('.betId').val();
       var status = $(this).text();
        $.ajax({
           type:'POST',
           url:'{{url('admin/review/changeStatus')}}',
           data:{'_token': '{{ csrf_token() }}','id':id,'status':status},
           success:function(data) {
              if(data=='success'){
                  showMessage('Status Has been Changed for this Bet','success');
                  parent.find('.statustd').html('');
                  if(status=='Pending'){
                  parent.find('.statustd').append('<span class="badge badge-warning badge-pill m-b-5">Pending</span>');  
                 }
                 if(status=='Approved'){
                  parent.find('.statustd').append('<span class="badge badge-success badge-pill m-b-5">Approved</span>');  
                 }
                 if(status=='Disapproved'){
                  parent.find('.statustd').append('<span class="badge badge-danger badge-pill m-b-5">Disapproved</span>');  
                 }


              }
           }
        });
       
    });
 @endif 
    $('.deleteReview').click(function(e){
      if(confirm("Are you sure you want to delete this Template Forever?")===true){
            var parent = $(this).parent().parent();
            var Ids = parent.find('.betId').val();
            $.ajax({
             type:'POST',
             url:'{{url('admin/template/deletetemplate')}}',
             data:{'_token': '{{ csrf_token() }}','id':Ids},
             success:function(data) {
                if(data=='success'){
                  showMessage('Template has been Removed, Successfully!','success');
                  setTimeout(function(){ location.reload(); }, 4000);
                }
             }
          });
      }
    });

  
    
</script>
@endpush