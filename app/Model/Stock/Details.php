<?php

namespace App\Model\Stock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Details extends Model
{
   	// use SoftDeletes;
    
    protected $table = 'stock_details';

   
    public function admin(){
        return $this->belongsTo('App\Model\Admin\Main', 'admin_id')
        ->select('id', 'user_id')
        ->with([
            'user:id,name,email,phone'
        ]);
    }

    public function stock(){
        return $this->belongsTo('App\Model\Stock\Stock', 'stock_id');
    }

    public function product(){
        return $this->belongsTo('App\Model\Product\Product', 'product_id')
        ;
    }

   
    
}
