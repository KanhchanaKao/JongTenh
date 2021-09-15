<?php

namespace App\Model\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
   	use SoftDeletes;

    protected $table = 'order';


    public function details() {
        return $this->hasMany('App\Model\Order\Details', 'order_id')
        ->select('id', 'order_id', 'qty', 'product_id', 'unit_price')
        ->with([
            'product:id,name,image,qty'
        ])
        ;
    }

    public function customer() {  //M-1
        return $this->belongsTo('App\Model\Customer\Customer', 'customer_id')
        ->with(['user:id,name,phone'])
        ;
    }

    public function status() {  //M-1
        return $this->belongsTo('App\Model\Setup\Status', 'status_id');
    }

    public function payment() {
        return $this->belongsTo('App\Model\Setup\Payment', 'payment_id');
    }
    
}