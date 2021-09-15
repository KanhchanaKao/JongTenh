<?php

namespace App\CamCyber;
use App\Model\Customer\Recomendation as Model; 

class Recomendation{
    
  
    public static function update($order){
      
        foreach($order->details as $row){
            $data =Model::where([
                'customer_id' => $order->customer_id,
                'product_id'  => $row->product_id  
            ])
            ->first()
            ;
            if($data){
                $data->n_of_orders = $data->n_of_orders + 1;
                $data->qty         = $data->qty + $row->qty;
                $data->save();
            }else{
                $data = new Model;
                $data->customer_id = $order->customer_id;
                $data->product_id  = $row->product_id;
                $data->n_of_orders = 1;
                $data->qty         = $row->qty;
                $data->save();
            }
        }
        
    }

   
  
}
