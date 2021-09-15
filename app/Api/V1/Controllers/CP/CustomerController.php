<?php

namespace App\Api\V1\Controllers\CP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Dingo\Api\Routing\Helpers;

use App\Api\V1\Controllers\ApiController;
use App\Model\User\Main;

class CustomerController extends ApiController{
    
    use Helpers;

    function listing(){

        $data       = Main::select('id','name','type_id','email','phone','created_at')
        ->where('type_id',2)
        ->whereHas('customer')
        ->with(['customer'])
        ->limit(100)
        ->orderBy('id', 'DESC')
        ->get();
        return $data;
    }
    function changePassword(Request $req, $id = 0){

        //==============================>> Check validation
        $this->validate($req, [
            
            'password'             => 'required|min:6|max:20',
            'confirmed_password'   => 'required|min:6|max:20'
        ]);

        //==============================>> Start Adding data

        $user = Main::find($id); 
        if($user){
            return $user;
            $user->password                 = bcrypt($req->password); 
            $user->password_last_updated_at = now(); 
            $user->save(); 

            return response()->json([
                'message' => 'Password has been updated.'
            ], 200);

        }else{
            return response()->json([
                'message' => 'Invalid user.'
            ], 400);
        }
        
    }
}