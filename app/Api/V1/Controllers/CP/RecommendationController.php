<?php

namespace App\Api\V1\Controllers\CP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use DB; 

use Dingo\Api\Routing\Helpers;

use App\Api\V1\Controllers\ApiController;
use App\Model\Product\Product;
use App\Model\Review\Rate;

class RecommendationController extends ApiController{
    
    use Helpers;

    function rate(){

        $data       = Rate::select('id', 'name', 'color')
        ->with([
            'products:id,name,image,unit_price,category_id,review_rate_id',
            'products.category'
        ])
        ->withCount([
            'reviews as n_of_reviews', 
            'products as n_of_products'
        ])
        ->get();

        return $data;
    }

    function review(){

        $data       = Product::select('*')
        ->with([
            'category',
            'supplier', 
            'rate',
            'reviews', 
            'reviews.customer'
        ])
        ->withCount([
            'reviews as n_of_reviews'
            
        ])
        ->limit(100)
        ->orderBy('review_rate_id', 'DESC')
        ->get();
        return $data;
    }

    function sale(){

        $data       = Product::select('*')
        ->with([
            'category',
            'supplier', 
            'rate',
        ])
        ->withCount([
            'details as n_of_orders', 
            'details as total_order' => function($query) {
                $query->select(DB::raw("SUM(unit_price)"));
            }, 
            'reviews as n_of_reviews'
        ])
        ->limit(100)
        ->orderBy('n_of_orders', 'DESC')
        ->get();
        return $data;
    }

   
}