<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Plan;
class Membership extends Model
{

    protected $table = 'membership';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','is_renew', 'plan_id','payment_id', 'amount', 'status','start_date','end_date'
    ];
    // public $sortable = ['invoice_no', 'amount', 'payment_for','status','created_at'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    /* Get user detail attach with payments */
    public function get_user(){
        return $this->belongsTo('App\User','user_id');
    }

    public function has_user(){
        return $this->hasOne('App\User','user_id');
    }
    /* Get plan with payments */
    public function get_plan(){
        return $this->belongsTo('App\Plan', 'plan_id');
    }

    /* Get payment details */
    public function get_payment(){
        return $this->hasOne('App\Payment','id','payment_id');
    }
}
