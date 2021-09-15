<?php

namespace App\Model\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB; 

class Product extends Model
{
   	use SoftDeletes;
    

    protected $table = 'product';

    public function rate() { //M:1
        return $this->belongsTo('App\Model\Review\Rate', 'review_rate_id')
        ->select('id', 'name', 'color')
        ;
    }
   
    public function category() { //M:1
        return $this->belongsTo('App\Model\Product\Category', 'category_id')
        ->select('id', 'name');
    }

    public function order_detials() { //1:M
        return $this->hasMany('App\Model\Order\Detail', 'product_id')
        //->select('id', 'name')
        ;
    }

    public function supplier(){

        return $this->belongsTo('App\Model\Supplier\Supplier','supplier_id')
        ->select('id', 'name');
    }

    public function stock_details(){
        return $this->hasMany('App\Model\Stock\Details', 'product_id');
    }

    public function recomendations(){
        return $this->hasMany('App\Model\Customer\Recomendation', 'product_id')
        ->select('id','product_id','customer_id','n_of_orders')
        ->with([
            'customer',
            'customer.user'
        ])
        ;
    }

    public function details() { //1:M
        return $this->hasMany('App\Model\Order\Details', 'product_id')
        ; 
    }

    public function reviews() { //1:M
        return $this->hasMany('App\Model\Review\Review', 'product_id')
        ->with([
            'customer', 
            'customer.user:id,name,phone', 
            'rate'
        ])
        ; 
    }

   
    
}
