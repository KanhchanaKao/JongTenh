<?php

namespace App\Api\V1\Controllers\CP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Dingo\Api\Routing\Helpers;
use JWTAuth;

use App\Api\V1\Controllers\ApiController;
use App\Enum\OrderStatus;
use App\Model\Order\Details as OrderDetails;
use App\Model\Order\Order;
use App\Model\Product\Product; 
use App\Model\Customer\Customer;
use App\CamCyber\Recomendation;
use App\Model\Setup\Status;

class OrderController extends ApiController
{
    use Helpers;
   
    function listing(Request $req){
       
        $data           = Order::select('*')
        ->with([
            'details',
            'status:id,name',
            'customer'
        ]); 

       // ==============================>> Date Range
       if($req->from && $req->to && isValidDate($req->from) && isValidDate($req->to)){
            $data = $data->whereBetween('created_at', [$req->from." 00:00:00", $req->to." 23:59:59"]);
        }
        
        // =========================== Search receipt number
        if( $req->receipt_number && $req->receipt_number !="" ){
            $data = $data->where('receipt_number', $req->receipt_number);
        }
    
        $data = $data->orderBy('id', 'DESC')->paginate( $req->limit ? $req->limit : 10);
        return response()->json($data, 200);
    }
    function delete($id =0){
        
        $data = Order::find($id);
        //==============================>> Start deleting data
        if($data){

            $data->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data has been deleted',
            ], 200);

        }else{

            return response()->json([
                'message' => 'Invalid data.',
            ], 400);

        }

        
    }
    function create(Request $req){
        
        $this->validate($req,[
             'cart'             => 'required|json',
             'discount'         => 'required',
             'customer_id'      => 'required'          
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

        $customer = Customer::find($req->customer_id); 

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
            $order->status_id       = OrderStatus::Pending;
            $order->total_price_khr = $totalPriceKhr; 
            $order->total_price_usd = $totalPriceKhr/$rate; 
            $order->ordered_at = Date('Y-m-d H:i:s'); 
            $order->save(); 

            $data           = Order::select('*')
            ->with([
                'details'
            ])
            ->find($order->id); 

            //update recomendation
            Recomendation::update($order);
            
            return response()->json([
                'cart' => $cart,
                'order' => $data,
                'details' => $details, 
                'total_price' => $totalPrice, 
                'message' => 'Order has been successfully created.'
            ], 200);
        }else{
            
            return response()->json([
                'message' => 'Invalid Customer.'
            ], 400);
        }
    }
    function acceptOrder($id = 0){

        $order = Order::select('*')
        ->with(['customer','status'])
        ->find($id);
        // return $order;

        if ($order){
          
            if(!$order->accepted_at ){
                
                $hasEnough = true;
                $stocks = [];
                
                foreach($order->details as $row){
                    if($row->product->qty - $row->qty < 0){
                        $hasEnough = false;
                        $stocks[]  = [
                            "product"        => $row->product->name,
                            "availibale_qty" => $row->product->qty,
                            "requirement"    => $row->qty
                        ];
                    }
                  
                }

                if($hasEnough){

                    foreach($order->details as $row){
                        
                        $row->product->qty = $row->product->qty - $row->qty;
                        $row->product->save();
                    }
                    $order->accepted_at = Date("Y-m-d H:i:s");
                    $order->status_id = OrderStatus::Accepted;
                    $order->save();

                    //update recomendation
                    Recomendation::update($order);
    
                    return response()->json([
                        'message' => 'Order has been successfully accepted',
                        'data' => $order
                    ], 200);
                }else{
                    return response()->json([
                        'message'   => 'Some products are out of stock',
                        'stocks'    => $stocks
                    ], 400);
                }

            }else{

                return response()->json([
                    'message' => 'This Product has already Accepted',
                    'data' => $order
                ], 400);
    
            }
        
        }else{
            return response()->json([
                'message' => 'Invalid data'
            ], 400);
        }
        
    }
    function rejectOrder($id = 0){
        $order = Order::select('*')
        ->with(['customer','status:id,name'])
        ->find($id)
        ;
        if($order){

            if(!$order->rejected_at){

                foreach($order->details as $row){
                        
                    $row->product->qty = $row->product->qty + $row->qty;
                    $row->product->save();
                }
                $order->rejected_at = Date("Y-m-d H:i:s");
                $order->status_id = OrderStatus::Rejected;
                $order->save();
                return response()->json([
                    'message' => 'Order has been successfully rejected',
                    'data' => $order
                ], 200);
               
            }else{
                return response([
                    'message'=>'This Product has already Rejected',
                    'data'   => $order
                ],400);
            }

        }else{
            return response([
                'message'=>'Invalid Order'
            ],400);
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
    function getStatus(){
        $status = Status::select('*')
        ->withCount('order')
        ->get()        
        ;
        return response()->json([
            'data' => $status

        ],200);
    }
    
    
}
