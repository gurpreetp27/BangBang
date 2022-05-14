@extends('admin.layout.main')
@section('title','BangBang DashBoard')
@push('styles')
 <link href="{{asset('public/adminn/assets/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
 <style>
   .btn-group.open ul.dropdown-menu {
    top: -11px!important;
}
.nav-pills .nav-item.active, .nav-pills .nav-item.active:focus, .nav-pills .nav-item.active:hover {
    background-color: #2cc4cb!important;
    color: #fff;
}
#monthdropDown-tab1,#monthdropDown-tab2,#monthdropDown-tab3,#monthdropDown-tab4{
 display: none; 
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
 </style>
@endpush
@section('content')
            <div class="page-content fade-in-up">
                <div class="col-sm-12">
                <div class="ibox">
                        <div class="ibox-head">
                            <div class="ibox-title">Result Stats</div>
                        </div>
                        <div class="ibox-body">
                            <ul class="nav nav-pills">
                                <li class="nav-item active">
                                    <a class="nav-link" href="#pill-1-1" data-toggle="tab" aria-expanded="true">All Bets</a>
                                </li>
                                @if(count($betcategory) > 0)
                                   @php
                                     $count = 2;
                                   @endphp
                                 @foreach($betcategory as $betcat)
                                  <li class="nav-item">
                                      <a class="nav-link" href="#pill-1-{{$count++}}" data-toggle="tab" aria-expanded="false">{{$betcat['name']}}</a>
                                  </li>
                                 @endforeach
                                @endif
                                <!-- <li class="nav-item">
                                    <a class="nav-link" href="#pill-1-3" data-toggle="tab" aria-expanded="false">Third</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#pill-1-4" data-toggle="tab" aria-expanded="false">Four</a>
                                </li> -->
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="pill-1-1" aria-expanded="true">
                                 <div class="row">
                                  <div class="col-sm-3">
                                  <div class="form-group">
                                        <label>Select Option</label>
                                        <select class="form-control tab1-main-select">
                                            <option value="allbets">All Bets</option>
                                            <option value="last30days">Last 30 Days</option>
                                            <option value="bymonth">By Month</option>
                                        </select>
                                    </div>
                                    </div>
                                    <div class="col-sm-3">
                                    <div class="form-group" id="monthdropDown-tab1">
                                        <label>Select Month</label>
                                        <select class="form-control tab1-monthselect" >
                                              <option value="">Select Option</option>
                                              <option value="01">January</option>
                                              <option value="02">Febuary</option>
                                              <option value="03">March</option>
                                              <option value="04">April</option>
                                              <option value="05">May</option>
                                              <option value="06">June</option>
                                              <option value="07">July</option>
                                              <option value="08">August</option>
                                              <option value="09">September</option>
                                              <option value="10">October</option>
                                              <option value="11">November</option>
                                              <option value="12">December</option>
                                        </select>
                                    </div>
                                   </div>
                                   <div class="col-sm-3">
                                      <span class="badge badge-default badge-pill" style="font-size: 22px;" id="tab1-total">Total Profit-: {{number_format($headerCounter['tab1'],2)}}</span>
                                   </div> 
                                  </div>
                                    <table class="table table-bordered">
                                      <thead class="thead-default">
                                          <tr>
                                              <th>Event Date</th>
                                              <th>Bet type</th>
                                              <th>Sport</th>
                                              <th>Tip Type</th>
                                              <th>Odds/Final Odds</th>
                                              <th>Bet Category</th>
                                              <th>Status</th>
                                              <th>Profit</th>
                                              <th>Action</th>
                                          </tr>
                                      </thead>
                                      <tbody id="tab1-tbody">
                                      <?php $bet3_counter = 0; ?>
                                        @if(count($data) > 0)
                                         @foreach($data as $key => $bet)
                                           <tr>
                                             <td>{{$bet['betdate']}} EST</td>
                                             <td>{{$bet['bettype']}}</td>
                                             <td>{{$bet['sport']['name']}}</td>
                                             <td>{{$bet['tiptype']['name']}}</td>
                                             <td>{{number_format($bet['odds'],2)}}</td>
                                             <td>{{$bet['betcategory1']['name']}}</td>
                                             <td>
                                             <?php
                                                   $profit = 0;
                                                   if($bet['status']=='Won'){
                                                     $sdsd = $bet['odds'] * 100;
                                                     $profit = ($sdsd - 100);
                                                     echo "<span class='badge badge-success badge-pill m-b-5'>".$profit."</span>";
                                                     $bet3_counter = $bet3_counter + $profit;

                                                   } 

                                                    if($bet['status']=='Lost'){
                                                      $bet3_counter = $bet3_counter - 100;
                                                     echo "<span class='badge badge-danger badge-pill m-b-5'>-100</span>";
                                                   }
                                                 ?>
                                               <td>
                                               {{number_format($overallProfit['tab1'][$key],2)}}
                                               </td>
                                               <input type="hidden" class="idofbet" value="{{$bet['id']}}">
                                               <td>
                                                 <button class="btn btn-default btn-xs showresult-tab1"><i class="fa fa-eye font-14"></i></button>
                                               </td>
                                           </tr>
                                         @endforeach 
                                        @endif
                                        
                                      </tbody>
                                  </table>
                                </div>
                                <div class="tab-pane" id="pill-1-2" aria-expanded="false">
                                  <div class="row">
                                  <div class="col-sm-3">
                                  <div class="form-group">
                                        <label>Select Option</label>
                                        <select class="form-control tab2-main-select">
                                            <option value="allbets">All Bets</option>
                                            <option value="last30days">Last 30 Days</option>
                                            <option value="bymonth">By Month</option>
                                        </select>
                                    </div>
                                    </div>
                                    <div class="col-sm-3">
                                    <div class="form-group" id="monthdropDown-tab2">
                                        <label>Select Month</label>
                                        <select class="form-control tab2-monthselect" >
                                              <option value="">Select Option</option>
                                              <option value="01">January</option>
                                              <option value="02">Febuary</option>
                                              <option value="03">March</option>
                                              <option value="04">April</option>
                                              <option value="05">May</option>
                                              <option value="06">June</option>
                                              <option value="07">July</option>
                                              <option value="08">August</option>
                                              <option value="09">September</option>
                                              <option value="10">October</option>
                                              <option value="11">November</option>
                                              <option value="12">December</option>
                                        </select>
                                    </div>
                                   </div>
                                   <div class="col-sm-3">
                                      <span class="badge badge-default badge-pill" style="font-size: 22px;" id="tab2-total">Total Profit-: {{number_format($headerCounter['tab2'],2)}}</span>
                                   </div> 
                                  </div>
                                    <table class="table table-bordered">
                                      <thead class="thead-default">
                                          <tr>
                                              <th>Event Date</th>
                                              <th>Bet type</th>
                                              <th>Sport</th>
                                              <th>Tip Type</th>
                                              <th>Odds/Final Odds</th>
                                              <th>Bet Category</th>
                                              <th>Status</th>
                                              <th>Profit</th>
                                              <th>Action</th>
                                          </tr>
                                      </thead>
                                      <tbody id="tab2-tbody">
                                      <?php $bet3_counter = 0; ?>
                                        @if(count($data) > 0)
                                         @foreach($data as $key => $bet)
                                          @if($bet['betcategory_id']==1)
                                           <tr>
                                             <td>{{$bet['betdate']}} EST</td>
                                             <td>{{$bet['bettype']}}</td>
                                             <td>{{$bet['sport']['name']}}</td>
                                             <td>{{$bet['tiptype']['name']}}</td>
                                             <td>{{number_format($bet['odds'],2)}}</td>
                                             <td>{{$bet['betcategory1']['name']}}</td>
                                             <td>
                                             <?php
                                                   $profit = 0;
                                                   if($bet['status']=='Won'){
                                                     $sdsd = $bet['odds'] * 100;
                                                     $profit = ($sdsd - 100);
                                                     echo "<span class='badge badge-success badge-pill m-b-5'>".$profit."</span>";
                                                     $bet3_counter = $bet3_counter + $profit;

                                                   } 

                                                    if($bet['status']=='Lost'){
                                                      $bet3_counter = $bet3_counter - 100;
                                                     echo "<span class='badge badge-danger badge-pill m-b-5'>-100</span>";
                                                   }
                                                 ?>
                                               <td>
                                               {{number_format(isset($overallProfit['tab2'][$key])?$overallProfit['tab2'][$key]:0,2)}}
                                               </td>
                                               <input type="hidden" class="idofbet" value="{{$bet['id']}}">
                                               <td>
                                                 <button class="btn btn-default btn-xs showresult-tab1"><i class="fa fa-eye font-14"></i></button>
                                               </td>
                                           </tr>
                                           @endif
                                         @endforeach 
                                        @endif
                                       
                                      </tbody>
                                  </table>
                                </div>
                                <div class="tab-pane" id="pill-1-3" aria-expanded="false">
                                  <div class="row">
                                  <div class="col-sm-3">
                                  <div class="form-group">
                                        <label>Select Option</label>
                                        <select class="form-control tab3-main-select">
                                            <option value="allbets">All Bets</option>
                                            <option value="last30days">Last 30 Days</option>
                                            <option value="bymonth">By Month</option>
                                        </select>
                                    </div>
                                    </div>
                                    <div class="col-sm-3">
                                    <div class="form-group" id="monthdropDown-tab3">
                                        <label>Select Month</label>
                                        <select class="form-control tab3-monthselect" >
                                              <option value="">Select Option</option>
                                              <option value="01">January</option>
                                              <option value="02">Febuary</option>
                                              <option value="03">March</option>
                                              <option value="04">April</option>
                                              <option value="05">May</option>
                                              <option value="06">June</option>
                                              <option value="07">July</option>
                                              <option value="08">August</option>
                                              <option value="09">September</option>
                                              <option value="10">October</option>
                                              <option value="11">November</option>
                                              <option value="12">December</option>
                                        </select>
                                    </div>
                                   </div>
                                   <div class="col-sm-3">
                                      <span class="badge badge-default badge-pill" style="font-size: 22px;" id="tab3-total">Total Profit-: {{number_format($headerCounter['tab3'],2)}}</span>
                                   </div> 
                                  </div>
                                    <table class="table table-bordered">
                                      <thead class="thead-default">
                                          <tr>
                                              <th>Event Date</th>
                                              <th>Bet type</th>
                                              <th>Sport</th>
                                              <th>Tip Type</th>
                                              <th>Odds/Final Odds</th>
                                              <th>Bet Category</th>
                                              <th>Status</th>
                                              <th>Profit</th>
                                              <th>Action</th>
                                          </tr>
                                      </thead>
                                      <tbody id="tab3-tbody">
                                      <?php  $bet3_counter = 0; ?>
                                        @if(count($data) > 0)
                                         @foreach($data as $key => $bet)
                                          @if($bet['betcategory_id']==2)
                                           <tr>
                                             <td>{{$bet['betdate']}} EST</td>
                                             <td>{{$bet['bettype']}}</td>
                                             <td>{{$bet['sport']['name']}}</td>
                                             <td>{{$bet['tiptype']['name']}}</td>
                                             <td>{{number_format($bet['odds'],2)}}</td>
                                             <td>{{$bet['betcategory1']['name']}}</td>
                                             <td>
                                             <?php
                                                   $profit = 0;
                                                   if($bet['status']=='Won'){
                                                     $sdsd = $bet['odds'] * 100;
                                                     $profit = ($sdsd - 100);
                                                     echo "<span class='badge badge-success badge-pill m-b-5'>".$profit."</span>";
                                                     $bet3_counter = $bet3_counter + $profit;

                                                   } 

                                                    if($bet['status']=='Lost'){
                                                      $bet3_counter = $bet3_counter - 100;
                                                     echo "<span class='badge badge-danger badge-pill m-b-5'>-100</span>";
                                                   }
                                                 ?>
                                               <td>
                                                {{number_format(isset($overallProfit['tab3'][$key])?$overallProfit['tab3'][$key]:0,2)}}
                                               </td>
                                               <input type="hidden" class="idofbet" value="{{$bet['id']}}">
                                               <td>
                                                 <button class="btn btn-default btn-xs showresult-tab1"><i class="fa fa-eye font-14"></i></button>
                                               </td>
                                           </tr>
                                           @endif
                                         @endforeach 
                                        @endif
                                      </tbody>
                                  </table>
                                </div>
                                <div class="tab-pane" id="pill-1-4" aria-expanded="false">
                                  <div class="row">
                                  <div class="col-sm-3">
                                  <div class="form-group">
                                        <label>Select Option</label>
                                        <select class="form-control tab4-main-select">
                                            <option value="allbets">All Bets</option>
                                            <option value="last30days">Last 30 Days</option>
                                            <option value="bymonth">By Month</option>
                                        </select>
                                    </div>
                                    </div>
                                    <div class="col-sm-3">
                                    <div class="form-group" id="monthdropDown-tab4">
                                        <label>Select Month</label>
                                        <select class="form-control tab4-monthselect" >
                                              <option value="">Select Option</option>
                                              <option value="01">January</option>
                                              <option value="02">Febuary</option>
                                              <option value="03">March</option>
                                              <option value="04">April</option>
                                              <option value="05">May</option>
                                              <option value="06">June</option>
                                              <option value="07">July</option>
                                              <option value="08">August</option>
                                              <option value="09">September</option>
                                              <option value="10">October</option>
                                              <option value="11">November</option>
                                              <option value="12">December</option>
                                        </select>
                                    </div>
                                   </div>
                                   <div class="col-sm-3">
                                      <span class="badge badge-default badge-pill" style="font-size: 22px;" id="tab4-total">Total Profit-: {{number_format($headerCounter['tab4'],2)}}</span>
                                   </div> 
                                  </div>
                                    <table class="table table-bordered">
                                      <thead class="thead-default">
                                          <tr>
                                              <th>Event Date</th>
                                              <th>Bet type</th>
                                              <th>Sport</th>
                                              <th>Tip Type</th>
                                              <th>Odds/Final Odds</th>
                                              <th>Bet Category</th>
                                              <th>Status</th>
                                              <th>Profit</th>
                                              <th>Action</th>
                                          </tr>
                                      </thead>
                                       <tbody id="tab4-tbody">
                                      <?php $bet3_counter = 0; ?>
                                        @if(count($data) > 0)
                                         @foreach($data as $key => $bet)
                                          @if($bet['betcategory_id']==3)
                                           <tr>
                                             <td>{{$bet['betdate']}} EST</td>
                                             <td>{{$bet['bettype']}}</td>
                                             <td>{{$bet['sport']['name']}}</td>
                                             <td>{{$bet['tiptype']['name']}}</td>
                                             <td>{{number_format($bet['odds'],2)}}</td>
                                             <td>{{$bet['betcategory1']['name']}}</td>
                                             <td>
                                             <?php
                                                   $profit = 0;
                                                   if($bet['status']=='Won'){
                                                     $sdsd = $bet['odds'] * 100;
                                                     $profit = ($sdsd - 100);
                                                     echo "<span class='badge badge-success badge-pill m-b-5'>".$profit."</span>";
                                                     $bet3_counter = $bet3_counter + $profit;

                                                   } 

                                                    if($bet['status']=='Lost'){
                                                      $bet3_counter = $bet3_counter - 100;
                                                     echo "<span class='badge badge-danger badge-pill m-b-5'>-100</span>";
                                                   }
                                                 ?>
                                               <td>
                                                {{number_format(isset($overallProfit['tab4'][$key])?$overallProfit['tab4'][$key]:0,2)}}
                                               </td>
                                               <input type="hidden" class="idofbet" value="{{$bet['id']}}">
                                               <td>
                                                 <button class="btn btn-default btn-xs showresult-tab1"><i class="fa fa-eye font-14"></i></button>
                                               </td>
                                           </tr>
                                           @endif
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

    $('.tab1-main-select').change(function () {
      if($(this).val()=='bymonth'){
        $('#monthdropDown-tab1').show();
      }
      if($(this).val()=='last30days'){
        $('#monthdropDown-tab1').hide();
         var tab = 'tab1';
         var value = 'all';
         getsearchResult(value,tab,'last30days');
      }
      if($(this).val()=='allbets'){
        $('#monthdropDown-tab1').hide();
         var tab = 'tab1';
         var value = 'all';
         getsearchResult(value,tab,'allbets');
      }
  });

    $('.tab2-main-select').change(function () {
      if($(this).val()=='bymonth'){
        $('#monthdropDown-tab2').show();
      }
      if($(this).val()=='last30days'){
        $('#monthdropDown-tab2').hide();
         var tab = 'tab2';
         var value = 'all';
         getsearchResult(value,tab,'last30days');
      }
      if($(this).val()=='allbets'){
        $('#monthdropDown-tab2').hide();
         var tab = 'tab2';
         var value = 'all';
         getsearchResult(value,tab,'allbets');
      }
  });
    $('.tab3-main-select').change(function () {
      if($(this).val()=='bymonth'){
        $('#monthdropDown-tab3').show();
      }
      if($(this).val()=='last30days'){
        $('#monthdropDown-tab3').hide();
         var tab = 'tab3';
         var value = 'all';
         getsearchResult(value,tab,'last30days');
      }
      if($(this).val()=='allbets'){
        $('#monthdropDown-tab3').hide();
         var tab = 'tab3';
         var value = 'all';
         getsearchResult(value,tab,'allbets');
      }
  });
    $('.tab4-main-select').change(function () {
      if($(this).val()=='bymonth'){
        $('#monthdropDown-tab4').show();
      }
      if($(this).val()=='last30days'){
        $('#monthdropDown-tab4').hide();
         var tab = 'tab4';
         var value = 'all';
         getsearchResult(value,tab,'last30days');
      }
      if($(this).val()=='allbets'){
        $('#monthdropDown-tab4').hide();
         var tab = 'tab4';
         var value = 'all';
         getsearchResult(value,tab,'allbets');
      }
  });
   $('.tab1-monthselect').change(function () {
      var value = $(this).val();
      if(value!=' '){
         var tab = 'tab1';
         getsearchResult(value,tab,'bymonth');
      }
   }); 
   $('.tab2-monthselect').change(function () {
      var value = $(this).val();
      if(value!=' '){
         var tab = 'tab2';
         getsearchResult(value,tab,'bymonth');
      }
   }); 
   $('.tab3-monthselect').change(function () {
      var value = $(this).val();
      if(value!=' '){
         var tab = 'tab3';
         getsearchResult(value,tab,'bymonth');
      }
   });
   $('.tab4-monthselect').change(function () {
      var value = $(this).val();
      if(value!=' '){
         var tab = 'tab4';
         getsearchResult(value,tab,'bymonth');
      }
   });


