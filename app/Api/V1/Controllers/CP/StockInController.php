<?php

namespace App\Api\V1\Controllers\CP;

use Illuminate\Http\Request;

use Dingo\Api\Routing\Helpers;
use JWTAuth;

use App\Api\V1\Controllers\ApiController;
use App\Model\Stock\Details;
use App\Model\Product\Product; 
use App\Model\Stock\Stock;
use App\Model\Supplier\Supplier;

class StockInController extends ApiController
{
    use Helpers;
   
    function listing(Request $req){
       
        $data           = Stock::select('*')
        ->with([
            'details',
            'supplier',
            'status',
        ]); 


       // ==============================>> Date Range
       if($req->from && $req->to && isValidDate($req->from) && isValidDate($req->to)){
            $data = $data->whereBetween('created_at', [$req->from." 00:00:00", $req->to." 23:59:59"]);
        }
        
        // =========================== Search receipt number
        if( $req->code && $req->code !="" ){
            $data = $data->where('code', $req->code);
        }
    
        $data = $data->orderBy('id', 'desc')->paginate( $req->limit ? $req->limit : 10);
        return response()->json($data, 200);
    }

     function delete($id = 0){
        
        $data = Stock::find($id);

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

    function stockRequest(Request $req){

        $user         = JWTAuth::parseToken()->authenticate();
        
        $this->validate($req,[
             'cart'                 => 'required|json',
             'supplier_id'          => 'required',
        ]);

      

        //Create Order
        $stock      = new Stock;
        $stock->code  = $this->generateReceiptNumber(); 
        $stock->save();

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
                    'stock_id'      => $stock->id,
                    'product_id'    => $productId,
                    'qty'           => $qty,
                    'unit_price'    => $product->unit_price,
                ];

                $totalPrice += $qty*$product->unit_price ;

            }

        }
        $supplier = Supplier::find($req->supplier_id);
        if($supplier){

        // return $customer;
        //Save to Detail
        Details::insert($details);

        //Update Stock In
        $stock->total_price     = $totalPrice; 
        $stock->requested_at = Date('Y-m-d H:i:s');
        $stock->status_id       = 3;
        $stock->supplier_id = $supplier->id; 
        $stock->save(); 
        $data           = Stock::select('*')
       ->with([
           'details'
       ])
       ->find($stock->id); 

       return response()->json([
            'cart' => $cart,
            'stock' => $data,
            'details' => $details, 
            'total_price' => $totalPrice, 
            'message' => 'Stock has been successfully created.'
        ], 200);
        }else{

        }
    }

    function makeStock( $id = 0){
        $stock = Stock::select('*')
        ->with([
           'details',
           'details.product'
           ])
        //->where('stocked_at', null)

        ->find($id)
        ;
        if ($stock){
            if(!$stock->stocked_at ){
                foreach($stock->details as $row){
                    $row->product->qty = $row->product->qty + $row->qty;
                    $row->product->save();
                }

                $stock->stocked_at = Date("Y-m-d H:i:s");
                $stock->status_id = 1;
                $stock->save();

                return response()->json([
                    'message' => 'Product has been Stock-In Successfully!',
                    'data' => $stock
                ], 200);
            }else{

                return response()->json([
                    'message' => 'This record has already been Stocked-In',
                    'data' => $stock
                ], 400);
    
            }
        
        }else{
            return response()->json([
                'message' => 'This record has already been Stocked-In'
            ], 400);
        }
      

    }

    function generateReceiptNumber(){
        $number = rand(1000000, 9999999); 
        $check = Stock::where('code', $number)->first(); 
        if($check){
            return $this->generateReceiptNumber();
        }

        return $number; 
    }
    
}
