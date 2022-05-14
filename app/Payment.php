<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use App\User;
class Payment extends Model
{
    protected $table = 'payments';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_no', 'user_id', 'plan_id', 'actual_amount', 'paid_amount', 'payment_for', 'status', 'gateway', 'mode','start_date','end_date'
    ];
    public $sortable = ['invoice_no', 'amount', 'payment_for','status','created_at'];
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
    /* Get challenge description attach with payments */
    public function get_plan(){
        return $this->hasOne('App\Plan', 'id','plan_id');
    }
}
