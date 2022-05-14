@extends('layouts.main')
@section('content')

<style>
.pending-btn{
    background-color: #ffeeba;
    color: #000!important;
}
.pending-btn:hover{
    background-color: #ffeeba!important;
    color: #000!important;
}
.close-btnclr, .close-btnclr:hover{
    background-color: #d1ecf1;
    color: #000!important;
}
.best-resultlast{
    color: #999999;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 32px;
    margin: 30px 0px 30px;
    text-align: center;
}
.best-resultlast_desc h3 {
    text-align: center;
    background-color: #999999;
    color: #fff;
    padding: 12px 0px;
}
.best-resultlast_desc .latest-rsult .table{
    background-color: transparent!important;
}
.best-resultlast_desc .latest-rsult .result-right {
    background-color: #e6e6e6!important;
}
</style>
<section id="plan_info" class="wi-full py-5 text-center all-margin">
        <div class="container">
            <div class="title-main wi-full">
                <h2>{{ __('member.bet_title') }}</h2>
            </div>
        </div>
</section>

  <section class="wi-full py-5">
        <div class="container">
            <div class="results-tabs wi-full">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">BANG OF THE DAY</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">ACCA OF THE DAY</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">BOMBS OF THE DAY</a>
                    </li>
                </ul><!-- Tab panes -->

                <div class="tab-content">
                    <div class="tab-pane active" id="tabs-1" role="tabpanel">
                @if(count($data) > 0)
                  @foreach($data as $bet)
                    @if($bet['betcatid']==1)

                    @if($bet['parent_id'] == 0)
                    <div class="row latest-rsult">
                        <div class="col-8">
                            <div class="table-responsive">
                                <table class="table table-bordered dsktopview table2">
                                    <tbody>
                                        <tr>
                                            <td class="text-left"><p>{{$bet['betdate']}}</p>
                                            <span>{{$bet['bettime']}}</span></td>
                                            <td class="text-center">{{$bet['competion']}}</td>
                                            <td><p>WAGER</p>
                                            <span>€100</span></td>
                                                <td><p>TOTAL ODDS</p>
                                                <span>{{$bet['odds']}}</span></td>
                                                <td><p>PROFIT</p>
                                                <span>+ €100</span></td>
                                            </tr>

                                            <tr>
                                                <td colspan="5" class="text-center"><strong>{{$bet['teama']}}</strong><span>VS</span><strong>{{$bet['teamb']}}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- Mobile VIEW -->
                                    <table class="table table-bordered mbileview table2">
                                        <tbody>
                                            <tr>
                                                <td class="text-left"><p>{{$bet['betdate']}}</p>
                                                <span>{{$bet['bettime']}}</span></td>
                                                <td colspan="2" class="text-center">{{$bet['competion']}}</td>
                                                
                                            </tr>
                                            <tr>
                                                <td><p>WAGER</p>
                                                <span>€100</span></td>
                                                <td><p>TOTAL ODDS</p>
                                                <span>{{$bet['odds']}}</span></td>
                                                <td><p>PROFIT</p>
                                                <span>+ €100</span></td>
                                            </tr>

                                            <tr>
                                                <td colspan="3" class="text-center"><strong>{{$bet['teama']}}</strong><span>VS</span><strong>{{$bet['teamb']}}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- END Mobile VIEW -->
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="result-right">
                                    <ul>
                                        <li>
                                            <div class="detail-match">
                                                <div>
                                                    <tag>TYPE</tag>
                                                    <p>{{$bet['tiptype']}}</p>
                                                </div>
                                                @if($bet['status'] == "Won")
                                                <a href="#" class="btn btn-won btn-sucess float-right">{{$bet['status']}}</a>
                                                @elseif($bet['status'] == "Lost")
                                                <a href="#" class="btn btn-won btn-danger float-right">{{$bet['status']}}</a>
                                                @elseif($bet['status'] == "Pending")
                                                <a href="#" class="btn btn-won btn-danger pending-btn float-right">{{$bet['status']}}</a>
                                                @else
                                                <a href="#" class="btn btn-won close-btnclr btn-danger float-right">{{$bet['status']}}</a>
                                                @endif
                                            </div>
                                        </li>
                                        <li>
                                            <div class="detail-match">
                                                <tag>TIP</tag>
                                                <p>{{$bet['actualtip']}}</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        @elseif($bet['parent_id'] == -1)
                             <!-- ================= Multibet Bet ========================-->
                            <div class="row new_tablestructure">
                              <div class="col-8 div-1">
                                    <div class="newstructure_leftpart">
                                        <div class="new_bettop">
                                          <ul>
                                            <li><strong>DAILY BANG</strong></li>
                                            <li><tag>WAGER</tag><span>€100</span></li>
                                            <li><tag>TOTAL ODDS</tag><span>{{number_format($bet['odds'],2)}}</span></li>
                                            <li><tag>PROFIT</tag><span>€100</span></li>
                                          </ul>
                                        </div>
                                        
                                        @if(count($bet['child_bet']) > 0)
                                        <?php $leftpart = ''; ?>
                                          @foreach($bet['child_bet'] as $key=>$b)

                                            <div class="newbet_bottompart">
                                              <div class="countpart">
                                                <tag>BET</tag>
                                                <p>{{$key + 1}}</p>
                                                 <div class="mb-tag">
                                               <tag>BET ODDS</tag>
                                               <p>{{number_format($b['odd'],2)}}</p>
                                             </div>
                                              </div>
                                              <div class="countpart-full">
                                                <div class="firts-sec">
                                                  <ul>
                                                    <li><tag>{{$b['betdate']}}</tag><p>{{$b['bettime']}}</p></li>
                                                    <li><p>{{$b['competion']}}</p></li>
                                                    <li><tag>BET ODDS</tag><p>{{number_format($b['odd'],2)}}</p></li>
                                                  </ul>
                                                </div>
                                                <div class="secnd-sec">
                                                   <ul>
                                                    <li><p>{{$b['teama']}}</p></li>
                                                    <span>VS</span>
                                                    <li><p>{{$b['teamb']}}</p></li>
                                                  </ul>
                                                </div>
                                              </div>
                                            </div>
                                            <?php
                                            $leftpart .= '<div class="first-newrepeat"><div>
                                                      <tag>TYPE</tag><p>'.$b['tiptype'].'</p>
                                                  </div>
                                                  <div>
                                                      <tag>TIP</tag>
                                                      <p>'.$b['actualtip'].'</p>
                                                  </div>
                                                </div>'; ?>
                                              

                                          @endforeach
                                        @endif
                                      </div>
                              </div>

                              <div class="col-4 div-1">
                                <div class="result-right newpart_result-right">
                                    <ul>
                                        <li>
                                            <div class="detail-match newmultiple_detail-match">

                                                 @if($bet['status'] == "Won")
                                                <a href="#" class="btn btn-won btn-sucess">{{$bet['status']}}</a>
                                                @elseif($bet['status'] == "Lost")
                                                <a href="#" class="btn btn-won btn-danger ">{{$bet['status']}}</a>
                                                @elseif($bet['status'] == "Pending")
                                                <a href="#" class="btn btn-won btn-danger pending-btn float-right">{{$bet['status']}}</a>
                                                @else
                                                <a href="#" class="btn btn-won close-btnclr btn-danger float-right">{{$bet['status']}}</a>
                                                @endif
                                               
                                               <?php echo $leftpart; ?>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                             </div><!--- New COL 4---->
                            </div><!--- New DATA ROW---->


                            <!-- ================= Multibet Bet End========================-->

                            @endif

                        @endif
                     @endforeach
                 @endif  


                        <!-- ==================last five day========================== -->
                   <div class="row latest-rsult"> 
                <div class="col-12">
                    <div class="best-resultlast">
                     Last 5 Days Result                                  
                    </div>
                    </div>
                    </div>
                   
                        <div class="best-resultlast_desc">
                    @if(count($last5daysResult1) > 0)
                          @foreach($last5daysResult1 as $bets)
                             @php
                               $profit = 0;
                               if($bets['status']=='Won'){
                                 $p = ($bets['odds'] * 100);
                                 $profit = ($p - 100);
                               }else{
                                  $profit = -100;
                               }

                             @endphp

                            @if($bets['betcatid']==1)
                            @if($bets['parent_id'] == 0)
                            <div class="row latest-rsult"> 
                            <div class="col-8 div-2">
                            <div class="table-responsive">
                                <table class="table table-bordered dsktopview table2">
                                    <tbody>
                                        <tr>
                                            <td class="text-left"><p>{{$bets['betdate']}}</p>
                                            <span>{{$bets['bettime']}}</span></td>
                                            <td class="text-center">{{$bets['competion']}}</td>
                                            <td><p>WAGER</p>
                                            <span>€100</span></td>
                                                <td><p>TOTAL ODDS</p>
                                                <span>{{number_format($bets['odds'],2)}}</span></td>
                                                <td><p>PROFIT</p>
                                                <span>{{$profit}}</span></td>
                                            </tr>

                                           <tr>
                                                <td colspan="5" class="text-center"><strong>{{$bets['teama']}}</strong><span>VS</span><strong>{{$bets['teamb']}}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- Mobile VIEW -->
                                    <table class="table table-bordered mbileview table2">
                                        <tbody>
                                            <tr>
                                                <td class="text-left"><p>{{$bets['betdate']}}</p>
                                                <span>{{$bets['bettime']}}</span></td>
                                                <td colspan="2" class="text-center">{{$bets['competion']}}</td>
                                                
                                            </tr>
                                            <tr>
                                                <td><p>WAGER</p>
                                                <span>€100</span></td>
                                                <td><p>TOTAL ODDS</p>
                                                <span>{{number_format($bets['odds'],2)}}</span></td>
                                                <td><p>PROFIT</p>
                                                <span>{{$profit}}</span></td>
                                            </tr>

                                            <tr>
                                               <td colspan="3" class="text-center"><strong>{{$bets['teama']}}</strong><span>VS</span><strong>{{$bets['teamb']}}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                               
                            </div>
                            <div class="col-4 div-2">
                                <div class="result-right">
                                    <ul>
                                        <li>
                                            <div class="detail-match">
                                                <div>
                                                    <tag>TYPE</tag>
                                                    <p>{{$bets['tiptype']}}</p>
                                                </div>
                                                @if($bets['status']=='Won')
                                                <a href="#" class="btn btn-won btn-sucess float-right">WON</a>
                                                @endif
                                                 @if($bets['status']=='Lost')
                                                <a href="#" class="btn btn-won btn-danger float-right">LOSS</a>
                                                @endif
                                            </div>
                                        </li>
                                        <li>
                                            <div class="detail-match">
                                                <tag>TIP</tag>
                                                <p>{{$bets['actualtip']}}</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            </div>
                            @elseif($bets['parent_id'] == -1)
                             <!-- ================= Multibet Bet ========================-->
                            <div class="row new_tablestructure">
                              <div class="col-8 div-1">
                                      <div class="newstructure_leftpart">
                                        <div class="new_bettop">
                                          <ul>
                                            <li><strong>DAILY BANG</strong></li>
                                            <li><tag>WAGER</tag><span>€100</span></li>
                                            <li><tag>TOTAL ODDS</tag><span>{{number_format($bets['odds'],2)}}</span></li>
                                            <li><tag>PROFIT</tag><span>{{$profit}}</span></li>
                                          </ul>
                                        </div>
                                        
                                        @if(count($bets['child_bet']) > 0)
                                        <?php $leftpart = ''; ?>
                                          @foreach($bets['child_bet'] as $key=>$b)

                                            <div class="newbet_bottompart">
                                              <div class="countpart">
                                                <tag>BET</tag>
                                                <p>{{$key + 1}}</p>
                                                <div class="mb-tag">
                                               <tag>BET ODDS</tag>
                                               <p>{{number_format($b['odd'],2)}}</p>
                                             </div>
                                              </div>
                                              <div class="countpart-full">
                                                <div class="firts-sec">
                                                  <ul>
                                                    <li><tag>{{$b['betdate']}}</tag><p>{{$b['bettime']}}</p></li>
                                                    <li><p>{{$bets['competion']}}</p></li>
                                                    <li><tag>BET ODDS</tag><p>{{number_format($b['odd'],2)}}</p></li>
                                                  </ul>
                                                </div>
                                                <div class="secnd-sec">
                                                   <ul>
                                                    <li><p>{{$b['teama']}}</p></li>
                                                    <span>VS</span>
                                                    <li><p>{{$b['teamb']}}</p></li>
                                                  </ul>
                                                </div>
                                              </div>
                                            </div>
                                            <?php
                                            $leftpart .= '<div class="first-newrepeat"><div>
                                                      <tag>TYPE</tag><p>'.$b['tiptype'].'</p>
                                                  </div>
                                                  <div>
                                                      <tag>TIP</tag>
                                                      <p>'.$b['actualtip'].'</p>
                                                  </div>
                                                </div>'; ?>
                                              

                                          @endforeach
                                        @endif

                                      </div>
                                  </div>
                              <div class="col-4 div-1">
                                <div class="result-right newpart_result-right">
                                    <ul>
                                        <li>
                                            <div class="detail-match newmultiple_detail-match">
                                                @if($bets['status']=='Won')
                                                <a href="#" class="btn btn-won btn-sucess">WON</a>
                                                @else
                                                <a href="#" class="btn btn-won btn-danger">LOSS</a>
                                                @endif
                                               <?php echo $leftpart; ?>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                             </div><!--- New COL 4---->
                            </div><!--- New DATA ROW---->
                           <!-- ================= Multibet Bet End========================-->
                            @endif


                            @endif
                          
                            @endforeach
                            @else
                            <h3>No Record Found!!</h3>
                            @endif   
                            </div>
                 <!-- ==================last five day========================== -->
                        <!--- DATA ROW--->
                    </div><!-- Tab One -->
                    <div class="tab-pane" id="tabs-2" role="tabpanel">
                @if(count($data) > 0)
                  @foreach($data as $bet)
                    @if($bet['betcatid']==2)
                    @if($bet['parent_id'] == 0)
                    <div class="row latest-rsult">
                        <div class="col-8">
                            <div class="table-responsive">
                                <table class="table table-bordered dsktopview table2">
                                    <tbody>
                                        <tr>
                                            <td class="text-left"><p>{{$bet['betdate']}}</p>
                                            <span>{{$bet['bettime']}}</span></td>
                                            <td class="text-center">{{$bet['competion']}}</td>
                                            <td><p>WAGER</p>
                                            <span>€100</span></td>
                                                <td><p>TOTAL ODDS</p>
                                                <span>{{$bet['odds']}}</span></td>
                                                <td><p>PROFIT</p>
                                                <span>+ €100</span></td>
                                            </tr>

                                            <tr>
                                                <td colspan="5" class="text-center"><strong>{{$bet['teama']}}</strong><span>VS</span><strong>{{$bet['teamb']}}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- Mobile VIEW -->
                                    <table class="table table-bordered mbileview table2">
                                        <tbody>
                                            <tr>
                                                <td class="text-left"><p>{{$bet['betdate']}}</p>
                                                <span>{{$bet['bettime']}}</span></td>
                                                <td colspan="2" class="text-center">{{$bet['competion']}}</td>
                                                
                                            </tr>
                                            <tr>
                                                <td><p>WAGER</p>
                                                <span>€100</span></td>
                                                <td><p>TOTAL ODDS</p>
                                                <span>{{$bet['odds']}}</span></td>
                                                <td><p>PROFIT</p>
                                                <span>+ €100</span></td>
                                            </tr>

                                            <tr>
                                                <td colspan="3" class="text-center"><strong>{{$bet['teama']}}</strong><span>VS</span><strong>{{$bet['teamb']}}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- END Mobile VIEW -->
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="result-right">
                                    <ul>
                                        <li>
                                            <div class="detail-match">
                                                <div>
                                                    <tag>TYPE</tag>
                                                    <p>{{$bet['tiptype']}}</p>
                                                </div>
                                                @if($bet['status'] == "Won")
                                                <a href="#" class="btn btn-won btn-sucess float-right">{{$bet['status']}}</a>
                                                @elseif($bet['status'] == "Lost")
                                                <a href="#" class="btn btn-won btn-danger float-right">{{$bet['status']}}</a>
                                                @elseif($bet['status'] == "Pending")
                                                <a href="#" class="btn btn-won btn-danger pending-btn float-right">{{$bet['status']}}</a>
                                                @else
                                                <a href="#" class="btn btn-won close-btnclr btn-danger float-right">{{$bet['status']}}</a>
                                                @endif
                                               
                                                
                                            </div>
                                        </li>
                                        <li>
                                            <div class="detail-match">
                                                <tag>TIP</tag>
                                                <p>{{$bet['actualtip']}}</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        @elseif($bet['parent_id'] == -1)
                             <!-- ================= Multibet Bet ========================-->
                            <div class="row new_tablestructure">
                              <div class="col-8 div-1">
                                    <div class="newstructure_leftpart">
                                        <div class="new_bettop">
                                          <ul>
                                            <li><strong>ACCA OF THE DAY</strong></li>
                                            <li><tag>WAGER</tag><span>€100</span></li>
                                            <li><tag>TOTAL ODDS</tag><span>{{number_format($bet['odds'],2)}}</span></li>
                                            <li><tag>PROFIT</tag><span>€100</span></li>
                                          </ul>
                                        </div>
                                        
                                        @if(count($bet['child_bet']) > 0)
                                        <?php $leftpart = ''; ?>
                                          @foreach($bet['child_bet'] as $key=>$b)

                                            <div class="newbet_bottompart">
                                              <div class="countpart">
                                                <tag>BET</tag>
                                                <p>{{$key + 1}}</p>
                                                 <div class="mb-tag">
                                               <tag>BET ODDS</tag>
                                               <p>{{number_format($b['odd'],2)}}</p>
                                             </div>
                                              </div>
                                              <div class="countpart-full">
                                                <div class="firts-sec">
                                                  <ul>
                                                    <li><tag>{{$b['betdate']}}</tag><p>{{$b['bettime']}}</p></li>
                                                    <li><p>{{$b['competion']}}</p></li>
                                                    <li><tag>BET ODDS</tag><p>{{number_format($b['odd'],2)}}</p></li>
                                                  </ul>
                                                </div>
                                                <div class="secnd-sec">
                                                   <ul>
                                                    <li><p>{{$b['teama']}}</p></li>
                                                    <span>VS</span>
                                                    <li><p>{{$b['teamb']}}</p></li>
                                                  </ul>
                                                </div>
                                              </div>
                                            </div>
                                            <?php
                                            $leftpart .= '<div class="first-newrepeat"><div>
                                                      <tag>TYPE</tag><p>'.$b['tiptype'].'</p>
                                                  </div>
                                                  <div>
                                                      <tag>TIP</tag>
                                                      <p>'.$b['actualtip'].'</p>
                                                  </div>
                                                </div>'; ?>
                                              

                                          @endforeach
                                        @endif
                                      </div>
                              </div>

                              <div class="col-4 div-1">
                                <div class="result-right newpart_result-right">
                                    <ul>
                                        <li>
                                            <div class="detail-match newmultiple_detail-match">

                                                 @if($bet['status'] == "Won")
                                                <a href="#" class="btn btn-won btn-sucess">{{$bet['status']}}</a>
                                                @elseif($bet['status'] == "Lost")
                                                <a href="#" class="btn btn-won btn-danger ">{{$bet['status']}}</a>
                                                @elseif($bet['status'] == "Pending")
                                                <a href="#" class="btn btn-won btn-danger pending-btn float-right">{{$bet['status']}}</a>
                                                @else
                                                <a href="#" class="btn btn-won close-btnclr btn-danger float-right">{{$bet['status']}}</a>
                                                @endif
                                               
                                               <?php echo $leftpart; ?>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                             </div><!--- New COL 4---->
                            </div><!--- New DATA ROW---->


                            <!-- ================= Multibet Bet End========================-->

                            @endif
                        @endif
                     @endforeach
                 @endif



                        <!-- ==================last five day========================== -->
                   <div class="row latest-rsult"> 
                <div class="col-12">
                    <div class="best-resultlast">
                     Last 5 Days Result                                  
                    </div>
                    </div>
                    </div>
                   
                        <div class="best-resultlast_desc">
                    @if(count($last5daysResult2) > 0)
                          @foreach($last5daysResult2 as $bets)
                             @php
                               $profit = 0;
                               if($bets['status']=='Won'){
                                 $p = ($bets['odds'] * 100);
                                 $profit = ($p - 100);
                               }else{
                                  $profit = -100;
                               }

                             @endphp

                            @if($bets['betcatid']==2)
                            @if($bets['parent_id'] == 0)
                            <div class="row latest-rsult"> 
                            <div class="col-8 div-2">
                            <div class="table-responsive">
                                <table class="table table-bordered dsktopview table2">
                                    <tbody>
                                        <tr>
                                            <td class="text-left"><p>{{$bets['betdate']}}</p>
                                            <span>{{$bets['bettime']}}</span></td>
                                            <td class="text-center">{{$bets['competion']}}</td>
                                            <td><p>WAGER</p>
                                            <span>€100</span></td>
                                                <td><p>TOTAL ODDS</p>
                                                <span>{{number_format($bets['odds'],2)}}</span></td>
                                                <td><p>PROFIT</p>
                                                <span>{{$profit}}</span></td>
                                            </tr>

                                           <tr>
                                                <td colspan="5" class="text-center"><strong>{{$bets['teama']}}</strong><span>VS</span><strong>{{$bets['teamb']}}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- Mobile VIEW -->
                                    <table class="table table-bordered mbileview table2">
                                        <tbody>
                                            <tr>
                                                <td class="text-left"><p>{{$bets['betdate']}}</p>
                                                <span>{{$bets['bettime']}}</span></td>
                                                <td colspan="2" class="text-center">{{$bets['competion']}}</td>
                                                
                                            </tr>
                                            <tr>
                                                <td><p>WAGER</p>
                                                <span>€100</span></td>
                                                <td><p>TOTAL ODDS</p>
                                                <span>{{number_format($bets['odds'],2)}}</span></td>
                                                <td><p>PROFIT</p>
                                                <span>{{$profit}}</span></td>
                                            </tr>

                                            <tr>
                                               <td colspan="3" class="text-center"><strong>{{$bets['teama']}}</strong><span>VS</span><strong>{{$bets['teamb']}}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                               
                            </div>
                            <div class="col-4 div-2">
                                <div class="result-right">
                                    <ul>
                                        <li>
                                            <div class="detail-match">
                                                <div>
                                                    <tag>TYPE</tag>
                                                    <p>{{$bets['tiptype']}}</p>
                                                </div>
                                                @if($bets['status']=='Won')
                                                <a href="#" class="btn btn-won btn-sucess float-right">WON</a>
                                                @endif
                                                 @if($bets['status']=='Lost')
                                                <a href="#" class="btn btn-won btn-danger float-right">LOSS</a>
                                                @endif
                                            </div>
                                        </li>
                                        <li>
                                            <div class="detail-match">
                                                <tag>TIP</tag>
                                                <p>{{$bets['actualtip']}}</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            </div>
                            @elseif($bets['parent_id'] == -1)
                             <!-- ================= Multibet Bet ========================-->
                            <div class="row new_tablestructure">
                              <div class="col-8 div-1">
                                      <div class="newstructure_leftpart">
                                        <div class="new_bettop">
                                          <ul>
                                            <li><strong>ACCA OF THE DAY</strong></li>
                                            <li><tag>WAGER</tag><span>€100</span></li>
                                            <li><tag>TOTAL ODDS</tag><span>{{number_format($bets['odds'],2)}}</span></li>
                                            <li><tag>PROFIT</tag><span>{{$profit}}</span></li>
                                          </ul>
                                        </div>
                                        
                                        @if(count($bets['child_bet']) > 0)
                                        <?php $leftpart = ''; ?>
                                          @foreach($bets['child_bet'] as $key=>$b)

                                            <div class="newbet_bottompart">
                                              <div class="countpart">
                                                <tag>BET</tag>
                                                <p>{{$key + 1}}</p>
                                                <div class="mb-tag">
                                               <tag>BET ODDS</tag>
                                               <p>{{number_format($b['odd'],2)}}</p>
                                             </div>
                                              </div>
                                              <div class="countpart-full">
                                                <div class="firts-sec">
                                                  <ul>
                                                    <li><tag>{{$b['betdate']}}</tag><p>{{$b['bettime']}}</p></li>
                                                    <li><p>{{$bets['competion']}}</p></li>
                                                    <li><tag>BET ODDS</tag><p>{{number_format($b['odd'],2)}}</p></li>
                                                  </ul>
                                                </div>
                                                <div class="secnd-sec">
                                                   <ul>
                                                    <li><p>{{$b['teama']}}</p></li>
                                                    <span>VS</span>
                                                    <li><p>{{$b['teamb']}}</p></li>
                                                  </ul>
                                                </div>
                                              </div>
                                            </div>
                                            <?php
                                            $leftpart .= '<div class="first-newrepeat"><div>
                                                      <tag>TYPE</tag><p>'.$b['tiptype'].'</p>
                                                  </div>
                                                  <div>
                                                      <tag>TIP</tag>
                                                      <p>'.$b['actualtip'].'</p>
                                                  </div>
                                                </div>'; ?>
                                              

                                          @endforeach
                                        @endif

                                      </div>
                                  </div>
                              <div class="col-4 div-1">
                                <div class="result-right newpart_result-right">
                                    <ul>
                                        <li>
                                            <div class="detail-match newmultiple_detail-match">
                                                @if($bets['status']=='Won')
                                                <a href="#" class="btn btn-won btn-sucess">WON</a>
                                                @else
                                                <a href="#" class="btn btn-won btn-danger">LOSS</a>
                                                @endif
                                               <?php echo $leftpart; ?>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                             </div><!--- New COL 4---->
                            </div><!--- New DATA ROW---->
                           <!-- ================= Multibet Bet End========================-->
                            @endif


                            @endif
                          
                            @endforeach
                            @else
                            <h3>No Record Found!!</h3>
                            @endif   
                            </div>
                 <!-- ==================last five day========================== -->
                        
                    </div><!-- Tab Two -->
                    <div class="tab-pane" id="tabs-3" role="tabpanel">
                @if(count($data) > 0)
                  @foreach($data as $bet)
                    @if($bet['betcatid']==3)
                    @if($bet['parent_id'] == 0)
                    <div class="row latest-rsult">
                        <div class="col-8">
                            <div class="table-responsive">
                                <table class="table table-bordered dsktopview table2">
                                    <tbody>
                                        <tr>
                                            <td class="text-left"><p>{{$bet['betdate']}}</p>
                                            <span>{{$bet['bettime']}}</span></td>
                                            <td class="text-center">{{$bet['competion']}}</td>
                                            <td><p>WAGER</p>
                                            <span>€100</span></td>
                                                <td><p>TOTAL ODDS</p>
                                                <span>{{$bet['odds']}}</span></td>
                                                <td><p>PROFIT</p>
                                                <span>+ €100</span></td>
                                            </tr>

                                            <tr>
                                                <td colspan="5" class="text-center"><strong>{{$bet['teama']}}</strong><span>VS</span><strong>{{$bet['teamb']}}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- Mobile VIEW -->
                                    <table class="table table-bordered mbileview table2">
                                        <tbody>
                                            <tr>
                                                <td class="text-left"><p>{{$bet['betdate']}}</p>
                                                <span>{{$bet['bettime']}}</span></td>
                                                <td colspan="2" class="text-center">{{$bet['competion']}}</td>
                                                
                                            </tr>
                                            <tr>
                                                <td><p>WAGER</p>
                                                <span>€100</span></td>
                                                <td><p>TOTAL ODDS</p>
                                                <span>{{$bet['odds']}}</span></td>
                                                <td><p>PROFIT</p>
                                                <span>+ €100</span></td>
                                            </tr>

                                            <tr>
                                                <td colspan="3" class="text-center"><strong>{{$bet['teama']}}</strong><span>VS</span><strong>{{$bet['teamb']}}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- END Mobile VIEW -->
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="result-right">
                                    <ul>
                                        <li>
                                            <div class="detail-match">
                                                <div>
                                                    <tag>TYPE</tag>
                                                    <p>{{$bet['tiptype']}}</p>
                                                </div>
                                               @if($bet['status'] == "Won")
                                                <a href="#" class="btn btn-won btn-sucess float-right">{{$bet['status']}}</a>
                                                @elseif($bet['status'] == "Lost")
                                                <a href="#" class="btn btn-won btn-danger float-right">{{$bet['status']}}</a>
                                                @elseif($bet['status'] == "Pending")
                                                <a href="#" class="btn btn-won btn-sucess pending-btn float-right">{{$bet['status']}}</a>
                                                @else
                                                <a href="#" class="btn btn-won close-btnclr btn-danger float-right">{{$bet['status']}}</a>
                                                @endif
                                            </div>
                                        </li>
                                        <li>
                                            <div class="detail-match">
                                                <tag>TIP</tag>
                                                <p>{{$bet['actualtip']}}</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        @elseif($bet['parent_id'] == -1)
                             <!-- ================= Multibet Bet ========================-->
                            <div class="row new_tablestructure">
                              <div class="col-8 div-1">
                                    <div class="newstructure_leftpart">
                                        <div class="new_bettop">
                                          <ul>
                                            <li><strong>DAILY BANG</strong></li>
                                            <li><tag>WAGER</tag><span>€100</span></li>
                                            <li><tag>TOTAL ODDS</tag><span>{{number_format($bet['odds'],2)}}</span></li>
                                            <li><tag>PROFIT</tag><span>€100</span></li>
                                          </ul>
                                        </div>
                                        
                                        @if(count($bet['child_bet']) > 0)
                                        <?php $leftpart = ''; ?>
                                          @foreach($bet['child_bet'] as $key=>$b)

                                            <div class="newbet_bottompart">
                                              <div class="countpart">
                                                <tag>BET</tag>
                                                <p>{{$key + 1}}</p>
                                                 <div class="mb-tag">
                                               <tag>BET ODDS</tag>
                                               <p>{{number_format($b['odd'],2)}}</p>
                                             </div>
                                              </div>
                                              <div class="countpart-full">
                                                <div class="firts-sec">
                                                  <ul>
                                                    <li><tag>{{$b['betdate']}}</tag><p>{{$b['bettime']}}</p></li>
                                                    <li><p>{{$b['competion']}}</p></li>
                                                    <li><tag>BET ODDS</tag><p>{{number_format($b['odd'],2)}}</p></li>
                                                  </ul>
                                                </div>
                                                <div class="secnd-sec">
                                                   <ul>
                                                    <li><p>{{$b['teama']}}</p></li>
                                                    <span>VS</span>
                                                    <li><p>{{$b['teamb']}}</p></li>
                                                  </ul>
                                                </div>
                                              </div>
                                            </div>
                                            <?php
                                            $leftpart .= '<div class="first-newrepeat"><div>
                                                      <tag>TYPE</tag><p>'.$b['tiptype'].'</p>
                                                  </div>
                                                  <div>
                                                      <tag>TIP</tag>
                                                      <p>'.$b['actualtip'].'</p>
                                                  </div>
                                                </div>'; ?>
                                              

                                          @endforeach
                                        @endif
                                      </div>
                              </div>

                              <div class="col-4 div-1">
                                <div class="result-right newpart_result-right">
                                    <ul>
                                        <li>
                                            <div class="detail-match newmultiple_detail-match">

                                                 @if($bet['status'] == "Won")
                                                <a href="#" class="btn btn-won btn-sucess">{{$bet['status']}}</a>
                                                @elseif($bet['status'] == "Lost")
                                                <a href="#" class="btn btn-won btn-danger ">{{$bet['status']}}</a>
                                                @elseif($bet['status'] == "Pending")
                                                <a href="#" class="btn btn-won btn-danger pending-btn float-right">{{$bet['status']}}</a>
                                                @else
                                                <a href="#" class="btn btn-won close-btnclr btn-danger float-right">{{$bet['status']}}</a>
                                                @endif
                                               
                                               <?php echo $leftpart; ?>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                             </div><!--- New COL 4---->
                            </div><!--- New DATA ROW---->


                            <!-- ================= Multibet Bet End========================-->

                            @endif
                        @endif
                     @endforeach
                 @endif


                 <!-- ==================last five day========================== -->
                   <div class="row latest-rsult"> 
                <div class="col-12">
                    <div class="best-resultlast">
                     Last 5 Days Result                                  
                    </div>
                    </div>
                    </div>
                   
                        <div class="best-resultlast_desc">
                    @if(count($last5daysResult3) > 0)
                          @foreach($last5daysResult3 as $bets)
                             @php
                               $profit = 0;
                               if($bets['status']=='Won'){
                                 $p = ($bets['odds'] * 100);
                                 $profit = ($p - 100);
                               }else{
                                  $profit = -100;
                               }

                             @endphp

                            @if($bets['betcatid']==3)
                            @if($bets['parent_id'] == 0)
                            <div class="row latest-rsult"> 
                            <div class="col-8 div-2">
                            <div class="table-responsive">
                                <table class="table table-bordered dsktopview table2">
                                    <tbody>
                                        <tr>
                                            <td class="text-left"><p>{{$bets['betdate']}}</p>
                                            <span>{{$bets['bettime']}}</span></td>
                                            <td class="text-center">{{$bets['competion']}}</td>
                                            <td><p>WAGER</p>
                                            <span>€100</span></td>
                                                <td><p>TOTAL ODDS</p>
                                                <span>{{number_format($bets['odds'],2)}}</span></td>
                                                <td><p>PROFIT</p>
                                                <span>{{$profit}}</span></td>
                                            </tr>

                                           <tr>
                                                <td colspan="5" class="text-center"><strong>{{$bets['teama']}}</strong><span>VS</span><strong>{{$bets['teamb']}}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- Mobile VIEW -->
                                    <table class="table table-bordered mbileview table2">
                                        <tbody>
                                            <tr>
                                                <td class="text-left"><p>{{$bets['betdate']}}</p>
                                                <span>{{$bets['bettime']}}</span></td>
                                                <td colspan="2" class="text-center">{{$bets['competion']}}</td>
                                                
                                            </tr>
                                            <tr>
                                                <td><p>WAGER</p>
                                                <span>€100</span></td>
                                                <td><p>TOTAL ODDS</p>
                                                <span>{{number_format($bets['odds'],2)}}</span></td>
                                                <td><p>PROFIT</p>
                                                <span>{{$profit}}</span></td>
                                            </tr>

                                            <tr>
                                               <td colspan="3" class="text-center"><strong>{{$bets['teama']}}</strong><span>VS</span><strong>{{$bets['teamb']}}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                               
                            </div>
                            <div class="col-4 div-2">
                                <div class="result-right">
                                    <ul>
                                        <li>
                                            <div class="detail-match">
                                                <div>
                                                    <tag>TYPE</tag>
                                                    <p>{{$bets['tiptype']}}</p>
                                                </div>
                                                @if($bets['status']=='Won')
                                                <a href="#" class="btn btn-won btn-sucess float-right">WON</a>
                                                @endif
                                                 @if($bets['status']=='Lost')
                                                <a href="#" class="btn btn-won btn-danger float-right">LOSS</a>
                                                @endif
                                            </div>
                                        </li>
                                        <li>
                                            <div class="detail-match">
                                                <tag>TIP</tag>
                                                <p>{{$bets['actualtip']}}</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            </div>
                            @elseif($bets['parent_id'] == -1)
                             <!-- ================= Multibet Bet ========================-->
                            <div class="row new_tablestructure">
                              <div class="col-8 div-1">
                                      <div class="newstructure_leftpart">
                                        <div class="new_bettop">
                                          <ul>
                                            <li><strong>BOMBS OF THE DAY  </strong></li>
                                            <li><tag>WAGER</tag><span>€100</span></li>
                                            <li><tag>TOTAL ODDS</tag><span>{{number_format($bets['odds'],2)}}</span></li>
                                            <li><tag>PROFIT</tag><span>{{$profit}}</span></li>
                                          </ul>
                                        </div>
                                        
                                        @if(count($bets['child_bet']) > 0)
                                        <?php $leftpart = ''; ?>
                                          @foreach($bets['child_bet'] as $key=>$b)

                                            <div class="newbet_bottompart">
                                              <div class="countpart">
                                                <tag>BET</tag>
                                                <p>{{$key + 1}}</p>
                                                <div class="mb-tag">
                                               <tag>BET ODDS</tag>
                                               <p>{{number_format($b['odd'],2)}}</p>
                                             </div>
                                              </div>
                                              <div class="countpart-full">
                                                <div class="firts-sec">
                                                  <ul>
                                                    <li><tag>{{$b['betdate']}}</tag><p>{{$b['bettime']}}</p></li>
                                                    <li><p>{{$bets['competion']}}</p></li>
                                                    <li><tag>BET ODDS</tag><p>{{number_format($b['odd'],2)}}</p></li>
                                                  </ul>
                                                </div>
                                                <div class="secnd-sec">
                                                   <ul>
                                                    <li><p>{{$b['teama']}}</p></li>
                                                    <span>VS</span>
                                                    <li><p>{{$b['teamb']}}</p></li>
                                                  </ul>
                                                </div>
                                              </div>
                                            </div>
                                            <?php
                                            $leftpart .= '<div class="first-newrepeat"><div>
                                                      <tag>TYPE</tag><p>'.$b['tiptype'].'</p>
                                                  </div>
                                                  <div>
                                                      <tag>TIP</tag>
                                                      <p>'.$b['actualtip'].'</p>
                                                  </div>
                                                </div>'; ?>
                                              

                                          @endforeach
                                        @endif

                                      </div>
                                  </div>
                              <div class="col-4 div-1">
                                <div class="result-right newpart_result-right">
                                    <ul>
                                        <li>
                                            <div class="detail-match newmultiple_detail-match">
                                                @if($bets['status']=='Won')
                                                <a href="#" class="btn btn-won btn-sucess">WON</a>
                                                @else
                                                <a href="#" class="btn btn-won btn-danger">LOSS</a>
                                                @endif
                                               <?php echo $leftpart; ?>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                             </div><!--- New COL 4---->
                            </div><!--- New DATA ROW---->
                           <!-- ================= Multibet Bet End========================-->
                            @endif


                            @endif
                          
                            @endforeach
                            @else
                            <h3>No Record Found!!</h3>
                            @endif   
                            </div>
                 <!-- ==================last five day========================== -->
				
                        <!-- DATA ROW---->
                    </div><!-- Tab Three -->
                </div><!-- Tab Content -->
                
              
           
                   
            </div>
        </div>
    </section>

   
    @endsection
    @section('js_file')
     <script src="{{asset('public/front/js/auth.js')}}"></script>
     <script src="{{asset('public/front/js/dashboard.js')}}"></script>
    @endsection