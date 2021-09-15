<?php

namespace App\Model\Review;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB; 

class Review extends Model
{
   	//use SoftDeletes;
    

    protected $table = 'review';

   
    public function rate() { //M:1
        return $this->belongsTo('App\Model\Review\Rate', 'rate_id')
        ->select('id', 'color');
    }

    public function product() { //M:1
        return $this->belongsTo('App\Model\Product\Product', 'product_id')
        ;
    }

    public function customer() { //M:1
        return $this->belongsTo('App\Model\Customer\Customer', 'customer_id')
        ->select('id', 'user_id')
        ->with([
            'user:id,name,phone'
        ])
        ;
    }

   
   
    
}
