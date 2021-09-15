<?php

namespace App\Model\Purchase;

use Illuminate\Database\Eloquent\Model;

class PurchaseStatus extends Model
{	
    protected $table ='purchase_status';

    public function purchases(){
        return $this->hasMany('App\Model\Purchase\Purchase', 'status_id');
    }
   
}
