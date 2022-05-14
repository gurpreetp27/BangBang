@extends('admin.layout.main')
@section('title','BangBang DashBoard')
@push('styles')
 <link href="{{asset('public/adminn/assets/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
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
    top: -2px;
}
.rating2 span {
    position: relative;
    font-size: 34px;
}
.rating2 span.active.half:after {
   width: 50%;
   overflow: hidden;
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
                <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">All Review</div>
                         
                    </div>
                    <div class="ibox">
                        @if(Auth::user()->name=='Admin')
                         <div class="ibox-head">
                               <?php
                               $average = 0;
                              if(count($data) > 0) { 
                              $sum = 0;
                               $sum =  array_sum(array_map(function($item) { 
                               	      if($item['status']=='Approved'){
                                          return $item['star']; 
                                      }
                                  }, $data));
                               $cmtnj = 0;
                               foreach ($data as $key => $value) {
                               	if($value['status']=='Approved'){
                                   $cmtnj++;
                               	  }
                                }
                               if($cmtnj > 0){
                               $average = ($sum/$cmtnj); 
                               }
                               $cntt = 0;
                              }
                             ?>
                             <h3>Average Rating: {{number_format($average,2)}}</h3>

                              <div class="rating2 star-rating m-auto">
                                 @for($i = 1;$i < 6;$i++)
                                   @if($i <= $average)
                                     <span class="active">☆</span> 
                                    @else
                                       @if(is_float($average) && $cntt===0)
                                         <span class="active half">☆</span> 
                                         @php
                                          $cntt=1;
                                          @endphp
                                        @else
                                        <span>☆</span>
                                      @endif      
                                   @endif
                                 @endfor
                              </div>  

                                <a href="{{url('/admin/review/add')}}" class="btn btn-success addcircle-img" aria-pressed="true"><img src="{{asset('public/adminn/assets/img/circle-add.png')}}" class="btn-success"> Add New Review</img></a>
                         </div>
                        @endif        
                            <div class="ibox-body">
                                <div class="table-responsive">
                                   <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                                  <thead>
                                      <tr>
                                          <th width="2">#</th>
                                          <th width="20">Name</th>
                                          <th width="10">Star</th>
                                          <th width="60">Comment</th>
                                          <th width="20">DateTime</th>
                                          <th width="15">Status</th>
                                          <th width="20">Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @if(count($data) > 0)
                                    @php 
                                      $counter=1;
                                    @endphp
                                     @foreach($data as $review)
                                       @php
                                        $comment_len = strlen($review['comment'])
                                       @endphp
                                      <tr>
                                        <td>{{$counter++}}</td>
                                        <td>{{$review['name']}}</td>
                                        <td>{{$review['star']}}</td>
                                        <td>{{substr(trim($review['comment']),0,70)}}@if($comment_len > 70) ... @endif</td>
                                        @if(Auth::user()->name=='Admin')
                                        <td>{{date('d M,Y H:i',strtotime($review['created_at']))}}</td>
                                        @else
                                        <td>{{$review['created_at'] }}</td>
                                        @endif
                                         <input type="hidden" name="" value="{{$review['id']}}" class="betId">
                                         <td class="statustd">
                                           @if($review['status']=='Pending')
                                            <span class="badge badge-warning badge-pill m-b-5">Pending</span>
                                           @endif
                                           @if($review['status']=='Approved')
                                            <span class="badge badge-success badge-pill m-b-5">Approved</span>
                                           @endif
                                           @if($review['status']=='Disapproved')
                                            <span class="badge badge-danger badge-pill m-b-5">Disapproved</span>
                                           @endif
                                         <td>
                                         @if(Auth::user()->name=='Admin')
                                          <div class="btn-group">
                                            <button class="btn btn-default btn-xs" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-cog font-14"></i></button>
                                            <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">
                                               <!--  <li>
                                                    <a class="dropdown-item statuschanger" href="javascript:void(0)">Pending</a>
                                                </li> -->
                                                <li>
                                                    <a class="dropdown-item statuschanger" href="javascript:void(0)">Approved</a>
                                                </li> 
                                                <li>
                                                    <a class="dropdown-item statuschanger" href="javascript:void(0)">Disapproved</a>
                                                </li>
                                            </ul>
                                          </div>                                            
                                          @endif
                                           <a href="{{url('admin/review/edit',$review['id'])}}" class="btn btn-default btn-xs m-r-5 editReview" data-original-title="Edit"> 
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

           <!-- <div class="modal fade" id="myModal" role="dialog">
              <div class="modal-dialog">
              
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Bet Detail</h4>
                  </div>
                  <div class="modal-body">
                    <form action="{{url('reviews/savereview')}}" method="post" id="myForm">
                      @csrf
                        <div class="row">
                            <div class="col-sm-6 form-group">                           
                                <label>First Name</label>
                                <input class="form-control" type="text" placeholder="First Name" name="firstName">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label>Last Name</label>
                                <input class="form-control" type="text" placeholder="First Name" name="lastName">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Comment</label>
                            <textarea class="form-control" rows="3" name="comment"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Star</label>
                            <select class="form-control" name="star">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-succees" id="saveForm">Save</button>
                  </div>
                    </form>
                  </div>
                </div>
                
              </div>
          </div>   -->  
@endsection

@push('script')
<script src="{{asset('public/adminn/assets/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
 @if(Auth::user()->name=='Admin')
  $(function() {
            $('#example-table').DataTable({
                pageLength: 10,
            });
        })

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
      if(confirm("Are you sure you want to delete this Review?")===true){
            var parent = $(this).parent().parent();
            var Ids = parent.find('.betId').val();
            $.ajax({
             type:'POST',
             url:'{{url('admin/review/deleteReview')}}',
             data:{'_token': '{{ csrf_token() }}','id':Ids},
             success:function(data) {
                if(data=='success'){
                  showMessage('Review has been Removed, Successfully!','success');
                  setTimeout(function(){ location.reload(); }, 4000);
                }
             }
          });
      }
    });

     $('#addnewreview').click(function(){
        $('#myModal').modal({
            backdrop: 'static',
            keyboard: false
        })
  });
    
</script>
@endpush