<?php
namespace App\Api\V1\Controllers\CP;

use Illuminate\Http\Request;
use App\Api\V1\Controllers\ApiController;
use App\Model\Customer\Customer;
use App\Model\Order\Details as OrderDetails;
use App\Model\Order\Order;
use App\Model\Product\Product;
use App\Model\Purchase\Purchase;
use App\Model\Purchase\PurchaseDetail;
use App\Model\Supplier\Supplier;
use Tymon\JWTAuth\Facades\JWTAuth;
use Dingo\Api\Routing\Helpers;
use Carbon\Carbon;

class PurchaseController extends ApiController
{
    function getSupplier(){
        return Supplier::select('id','name','phone')
        ->with([
            'products'
        ])
        ->get();
    }
    function create(Request $req){
        
        $this->validate($req,[
             'cart'             => 'required|json',
             'supplier_id'      => 'required'
        ]);

        //Create Order
        $purchase      = new Purchase;
        $purchase->purchase_number  = $this->generateReceiptNumber(); 
        $purchase->save();

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
                    'purchase_id'      => $purchase->id,
                    'product_id'       => $productId,
                    'qty'               => $qty,
                    'unit_price'    => $product->unit_price,
                ];

                $totalPrice += $qty*$product->unit_price - $qty*$product->unit_price*$product->discount*0.001;
            }
            // return $totalPrice;

        }

        $supplier = Supplier::find($req->supplier_id);

        if($supplier){
           
            //Save to Detail
            PurchaseDetail::insert($details);
    
            $rate               = 4000; 
            $discountAmount     = $totalPrice*$req->discount*0.01;
            // return $discountAmount; 
            $totalPriceKhr      = $totalPrice - $discountAmount; 

            //Update Order
            $purchase->total_price     = $totalPrice; 
            $purchase->created_at = Date('Y-m-d H:i:s');
            $purchase->supplier_id = $supplier->id; 
            $purchase->status_id  = 3; 
            $purchase->save(); 
            $data           = Purchase::select('*')
            ->with([
                'details',
                'supplier'
            ])
            ->find($purchase->id); 

            return response()->json([
                'cart' => $cart,
                'purchase' => $data,
                'details' => $details, 
                'total_price' => $totalPrice, 
                'message' => 'Order has been successfully created.'
            ], 200);

        }else{
            return response()->json([
                'message' => 'Invalid Supplier'
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
}