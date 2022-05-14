@extends('layouts.main')
@section('content')

    <section class="banner-section wi-full all-margin" style="background-image: url({{url('/public/front')}}/images/banner-new.jpg);">
        <div class="container">
            <div class="banner-text">
                <h1>Spargem <br/>
                    casieriaaa!</h1>
            </div>
        </div>
    </section>

    <section class="tips-section wi-full py-5 text-center bg-gray">
        <div class="container">
            <div class="title-main">
                <h2>TIPS THAT “BANG”</h2>
            </div>
            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="tips-sec">
                        <h5>ON GREEN</h5>
                        <p>our priority is to get you results, constantly. To have a constancy of 85% success rate and average odds between 1.60-1.75</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="tips-sec">
                        <h5>BANKROLL FOCUSED</h5>
                        <p>if we keep your bankroll positive and healthy we know we made it. 
                            This is how we honor your subscription.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="tips-sec">
                        <h5>TRANSPARENCY</h5>
                        <p>long term, soundproof stats. We do not adjust. We're in for the long run together with you</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="wi-full latest-rsult py-5 bg-white">
        <div class="container">
            <div class="title-main text-center mb-5">
                <h2>LATEST RESULTS</h2>
            </div>

        <div class="full-part wi-full mt-5">
            <div class="title-bang">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2>DAILY BANG</h2>
                    </div>
                    <div class="col-md-4">
                        <div class="points-clculate profit">
                            <p>profits in the last <br/>
                                <strong>30 days</strong></p>
                                @if(isset($totalsumpass30days['cat1']))
                                 @if($totalsumpass30days['cat1'] >= 0 )
                                    <span>+ €{{$totalsumpass30days['cat1']}}</span>
                                 @else 
                                  <span>- €{{$totalsumpass30days['cat1']}}</span>
                                @endif
                               @endif 
                        </div>
                    </div>
                </div>
            </div>

            @if(count($data) > 0)
              @foreach($data as $bets)
                @if($bets['betcatid']==1)
                 @php
                   $profit = 0;
                   if($bets['status']=='Won'){
                     $p = ($bets['odds'] * 100);
                     $profit = ($p - 100);
                   }else{
                      $profit = -100;
                   }
                    @endphp
                @if($bets['parent_id'] == 0)
                <div class="row">
                    <div class="col-8">
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
                @endif
               <!--  <div class="row">
                    <div class="col-md-4 offset-md-8 text-center mt-2">
                        <a href="#" class="btn btn-result">SEE ALL “DAILY BANG” RESULTS</a>
                    </div>
                </div> -->
            </div>
            <!---Full Part END--->

            <!---Full Part START---->
            <div class="full-part wi-full mt-5 pt-4">
            <div class="title-bang">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2>ACCA OF THE DAY</h2>
                    </div>
                    <div class="col-md-4">
                        <div class="points-clculate profit">
                            <p>profits in the last <br/>
                                <strong>30 days</strong></p>
                            @if(isset($totalsumpass30days['cat2']))
                             @if($totalsumpass30days['cat2'] >= 0 )
                                <span>+ €{{$totalsumpass30days['cat2']}}</span>
                             @else 
                              <span>- €{{$totalsumpass30days['cat2']}}</span>
                            @endif
                           @endif
                        </div>
                    </div>
                </div>
            </div>
            @if(count($data) > 0)
              @foreach($data as $bets)
                @if($bets['betcatid']==2)
                 @php
                   $profit = 0;
                   if($bets['status']=='Won'){
                     $p = ($bets['odds'] * 100);
                     $profit = ($p - 100);
                   }else{
                      $profit = -100;
                   }
                    @endphp
                @if($bets['parent_id'] == 0)
                <div class="row">
                    <div class="col-8">
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
                @endif
                <!-- <div class="row">
                    <div class="col-md-4 offset-md-8 text-center mt-2">
                        <a href="#" class="btn btn-result">SEE ALL “ACCA” RESULTS</a>
                    </div>
                </div> -->
            </div>
                <!---Full Part END--->

            <!---Full Part START---->
            <div class="full-part wi-full mt-5 pt-4">
            <div class="title-bang">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2>BOMBS OF THE DAY</h2>
                    </div>
                    <div class="col-md-4">
                        <div class="points-clculate profit">
                            <p>profits in the last <br/>
                                <strong>30 days</strong></p>
                            @if(isset($totalsumpass30days['cat3']))
                             @if($totalsumpass30days['cat3'] >= 0 )
                                <span>+ €{{$totalsumpass30days['cat3']}}</span>
                             @else 
                              <span>- €{{$totalsumpass30days['cat3']}}</span>
                            @endif
                           @endif
                        </div>
                    </div>
                </div>
            </div>
           @if(count($data) > 0)
              @foreach($data as $bets)
                @if($bets['betcatid']==3)
                 @php
                   $profit = 0;
                   if($bets['status']=='Won'){
                     $p = ($bets['odds'] * 100);
                     $profit = ($p - 100);
                   }else{
                      $profit = -100;
                   }
                    @endphp
                @if($bets['parent_id'] == 0)
                <div class="row">
                    <div class="col-8">
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
                @endif

            
               <!--  <div class="row">
                    <div class="col-md-4 offset-md-8 text-center mt-2">
                        <a href="#" class="btn btn-result">SEE ALL “BOMBS” RESULTS</a>
                    </div>
                </div> -->
            </div>
                <!---Full Part END---->
        </div>
    </section>

    <footer class="wi-full">
        <div class="container">
        </div>
    </footer>

    <!-- Popup Login -->
   
   
    @endsection
    @section('js_file')
     <script src="{{asset('public/front/js/auth.js')}}"></script>
     <script src="{{asset('public/front/js/dashboard.js')}}"></script>
    @endsection