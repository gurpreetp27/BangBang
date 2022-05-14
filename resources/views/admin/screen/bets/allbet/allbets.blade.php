@extends('admin.layout.main')
@section('title','BangBang DashBoard')
@push('styles')
<!-- <link rel="stylesheet" type="text/css" media="screen" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" /> -->
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
.list-group-item{
  padding: 0 !important;
}
.panel-group .panel {
    margin-bottom: 0;
    border-radius: 4px;
}

.panel-default {
    border-color: #ddd;
}
.panel {
    margin-bottom: 20px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
    box-shadow: 0 1px 1px rgba(0,0,0,.05);
}
.panel-default>.panel-heading {
    color: #333;
    background-color: #f5f5f5;
    border-color: #ddd;
}
.panel-group .panel-heading {
    border-bottom: 0;
}
.panel-title {
    margin-top: 0;
    margin-bottom: 0;
    font-size: 16px;
    color: inherit;
}
.panel-title>a {
    color: inherit;
}
.panel-group .panel-heading {
    border-bottom: 0;
}
.panel-heading {
    padding: 10px 15px;
    border-bottom: 1px solid transparent;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;
}
.panel-default>.panel-heading+.panel-collapse>.panel-body {
    border-top-color: #ddd;
}
.panel-group .panel-heading+.panel-collapse>.panel-body, .panel-group .panel-heading+.panel-collapse>.list-group {
    border-top: 1px solid #ddd;
}
.panel-body {
    padding: 15px;
}
 </style>


