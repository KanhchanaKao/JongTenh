<?php

namespace App\Api\V1\Controllers\CP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Dingo\Api\Routing\Helpers;

use App\Api\V1\Controllers\ApiController;
use App\Model\Stock\Stock;
use App\Model\Supplier\Supplier;

class SupplierController extends ApiController{
    
    use Helpers;

    function listing(){

        $data       = Supplier::select('*')
        ->with([
            'products',
        ])
        ->limit(100)
        ->orderBy('id', 'DESC')
        ->get();
        return $data;
    }

    function create(Request $req){
        
        $this->validate($req,[
            'name'              => 'required|max:20',
            'phone'             => [
                                    'required', 
                                    'regex:/(^[0][0-9].{7}$)|(^[0][0-9].{8}$)/', 
                                    Rule::unique('user', 'phone')]
        ],
        [
            'name.required'     => 'Please enter the name.',
            'phone.required'    => 'Please enter phone number'
        ]);

        $supplier                = New Supplier;
        $supplier->name          = $req->name;
        $supplier->phone         = $req->phone;
        
        $supplier ->save();

        return response()->json([
            'product'    => $supplier,
            'message'    => 'Supplier has been successfully created.'
        ], 200);
    }

    function update(Request $req, $id = 0){

        $this->validate($req,[
            'name'           => 'required|max:20'
        ],
        [
            'name.required'  => 'Please enter product name.',
            'name.max'       => 'Name cannot be more than 20 characters.',
        ]);

        $supplier             = Supplier::find($id);
        
        if($supplier){
            $supplier->name              =$req->input('name');

            $supplier->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Supplier has been updated Successfully',
                'product' => $supplier,
            ], 200);
        }else{
            return response()->json([
                'message' => 'Invalid data.',
            ], 400);
        }

    }

  

    function delete($id = 0 ){
        $data = Supplier::find($id);

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
}