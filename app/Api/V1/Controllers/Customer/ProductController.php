<?php

namespace App\Api\V1\Controllers\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use JWTAuth;
use Dingo\Api\Routing\Helpers;

use App\Api\V1\Controllers\ApiController;
use App\Model\Product\Product;
use App\Model\Review\Review;

class ProductController extends ApiController{
    
    use Helpers;

    function listing(){

        $data       = Product::select('*')
        ->with([
            'category',
            'supplier'
        ])
        ->limit(100)
        ->orderBy('id', 'DESC')
        ->get();
        return $data;
    }

    function view($id){

        $data       = Product::select('*')
        ->with([
            'category',
            'rate', 
            'reviews' => function($query){
                $query->select('id', 'product_id', 'rate_id', 'customer_id', 'comment', 'created_at')
                ->with([
                    'customer:id,user_id',
                    'customer.user:id,name', 
                    'rate:id,name,color'
                ])
                ->orderBy('id', 'DESC')
                ;
            }
        ])
       ->withCount([
           'reviews as n_of_reviews'
       ])
        ->find($id);
        
        if($data){

            //Check if logged and used to buy this product.
            $token = JWTAuth::getToken();
            $yourReview = [
                'can_review' => 0, 
                'status' => 'no_yet_buy'
            ]; 
         
            if($token){ //check login

                $user                       = JWTAuth::parseToken()->authenticate();
                if(isset($user->customer)){ //check if being customer; 

                    $review = Review::select('id', 'product_id', 'rate_id', 'comment', 'created_at')
                    ->where([
                        'product_id' => $data->id, 
                        'customer_id' => $user->customer->id
                    ])
                    ->with([
                        'rate:id,name,color'
                    ])
                    ->first(); 

                    if($review){

                        $yourReview = [
                            'can_review'    => 0, 
                            'review'        => $review, 
                            'status' => 'already_reviewed'
                        ]; 

                    }else{

                        $order = Product::whereHas('details', function($query) use ($user){
                            $query->whereHas('order', function($query) use ($user){
                                $query->where('customer_id', $user->customer->id); 
                            });
                        })
                        // ->with([
                        //     'order'
                        // ])
                        ->first()
                        ;

                        if(!$order){
                            $yourReview = [
                                'can_review'    => 0, 
                                'status' => 'no_yet_buy'
                            ]; 

                        }else{
                            $yourReview = [
                                'can_review'    => 1, 
                                'status' => 'already_bought_but_not_yet_review', 
                                //'order' => $order
                            ]; 
                        }

                       
                    }

                   
                    
                }
                

            }

            $data->your_review = $yourReview;

            return $data; 

        }else{
            return response()->json([
                'message'    => 'Invalid'
            ], 400);
        }
        
    }

    function review(Request $req){

        $this->validate($req,[
            'product_id'       => 'required|exists:product,id',
            'rate_id'         => 'required|exists:rate,id'
        ]);

        $token = JWTAuth::getToken();
        if($token){

            $user                       = JWTAuth::parseToken()->authenticate();
            if($user->customer){

                //Check if use to review
                $review = Review::select('id', 'product_id', 'rate_id', 'comment', 'created_at')
                ->where([
                    'product_id' => $req->product_id, 
                    'customer_id' => $user->customer->id
                ])
                ->with([
                    'rate:id,name,color'
                ])
                ->first(); 

                if($review){
                    return response()->json([
                        'message' => 'Already review.'
                    ], 400);
                }


                $data                   = new Review; 
                $data->product_id       = $req->product_id; 
                $data->rate_id          = $req->rate_id; 
                $data->customer_id      = $user->customer->id; 
                $data->comment          = $req->comment;
                $data->save(); 

                //Re calculate score for the product; 
                $product = Product::withCount([
                    'reviews as n_of_reviews'
                ])
                ->find($req->product_id); 

                $totalScore = Review::where('product_id', $req->product_id)->sum('rate_id'); 
                $product->rate_score   = round($totalScore/$product->n_of_reviews); 
                $product->save(); 


                return response()->json([
                    'message' => 'You have success reviewed this product. ', 
                    'product' => $this->view($req->product_id)
                ], 200);
               
            }
            

        }else{
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }


    }

}