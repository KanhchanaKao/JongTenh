<?php 

namespace App\Api\V1\Controllers\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Dingo\Api\Routing\Helpers;
use Tymon\JWTAuth\JWTAuth;

use App\Api\V1\Controllers\ApiController;
use App\Model\Product\Category;

class CategoryController extends ApiController{

    use Helpers;

    function listing(){
        
        $data           = Category::select('*')
        ->with(['products'])
        ->orderBy('id', 'DESC')
        ->get();
        return $data;
    }
}