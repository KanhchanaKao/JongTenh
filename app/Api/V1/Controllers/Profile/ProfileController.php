<?php

namespace App\Api\V1\Controllers\Profile;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\CamCyber\FileUpload;
use App\Api\V1\Controllers\ApiController;
use App\Model\User\Main;
use Carbon\Carbon;
use Dingo\Api\Routing\Helpers;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProfileController extends ApiController
{
    use Helpers;
    function get(){
        $auth = JWTAuth::parseToken()->authenticate();
        $admin = Main::select('id', 'name', 'phone', 'email', 'avatar')->where('id', $auth->id)->first();
        return response()->json($admin, 200);
    }
    
    function put(Request $request){

         $user_id = JWTAuth::parseToken()->authenticate()->id;

        $this->validate($request, [
            'name' => 'required|max:60',
            'phone' =>  [
                            'required', 
                            'regex:/(^[0][0-9].{7}$)|(^[0][0-9].{8}$)/', 
                            Rule::unique('user')->ignore($user_id)
                        ],
        ]);

       

        //========================================================>>>> Start to update user
        $user = Main::findOrFail($user_id);
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        // $user->telegram_chat_id = $request->input('telegram_id');
        $user->updated_at = now();
        $date_today = Carbon::today()->format('d').'-'.Carbon::today()->format('M').'-'.Carbon::today()->format('Y');    
        if($request->avatar){
            // return $request->avatar;
            $image     = FileUpload::uploadFileV2( $request->avatar, 'user/'.$date_today , '');
            if($image['url']){
                $user->avatar = $image['url'];
            }
        }
        $user->save();



        return response()->json([
            'status' => 'success',
            'message' => 'The edit was successful!', 
            'data' => $user
        ], 200);

    }
  
    function changePassword(Request $request){
        $old_password = $request->input('old_password');
        $user_id = JWTAuth::parseToken()->authenticate()->id;
        //dd($user_id);
       $current_password = Main::find($user_id)->password;
        

       if (password_verify($old_password, $current_password)){ 
            
            $this->validate($request, [
                            'old_password'         => 'required|min:6|max:18',
                            'confirm_password' => 'required|same:password',
            ]);

            $id=0;
            //========================================================>>>> Start to update user
            $user = Main::findOrFail($user_id);
            $user->password = bcrypt($request->input('password'));
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'The edit was successful!'
            ], 200);
        }else{
         return response()->json([
                'status' => 'error',
                'message' => 'Your old password is not valid. Please add another'
            ], 200);   
        }
        

    }

}
