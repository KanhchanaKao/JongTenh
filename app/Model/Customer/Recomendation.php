<?php

namespace App\Model\Customer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recomendation extends Model
{
    use SoftDeletes;
    protected $table = 'customer_products_recomendation';

    public function customer(){
        return $this->belongsTo('App\Model\Customer\Customer', 'cutomer_id')
        ->select('id','user_id')
        ->with(['
            user:id,name,phone
        ']);
    }

    public function product(){
        return $this->belongsTo('App\Model\Product\Product', 'product_id')
        ->select('id','name','image');
    }


}