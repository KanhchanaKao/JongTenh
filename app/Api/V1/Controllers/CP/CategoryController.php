<?php 

namespace App\Api\V1\Controllers\CP;

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
        ->withCount(['products'])
        ->orderBy('id', 'DESC')
        ->get();
        return $data;
    }

    function create(Request $req){

        $this->validate($req,[
            'name'             =>'required|max:20',
        ],
        [
        'name.required'        =>'Please enter the name.',
        'name.max'             =>'Total canot be more than 20 characters',
        ]);

        $product_category          = New Category;
        $product_category->name    = $req->name;

        $product_category ->save();

        return response()->json([
            'product_category'  =>$product_category,
            'message'           =>'Category has been successfully created.'
        ],200);
        
    }

    function createsubcategory(Request $req){

        $this->validate($req,[
            'name'             =>'required|max:20', 
        ],
        [
        'name.required'        =>'Please enter the name.',
        'name.max'             =>'Total canot be more than 20 characters',
        ]);

        $subcategory                 = New Category;
        $subcategory->name           = $req->name;
        $subcategory->parent_id      = $req->parent_id;

        $subcategory ->save();

        return response()->json([
            'product_category'  =>$subcategory,
            'message'           =>'Category has been successfully created.'
        ],200);
        
    }

    function update(Request $req, $id=0){

        $this->validate($req,[
            'name'           =>'required|max:20',
        ],[
            'name.required' => 'please Enter the name',
            'name.max'      => 'Name cannot be more than 20 characters.',
        ]);

        $product_category       =Category::find($id);
        if($product_category){
            $product_category->name       =$req->input('name');
            $product_category->save();

            return response()->json([
                'status'     =>'success',
                'message'    =>'Product has been succesfully updated',
                'product_category' => $product_category,
            ], 200);
        }else{
            return response()->json([
                'message' => 'Invalid data.',
            ],400);
        }
    }

    function delete($id = 0 ){
        $data   = Category::find($id);

        if ($data){
            $data-> delete();
            return response()->json([
                'status'=> 'success',
                'message'=> 'Data has been deleted',
            ], 200);
        }else{
            return response()->json([
                'message'=> 'Invalid data.'
            ],400);
        }
    }
}