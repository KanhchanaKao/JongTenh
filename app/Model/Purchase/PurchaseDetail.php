<?php

namespace App\Model\Purchase;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{	
    protected $table ='purchase_details';

    public function purchase(){
        return $this->belongsTo('App\Model\Purchase\Purchase', 'purchase_id');
    }

    public function product(){
        return $this->belongsTo('App\Model\Product\Product', 'product_id')
        ->select('id','name');
    }

   
}