@endpush
@section('content')

            <div class="page-content fade-in-up">
                <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">All Bets</div>
                    </div>
                    <div class="ibox">
                          <!--   <div class="ibox-head">
                                <div class="ibox-title">Aligned options</div>
                            </div> -->
                            <div class="ibox-body">
                                <div class="clf">
                                    <ul class="nav nav-tabs tabs-line-left">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#tab-9-1" data-toggle="tab" aria-expanded="true"><i class="fa fa-bars"></i> All bets</a>
                                        </li>
                                        @if(count($betcategory) > 0)
                                          @php
                                             $count = 2;
                                           @endphp
                                           @foreach($betcategory as $betcat)
                                            <li class="nav-item">
                                                <a class="nav-link" href="#tab-9-{{$count++}}" data-toggle="tab" aria-expanded="false"><i class="fa fa-smile-o"></i> {{$betcat['name']}}</a>
                                            </li>
                                           @endforeach
                                        @endif
                                       
                                       <!--  <li class="nav-item">
                                            <a class="nav-link" href="#tab-9-3" data-toggle="tab" aria-expanded="false"><i class="fa fa-bullhorn"></i> Third</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#tab-9-4" data-toggle="tab" aria-expanded="false"><i class="fa fa-bell-o"></i> Four</a>
                                        </li> -->
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab-9-1" aria-expanded="true">
                                          <div class="table-responsive">
                                             <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Bet Date</th>
                                                    <th>Category</th>
                                                    <th>Odds</th>
                                                    <th>Status</th>
                                                    <th>Created at</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                             @if(isset($data))
                                               @foreach($data as $bet)
                                                 <tr>
                                                   <td>{{$bet['id']}}</td>
                                                   <td>{{date('d M,Y H:i',strtotime($bet['betdate']))}} EST</td>
                                                   <td>{{$bet['betcategory1']['name']}}</td>
                                                   <td>{{number_format($bet['finalodds'],2)}}</td>
                                                   <input type="hidden" name="" value="{{$bet['id']}}" class="betId">
                                                  <input type="hidden" name="" value="{{$bet['status']}}" class="betStatus">
                                                   <td class="statustd">
                                                   @if($bet['status']=='Pending')
                                                    <span class="badge badge-warning badge-pill m-b-5">Pending</span>
                                                   @endif
                                                   @if($bet['status']=='Won')
                                                    <span class="badge badge-success badge-pill m-b-5">Won</span>
                                                   @endif
                                                   @if($bet['status']=='Lost')
                                                    <span class="badge badge-danger badge-pill m-b-5">Lost</span>
                                                   @endif
                                                   @if($bet['status']=='Cancel')
                                                    <span class="badge badge-default badge-pill m-b-5">Cancel</span>
                                                   @endif
                                                   </td>
                                                   <td>{{date('d M,Y H:i',strtotime($bet['created_at']))}}</td>
                                                  <td>
                                                   <a href="javascript:void(0)" class="btn btn-default btn-xs detailofbet" data-original-title="Delete"> 
                                                     <i class="fa fa-eye font-14"></i>
                                                  </a>
                                                  <a href="{{url('admin/bets/allbets/edit',$bet['id'])}}" class="btn btn-default btn-xs m-r-5" data-original-title="Edit"> 
                                                     <i class="fa fa-pencil font-14"></i>
                                                  </a>
                                                   <a href="javascript:void(0)" class="btn btn-default btn-xs deletes" data-original-title="Delete"> 
                                                     <i class="fa fa-trash font-14"></i>
                                                  </a>
                                                  <div class="btn-group">
                                                    <button class="btn btn-default btn-xs" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-cog font-14"></i></button>
                                                    <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                      <!--   <li>
                                                            <a class="dropdown-item statuschanger" href="javascript:void(0)">Pending</a>
                                                        </li> -->
                                                        <li>
                                                            <a class="dropdown-item statuschanger" href="javascript:void(0)">Won</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item statuschanger" href="javascript:void(0)">Lost</a>
                                                        </li> 
                                                        <li>
                                                            <a class="dropdown-item statuschanger" href="javascript:void(0)">Cancel</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                </td>
                                                 </tr>
                                               @endforeach
                                             @endif
                                            </tbody>
                                          </table>  
                                        </div>
                                        </div>
                                        <div class="tab-pane" id="tab-9-2" aria-expanded="false">
                                              @if(isset($data))
                                               <table class="table table-striped table-bordered table-hover" id="example-table2" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Bet Date</th>
                                                            <th>Category</th>
                                                            <th>Odds</th>
                                                            <th>Status</th>
                                                            <th>Created at</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                               @foreach($data as $bet)
                                               @if($bet['betcategory_id']==1)
                                                 <tr>
                                                   <td>{{$bet['id']}}</td>
                                                  <td>{{date('d M,Y H:i',strtotime($bet['betdate']))}} EST</td>
                                                   <td>{{$bet['betcategory1']['name']}}</td>
                                                   <td>{{number_format($bet['finalodds'],2)}}</td>
                                                   <input type="hidden" name="" value="{{$bet['id']}}" class="betId">
                                                  <input type="hidden" name="" value="{{$bet['status']}}" class="betStatus">
                                                   <td class="statustd">
                                                   @if($bet['status']=='Pending')
                                                    <span class="badge badge-warning badge-pill m-b-5">Pending</span>
                                                   @endif
                                                   @if($bet['status']=='Won')
                                                    <span class="badge badge-success badge-pill m-b-5">Won</span>
                                                   @endif
                                                   @if($bet['status']=='Lost')
                                                    <span class="badge badge-danger badge-pill m-b-5">Lost</span>
                                                   @endif
                                                   @if($bet['status']=='Cancel')
                                                    <span class="badge badge-default badge-pill m-b-5">Cancel</span>
                                                   @endif
                                                   </td>
                                                    <td>{{date('d M,Y H:i',strtotime($bet['created_at']))}}</td>
                                                  <td>
                                                   <a href="javascript:void(0)" class="btn btn-default btn-xs detailofbet" data-original-title="Delete"> 
                                                     <i class="fa fa-eye font-14"></i>
                                                  </a>
                                                  <a href="{{url('admin/bets/allbets/edit',$bet['id'])}}" class="btn btn-default btn-xs m-r-5" data-original-title="Edit"> 
                                                     <i class="fa fa-pencil font-14"></i>
                                                  </a>
                                                   <a href="javascript:void(0)" class="btn btn-default btn-xs deletes" data-original-title="Delete"> 
                                                     <i class="fa fa-trash font-14"></i>
                                                  </a>
                                                  <div class="btn-group">
                                                    <button class="btn btn-default btn-xs" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-cog font-14"></i></button>
                                                    <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                      <!--   <li>
                                                            <a class="dropdown-item statuschanger" href="javascript:void(0)">Pending</a>
                                                        </li> -->
                                                        <li>
                                                            <a class="dropdown-item statuschanger" href="javascript:void(0)">Won</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item statuschanger" href="javascript:void(0)">Lost</a>
                                                        </li> 
                                                        <li>
                                                            <a class="dropdown-item statuschanger" href="javascript:void(0)">Cancel</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                </td>
                                                 </tr>
                                               @endif
                                               @endforeach
                                                </tbody>
                                                </table>
                                             @endif
                                        </div>
                                        <div class="tab-pane" id="tab-9-3" aria-expanded="false">
                                           @if(isset($data))
                                               <table class="table table-striped table-bordered table-hover" id="example-table3" cellspacing="0" width="100%">
                                                  <thead>
                                                      <tr>
                                                          <th>#</th>
                                                          <th>Bet Date</th>
                                                          <th>Category</th>
                                                          <th>Odds</th>
                                                          <th>Status</th>
                                                          <th>Created at</th>
                                                          <th>Action</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                               @foreach($data as $bet)
                                               @if($bet['betcategory_id']==2)
                                                 <tr>
                                                   <td>{{$bet['id']}}</td>
                                                  <td>{{date('d M,Y H:i',strtotime($bet['betdate']))}} EST</td>
                                                   <td>{{$bet['betcategory1']['name']}}</td>
                                                   <td>{{number_format($bet['finalodds'],2)}}</td>
                                                   <input type="hidden" name="" value="{{$bet['id']}}" class="betId">
                                                  <input type="hidden" name="" value="{{$bet['status']}}" class="betStatus">
                                                   <td class="statustd">
                                                   @if($bet['status']=='Pending')
                                                    <span class="badge badge-warning badge-pill m-b-5">Pending</span>
                                                   @endif
                                                   @if($bet['status']=='Won')
                                                    <span class="badge badge-success badge-pill m-b-5">Won</span>
                                                   @endif
                                                   @if($bet['status']=='Lost')
                                                    <span class="badge badge-danger badge-pill m-b-5">Lost</span>
                                                   @endif
                                                   @if($bet['status']=='Cancel')
                                                    <span class="badge badge-default badge-pill m-b-5">Cancel</span>
                                                   @endif
                                                   </td>
                                                    <td>{{date('d M,Y H:i',strtotime($bet['created_at']))}}</td>
                                                  <td>
                                                   <a href="javascript:void(0)" class="btn btn-default btn-xs detailofbet" data-original-title="Delete"> 
                                                     <i class="fa fa-eye font-14"></i>
                                                  </a>
                                                  <a href="{{url('admin/bets/allbets/edit',$bet['id'])}}" class="btn btn-default btn-xs m-r-5" data-original-title="Edit"> 
                                                     <i class="fa fa-pencil font-14"></i>
                                                  </a>
                                                   <a href="javascript:void(0)" class="btn btn-default btn-xs deletes" data-original-title="Delete"> 
                                                     <i class="fa fa-trash font-14"></i>
                                                  </a>
                                                  <div class="btn-group">
                                                    <button class="btn btn-default btn-xs" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-cog font-14"></i></button>
                                                    <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                      <!--   <li>
                                                            <a class="dropdown-item statuschanger" href="javascript:void(0)">Pending</a>
                                                        </li> -->
                                                        <li>
                                                            <a class="dropdown-item statuschanger" href="javascript:void(0)">Won</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item statuschanger" href="javascript:void(0)">Lost</a>
                                                        </li> 
                                                        <li>
                                                            <a class="dropdown-item statuschanger" href="javascript:void(0)">Cancel</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                </td>
                                                 </tr>
                                               @endif
                                               @endforeach
                                              </tbody>
                                             </table>  
                                             @endif
                                        </div>
                                        <div class="tab-pane" id="tab-9-4" aria-expanded="false">
                                           @if(isset($data))
                                               <table class="table table-striped table-bordered table-hover" id="example-table4" cellspacing="0" width="100%">
                                                  <thead>
                                                      <tr>
                                                          <th>#</th>
                                                          <th>Bet Date</th>
                                                          <th>Category</th>
                                                          <th>Odds</th>
                                                          <th>Status</th>
                                                          <th>Created at</th>
                                                          <th>Action</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                               @foreach($data as $bet)
                                               @if($bet['betcategory_id']==3)
                                                 <tr>
                                                   <td>{{$bet['id']}}</td>
                                                    <td>{{date('d M,Y H:i',strtotime($bet['betdate']))}} EST</td>
                                                   <td>{{$bet['betcategory1']['name']}}</td>
                                                   <td>{{number_format($bet['finalodds'],2)}}</td>
                                                   <input type="hidden" name="" value="{{$bet['id']}}" class="betId">
                                                  <input type="hidden" name="" value="{{$bet['status']}}" class="betStatus">
                                                   <td class="statustd">
                                                   @if($bet['status']=='Pending')
                                                    <span class="badge badge-warning badge-pill m-b-5">Pending</span>
                                                   @endif
                                                   @if($bet['status']=='Won')
                                                    <span class="badge badge-success badge-pill m-b-5">Won</span>
                                                   @endif
                                                   @if($bet['status']=='Lost')
                                                    <span class="badge badge-danger badge-pill m-b-5">Lost</span>
                                                   @endif
                                                   @if($bet['status']=='Cancel')
                                                    <span class="badge badge-default badge-pill m-b-5">Cancel</span>
                                                   @endif
                                                   </td>
                                                   <td>{{date('d M,Y H:i',strtotime($bet['created_at']))}}</td>
                                                  <td>
                                                   <a href="javascript:void(0)" class="btn btn-default btn-xs detailofbet" data-original-title="Delete"> 
                                                     <i class="fa fa-eye font-14"></i>
                                                  </a>
                                                  <a href="{{url('admin/bets/allbets/edit',$bet['id'])}}" class="btn btn-default btn-xs m-r-5" data-original-title="Edit"> 
                                                     <i class="fa fa-pencil font-14"></i>
                                                  </a>
                                                   <a href="javascript:void(0)" class="btn btn-default btn-xs deletes" data-original-title="Delete"> 
                                                     <i class="fa fa-trash font-14"></i>
                                                  </a>
                                                  <div class="btn-group">
                                                    <button class="btn btn-default btn-xs" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-cog font-14"></i></button>
                                                    <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                      <!--   <li>
                                                            <a class="dropdown-item statuschanger" href="javascript:void(0)">Pending</a>
                                                        </li> -->
                                                        <li>
                                                            <a class="dropdown-item statuschanger" href="javascript:void(0)">Won</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item statuschanger" href="javascript:void(0)">Lost</a>
                                                        </li> 
                                                        <li>
                                                            <a class="dropdown-item statuschanger" href="javascript:void(0)">Cancel</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                </td>
                                                 </tr>
                                               @endif
                                               @endforeach
                                               </tbody>
                                              </table> 
                                             @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                </div>
            </div>


            <div class="modal fade" id="myModal" role="dialog">
              <div class="modal-dialog">
              
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Bet Detail</h4>
                  </div>
                  <div class="modal-body">
                   <div class="panel-group" id="accordion">
                     
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                   <!--  <button type="button" class="btn btn-succees" id="saveForm">Save</button> -->
                  </div>
                </div>
                
              </div>
          </div>  
