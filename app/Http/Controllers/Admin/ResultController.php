<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Sport;
use App\Competition;
use App\Player;
use App\Team;
use App\Tiptype;
use App\Plan;
use App\BetManager;
use App\WhoisPlaying;
use App\Bets;
use App\BetCategory;
use DB;





class ResultController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
      public function allresult(){

          $data = Bets::with('competion','sport','tiptype','betcategory1')->where(function($query){
            $query->where('status', 'Lost');
            $query->orWhere('status','Won');
            })->orderBy('betdate','DESC')->get()->toArray();
            //dd($data);
            $betcategory = BetCategory::all()->toArray();
            $headerCounter = array();
            $tab1 = $tab2 = $tab3 = $tab4 = 0;
            $alltabpro = array();
            $cat1pro = array();
            $cat2pro = array();
            $cat3pro = array();
            if(count($data) > 0){
              foreach ($data as $key => $value) {
                if($value['status']=='Won'|| $value['status']=='won'){
                  $ts = ($value['odds'] * 100);
                  $str = ($ts - 100);
                  $tab1 = $tab1 + $str;
                  $alltabpro[] = $str; 
                }else{
                    $tab1 = $tab1 - 100; 
                     $alltabpro[] = -100;  
                }



                if($value['betcategory_id']==1){
                  if($value['status']=='Won'|| $value['status']=='won'){
                    $ts = ($value['odds'] * 100);
                    $str = ($ts - 100);
                    $tab2 = $tab2 + $str;
                    $cat1pro[] = $str;  
                  }else{
                      $tab2 = $tab2 - 100; 
                      $cat1pro[] = -100; 
                  }
                }
                if($value['betcategory_id']==2){
                  if($value['status']=='Won'|| $value['status']=='won'){
                      $ts = ($value['odds'] * 100);
                      $str = ($ts - 100);
                      $tab3 = $tab3 + $str;
                      $cat2pro[] = $str;  
                    }else{
                        $tab3 = $tab3 - 100; 
                        $cat2pro[] = -100; 
                    }
                }

                if($value['betcategory_id']==3){
                  if($value['status']=='Won'|| $value['status']=='won'){
                      $ts = ($value['odds'] * 100);
                      $str = ($ts - 100);
                      $tab4 = $tab4 + $str; 
                      $cat3pro[] = $str; 
                    }else{
                        $tab4 = $tab4 - 100; 
                        $cat3pro[] = -100; 
                    }
                }
              }
            }



          $alltabpro = array_reverse($alltabpro);
          $profit1 = array();
          foreach ($alltabpro as $key => $v) {
               if($key == 0){
                $profit1[] = $v;
                $n = $v;
               } else {
                $profit1[] = $n + $v;
                $n = $n + $v;
               }  
          }
        $finalprofit1 = array_reverse($profit1);

        $cat1pro = array_reverse($cat1pro);
          $profit2 = array();
          foreach ($cat1pro as $key => $v) {
               if($key == 0){
                $profit2[] = $v;
                $n = $v;
               } else {
                $profit2[] = $n + $v;
                $n = $n + $v;
               }  
          }
        $finalprofit2 = array_reverse($profit2);

         $cat2pro = array_reverse($cat2pro);
          $profit3 = array();
          foreach ($cat2pro as $key => $v) {
               if($key == 0){
                $profit3[] = $v;
                $n = $v;
               } else {
                $profit3[] = $n + $v;
                $n = $n + $v;
               }  
          }
        $finalprofit3 = array_reverse($profit3);

         $cat3pro = array_reverse($cat3pro);
          $profit4 = array();
          foreach ($cat3pro as $key => $v) {
               if($key == 0){
                $profit4[] = $v;
                $n = $v;
               } else {
                $profit4[] = $n + $v;
                $n = $n + $v;
               }  
          }
        $finalprofit4 = array_reverse($profit4);
        $overallProfit = array(
            'tab1' => $finalprofit1,
            'tab2' => $finalprofit2,
            'tab3' => $finalprofit3,
            'tab4' => $finalprofit4
          );
       /* echo "<pre>";
        print_r($overallProfit);
        die();*/

            $headerCounter = array(
                  'tab1' => $tab1,
                  'tab2' => $tab2,
                  'tab3' => $tab3,
                  'tab4' => $tab4,
              );
           
         return view('admin.screen.result.allresult.allresult',['data'=>$data,'headerCounter'=> $headerCounter,'betcategory'=>$betcategory,'overallProfit'=>$overallProfit]);
      } 
      public function monthlyresult(){
          $betcategory = BetCategory::all()->toArray();
          $data = Bets::where(function($query){
              $query->where('status', 'Lost');
              $query->orWhere('status','Won');
            })->select(
            DB::raw('sum(odds) as sums'), 
            DB::raw('count(id) as number'),
            DB::raw('avg(odds) as averageodds'), 
            DB::raw("DATE_FORMAT(betdate,'%M') as months"),'status','betcategory_id','id'
            )
          ->groupBy('months','status','betcategory_id','id')
          ->get()->toArray();

          $dtArray = array();
          foreach ($data as $key => $value) {
             $dtArray[$value['betcategory_id']][date("n", strtotime($value['months']))][] = array(
                   'numberofbets' => $value['number'],
                   'averageodds' => $value['averageodds'],
                   'status' => $value['status'],
                   'sums' => $value['sums'],
                   'betcat' => $value['betcategory_id'],
                   'innerbetcount' => $value['id']
              );
          }
           /* echo "<pre>";
            print_r($dtArray);
            die();*/
        $updatedArray = array();
        if(isset($dtArray[1])){
         $tcounet = 0;   
        foreach ($dtArray[1] as $key => $value) {
           $counterWin = $counterLoss = $betsnumber  = $sum = $aveodds = 0 ; 
           foreach ($value as $ke => $val) {
             if($val['status']=='Won' || $val['status']=='won'){
              $counterWin++;
             }else{
               $counterLoss++;
             }
             $tcounet = $tcounet + Bets::where('id',$val['innerbetcount'])->count('id');
             $betsnumber = $betsnumber + $val['numberofbets'];
             $sum = $sum + $val['sums']; 
             $aveodds = $aveodds + $val['averageodds'];  
           }
           $winpercent = ($counterWin * 100/ $betsnumber);
           $losspercent = ($counterLoss * 100/ $betsnumber);
           $p = (($sum * 100) - 100);
           $pr = (($counterWin * $p) - ($counterLoss * $p));
           $updatedArray[$key] = array(
                 'total' => $tcounet,
                 'sum' => $sum,
                 'totalAverageOdds' => $aveodds,
                 'winpercent' => number_format($winpercent,2),
                 'losspercent' =>  number_format($losspercent,2),
                 'profit' => number_format($pr,2), 
               );

        }
      }
        $updatedArray1 = array();
        if(isset($dtArray[2])){
          $tcounet = 0;
        foreach ($dtArray[2] as $key => $value) {
           $counterWin = $counterLoss = $betsnumber  = $sum = $aveodds = 0; 
           foreach ($value as $ke => $val) {
             if($val['status']=='Won' || $val['status']=='won'){
              $counterWin++;
             }else{
               $counterLoss++;
             }
             $tcounet = $tcounet + Bets::where('id',$val['innerbetcount'])->count('id');
             $betsnumber = $betsnumber + $val['numberofbets'];
             $sum = $sum + $val['sums']; 
             $aveodds = $aveodds + $val['averageodds'];  
           }
           $winpercent = ($counterWin * 100/ $betsnumber);
           $losspercent = ($counterLoss * 100/ $betsnumber);
           $p = (($sum * 100) - 100);
           $pr = (($counterWin * $p) - ($counterLoss * $p));
           $updatedArray1[$key] = array(
                 'total' => $tcounet,
                 'sum' => $sum,
                 'totalAverageOdds' => $aveodds,
                 'winpercent' => number_format($winpercent,2),
                 'losspercent' => number_format($losspercent,2),
                 'profit' => number_format($pr,2), 
               );

        }
      }
        $updatedArray2 = array();
        if(isset($dtArray[3])){
          $tcounet = 0;
        foreach ($dtArray[3] as $key => $value) {
           $counterWin = $counterLoss = $betsnumber  = $sum = $aveodds = 0; 
           foreach ($value as $ke => $val) {
             if($val['status']=='Won' || $val['status']=='won'){
              $counterWin++;
             }else{
               $counterLoss++;
             }
              $tcounet = $tcounet +Bets::where('id',$val['innerbetcount'])->count('id');
             $betsnumber = $betsnumber + $val['numberofbets'];
             $sum = $sum + $val['sums']; 
             $aveodds = $aveodds + $val['averageodds'];  
           }
           $winpercent = ($counterWin * 100/ $betsnumber);
           $losspercent = ($counterLoss * 100/ $betsnumber);
           $p = (($sum * 100) - 100);
           $pr = (($counterWin * $p) - ($counterLoss * $p));
           $updatedArray2[$key] = array(
                 'total' => $tcounet,
                 'sum' => $sum,
                 'totalAverageOdds' => $aveodds,
                 'winpercent' => number_format($winpercent,2),
                 'losspercent' => number_format($losspercent,2),
                 'profit' => number_format($pr,2), 
               );

        }
      }

     /*   echo "<pre>";
        print_r($updatedArray2);
        die();*/

          return view('admin.screen.result.monthlyresult.monthlyresult',['betcategory'=>$betcategory,'data'=>$updatedArray,'data1'=> $updatedArray1,'data2'=> $updatedArray2]);
      }
      

      public function getdetail(Request $request){
            $data = Bets::where('id',$request->id)->with('whoisPlaying1')->with('competion')->with('sport')->with('tiptype')->get()->toArray();
          $arraytofrontend = array();
          $counter = 1;
          foreach ($data as $key => $value) {
            $arraytofrontend[] = array(
                  'date' => date('d M,Y H:i',strtotime($value['betdate'])),
                  'competition' => $value['competion']['name'], 
                  'sport' => $value['sport']['name'], 
                  'tiptype' => $value['tiptype']['name'], 
                  'actualtip' => $value['actualtip'], 
                  'odds' => $value['odds'], 
                  'trustnote' => $value['odds'],
                  'type' => $value['whois_playing1']['type'],
                  'teama' =>  Team::where('id',$value['whois_playing1']['teama'])->value('name'),
                  'teamb' =>  Team::where('id',$value['whois_playing1']['teamb'])->value('name'),
                  'playera' => Player::where('id',$value['whois_playing1']['playera'])->value('name'),
                  'playerb' => Player::where('id',$value['whois_playing1']['playerb'])->value('name'),
                  'name' => 'Bet '.$counter++,
                  'rating' => $value['trustnote']

          );
          }
          /*print_r($arraytofrontend);
          die();*/
          $json = json_encode($arraytofrontend);
          echo $json;
          exit();
      }

      public function getSearch(Request $request){
         // Tab 1 all type data
        if(trim($request->tab)=='tab1'){
         if(trim($request->type)=='bymonth'){
            $data = Bets::with('competion','sport','tiptype','betcategory1')->where(function($query){
              $query->where('status', 'Lost');
              $query->orWhere('status','Won');
              })->whereMonth('betdate',$request->month)->whereYear('betdate',date('Y'))->orderBy('betdate','DESC')->get()->toArray();
            //dd($data);
         }
         if(trim($request->type)=='last30days'){
            $from = date('Y-m-d H:i:s');
            $to = date('Y-m-d H:i:s', strtotime('-30 days'));
             $data = Bets::where('betdate','<=',$from)->where('betdate','>=',$to)->with('competion','sport','tiptype','betcategory1')->where(function($query){
              $query->where('status', 'Lost');
              $query->orWhere('status','Won');
              })->orderBy('betdate','DESC')->get()->toArray();
           }
            if(trim($request->type)=='allbets'){
               $data = Bets::with('competion','sport','tiptype','betcategory1')->where(function($query){
              $query->where('status', 'Lost');
              $query->orWhere('status','Won');
              })->orderBy('betdate','DESC')->get()->toArray();
            }
        }


          // tab 2 data 

      if(trim($request->tab)=='tab2'){
         if(trim($request->type)=='bymonth'){
          $data = Bets::whereMonth('betdate',$request->month)->whereYear('betdate',date('Y'))->with('competion','sport','tiptype','betcategory1')->where(function($query){
              $query->where('status', 'Lost');
              $query->orWhere('status','Won');
              })->where('betcategory_id',1)->orderBy('betdate','DESC')->get()->toArray();
         }
         if(trim($request->type)=='last30days'){
            $from = date('Y-m-d H:i:s');
            $to = date('Y-m-d H:i:s', strtotime('-30 days'));
             $data = Bets::where('betdate','<=',$from)->where('betdate','>=',$to)->with('competion','sport','tiptype','betcategory1')->where(function($query){
              $query->where('status', 'Lost');
              $query->orWhere('status','Won');
              })->where('betcategory_id',1)->orderBy('betdate','DESC')->get()->toArray();
           }
            if(trim($request->type)=='allbets'){
               $data = Bets::with('competion','sport','tiptype','betcategory1')->where(function($query){
              $query->where('status', 'Lost');
              $query->orWhere('status','Won');
              })->where('betcategory_id',1)->orderBy('betdate','DESC')->get()->toArray();
            }
        }

         if(trim($request->tab)=='tab3'){
         if(trim($request->type)=='bymonth'){
          $data = Bets::whereMonth('betdate',$request->month)->whereYear('betdate',date('Y'))->with('competion','sport','tiptype','betcategory1')->where(function($query){
              $query->where('status', 'Lost');
              $query->orWhere('status','Won');
              })->where('betcategory_id',2)->orderBy('betdate','DESC')->get()->toArray();
         }
         if(trim($request->type)=='last30days'){
            $from = date('Y-m-d H:i:s');
            $to = date('Y-m-d H:i:s', strtotime('-30 days'));
             $data = Bets::where('betdate','<=',$from)->where('betdate','>=',$to)->with('competion','sport','tiptype','betcategory1')->where(function($query){
              $query->where('status', 'Lost');
              $query->orWhere('status','Won');
              })->where('betcategory_id',2)->orderBy('betdate','DESC')->get()->toArray();
           }
            if(trim($request->type)=='allbets'){
               $data = Bets::with('competion','sport','tiptype','betcategory1')->where(function($query){
              $query->where('status', 'Lost');
              $query->orWhere('status','Won');
              })->where('betcategory_id',2)->orderBy('betdate','DESC')->get()->toArray();
            }
        }

        if(trim($request->tab)=='tab4'){
         if(trim($request->type)=='bymonth'){
          $data = Bets::whereMonth('betdate',$request->month)->whereYear('betdate',date('Y'))->with('competion','sport','tiptype','betcategory1')->where(function($query){
              $query->where('status', 'Lost');
              $query->orWhere('status','Won');
              })->where('betcategory_id',3)->orderBy('betdate','DESC')->get()->toArray();
         }
         if(trim($request->type)=='last30days'){
            $from = date('Y-m-d H:i:s');
            $to = date('Y-m-d H:i:s', strtotime('-30 days'));
             $data = Bets::where('betdate','<=',$from)->where('betdate','>=',$to)->with('competion','sport','tiptype','betcategory1')->where(function($query){
              $query->where('status', 'Lost');
              $query->orWhere('status','Won');
              })->where('betcategory_id',3)->orderBy('betdate','DESC')->get()->toArray();
           }
            if(trim($request->type)=='allbets'){
               $data = Bets::with('competion','sport','tiptype','betcategory1')->where(function($query){
              $query->where('status', 'Lost');
              $query->orWhere('status','Won');
              })->where('betcategory_id',3)->orderBy('betdate','DESC')->get()->toArray();
            }
        }

        /*==========================================*/
            $all_pro = array();
             foreach ($data as $ke => $val) {
                $profitt = 0;
                if($val['status']=='Won'){
                  $profitsd = $val['odds'] * 100;
                  $all_pro[] = ($profitsd - 100); 
                }

                 if($val['status']=='Lost'){
                  $all_pro[] = -100;  
                }
                 
              }
            $all_pro = array_reverse($all_pro);
            $all_profit = array();

            foreach ($all_pro as $key => $v) {
                 if($key == 0){
                  $all_profit[] = $v;
                  $n = $v;
                 } else {
                  $all_profit[] = $n + $v;
                  $n = $n + $v;
                 }  
            }
            $all_profit = array_reverse($all_profit);
            /*===================================*/

            $Array = array();
            $count = 0;
            $counter = 0;
             foreach ($data as $ke => $val) {
                $profit = 0;
                if($val['status']=='Won'){
                  $profitsd = $val['odds'] * 100;  
                  $profit = ($profitsd - 100);  
                }

                 if($val['status']=='Lost'){
                  $profit = -100;  
                }
                 $Array[] = array(
                      'id' => $val['id'],
                      'betdate' => $val['betdate'],
                      'bettype' => $val['bettype'],
                      'sport' => $val['sport']['name'],
                      'tiptype' => $val['tiptype']['name'],
                      'odds' => number_format($val['odds'],2),
                      'betcategory' => $val['betcategory1']['name'],
                      'status' => $val['status'],
                      'profit' => number_format($profit,2),
                      'overall_profit' => number_format($all_profit[$counter],2),

                  );
                 $count = $count + $profit;
                 $counter ++;
              }


        
         $finalArray = array(
             'sum' => number_format($count,2),
             'data' => $Array
          );
         $json = json_encode($finalArray);
         echo $json;
         exit();
      }

      public function searchbymonth(Request $request){
        if($request->tab=='tab1'){
           $month = date("m", strtotime($request->month));
           // echo $month;
            //die();
             $data = Bets::where('betcategory_id',1)->with('competion','sport','tiptype','betcategory1')->where(function($query){
              $query->where('status', 'Lost');
              $query->orWhere('status','Won');
              })->whereMonth('betdate',$month)->whereYear('betdate',date('Y'))->orderBy('betdate','DESC')->get()->toArray();
             //dd($data);
        }
        if($request->tab=='tab2'){
          $month = date("m", strtotime($request->month));
           $data = Bets::where('betcategory_id',2)->with('competion','sport','tiptype','betcategory1')->where(function($query){
              $query->where('status', 'Lost');
              $query->orWhere('status','Won');
              })->whereMonth('betdate',$month)->whereYear('betdate',date('Y'))->orderBy('betdate','DESC')->get()->toArray();
        }
        if($request->tab=='tab3'){
           $month = date("m", strtotime($request->month));
           $data = Bets::where('betcategory_id',3)->with('competion','sport','tiptype','betcategory1')->where(function($query){
              $query->where('status', 'Lost');
              $query->orWhere('status','Won');
              })->whereMonth('betdate',$month)->whereYear('betdate',date('Y'))->orderBy('betdate','DESC')->get()->toArray();
        }

           $Array = array();
            $count = 0;
              /*echo "<pre>";
              print_r($data);
              die();*/
            foreach ($data as $ke => $val) {
                $profit = 0;
                if($val['status']=='Won'){
                  $profitsd = $val['odds'] * 100;  
                  $profit = ($profitsd - 100);  
                }else{
                  $profit = -100;  
                }

                 $Array[] = array(
                      'id' => $val['id'],
                      'betdate' => $val['betdate'],
                      'bettype' => $val['bettype'],
                      'sport' => $val['sport']['name'],
                      'tiptype' => $val['tiptype']['name'],
                      'odds' => number_format($val['odds'],2),
                      'betcategory' => $val['betcategory1']['name'],
                      'status' => $val['status'],
                      'profit' => $profit
                  );
              }
            $json = json_encode($Array);
            echo $json;
            exit();

      }
    

    

}
