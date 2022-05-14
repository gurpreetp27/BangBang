<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bets extends Model
{
    protected $table = 'bet';

    public function whoisPlaying1()
    {
    	
        return $this->hasOne('App\WhoisPlaying','id','whosplaying_id');
    }

    public function betcategory1()
    {
        return $this->hasOne('App\BetCategory','id','betcategory_id');
    }
    public function competion(){
    	return $this->hasOne('App\Competition','id','competition_id');
    }
    public function sport(){
    	return $this->hasOne('App\Sport','id','sport_id');
    }
    public function tiptype(){
    	return $this->hasOne('App\Tiptype','id','tiptype_id');
    }
    public function team(){
    	return $this->hasOne('App\Team','id','tiptype_id');
    }
    public function betManager(){
      return $this->hasOne('App\BetManager','id','betmanager_id');   
    }
     public function delete1()
    {
        $this->whoisPlaying1()->delete();
        return parent::delete();
    }
}
