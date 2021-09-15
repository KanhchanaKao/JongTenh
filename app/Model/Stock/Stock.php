<?php

namespace App\Model\Stock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Stock extends Model
{
   	// use SoftDeletes;
    

    protected $table = 'stock';

   
    public function admin(){
        return $this->belongsTo('App\Model\Admin\Main', 'admin_id')
        ->select('id', 'user_id')
        ->with([
            'user:id,name,email,phone'
        ]);
    }

    public function details(){
        return $this->hasMany('App\Model\Stock\Details','stock_id')
        ->with(['product:id,name'])
        ;
    }

    public function supplier(){
        return $this->belongsTo('App\Model\Supplier\Supplier','supplier_id')
        ->select('id','name')
        ;
    }

    public function status() {  //M-1
        return $this->belongsTo('App\Model\Setup\Status', 'status_id')
        ->select('id','name')
        ;
    }
    
}
