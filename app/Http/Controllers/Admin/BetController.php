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
use App\BetCategory;
use App\WhoisPlaying;
use App\Bets;
use App\BetManager;




class BetController extends Controller
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

    public function addnewbetSingel(){
        $competition = Competition::all()->toArray(); 
        $player = Player::all()->toArray(); 
        $sport = Sport::all()->toArray(); 
        $tiptype = Tiptype::all()->toArray();
        $team = Team::all()->toArray();
        $betcategory = BetCategory::all()->toArray();
        $data = array(
             'competition'=> $competition,
             'player' => $player,
             'sport' => $sport,
             'tiptype' => $tiptype,
             'team' => $team,
             'betcategory' => $betcategory
        ); 
        return view('admin.screen.bets.addnewbet.singelbet',['data'=>$data]);
    }
 
    public function addSinglesave(Request $request){
         $request->validate([
            'competition' => 'required',
            'sport' => 'required',
            'datetime' => 'required',
            'tiptype' => 'required',
            'betcategory' => 'required',
        ]);
         $newtowhosplay = new WhoisPlaying;
         $newtowhosplay->type = $request->whosplaying;
         $newtowhosplay->teama = $request->teamA;
         $newtowhosplay->teamb = $request->teamB;
         $newtowhosplay->playera = $request->playerA;
         $newtowhosplay->playerb = $request->playerA;
         $newtowhosplay->status = 'active';
         $newtowhosplay->created_at = date('Y-m-d H:i:s');
         $newtowhosplay->updated_at = date('Y-m-d H:i:s');
         $newtowhosplay->save();

         $explode = explode('-', $request->datetime);
        $str = str_replace(',', ' ',$explode[0]);
        $concat = $str.' '.$explode[1];
        $date = date('Y-m-d H:i:s',strtotime($concat));

         /*$betm = new BetManager;
         $betm->bettype = 'singlebet';
         $betm->finalodds = $request->odds;
         $betm->betcategory_id = $request->betcategory;
         $betm->created_at = date('Y-m-d H:i:s'); 
         $betm->updated_at = date('Y-m-d H:i:s');
         $betm->save(); */

         $new = new Bets;
         $new->bettype = 'singelbet';
         $new->competition_id = $request->competition;
         $new->sport_id = $request->sport;
         $new->betdate = $date;
         $new->whosplaying_id = $newtowhosplay->id;
         $new->tiptype_id  = $request->tiptype; 
         $new->betcategory_id  = $request->betcategory; 
         $new->trustnote  = $request->rating;
         $new->odds  = $request->odds;
         $new->actualtip  = $request->actualtip;
         $new->finalodds = $request->odds;
         //$new->betmanager_id = $betm->id;
         $new->created_at = date('Y-m-d H:i:s');
         $new->updated_at = date('Y-m-d H:i:s');
         $new->save();
         

         return redirect()->back()->with('success', 'Bet Has been Registered, Successfully!');
    }
    public function addnewbetMultiple(){
        $competition = Competition::all()->toArray(); 
        $player = Player::all()->toArray(); 
        $sport = Sport::all()->toArray(); 
        $tiptype = Tiptype::all()->toArray();
        $team = Team::all()->toArray();
        $betcategory = BetCategory::all()->toArray();
        $data = array(
             'competition'=> $competition,
             'player' => $player,
             'sport' => $sport,
             'tiptype' => $tiptype,
             'team' => $team,
             'betcategory' => $betcategory
        );
        return view('admin.screen.bets.addnewbet.multiplebet',['data'=>$data]);
    }

    public function addmultiplesave(Request $request){
       /* echo "<pre>";
        print_r($request->all());
        die();*/

         $request->validate([
            'competition' => 'required',
            'sport' => 'required',
            'datetime' => 'required',
            'tiptype' => 'required',
            'betcategory' => 'required',
        ]);
         
			/* $betm = new BetManager;
	         $betm->bettype = 'multiplebet';
	         $betm->finalodds = $request->finalOdds;
	         $betm->betcategory_id = $request->betcategory;
	         $betm->created_at = date('Y-m-d H:i:s'); 
	         $betm->updated_at = date('Y-m-d H:i:s');
	         $betm->save(); */

            /*Start-- it is used to get recent date*/   

             for ($i=0; $i < count($request->competition); $i++) { 
                $explode = explode('-', $request->datetime[$i]);
                $str = str_replace(',', ' ',$explode[0]);
                $concat = $str.' '.$explode[1];
                $all_date[] = $date = date('Y-m-d H:i:s',strtotime($concat));
             }
                        
             $mostRecent = 0;
                foreach($all_date as $ke=>$date){
                    if($ke == 0){
                        $mostRecent = strtotime($date);
                    }
                  $curDate = strtotime($date);
                  if ($curDate < $mostRecent) {
                     $mostRecent = $curDate;
                  }
                }

           
            $mostRecent_date = $mostRecent;

             /*End-- it is used to get recent date*/
         $parent_id = 0; 
         $all_child_ids = array();   
         for ($i=0; $i < count($request->competition); $i++) { 
             if(empty($request->teamA[$i]) && empty($request->teamB[$i])){
                 $newtowhosplay1 = new WhoisPlaying;
                 $newtowhosplay1->type = 'Individual';
                 $newtowhosplay1->playera = $request->playerA[$i];
                 $newtowhosplay1->playerb = $request->playerB[$i];
                 $newtowhosplay1->status = 'active';
                 $newtowhosplay1->created_at = date('Y-m-d H:i:s');
                 $newtowhosplay1->updated_at = date('Y-m-d H:i:s');
                 $newtowhosplay1->save();
             }else{
                 $newtowhosplay1 = new WhoisPlaying;
                 $newtowhosplay1->type = 'Team';
                 $newtowhosplay1->teama = $request->teamA[$i];
                 $newtowhosplay1->teamb = $request->teamB[$i];
                 $newtowhosplay1->status = 'active';
                 $newtowhosplay1->created_at = date('Y-m-d H:i:s');
                 $newtowhosplay1->updated_at = date('Y-m-d H:i:s');
                 $newtowhosplay1->save();
             }
             

            $explode = explode('-', $request->datetime[$i]);
            $str = str_replace(',', ' ',$explode[0]);
            $concat = $str.' '.$explode[1];
            $date = date('Y-m-d H:i:s',strtotime($concat));


             $new = new Bets;
             $new->bettype = 'multiplebet';
             $new->competition_id = $request->competition[$i];
             $new->sport_id = $request->sport[$i];
             $new->betdate = $date;
             $new->whosplaying_id = $newtowhosplay1->id;
             $new->tiptype_id  = $request->tiptype[$i]; 
             $new->betcategory_id  = $request->betcategory; 
             $new->trustnote  = $request->rating;
             $new->odds  = $request->odds[$i];
             $new->actualtip  = $request->actualtip[$i];
             $new->finalodds = $request->finalOdds;
             //$new->betmanager_id = $betm->id;
             $new->created_at = date('Y-m-d H:i:s');
             $new->updated_at = date('Y-m-d H:i:s');
             $new->save();

            if(strtotime($date) == $mostRecent_date && $parent_id == 0){
                $parent_id = $new->id;
                Bets::where('id',$new->id)->update(['parent_id' => -1]);
            } else {
                $all_child_ids[] = $new->id;
            }

            if(count($all_child_ids) > 0){
                Bets::whereIn('id',$all_child_ids)->update(['parent_id' => $parent_id]);
            }

        }  
        
         return redirect()->back()->with('success', 'Bet Has been Registered, Successfully!'); 
    }

    public function getAllBets(){
       /* $data = BetManager::with('bets')->with('betcategory')->orderBy('created_at','DESC')->get();*/
        $data = Bets::with('betcategory1')->with('whoisPlaying1')->with('competion')->with('sport')->with('tiptype')->where('active',1)->whereIn('parent_id',array(0,-1))->orderBy('created_at','DESC')->get()->toArray();

        /*$data = Bets::with('betcategory1')->with('whoisPlaying1')->with('competion')->with('sport')->with('tiptype')->where('active',1)->orderBy('created_at','DESC')->get()->toArray();*/
         $betcategory = BetCategory::all()->toArray();
       // dd($data); 
        return view('admin.screen.bets.allbet.allbets',['data'=>$data,'betcategory'=>$betcategory]);
    }
    public function changeStatus(Request $request){

        $betid = $request->id;
        $bet = Bets::where('id',$betid)->first();
        $betids = array($request->id);
        if($bet->parent_id == -1){
            $child_bet = Bets::where('parent_id',$betid)->get()->pluck('id')->toArray();
            $betids = array_merge($betids,$child_bet);
        }
        Bets::whereIn('id',$betids)->update(['status'=>$request->status]);
         // $update = Bets::find($request->id);
         // $update->status = $request->status;
         // $update->save();
         echo "success";
         exit();

    }

    public function remove(Request $request){

        $betid = $request->id;
        $bet = Bets::where('id',$betid)->first();
        $betids = array($request->id);
        if($bet->parent_id == -1){
            $child_bet = Bets::where('parent_id',$betid)->get()->pluck('id')->toArray();
            $betids = array_merge($betids,$child_bet);
        }
        
        foreach ($betids as $key => $bet_id) {
          Bets::find($bet_id)->delete1();
        }
        
        echo "success";
    }

    public function Getdetail(Request $request){

        $betid = $request->id;
    	$bet = Bets::where('id',$betid)->first();

        $betids = array($request->id);
        if($bet->parent_id == -1){
            $child_bet = Bets::where('parent_id',$betid)->get()->pluck('id')->toArray();
            $betids = array_merge($betids,$child_bet);
        }

        $data = Bets::whereIn('id',$betids)->with('whoisPlaying1')->with('competion')->with('sport')->with('tiptype')->get()->toArray();
    	//echo "<pre>";
    	$arraytofrontend = array();
    	$counter = 1;
    	foreach ($data as $key => $value) {
    		$arraytofrontend[] = array(
              'date' => date('d M,Y H:i',strtotime($value['betdate'])).' EST',
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

    public function editbet($betid){
    	$competition = Competition::all()->toArray(); 
        $player = Player::all()->toArray(); 
        $sport = Sport::all()->toArray(); 
        $tiptype = Tiptype::all()->toArray();
        $team = Team::all()->toArray();
        $betcategory = BetCategory::all()->toArray();
        $data = array(
             'competition'=> $competition,
             'player' => $player,
             'sport' => $sport,
             'tiptype' => $tiptype,
             'team' => $team,
             'betcategory' => $betcategory
        );

        /*check multibet*/
        $bet = Bets::where('id',$betid)->first();
        $betids = array($betid);
        if($bet->parent_id == -1){
            $child_bet = Bets::where('parent_id',$betid)->get()->pluck('id')->toArray();
            $betids = array_merge($betids,$child_bet);
        }

        $bets = Bets::whereIn('id',$betids)->with('whoisPlaying1')->get()->toArray();
        /* echo "<pre>";
         print_r($bets);
         die();	*/
         return view('admin.screen.bets.allbet.editbet',['data'=>$data,'bets'=>$bets]);

    	
    }


    /*Save Single bet*/
        public function editbetSingleSave(Request $request){
      
         $request->validate([
            'competition' => 'required',
            'sport' => 'required',
            'datetime' => 'required',
            'tiptype' => 'required',
            'betcategory' => 'required',
        ]);
        /* echo "<pre>";
         print_r($request->all());
         die();*/
            // Remove bet id from bets Table


            /* $getids = Bets::where('betmanager_id',$request->betmanager_id)->pluck('id')->toArray();  
             foreach ($getids as $key => $value) {
                //echo $value;
                if(!in_array($value, $request->betids)){
                    Bets::find($value)->delete();
                }
             }*/
            // die();


             /*$betm = Bet::find($request->betmanager_id);
             $betm->finalodds = $request->finalOdds;
             $betm->betcategory_id = $request->betcategory;
              if(count($request->competition) > 1){
                $betm->bettype = 'multiplebet';
             }else{
                 $betm->bettype = 'singlebet';
             }
             $betm->save(); 
*/

             /*Start-- it is used to get recent date*/   
            $exitids = array();
            for ($i=0; $i < count($request->competition); $i++) { 
                $explode = explode('-', $request->datetime[$i]);
                $str = str_replace(',', ' ',$explode[0]);
                $concat = $str.' '.$explode[1];
                $all_date[] = $date = date('Y-m-d H:i:s',strtotime($concat));
                ///
                if(array_key_exists($i,$request->betids)){
                    $exitids[] = $request->betids[$i];
                }
                ///
            }


            /*================Satrt delete process*/
            $av_ids = array();
            if(count($exitids) > 0){
                $check_id = Bets::find($exitids[0]);

                if($check_id->bettype = 'multiplebet'){
                    $av_ids = array($exitids[0]);

                    if($check_id->parent_id == -1){
                    $child_data = Bets::where('parent_id',$check_id->id)->get()->pluck('id')->toArray();
                    $av_ids = array_merge($av_ids,$child_data);
                    } else {
                        $child_data = Bets::where('parent_id',$check_id->parent_id)->get()->pluck('id')->toArray();
                        $av_ids = array_merge($av_ids,$child_data);
                        $av_ids = array_merge($av_ids,array($check_id->parent_id));
                    }
                }
            }

                     
             /*================End delete process*/
                        
             $mostRecent = 0;
                foreach($all_date as $ke=>$date){
                    if($ke == 0){
                        $mostRecent = strtotime($date);
                    }
                  $curDate = strtotime($date);
                  if ($curDate < $mostRecent) {
                     $mostRecent = $curDate;
                  }
                }

           // die;
            $mostRecent_date = $mostRecent;
            $parent_id = 0; 
            $all_child_ids = array();  
             /*End-- it is used to get recent date*/

        for ($i=0; $i < count($request->competition); $i++) { 
            if(empty($request->teamA[$i]) && empty($request->teamB[$i])){
                if(array_key_exists($i,$request->whosids)){
                 $newtowhosplay1 = WhoisPlaying::find($request->whosids[$i]);
                 $newtowhosplay1->type = 'Individual';
                 $newtowhosplay1->playera = $request->playerA[$i];
                 $newtowhosplay1->playerb = $request->playerB[$i];
                 $newtowhosplay1->status = 'active';
                 $newtowhosplay1->save();
             }else{
                 $newtowhosplay1 = new WhoisPlaying;
                 $newtowhosplay1->type = 'Individual';
                 $newtowhosplay1->playera = $request->playerA[$i];
                 $newtowhosplay1->playerb = $request->playerB[$i];
                 $newtowhosplay1->status = 'active';
                 $newtowhosplay1->created_at = date('Y-m-d H:i:s');
                 $newtowhosplay1->updated_at = date('Y-m-d H:i:s');
                 $newtowhosplay1->save();

             }
          }
              else{
                if(array_key_exists($i,$request->whosids)){
                 $newtowhosplay1 = WhoisPlaying::find($request->whosids[$i]);
                 $newtowhosplay1->type = 'Team';
                 $newtowhosplay1->teama = $request->teamA[$i];
                 $newtowhosplay1->teamb = $request->teamB[$i];
                 $newtowhosplay1->status = 'active';
                 $newtowhosplay1->save();
               }else{
                 $newtowhosplay1 = new WhoisPlaying;
                 $newtowhosplay1->type = 'Team';
                 $newtowhosplay1->teama = $request->teamA[$i];
                 $newtowhosplay1->teamb = $request->teamB[$i];
                 $newtowhosplay1->status = 'active';
                 $newtowhosplay1->created_at = date('Y-m-d H:i:s');
                 $newtowhosplay1->updated_at = date('Y-m-d H:i:s');
                 $newtowhosplay1->save();

               }
             }
             


            $explode = explode(' - ', $request->datetime[$i]);
            $str1 = str_replace(',', ' ', $explode[0]);
            $concat = $str1.' '.$explode[1];
            $date = date('Y-m-d H:i:s',strtotime($concat));

            if(array_key_exists($i,$request->betids)){
             $new = Bets::find($request->betids[$i]);
              if(count($request->competition) > 1){
                $new->bettype = 'multiplebet';
             }else{
                 $new->bettype = 'singlebet';
             }
             $new->competition_id = $request->competition[$i];
             $new->sport_id = $request->sport[$i];
             $new->betdate = $date;
             $new->whosplaying_id = $newtowhosplay1->id;
             $new->tiptype_id  = $request->tiptype[$i]; 
             $new->betcategory_id  = $request->betcategory; 
             $new->trustnote  = $request->rating;
             $new->odds  = $request->odds[$i];
             $new->actualtip  = $request->actualtip[$i];
             $new->finalodds = $request->finalOdds;
             //$new->betmanager_id = $betm->id;
             /*$new->created_at = date('Y-m-d H:i:s');
             $new->updated_at = date('Y-m-d H:i:s');*/
             $new->save();
            }else{
             $new = new Bets;
              if(count($request->competition) > 1){
                $new->bettype = 'multiplebet';
             }else{
                 $new->bettype = 'singlebet';
             }
             $new->competition_id = $request->competition[$i];
             $new->sport_id = $request->sport[$i];
             $new->betdate = $date;
             $new->whosplaying_id = $newtowhosplay1->id;
             $new->tiptype_id  = $request->tiptype[$i]; 
             $new->betcategory_id  = $request->betcategory; 
             $new->trustnote  = $request->rating;
             $new->odds  = $request->odds[$i];
             $new->actualtip  = $request->actualtip[$i];
             $new->finalodds = $request->finalOdds;
             //$new->betmanager_id = $betm->id;
             $new->created_at = date('Y-m-d H:i:s');
             $new->updated_at = date('Y-m-d H:i:s');
             $new->save();


            }



                    

            /* Multibet End*/

         }
         return redirect('admin/bets/allbets')->with('success', 'Bet Has been Updated, Successfully!');
    }

    /*Save Multiple Bet*/
    public function editbetSave(Request $request){
       /* echo "<pre>";
        print_r($request->all());
        die();*/
      
    	 $request->validate([
            'competition' => 'required',
            'sport' => 'required',
            'datetime' => 'required',
            'tiptype' => 'required',
            'betcategory' => 'required',
        ]);
    	    // Remove bet id from bets Table


    	    /* $getids = Bets::where('betmanager_id',$request->betmanager_id)->pluck('id')->toArray();  
    	     foreach ($getids as $key => $value) {
    	     	//echo $value;
    	     	if(!in_array($value, $request->betids)){
    	     		Bets::find($value)->delete();
    	     	}
    	     }*/
    	    // die();


    	     /*$betm = Bet::find($request->betmanager_id);
	         $betm->finalodds = $request->finalOdds;
	         $betm->betcategory_id = $request->betcategory;
	          if(count($request->competition) > 1){
             	$betm->bettype = 'multiplebet';
             }else{
                 $betm->bettype = 'singlebet';
             }
	         $betm->save(); 
*/

             /*Start-- it is used to get recent date*/   
            $exitids = array();
            for ($i=0; $i < count($request->competition); $i++) { 
                $explode = explode('-', $request->datetime[$i]);
                $str = str_replace(',', ' ',$explode[0]);
                $concat = $str.' '.$explode[1];
                $all_date[] = $date = date('Y-m-d H:i:s',strtotime($concat));
                ///
                if(array_key_exists($i,$request->betids)){
                    $exitids[] = $request->betids[$i];
                }
                ///
            }


            /*================Satrt delete process*/
            $av_ids = array();
            if(count($exitids) > 0){
                $check_id = Bets::find($exitids[0]);

                if($check_id->bettype = 'multiplebet'){
                    $av_ids = array($exitids[0]);

                    if($check_id->parent_id == -1){
                    $child_data = Bets::where('parent_id',$check_id->id)->get()->pluck('id')->toArray();
                    $av_ids = array_merge($av_ids,$child_data);
                    } else {
                        $child_data = Bets::where('parent_id',$check_id->parent_id)->get()->pluck('id')->toArray();
                        $av_ids = array_merge($av_ids,$child_data);
                        $av_ids = array_merge($av_ids,array($check_id->parent_id));
                    }
                }
            }

            if(count($exitids) > 0){
                foreach ($av_ids as $key => $iid) {
                    if(!in_array($iid,$exitids)){
                        Bets::where('id',$iid)->delete();
                    }
                }
            }



            
             /*================End delete process*/
                        
             $mostRecent = 0;
                foreach($all_date as $ke=>$date){
                    if($ke == 0){
                        $mostRecent = strtotime($date);
                    }
                  $curDate = strtotime($date);
                  if ($curDate < $mostRecent) {
                     $mostRecent = $curDate;
                  }
                }

           // die;
            $mostRecent_date = $mostRecent;
            $parent_id = 0; 
            $all_child_ids = array();  
             /*End-- it is used to get recent date*/

    	for ($i=0; $i < count($request->competition); $i++) { 
    		if(empty($request->teamA[$i]) && empty($request->teamB[$i])){
    			if(array_key_exists($i,$request->whosids)){
    			 $newtowhosplay1 = WhoisPlaying::find($request->whosids[$i]);
    			 $newtowhosplay1->type = 'Individual';
                 $newtowhosplay1->playera = $request->playerA[$i];
                 $newtowhosplay1->playerb = $request->playerB[$i];
                 $newtowhosplay1->status = 'active';
                 $newtowhosplay1->save();
             }else{
             	 $newtowhosplay1 = new WhoisPlaying;
    			 $newtowhosplay1->type = 'Individual';
                 $newtowhosplay1->playera = $request->playerA[$i];
                 $newtowhosplay1->playerb = $request->playerB[$i];
                 $newtowhosplay1->status = 'active';
                 $newtowhosplay1->created_at = date('Y-m-d H:i:s');
                 $newtowhosplay1->updated_at = date('Y-m-d H:i:s');
                 $newtowhosplay1->save();

             }
          }
              else{
              	if(array_key_exists($i,$request->whosids)){
             	 $newtowhosplay1 = WhoisPlaying::find($request->whosids[$i]);
             	 $newtowhosplay1->type = 'Team';
                 $newtowhosplay1->teama = $request->teamA[$i];
                 $newtowhosplay1->teamb = $request->teamB[$i];
                 $newtowhosplay1->status = 'active';
                 $newtowhosplay1->save();
               }else{
               	 $newtowhosplay1 = new WhoisPlaying;
    			 $newtowhosplay1->type = 'Team';
                 $newtowhosplay1->teama = $request->teamA[$i];
                 $newtowhosplay1->teamb = $request->teamB[$i];
                 $newtowhosplay1->status = 'active';
                 $newtowhosplay1->created_at = date('Y-m-d H:i:s');
                 $newtowhosplay1->updated_at = date('Y-m-d H:i:s');
                 $newtowhosplay1->save();

               }
             }
             


            $explode = explode(' - ', $request->datetime[$i]);
			$str1 = str_replace(',', ' ', $explode[0]);
			$concat = $str1.' '.$explode[1];
			$date = date('Y-m-d H:i:s',strtotime($concat));

			if(array_key_exists($i,$request->betids)){
			 $new = Bets::find($request->betids[$i]);
			  if(count($request->competition) > 1){
             	$new->bettype = 'multiplebet';
             }else{
                 $new->bettype = 'singlebet';
             }
             $new->competition_id = $request->competition[$i];
             $new->sport_id = $request->sport[$i];
             $new->betdate = $date;
             $new->whosplaying_id = $newtowhosplay1->id;
             $new->tiptype_id  = $request->tiptype[$i]; 
             $new->betcategory_id  = $request->betcategory; 
             $new->trustnote  = $request->rating;
             $new->odds  = $request->odds[$i];
             $new->actualtip  = $request->actualtip[$i];
            $new->finalodds = $request->finalOdds;
             //$new->betmanager_id = $betm->id;
             /*$new->created_at = date('Y-m-d H:i:s');
             $new->updated_at = date('Y-m-d H:i:s');*/
             $new->save();
			}else{
		     $new = new Bets;
		      if(count($request->competition) > 1){
             	$new->bettype = 'multiplebet';
             }else{
                 $new->bettype = 'singlebet';
             }
             $new->competition_id = $request->competition[$i];
             $new->sport_id = $request->sport[$i];
             $new->betdate = $date;
             $new->whosplaying_id = $newtowhosplay1->id;
             $new->tiptype_id  = $request->tiptype[$i]; 
             $new->betcategory_id  = $request->betcategory; 
             $new->trustnote  = $request->rating;
             $new->odds  = $request->odds[$i];
             $new->actualtip  = $request->actualtip[$i];
              $new->finalodds = $request->finalOdds;
             //$new->betmanager_id = $betm->id;
             $new->created_at = date('Y-m-d H:i:s');
             $new->updated_at = date('Y-m-d H:i:s');
             $new->save();


			}



            /* Multibet start*/
            if($new->bettype == 'multiplebet'){
                if(strtotime($date) == $mostRecent_date && $parent_id == 0){
                $parent_id = $new->id;
                Bets::where('id',$new->id)->update(['parent_id' => -1]);
                } else {
                    $all_child_ids[] = $new->id;
                }

                if(count($all_child_ids) > 0){
                    Bets::whereIn('id',$all_child_ids)->update(['parent_id' => $parent_id]);
                } 
            } else {
                Bets::where('id',$new->id)->update(['parent_id' => 0]);
            }

          

            /* Multibet End*/

    	 }
    	 return redirect('admin/bets/allbets')->with('success', 'Bet Has been Updated, Successfully!');
    }

    

}
