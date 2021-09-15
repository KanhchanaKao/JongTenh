<?php

namespace App\Model\Customer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    protected $table = 'customer';

    public function user(){
        return $this->belongsTo('App\Model\User\Main', 'user_id')
        ->select('id','name','phone','email','avatar');
    }

    public function orders(){
        return $this->hasMany('App\Model\Order\Order', 'customer_id')->select('*')
        ;
    }

    public function recomendations(){
        return $this->hasMany('App\Model\Customer\Recomendation', 'customer_id')
        ->select('id','product_id','customer_id','n_of_orders')
        ->with(['product'])
        ;
    }


}