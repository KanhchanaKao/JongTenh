<?php

namespace App\Api\V1\Controllers\Customer;

use Dingo\Api\Routing\Helpers;
use JWTAuth;

use App\Api\V1\Controllers\ApiController;
use App\Model\Product\Product;
use App\Model\Product\Category;

class HomeController extends ApiController{
    
    use Helpers;

    function index(){

        $categories       = Category::select('id', 'name' , 'image')
        ->get();

        $brands       = Product::select('*')
        ->limit(10)
        ->orderBy('id', 'DESC')
        ->get();

        //===================================================>> Top Sale Product
        $topSale       = Product::select('id','name','discount','image','unit_price', 'category_id', 'review_rate_id')
        ->with([
            'category',
        ])
        ->withCount([
            'details as n_of_orders', 
        ])
        ->limit(8)
        ->orderBy('n_of_orders', 'DESC')
        ->get();

        //===================================================>> Top Review
        $topReview       = Product::select('id','name','discount','image','unit_price', 'category_id', 'review_rate_id')
        ->with([
            'category',
        ])
        ->limit(8)
        ->orderBy('review_rate_id', 'DESC')
        ->get();


        //===================================================>> Recent Order Product
        $recentOrderedProducts = [];
        $token = JWTAuth::getToken();
        $customer = []; 
        if($token){

            $user                       = JWTAuth::parseToken()->authenticate();
            if(isset($user->customer)){

                $customer = $user->customer; 
                //find user recommended products
                $recentOrderedProducts        = Product::select('id','name','discount','image','unit_price')
                ->whereHas('recomendations', function($query) use ($user){
                    $query->where('customer_id', $user->customer->id); 
                })
                ->limit(8)
                ->orderBy('id', 'DESC')
                ->get();
            }
            

        }



        return [
            'categories'                =>  $categories,
            'top_review_products'       =>  $topReview,
            'top_sale_sales'            =>  $topSale,
            'recent_order_products'     =>  $recentOrderedProducts,
            'brands'                    =>  $brands,   
            //'customer'                  => $customer            
        ];
    }

}