$(document).on('click', '.showresult-tab1', function(){
      var parent = $(this).parent().parent();
      var id  = parent.find('.idofbet').val();
      getBetDetailbybetId(id);
  });

  function getBetDetailbybetId(id) {
    var timeStamp = "EST";
         $.ajax({
             type:'POST',
             url:'{{url('admin/result/getdetail')}}',
             data:{'_token': '{{ csrf_token() }}','id':id},
             success:function(data) {
              $('#accordion').html('');
              var html='';
               var responseObject = JSON.parse(data);
               $.each(responseObject, function(k, v) {
                     html+='<ul class="list-group list-group-full list-group-divider"><li class="list-group-item">Date Time:- '+v.date+' '+timeStamp+'</li><li class="list-group-item">Competition:- '+v.competition+'</li><li class="list-group-item">Sport:- '+v.sport+'</li><li class="list-group-item">whosplaying:- '+v.type+'</li>';
                     if(v.type=='Team'){
                      html+='<li class="list-group-item">Team A:- '+v.teama+'</li><li class="list-group-item">Team B:- '+v.teamb+'</li>';
                     }else{
                      html+='<li class="list-group-item">Player A:- '+v.playera+'</li><li class="list-group-item">Player B:- '+v.playera+'</li>';
                     }
                     html+='<li class="list-group-item">Tip Type:- '+v.tiptype+'</li><li class="list-group-item">odds:- '+v.odds+'</li><li class="list-group-item">Actual Tip:- '+v.actualtip+'</li><li class="list-group-item">Rating:- '+v.rating+'</li></ul>';
               });
                $('#accordion').append(html);
                 $('#myModal').modal({
                      backdrop: 'static',
                      keyboard: false
                  })
             }
          });
 
  }
  function getsearchResult(month,tab,type) {
     var timeStamp = "EST";
       $.ajax({
             type:'POST',
             url:'{{url('admin/result/search')}}',
             data:{'_token': '{{ csrf_token() }}','month':month,'tab':tab,'type':type},
             success:function(data) {
              console.log(tab)
              var html='';
               var responseObject = JSON.parse(data);
               $('#'+tab+'-total').text('Total Profit-: '+responseObject.sum);
               if(responseObject.data.length===0){
                $('#'+tab+'-tbody').html('');
                $('#'+tab+'-tbody').append("<center><h4>No Record Found!!</h4></center>");
               }else{
                 $.each(responseObject.data, function(k, v) {
                 html+='<tr>';
                 html+='<td>'+ v.betdate+' '+timeStamp+'</td>';
                 html+='<td>'+ v.bettype+'</td>';
                 html+='<td>'+ v.sport+'</td>';
                 html+='<td>'+ v.tiptype+'</td>';
                 html+='<td>'+ v.odds+'</td>';
                 html+='<td>'+ v.betcategory+'</td>';

                 if(v.status=='Pending'){
                 html+='<td><span class="badge badge-warning badge-pill m-b-5">Pending</span></td>';
                 }
                 if(v.status=='Won'){
                  
                 html+='<td><span class="badge badge-success badge-pill m-b-5">'+v.profit+'</span></td>';
                 }
                 if(v.status=='Lost'){
                 html+='<td><span class="badge badge-danger badge-pill m-b-5">'+v.profit+'</span></td>';
                 }
                 if(v.status=='Cancel'){
                 html+='<td><span class="badge badge-default badge-pill m-b-5">Cancel</span></td>';
                 }
                   
                 html+='<td>'+ v.overall_profit+'</td>';


                 html+='<input type="hidden" class="idofbet" value="'+v.id+'"><td><button class="btn btn-default btn-xs showresult-tab1"><i class="fa fa-eye font-14"></i></button></td>';
                 html+='<tr>';
                 });


                 $('#'+tab+'-tbody').html('');
                 $('#'+tab+'-tbody').append(html);
               }
             }
          });
 }    

</script>
@endpush