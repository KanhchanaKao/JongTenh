<?php

namespace App\Model\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Supplier extends Model
{
   	use SoftDeletes;
    

    protected $table = 'supplier';
   
    public function products(){
        return $this->hasMany('App\Model\Product\Product', 'supplier_id');
    }
    public function stock(){
        return $this->hasMany('App\Model\Stock\Stock','supplier_id');
    }
   
    
}