<?php

namespace App\Model\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Category extends Model
{

    protected $table = 'categories';

   
    public function products() { //1:M
        return $this->hasMany('App\Model\Product\Product', 'category_id')
        //->select('id', 'name')
        ;
    }

    public function subcategory(){
        return $this->hasMany('App\Model\Product\Category', 'parent_id');
    }

    

   
    
}
