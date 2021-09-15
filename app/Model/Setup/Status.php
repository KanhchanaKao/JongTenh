<?php

namespace App\Model\Setup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Status extends Model
{

    protected $table = 'status';

   
    public function order() { //1:M
        return $this->hasMany('App\Model\Order\Order', 'status_id');
    }

    public function stock() { //1:M
        return $this->hasMany('App\Model\Stock\Stock', 'status_id');
    }
 
}
