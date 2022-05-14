<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlertEmail extends Model
{
     protected $table = 'alert_email';

     /*it used to get user info related send email*/
     public function user_info(){
        return $this->hasOne('App\User', 'id','user_id');
    }
}
