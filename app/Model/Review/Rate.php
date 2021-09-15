<?php

namespace App\Model\Review;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Rate extends Model
{

    protected $table = 'rate';

   
    public function products() { //1:M
        return $this->hasMany('App\Model\Product\Product', 'review_rate_id')
        //->select('id', 'name')
        ;
    }

    public function reviews(){
        return $this->hasMany('App\Model\Review\Review', 'rate_id');
    }

    

   
    
}
