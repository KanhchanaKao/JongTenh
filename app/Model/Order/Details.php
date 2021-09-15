<?php

namespace App\Model\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Details extends Model
{
   	use SoftDeletes;

    protected $table = 'order_details';

    public function order() {  //M-1
        return $this->belongsTo('App\Model\Order\Order', 'order_id');
    }

    public function product() { //M-1
        return $this->belongsTo('App\Model\Product\Product', 'product_id');
    }
    
}