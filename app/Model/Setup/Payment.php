<?php

namespace App\Model\Setup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Payment extends Model
{

    protected $table = 'payment';

   
    public function order() { //1:M

        return $this->hasMany('App\Model\Order\Order', 'payment_id');

    }

   
    
}
