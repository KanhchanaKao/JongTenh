<?php

namespace App\Api\V1\Controllers\Auth;

use Illuminate\Http\Request;
use App\Api\V1\Controllers\ApiController;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends ApiController
{

    public function login(Request $request) {


        $this->validate($request, [
            'username'    =>  [
                            'required',
                        ],
            'password' => 'required|min:6|max:20',

        ],[
            'username.required'=>'Username is required.',
            'password.required'=>'Password is required.',
            'password.min'=>'Password must be at least 6 digit long.',
            'password.max'=>'Password is not allowed to be longer than 20 digit long.',
        ]);

        if(filter_var($request->post('username'), FILTER_VALIDATE_EMAIL)){
            $credentails = array(
                'email'=>$request->post('username'),
                'password'=>$request->post('password'),
                // 'is_active'=>1,
                'deleted_at'=>null,
            );
        }else{

            $credentails = array(
                'phone'             =>  $request->post('username'),
                'password'          =>  $request->post('password'),
                // 'is_active'         =>  1,
                'deleted_at'        =>  null,
            );
        }

        try{

            $token = JWTAuth::attempt($credentails);

            if(!$token){

                return response()->json([
                    'status'=> 'error',
                    'message' => 'ឈ្មោះអ្នកប្រើឬពាក្យសម្ងាត់មិនត្រឹមត្រូវ។'
                ], 401);
            }

        } catch(JWTException $e){
            return response()->json([
                'status'=> 'error',
                'message' => 'មិនអាចបង្កើតនិមិត្តសញ្ញាទេ!'
            ], 500);
        }

       $user = JWTAuth::toUser($token);

       $dataUser = [
           'name' => $user->name,
           'avatar' => $user->avatar,
           'phone' => $user->phone,
           'type'=> $user->type->name
       ]; 
        return response()->json([
            'status'=> 'success',
            'token'=> $token,
            'user' => $dataUser
        ], 200);
    }
}
