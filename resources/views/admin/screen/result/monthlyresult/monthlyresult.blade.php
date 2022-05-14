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
.table thead th{
 cursor: pointer; 
}
.table-bordered thead td, .table-bordered thead th{
 text-align: center; 
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
                                @if(count($betcategory) > 0)
                                   @php
                                     $count = 1;
                                     $monthArray = array();
                                     $months = array(
                                            'January',
                                            'February',
                                            'March',
                                            'April',
                                            'May',
                                            'June',
                                            'July ',
                                            'August',
                                            'September',
                                            'October',
                                            'November',
                                            'December'
                                        ); 

                                            $thismonth = date('n');
                                   @endphp
                                 @foreach($betcategory as $betcat)
                                  <li class="nav-item @if($count == 1) active @endif">
                                      <a class="nav-link" href="#pill-1-{{$count++}}" data-toggle="tab" aria-expanded="false">{{$betcat['name']}}</a>
                                  </li>
                                 @endforeach
                                @endif
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="pill-1-1" aria-expanded="true">
                                  <table class="table table-bordered">
                                    <thead class="thead-default">
                                        <tr>
                                          <th>&nbsp;</th>
                                          <input type="hidden" class="tabnumber" value="tab1">
                                          <th style="background-color: #2ecc71;" class="month-tab1">{{$months[$thismonth-1]}}</th>
                                          @for($i=0;$i < 12;$i++)
                                            @if($i+1!=$thismonth)
                                              <th class="month-tab1">{{$months[$i]}}</th>
                                            @endif
                                          @endfor
                                        </tr>
                                        <tr>
                                          <td>Number of best</td>
                                          @if(isset($data[$thismonth]))
                                          <td>{{$data[$thismonth]['total']}}</td>
                                          @else
                                          <td>0</td>
                                          @endif 
                                           @for($j=1;$j <= 12; $j++)
                                            @if($j!=$thismonth)
                                             @if(array_key_exists($j,$data))
                                               <td>{{$data[$j]['total']}}</td>
                                              @else
                                               <td>0</td>
                                              @endif 
                                             @endif 
                                           @endfor
                                        </tr>
                                        <tr>
                                          <td>Average Final Odds</td>
                                          @if(isset($data[$thismonth]))
                                          <td>{{$data[$thismonth]['totalAverageOdds']}}</td>
                                          @else
                                          <td>0</td>
                                          @endif 
                                           @for($j=1;$j <= 12; $j++)
                                            @if($j!=$thismonth)
                                             @if(array_key_exists($j,$data))
                                               <td>{{$data[$j]['totalAverageOdds']}}</td>
                                              @else
                                               <td>0</td>
                                              @endif 
                                             @endif 
                                           @endfor
                                        </tr>
                                        <tr>
                                          <td>Average Win Rate</td>
                                           @if(isset($data[$thismonth]))
                                           <td>{{$data[$thismonth]['winpercent']}}%</td>
                                          @else
                                          <td>0</td>
                                          @endif
                                           @for($j=1;$j <= 12; $j++)
                                            @if($j!=$thismonth)
                                             @if(array_key_exists($j,$data))
                                               <td>{{$data[$j]['winpercent']}}%</td>
                                              @else
                                               <td>0</td>
                                              @endif 
                                             @endif 
                                           @endfor
                                        </tr>
                                        <tr>
                                          <td>Average Loss Rate</td>
                                           @if(isset($data[$thismonth]))
                                          <td>{{$data[$thismonth]['losspercent']}}%</td>
                                          @else
                                          <td>0</td>
                                          @endif
                                           @for($j=1;$j <= 12; $j++)
                                            @if($j!=$thismonth)
                                             @if(array_key_exists($j,$data))
                                               <td>{{$data[$j]['losspercent']}}%</td>
                                              @else
                                               <td>0</td>
                                              @endif 
                                             @endif 
                                           @endfor
                                        </tr>
                                        <tr>
                                          <td>Monthly Profit</td>
                                           @if(isset($data[$thismonth]))
                                          <td>{{$data[$thismonth]['profit']}}</td>
                                          @else
                                          <td>0</td>
                                          @endif
                                           @for($j=1;$j <= 12; $j++)
                                            @if($j!=$thismonth)
                                             @if(array_key_exists($j,$data))
                                               <td>{{$data[$j]['profit']}}</td>
                                              @else
                                               <td>0</td>
                                              @endif 
                                             @endif 
                                           @endfor
                                        </tr>
                                        <tr>
                                          <td>Status</td>
                                         @if(isset($data[$thismonth]))
                                          @if($data[$thismonth]['profit'] >= 0)
                                          <td><i class="fa fa-arrow-up" style="color: #28a745"></td>
                                          @else
                                          <td><i class="fa fa-arrow-down" style="color: #dc3545"></td>
                                          @endif
                                          @else
                                          <td>-</td>
                                          @endif
                                           @for($j=1;$j <= 12; $j++)
                                            @if($j!=$thismonth)
                                             @if(array_key_exists($j,$data))
                                               @if($data[$j]['profit'] >= 0)
                                                  <td><i class="fa fa-arrow-up" style="color: #28a745"></td>
                                                  @else
                                                  <td><i class="fa fa-arrow-down" style="color: #dc3545"></td>
                                                  @endif
                                              @else
                                               <td>-</td>
                                              @endif 
                                             @endif 
                                           @endfor
                                        </tr>
                                    </thead>
                                </table>
                                </div>
                                <div class="tab-pane" id="pill-1-2" aria-expanded="false">
                                 <table class="table table-bordered">
                                    <thead class="thead-default">
                                        <tr>
                                          <th>&nbsp;</th>
                                          <input type="hidden" class="tabnumber" value="tab2">
                                          <th style="background-color: #2ecc71;" class="month-tab1">{{$months[$thismonth-1]}}</th>
                                          @for($i=0;$i < 12;$i++)
                                            @if($i+1!=$thismonth)
                                              <th class="month-tab1">{{$months[$i]}}</th>
                                            @endif
                                          @endfor
                                        </tr>
                                        <tr>
                                          <td>Number of best</td>
                                          @if(isset($data1[$thismonth]))
                                          <td>{{$data1[$thismonth]['total']}}</td>
                                          @else
                                          <td>0</td>
                                          @endif 
                                           @for($j=1;$j <= 12; $j++)
                                            @if($j!=$thismonth)
                                             @if(array_key_exists($j,$data1))
                                               <td>{{$data1[$j]['total']}}</td>
                                              @else
                                               <td>0</td>
                                              @endif 
                                             @endif 
                                           @endfor
                                        </tr>
                                        <tr>
                                          <td>Average Final Odds</td>
                                          @if(isset($data1[$thismonth]))
                                          <td>{{$data1[$thismonth]['totalAverageOdds']}}</td>
                                          @else
                                          <td>0</td>
                                          @endif 
                                           @for($j=1;$j <= 12; $j++)
                                            @if($j!=$thismonth)
                                             @if(array_key_exists($j,$data1))
                                               <td>{{$data1[$j]['totalAverageOdds']}}</td>
                                              @else
                                               <td>0</td>
                                              @endif 
                                             @endif 
                                           @endfor
                                        </tr>
                                        <tr>
                                          <td>Average Win Rate</td>
                                           @if(isset($data1[$thismonth]))
                                           <td>{{$data1[$thismonth]['winpercent']}}%</td>
                                          @else
                                          <td>0</td>
                                          @endif
                                           @for($j=1;$j <= 12; $j++)
                                            @if($j!=$thismonth)
                                             @if(array_key_exists($j,$data1))
                                               <td>{{$data1[$j]['winpercent']}}%</td>
                                              @else
                                               <td>0</td>
                                              @endif 
                                             @endif 
                                           @endfor
                                        </tr>
                                        <tr>
                                          <td>Average Loss Rate</td>
                                           @if(isset($data1[$thismonth]))
                                          <td>{{$data1[$thismonth]['losspercent']}}%</td>
                                          @else
                                          <td>0</td>
                                          @endif
                                           @for($j=1;$j <= 12; $j++)
                                            @if($j!=$thismonth)
                                             @if(array_key_exists($j,$data1))
                                               <td>{{$data1[$j]['losspercent']}}%</td>
                                              @else
                                               <td>0</td>
                                              @endif 
                                             @endif 
                                           @endfor
                                        </tr>
                                        <tr>
                                          <td>Monthly Profit</td>
                                           @if(isset($data1[$thismonth]))
                                          <td>{{$data1[$thismonth]['profit']}}</td>
                                          @else
                                          <td>0</td>
                                          @endif
                                           @for($j=1;$j <= 12; $j++)
                                            @if($j!=$thismonth)
                                             @if(array_key_exists($j,$data1))
                                               <td>{{$data1[$j]['profit']}}</td>
                                              @else
                                               <td>0</td>
                                              @endif 
                                             @endif 
                                           @endfor
                                        </tr>
                                        <tr>
                                          <td>Status</td>
                                         @if(isset($data1[$thismonth]))
                                          @if($data1[$thismonth]['profit'] >= 0)
                                          <td><i class="fa fa-arrow-up" style="color: #28a745"></td>
                                          @else
                                          <td><i class="fa fa-arrow-down" style="color: #dc3545"></td>
                                          @endif
                                          @else
                                          <td>-</td>
                                          @endif
                                           @for($j=1;$j <= 12; $j++)
                                            @if($j!=$thismonth)
                                             @if(array_key_exists($j,$data1))
                                               @if($data1[$j]['profit'] >= 0)
                                                  <td><i class="fa fa-arrow-up" style="color: #28a745"></td>
                                                  @else
                                                  <td><i class="fa fa-arrow-down" style="color: #dc3545"></td>
                                                  @endif
                                              @else
                                               <td>-</td>
                                              @endif 
                                             @endif 
                                           @endfor
                                        </tr>
                                    </thead>
                                </table>
                                </div>
                                <div class="tab-pane" id="pill-1-3" aria-expanded="false">
                                  <table class="table table-bordered">
                                    <thead class="thead-default">
                                        <tr>
                                          <th>&nbsp;</th>
                                          <input type="hidden" class="tabnumber" value="tab3">
                                          <th style="background-color: #2ecc71;" class="month-tab1">{{$months[$thismonth-1]}}</th>
                                          @for($i=0;$i < 12;$i++)
                                            @if($i+1!=$thismonth)
                                              <th class="month-tab1">{{$months[$i]}}</th>
                                            @endif
                                          @endfor
                                        </tr>
                                        <tr>
                                          <td>Number of best</td>
                                          @if(isset($data2[$thismonth]))
                                          <td>{{$data2[$thismonth]['total']}}</td>
                                          @else
                                          <td>0</td>
                                          @endif 
                                           @for($j=1;$j <= 12; $j++)
                                            @if($j!=$thismonth)
                                             @if(array_key_exists($j,$data2))
                                               <td>{{$data2[$j]['total']}}</td>
                                              @else
                                               <td>0</td>
                                              @endif 
                                             @endif 
                                           @endfor
                                        </tr>
                                        <tr>
                                          <td>Average Final Odds</td>
                                          @if(isset($data2[$thismonth]))
                                          <td>{{$data2[$thismonth]['totalAverageOdds']}}</td>
                                          @else
                                          <td>0</td>
                                          @endif 
                                           @for($j=1;$j <= 12; $j++)
                                            @if($j!=$thismonth)
                                             @if(array_key_exists($j,$data2))
                                               <td>{{$data2[$j]['totalAverageOdds']}}</td>
                                              @else
                                               <td>0</td>
                                              @endif 
                                             @endif 
                                           @endfor
                                        </tr>
                                        <tr>
                                          <td>Average Win Rate</td>
                                           @if(isset($data2[$thismonth]))
                                           <td>{{$data2[$thismonth]['winpercent']}}%</td>
                                          @else
                                          <td>0</td>
                                          @endif
                                           @for($j=1;$j <= 12; $j++)
                                            @if($j!=$thismonth)
                                             @if(array_key_exists($j,$data2))
                                               <td>{{$data2[$j]['winpercent']}}%</td>
                                              @else
                                               <td>0</td>
                                              @endif 
                                             @endif 
                                           @endfor
                                        </tr>
                                        <tr>
                                          <td>Average Loss Rate</td>
                                           @if(isset($data2[$thismonth]))
                                          <td>{{$data2[$thismonth]['losspercent']}}%</td>
                                          @else
                                          <td>0</td>
                                          @endif
                                           @for($j=1;$j <= 12; $j++)
                                            @if($j!=$thismonth)
                                             @if(array_key_exists($j,$data2))
                                               <td>{{$data2[$j]['losspercent']}}%</td>
                                              @else
                                               <td>0</td>
                                              @endif 
                                             @endif 
                                           @endfor
                                        </tr>
                                        <tr>
                                          <td>Monthly Profit</td>
                                           @if(isset($data2[$thismonth]))
                                          <td>{{$data2[$thismonth]['profit']}}</td>
                                          @else
                                          <td>0</td>
                                          @endif
                                           @for($j=1;$j <= 12; $j++)
                                            @if($j!=$thismonth)
                                             @if(array_key_exists($j,$data2))
                                               <td>{{$data2[$j]['profit']}}</td>
                                              @else
                                               <td>0</td>
                                              @endif 
                                             @endif 
                                           @endfor
                                        </tr>
                                        <tr>
                                          <td>Status</td>
                                         @if(isset($data2[$thismonth]))
                                          @if($data2[$thismonth]['profit'] >= 0)
                                          <td><i class="fa fa-arrow-up" style="color: #28a745"></td>
                                          @else
                                          <td><i class="fa fa-arrow-down" style="color: #dc3545"></td>
                                          @endif
                                          @else
                                          <td>-</td>
                                          @endif
                                           @for($j=1;$j <= 12; $j++)
                                            @if($j!=$thismonth)
                                             @if(array_key_exists($j,$data2))
                                               @if($data2[$j]['profit'] >= 0)
                                                  <td><i class="fa fa-arrow-up" style="color: #28a745"></td>
                                                  @else
                                                  <td><i class="fa fa-arrow-down" style="color: #dc3545"></td>
                                                  @endif
                                              @else
                                               <td>-</td>
                                              @endif 
                                             @endif 
                                           @endfor
                                        </tr>
                                    </thead>
                                </table>
                                </div>
                                <!-- <div class="tab-pane" id="pill-1-4" aria-expanded="false">
                                 
                                </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="myModal" role="dialog">
              <div class="modal-dialog" style="max-width: 740px !important;">
              
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Bet Detail</h4>
                  </div>
                  <div class="modal-body">
                  <h5 id="monthName">Month Name:-</h5>
                   <table class="table">
                      <thead>
                          <tr>
                              <th>Betdate</th>
                              <th>Sport</th>
                              <th>Tipt Type</th>
                              <th>Odds</th>
                              <th>Betcategory</th>
                              <th>Profit</th>
                          </tr>
                      </thead>
                      <tbody id="model-tbody">
                         
                      </tbody>
                  </table>
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
$('.month-tab1').click(function (){
 var monthname = $(this).text();
 var tab = $(this).parent().find('.tabnumber').val();
 getresultbymonth(tab,monthname);
 //alert(monthname);
});
function getresultbymonth(tab,month) {
     var timeStamp = "EST";
         $.ajax({
             type:'POST',
             url:'{{url('admin/result/searchbymonth')}}',
             data:{'_token': '{{ csrf_token() }}','tab':tab,'month':month},
             success:function(data) {
              //console.log(data) 
              $('#model-tbody').html('');
              var html='';
               var responseObject = JSON.parse(data);
               if(responseObject.length===0){
                html+='<center><h4>No Record Found!!</h4></center>';
                //$('#model-tbody').append("<center><h4>No Record Found!!</h4></center>");
               }else{
                   $.each(responseObject, function(k, v) {
                        html+='<tr>';
                            html+='<td>'+v.betdate+' '+timeStamp+'</td>'; 
                            html+='<td>'+v.sport+'</td>'; 
                            html+='<td>'+v.tiptype+'</td>'; 
                            html+='<td>'+v.odds+'</td>'; 
                            html+='<td>'+v.betcategory+'</td>'; 
                            html+='<td>'+v.profit+'</td>'; 
                        html+='</tr>'; 
                   });
                 }
                 $('#monthName').text('Month Name:- '+month)
                $('#model-tbody').append(html);
                 $('#myModal').modal({
                      backdrop: 'static',
                      keyboard: false
                  })
             }
          });
}


</script>
@endpush