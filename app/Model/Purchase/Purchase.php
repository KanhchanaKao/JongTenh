<?php

namespace App\Model\Purchase;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model{
    protected $table = 'purchase';

    public function supplier(){
        return $this->belongsTo('App\Model\Supplier\Supplier', 'supplier_id')
        ->select('id','name');
    }

    public function status() {  //M-1
        return $this->belongsTo('App\Model\Purchase\PurchaseStatus', 'status_id');
    }

    public function details() {
        return $this->hasMany('App\Model\Purchase\PurchaseDetail', 'purchase_id')
        ->select('id', 'purchase_id', 'qty', 'product_id', 'unit_price')
        ->with([
            'product:id,name,image,qty'
        ])
        ;
    }

}