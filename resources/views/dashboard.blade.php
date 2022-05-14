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

   <section class="wi-full py-5">
        <div class="container">
            <div class="title-main wi-full text-center mb-5">
                <h2>{{ __('member.results') }}</h2>
            </div>
            
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
                    <!-- <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabs-4" role="tab">MONTHLY PROFIT</a>
                    </li> -->
                </ul><!-- Tab panes -->

                <div class="tab-content">
                    <div class="tab-pane active" id="tabs-1" role="tabpanel">
                        <div class="row latest-rsult">
                        <div class="col-12 cat-1">
                            <div class="month-dropdown float-right">
                                  <select name="monts" class="cat1-month">
                                    <option value="">Select Month</option>
                                    @if(count($systemdates1) > 0)
                                      @foreach($systemdates1 as $value)
                                        <option value="{{$value['monthname']}}" data-year="{{$value['year']}}">{{$value['monthname']}}({{$value['year']}})</option>
                                      @endforeach
                                    @endif
                                  </select>
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
                         <div class="col-8 div-1">
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
                            <div class="col-4 div-1">
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
                             @endif
                            @endforeach
                            @endif
                            </div>

                    
                        <!--- DATA ROW---->
                    </div><!-- Tab One -->
                    <div class="tab-pane" id="tabs-2" role="tabpanel">
                        <div class="row latest-rsult">
                            <div class="col-12 cat-2">
                                <div class="month-dropdown float-right">
                                    <select name="monts" class="cat2-month">
                                       <option value="">Select Month</option>
                                        @if(count($systemdates2) > 0)
                                          @foreach($systemdates2 as $value)
                                            <option value="{{$value['monthname']}}" data-year="{{$value['year']}}">{{$value['monthname']}}({{$value['year']}})</option>
                                          @endforeach
                                        @endif
                                  </select>
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
                             @endif
                            @endforeach
                            @endif
                           </div>
                           </div>
                           <!-- Tab Two -->
                    <div class="tab-pane" id="tabs-3" role="tabpanel">
                        <div class="row latest-rsult">
                            <div class="col-12 cat-3">
                                <div class="month-dropdown float-right">
                                    <select name="monts" class="cat3-month">
                                       <option value="">Select Month</option>
                                        @if(count($systemdates3) > 0)
                                          @foreach($systemdates3 as $value)
                                            <option value="{{$value['monthname']}}" data-year="{{$value['year']}}">{{$value['monthname']}}({{$value['year']}})</option>
                                          @endforeach
                                        @endif
                                  </select>
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
                            <div class="col-8 div-3">
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
                            <div class="col-4 div-3">
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
                             @endif
                            @endforeach
                            @endif
                        </div>
                    </div>

            </div>
        </div>
    </section>
    @endsection
    @section('js_file')
     <script src="{{asset('public/front/js/auth.js')}}"></script>
     <script src="{{asset('public/front/js/dashboard.js')}}"></script>
     <script type="text/javascript">
         $(".cat1-month").change(function(){
            var tab = $(this).attr('class');
            var month = $(this).val();
            var year = $(this).find(':selected').attr('data-year');
            if(month!=''){
              searchbyMonth(tab[3],month,year);
            }else{
                alert('Select Month name first!!')
            }
           });
         $(".cat2-month").change(function(){
            var tab = $(this).attr('class');
            var month = $(this).val();
            var year = $(this).find(':selected').attr('data-year');
            if(month!=''){
              searchbyMonth(tab[3],month,year);
            }else{
                alert('Select Month name first!!')
            }
           });
         $(".cat3-month").change(function(){
            var tab = $(this).attr('class');
            var month = $(this).val();
            var year = $(this).find(':selected').attr('data-year');
            if(month!=''){
              searchbyMonth(tab[3],month,year);
            }else{
                alert('Select Month name first!!')
            }
           });
         function searchbyMonth(cat,month,year) {
          var timeStamp = "EST";
         $.ajax({
             type:'POST',
             url:'{{url('results/searchbymonth')}}',
             data:{'_token': '{{ csrf_token() }}','cat':cat,'month':month,'year':year},
             success:function(data) {
              var html='';
               var responseObject = JSON.parse(JSON.stringify(data));
                $('.removeoncedone').remove();
                $('.div-'+cat).remove();
                /*$('.cat-'+cat).next().remove();
                $('.cat-'+cat).next().next().remove();*/
               if(responseObject.length===0){
                //html+='<center><h4>No Record Found!!</h4></center>';
                $('.cat-'+cat).after("<span class='removeoncedone'><center><h4>No Record Found!!</h4></center></span>");
               }else{
                   passdatatohtmlfunction(responseObject,cat);
                   //alert('hvg')
                  /* $.each(responseObject, function(k, v) {
                       $.each(v.bet, function(b, m) { 
                          console.log(m.betdate); 
                       }); 
                   });*/
                 }
             }
          });
         }
       function passdatatohtmlfunction(data,cat) {
        //console.log(data)
          var html = '';
               $.each(data, function(b, m) { 
                   var profit = 0;
                   var sign = '';
                   //console.log(m.status)
                  // $('.cat-'+cat).html('');
                   if(m.status=='Won'){
                     p = (m.odds * 100);
                     profit = (p - 100);
                     sign+='<a href="#" class="btn btn-won btn-sucess float-right">WON</a>';
                   }else{
                      profit = -100;
                       sign+='<a href="#" class="btn btn-won btn-danger float-right">LOSS</a>';
                   }
                  // console.log(profit)

                  html+='<div class="col-8 removeoncedone"> <div class="table-responsive"> <table class="table table-bordered dsktopview table2"> <tbody> <tr> <td class="text-left"><p>'+m.betdate+'</p> <span>'+m.bettime+'</span></td> <td class="text-center">'+m.competion+'</td> <td><p>WAGER</p> <span>€100</span></td> <td><p>TOTAL ODDS</p> <span>'+m.odds+'</span></td> <td><p>PROFIT</p> <span>'+profit+'</span></td> </tr> <tr> <td colspan="5" class="text-center"><strong>'+m.teama+'</strong><span>VS</span><strong>'+m.teamb+'</strong></td> </tr> </tbody> </table> <!-- Mobile VIEW --> <table class="table table-bordered mbileview table2"> <tbody> <tr> <td class="text-left"><p>'+m.betdate+'</p> <span>'+m.bettime+'</span></td> <td colspan="2" class="text-center">'+m.competion+'</td> </tr> <tr> <td><p>WAGER</p> <span>€100</span></td> <td><p>TOTAL ODDS</p> <span>'+m.odds+'</span></td> <td><p>PROFIT</p> <span>'+profit+'</span></td> </tr> <tr> <td colspan="3" class="text-center"><strong>'+m.teama+'</strong><span>VS</span><strong>'+m.teamb+'</strong></td> </tr> </tbody> </table> </div> </div> <div class="col-4 removeoncedone"> <div class="result-right"> <ul> <li> <div class="detail-match"> <div> <tag>TYPE</tag> <p>'+m.tiptype+'</p> </div> '+sign+'</div> </li> <li> <div class="detail-match"> <tag>TIP</tag> <p>'+m.actualtip+'</p> </div> </li> </ul> </div> </div>';
               }); 

               $('.cat-'+cat).after(html);
      }  

     </script>
    @endsection