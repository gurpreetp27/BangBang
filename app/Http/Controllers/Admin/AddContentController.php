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

class AddContentController extends Controller
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

    public function addSport(){
        $sports = Sport::orderBy('created_at','DESC')->get()->toArray(); 
        return view('admin.screen.addcontent.sport.addSport',['sports'=>$sports]);
    }
    public function sportSave(Request $request) {
         $validatedData = $request->validate([
                'sportName' => 'required|max:255|unique:sport,name'
            ]);
         $new = new Sport;
         $new->name = $request->sportName;
         $new->status = 'active';
         $new->created_at = date('Y-m-d H:i:s');
         $new->updated_at = date('Y-m-d H:i:s');
         $new->save();
         return redirect()->back()->with('success', 'Sport Has been Added,Suceessfully!');
    }

    public function removesport(Request $request) {
        Sport::where('id', $request->id)->delete();
        echo "sucess";
        exit;
    }

   public function editsport($id){
       $sport = Sport::find($id);
       return view('admin.screen.addcontent.sport.editSport',['sport'=>$sport]);
   }
    public function editSavesport(Request $request){
        $validatedData = $request->validate([
            'sportName' => 'required|max:255'
        ]);
       $sport = Sport::find($request->aityd);
       $sport->name = $request->sportName;
       $sport->save();
       return redirect('/admin/addcontent/sport')->with('success', 'Sport Has been Updated,Suceessfully!');
   }

   public function addCompetition(){
        $sports = Competition::orderBy('created_at','DESC')->get()->toArray(); 
        return view('admin.screen.addcontent.competition.addCompetition',['sports'=>$sports]);
    }

    public function competitionSave(Request $request) {
          $validatedData = $request->validate([
                'competitionName' => 'required|max:255|unique:competition,name'
            ]);
         $new = new Competition;
         $new->name = $request->competitionName;
         $new->status = 'active';
         $new->created_at = date('Y-m-d H:i:s');
         $new->updated_at = date('Y-m-d H:i:s');
         $new->save();
         return redirect()->back()->with('success', 'Competition Has been Added,Suceessfully!');
    }
    public function removecompetition(Request $request) {
        Competition::where('id', $request->id)->delete();
        echo "sucess";
        exit;
    }
    public function editCompetition($id){
       $sport = Competition::find($id);
       return view('admin.screen.addcontent.competition.editCompetition',['sport'=>$sport]);
   }
   public function editSaveCompetition(Request $request){
        $validatedData = $request->validate([
            'CompetitionName' => 'required|max:255'
        ]);
       $sport = Competition::find($request->aityd);
       $sport->name = $request->CompetitionName;
       $sport->save();
       return redirect('/admin/addcontent/competition')->with('success', 'Competition Has been Updated,Suceessfully!');
   }



   public function addplayer(){
        $sports = Player::orderBy('created_at','DESC')->get()->toArray(); 
        return view('admin.screen.addcontent.player.addPlayer',['sports'=>$sports]);
    }

    public function playerSave(Request $request) {
          $validatedData = $request->validate([
                'PlayerName' => 'required|max:255|unique:player,name'
            ]);
         $new = new Player;
         $new->name = $request->PlayerName;
         $new->status = 'active';
         $new->created_at = date('Y-m-d H:i:s');
         $new->updated_at = date('Y-m-d H:i:s');
         $new->save();
         return redirect()->back()->with('success', 'Player Has been Added,Suceessfully!');
    }
    public function removeplayer(Request $request) {
        /*Check Plyaer exit or not in WhoisPlaying table*/
        $check_exit_1 = WhoisPlaying::where('playera',$request->id)->first();
        $check_exit_2 = WhoisPlaying::where('playerb',$request->id)->first();
        if($check_exit_1 || $check_exit_2){
          echo "error1";
          exit;
        }
        Player::where('id', $request->id)->delete();
        echo "sucess";
        exit;
    }
    public function editplayer($id){
       $sport = Player::find($id);
       return view('admin.screen.addcontent.player.editPlayer',['sport'=>$sport]);
   }
   public function editSaveplayer(Request $request){
        $validatedData = $request->validate([
            'PlayerName' => 'required|max:255'
        ]);
       $sport = Player::find($request->aityd);
       $sport->name = $request->PlayerName;
       $sport->save();
       return redirect('/admin/addcontent/player')->with('success', 'Player Has been Updated,Suceessfully!');
   }





   public function addteam(){
        $sports = Team::orderBy('created_at','DESC')->get()->toArray(); 
        return view('admin.screen.addcontent.team.addteam',['sports'=>$sports]);
    }

    public function teamSave(Request $request) {
          $validatedData = $request->validate([
                'teamName' => 'required|max:255|unique:team,name'
            ]);
         $new = new Team;
         $new->name = $request->teamName;
         $new->status = 'active';
         $new->created_at = date('Y-m-d H:i:s');
         $new->updated_at = date('Y-m-d H:i:s');
         $new->save();
         return redirect()->back()->with('success', 'Team Has been Added,Suceessfully!');
    }
    public function removeteam(Request $request) {
        Team::where('id', $request->id)->delete();
        echo "sucess";
        exit;
    }
    public function editteam($id){
       $sport = Team::find($id);
       return view('admin.screen.addcontent.team.editteam',['sport'=>$sport]);
   }
   public function editSaveteam(Request $request){
        $validatedData = $request->validate([
            'teamName' => 'required|max:255'
        ]);
       $sport = Team::find($request->aityd);
       $sport->name = $request->teamName;
       $sport->save();
       return redirect('/admin/addcontent/team')->with('success', 'Team Has been Updated,Suceessfully!');
   }




    public function addtiptype(){
        $sports = Tiptype::orderBy('created_at','DESC')->get()->toArray(); 
        return view('admin.screen.addcontent.tiptype.addtiptype',['sports'=>$sports]);
    }

    public function tiptypeSave(Request $request) {
          $validatedData = $request->validate([
                'tiptypeName' => 'required|max:255|unique:tiptype,name'
            ]);
         $new = new Tiptype;
         $new->name = $request->tiptypeName;
         $new->status = 'active';
         $new->created_at = date('Y-m-d H:i:s');
         $new->updated_at = date('Y-m-d H:i:s');
         $new->save();
         return redirect()->back()->with('success', 'Tiptype Has been Added,Suceessfully!');
    }
    public function removetiptype(Request $request) {
        Tiptype::where('id', $request->id)->delete();
        echo "sucess";
        exit;
    }
    public function edittiptype($id){
       $sport = Tiptype::find($id);
       return view('admin.screen.addcontent.tiptype.edittiptype',['sport'=>$sport]);
   }
   public function editSavetiptype(Request $request){
        $validatedData = $request->validate([
            'tiptypeName' => 'required|max:255'
        ]);
       $sport = Tiptype::find($request->aityd);
       $sport->name = $request->tiptypeName;
       $sport->save();
       return redirect('/admin/addcontent/tiptype')->with('success', 'Tiptype Has been Updated,Suceessfully!');
   }


   public function addplan(){
        $sports = Plan::orderBy('created_at','DESC')->get()->toArray(); 
        return view('admin.screen.addcontent.plan.addplan',['sports'=>$sports]);
   }

   public function planSave(Request $request){
         $validatedData = $request->validate([
                'planName' => 'required|max:255',
                'amount' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                'duration' => 'required|integer|min:1|digits_between: 1,8' 
            ]);
         $new = new Plan;
         $new->name = $request->planName;
         $new->amount = $request->amount;
         $new->duration = $request->duration;
         $new->status = 'active';
         $new->stats = $request->stats;
         $new->created_at = date('Y-m-d H:i:s');
         $new->updated_at = date('Y-m-d H:i:s');
         $new->save();
         return redirect()->back()->with('success', 'Plan Has been Added,Suceessfully!');
   }

   public function removeplan(Request $request){
        Plan::where('id', $request->id)->delete();
        echo "sucess";
        exit;
   }

   public function editplan($id){
       $sport = Plan::find($id);
       return view('admin.screen.addcontent.plan.editplan',['sport'=>$sport]);
   }

   public function editSaveplan(Request $request){
         $validatedData = $request->validate([
                'planName' => 'required|max:255',
                'amount' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                'duration' => 'required|integer|min:1|digits_between: 1,8' 
            ]);
         $new = Plan::find($request->aityd);
         $new->name = $request->planName;
         $new->amount = $request->amount;
         $new->duration = $request->duration;
         $new->status = 'active';
         $new->stats = $request->stats;
         $new->created_at = date('Y-m-d H:i:s');
         $new->updated_at = date('Y-m-d H:i:s');
         $new->save();
         return redirect('/admin/addcontent/plan')->with('success', 'Plan Has been Updated,Suceessfully!');
   }



 public function addbetcategory(){
        $sports = BetCategory::orderBy('created_at','DESC')->get()->toArray(); 
        return view('admin.screen.addcontent.betcategory.addbetcat',['sports'=>$sports]);
   }

    public function betcategorySave(Request $request){
         $validatedData = $request->validate([
                'betcategoryName' => 'required|max:255|unique:bet_category,name'
            ]);
         $new = new BetCategory;
         $new->name = $request->betcategoryName;
         $new->status = 'active';
         $new->created_at = date('Y-m-d H:i:s');
         $new->updated_at = date('Y-m-d H:i:s');
         $new->save();
         return redirect()->back()->with('success', 'Betcategory Has been Added,Suceessfully!');
   }

   public function betcategoryremove(Request $request){
        BetCategory::where('id', $request->id)->delete();
        echo "sucess";
        exit;
   }

   public function editbetcategory($id){
       $sport = BetCategory::find($id);
       return view('admin.screen.addcontent.betcategory.editbetcat',['sport'=>$sport]);
   }

   public function editSavebetcategory(Request $request){
         $validatedData = $request->validate([
                'betcategoryName' => 'required|max:255',
            ]);
         $new = BetCategory::find($request->aityd);
         $new->name = $request->betcategoryName;
         $new->save();
         return redirect('admin/addcontent/betcategory')->with('success', 'Betcategory Has been Updated, Suceessfully!');
      
   }

   

}