@endsection

@push('script')
<script src="{{asset('public/adminn/assets/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
  $(function() {
            $('#example-table,#example-table2,#example-table3,#example-table4').DataTable({
                pageLength: 10,
                "ordering": false
            });
        })
    $('.deletes').click(function(e){
      if(confirm("Are you sure you want to delete this Bet?")===true){
            var parent = $(this).parent().parent();
            var Ids = parent.find('.betId').val();
            $.ajax({
             type:'POST',
             url:'{{url('admin/bets/allbets/remove')}}',
             data:{'_token': '{{ csrf_token() }}','id':Ids},
             success:function(data) {
                if(data=='success'){
                  showMessage('Bet has been Removed, Successfully!','success');
                  setTimeout(function(){ location.reload(); }, 4000);
                }
             }
          });
      }
    });

    $('.detailofbet').click(function(e){
        var parent = $(this).parent().parent();
        var Ids = parent.find('.betId').val();
         $.ajax({
             type:'POST',
             url:'{{url('admin/bets/allbets/getdetail')}}',
             data:{'_token': '{{ csrf_token() }}','id':Ids},
             success:function(data) {
              $('#accordion').html('');
              var html='';
               var responseObject = JSON.parse(data);
               $.each(responseObject, function(k, v) {
                     html+='<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse_'+k+'">'+v.name+'</a></h4></div><div id="collapse_'+k+'" class="panel-collapse collapse"><div class="panel-body"><ul class="list-group list-group-full list-group-divider"><li class="list-group-item">Date Time:- '+v.date+'</li><li class="list-group-item">Competition:- '+v.competition+'</li><li class="list-group-item">Sport:- '+v.sport+'</li><li class="list-group-item">whosplaying:- '+v.type+'</li>';
                     if(v.type=='Team'){
                      html+='<li class="list-group-item">Team A:- '+v.teama+'</li><li class="list-group-item">Team B:- '+v.teamb+'</li>';
                     }else{
                      html+='<li class="list-group-item">Player A:- '+v.playera+'</li><li class="list-group-item">Player B:- '+v.playera+'</li>';
                     }
                     html+='<li class="list-group-item">Tip Type:- '+v.tiptype+'</li><li class="list-group-item">odds:- '+v.odds+'</li><li class="list-group-item">Actual Tip:- '+v.actualtip+'</li><li class="list-group-item">Rating:- '+v.rating+'</li></ul></div></div></div>'
               });
                $('#accordion').append(html);
                 $('#myModal').modal({
                      backdrop: 'static',
                      keyboard: false
                  })
             // $(".dfdfdf").each(function() {
             // console.log(data)
                /*if(data=='success'){
                  showMessage('Bet has been Removed, Successfully!','success');
                  setTimeout(function(){ location.reload(); }, 4000);
                }*/
             }
          });
    });

    $('.statuschanger').click(function(){
       var parent = $(this).parent().parent().parent().parent().parent();
       var id = parent.find('.betId').val();
       var status = $(this).text();
        $.ajax({
           type:'POST',
           url:'{{url('admin/bets/allbets/changeStatus')}}',
           data:{'_token': '{{ csrf_token() }}','id':id,'status':status},
           success:function(data) {
              if(data=='success'){
                  showMessage('Status Has been Changed for this Bet','success');
                  parent.find('.statustd').html('');
                  if(status=='Pending'){
                  parent.find('.statustd').append('<span class="badge badge-warning badge-pill m-b-5">Pending</span>');  
                 }
                 if(status=='Won'){
                  parent.find('.statustd').append('<span class="badge badge-success badge-pill m-b-5">Won</span>');  
                 }
                 if(status=='Lost'){
                  parent.find('.statustd').append('<span class="badge badge-danger badge-pill m-b-5">Lost</span>');  
                 }
                 if(status=='Cancel'){
                  parent.find('.statustd').append('<span class="badge badge-default badge-pill m-b-5">Cancel</span>');  
                 }
              }
           }
        });
       
    });
</script>
@endpush