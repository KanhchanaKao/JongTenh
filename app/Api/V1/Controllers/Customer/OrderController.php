<?php

namespace App\Api\V1\Controllers\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Dingo\Api\Routing\Helpers;
use JWTAuth;

use App\Api\V1\Controllers\ApiController;
use App\Model\Order\Details as OrderDetails;
use App\Model\Order\Order;
use App\Model\Product\Product; 
use App\Model\Customer\Customer;

class OrderController extends ApiController
{
    use Helpers;
   
    function create(Request $req){
        $user         = JWTAuth::parseToken()->authenticate();
        
        $this->validate($req,[
             'cart'             => 'required|json',
             'discount'         => 'required'
        ]);

      

        //Create Order
        $order      = new Order;
        $order->receipt_number  = $this->generateReceiptNumber(); 
        $order->save();

        //Find Total Price
            
        $details = [];
        $totalPrice = 0;

        $cart = json_decode($req->cart);
        
        
        // return response()->json([
        //     $cart
        // ], 200);

        foreach($cart as $productId => $qty){

            // return $productId;
            
            $product = Product::find($productId);

            if($product){

                //Check Stock
                $details[] = [
                    'order_id'      => $order->id,
                    'product_id'    => $productId,
                    'qty'           => $qty,
                    'discount'      => $product->discount,
                    'unit_price'    => $product->unit_price,
                ];

                $totalPrice += $qty*$product->unit_price - $qty*$product->unit_price*$product->discount*0.001;

            }

        }

        $customer = Customer::where('user_id', $user->id)->select('*')->first();

        if($customer){
            // return $customer;
            //Save to Detail
            OrderDetails::insert($details);
    
            $rate               = 4000; 
            $discountAmount     = $totalPrice*$req->discount*0.01; 
            $totalPriceKhr      = $totalPrice - $discountAmount; 

            //Update Order
            $order->total_price     = $totalPrice; 
            $order->discount        = $req->discount; 
            $order->customer_id     = $customer->id;
            $order->total_price_khr = $totalPriceKhr; 
            $order->total_price_usd = $totalPriceKhr/$rate; 
            $order->ordered_at = Date('Y-m-d H:i:s');
            $order->status_id  = 3; 
            $order->save(); 
            $data           = Order::select('*')
            ->with([
                'details'
            ])
            ->find($order->id); 

            return response()->json([
                'cart' => $cart,
                'order' => $data,
                'details' => $details, 
                'total_price' => $totalPrice, 
                'message' => 'Order has been successfully created.'
            ], 200);

        }else{
            return response()->json([
                'message' => 'Invalid Customer'
            ], 400);
        } 
    
    }
    function generateReceiptNumber(){
        $number = rand(1000000, 9999999); 
        $check = Order::where('receipt_number', $number)->first(); 
        if($check){
            return $this->generateReceiptNumber();
        }

        return $number; 
    }
    function orderHistory(){
        $user         = JWTAuth::parseToken()->authenticate();
        $customer = Customer::where('user_id', $user->id)->select('*')->first();
        $data       = Order::select(
        'id',
        'customer_id',
        'receipt_number',
        'ordered_at',
        'total_price_khr',
        'total_price_usd',
        'discount',
        'total_price',
        'status_id'
        )
        ->with(['details','status:id,name'])
        ->where('customer_id',$customer->id)
        ->limit(100)
        ->orderBy('id', 'DESC')
        ->get();
        return $data;   
    }
    

}
