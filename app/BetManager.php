<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BetManager extends Model
{
    protected $table = 'betmanager';

    public function bets()
    {
    	return $this->hasMany('App\Bets','betmanager_id','id');
    }
    public function betcategory()
    {
        return $this->hasOne('App\BetCategory','id','betcategory_id');
    }
    public function delete()
    {
        $this->bets()->delete();
        return parent::delete();
    }
}
