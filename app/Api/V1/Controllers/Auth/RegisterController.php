<?php

namespace App\Api\V1\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
use App\Api\V1\Controllers\ApiController;
use App\Model\User\Main as User;
use App\Model\User\Code;

use App\CamCyber\Bot\BotRegister;

//========================== Use Mail
use Illuminate\Support\Facades\Mail;
use App\Mail\Notification;
use App\Model\Admin\Customer as AdminCustomer;
use App\Model\Customer\Customer as UserCustomer;

class RegisterController extends ApiController
{

    public function register(Request $request) {
        
        $user = User::where(['phone' => $request->phone, 'type_id' => 2, 'is_phone_verified' => 0 ])->first(); 
 
        if($user){
            $notification = $this->getSMSCode($request->input('phone'), 'VERIFY');
            
            BotRegister::newRegister($user, 'Online', $notification['code']);

            return response()->json([
                'status'        => 'success',
                'message'       => 'Please verify your account.', 
                'data'          => $user, 
                'notification'  => $notification
    
            ], 200);   
        }
        $this->validate($request, [
         
            'name'      => 'required|max:60',
            'phone'     =>  [
                            'required',  
                             Rule::unique('user', 'phone')
                        ],
            'email'     =>   [
                            //'sometimes', 
                            'required', 
                            'email', 
                            'max:100', 
                            Rule::unique('user', 'email')
                        ],
            'password'  => 'required|min:6|max:60',
            'password_confirmation' => 'required|same:password',

        ], [

                'phone.unique'=>'Your phone is already use in the system', 
                'phone.regex'=>'Invalid phone number. Please use the right format.', 
                'phone.required'=>'Please input your phone number', 

                'email.required'=>'Please input your email', 
                'email.unique'=>'Your email is already use in the system',
                'password.required'=>'Please input you password',

                'password_confirmation.required' => 'please confirm your password',
                'password_confirmation.same:password'     => 'សូមបញ្ចូលពាក្យសម្ងាត់បញ្ជាក់របស់អ្នកឡើងវិញទៅពាក្យសម្ងាត់ថ្មីដដែល', 
            ]);

        //Check for valid ref
        //====================================>> Create New user
        $user = new User();
        $user->type_id      = 2; //For customer
      
        $user->name         = $request->input('name');
        $user->phone        = $request->input('phone');
        $user->email        = $request->input('email');
        $user->is_active    = 0;
        $user->password     = bcrypt($request->input('password'));

        $user->save();

        $customer[] = [
            'user_id'      => $user->id,
        ];

        UserCustomer::insert($customer);

        $notification = $this->getSMSCode($request->input('phone'), 'VERIFY');
        //====================================>> Send Email Verify Code
        //$notification = $this->getEmailCode($request->input('email'));
        
        BotRegister::newRegister($user, 'Online', $notification['code']);
        return response()->json([
            'status'        => 'success',
            'message'       => 'Account successfully created.', 
            'data'          => $user, 
            'notification'  => $notification,

        ], 200);   
    }

    private function getSMSCode($phone, $purpose) {
        
        $user = User::where(['phone'=>$phone, 'type_id'=>2, 'deleted_at'=>null])->first(); 
       
        if($user){
            $code = new Code; 
            $code->user_id = $user->id; 
            $code->code = rand(100000, 999999);
            $code->type = $purpose;
            $code->is_verified = 0; 
            $code->save(); 

            $notification = [
                'name'      => $user->name,
                'code'      => $code->code,
            ];

            return $notification;
        }   

    }
    
    public function verifyAccount(Request $request) {
        
        
        $this->validate($request, [
            'username'  => 'required',
            'code'      => 'required|min:6',
        ]);
        
        $code = $request->post('code'); 

        $data = Code::where(['code'=>$code, 'type'=>'VERIFY'])->orderBy('id', 'DESC')->first(); 
        $totalMinutesDifferent = 0;
        if($data){
            //Check if expired
            $created_at = Carbon::parse($data->created_at);
            $now = Carbon::now(env('APP_TIMEZONE')); 
            $totalMinutesDifferent = $now->diffInMinutes($created_at);

            // if($totalMinutesDifferent < 30){
                $user = User::findOrFail($data->user_id);
                if($user){
                    
                    //Updated Code
                    $code = Code::find($data->id); 
                    if($code->is_verified == 0){

                        $code->is_verified = 1; 
                        $code->verified_at = now(); 

                        $code->save(); 

                        $user->is_active = 1;

                        if(filter_var($request->post('username'), FILTER_VALIDATE_EMAIL)){
                           
                            if($user->email){
                                $user->is_email_verified = 1; 
                                $user->email_verified_at = now();
                            }
                        } else{
                            if($user->phone){    
                                $user->is_phone_verified = 1; 
                                $user->phone_verified_at = now();
                            }
                        }
                        $user->save();
                        //Crate token
                        $token = JWTAuth::fromUser($user);

                        //$botRes = BotRegister::registerVerify($user, $request->post('code')); 

                        return response()->json([
                            'status'=> 'success',
                            'message' => 'Account successfully verified.',
                            'token'=> $token,
                            'user' => $user,
                            //'botRes' => $botRes
                        ], 200);
                    }else{
                         return response()->json([
                            'status'=> 'fail',
                            'message'=> 'Security Code has already verified.' 
                        ], 422);
                    }
                        


                }else{
                     return response()->json([
                        'status'=> 'fail',
                        'message'=> 'Invalid Account. Please try again' 
                    ], 422);
                }
      
                
        }else{
            return response()->json([
                'status'=> 'fail',
                'message'=> 'Incorrect security code.', 
                'slug'=> 'code-not-valid' 
            ], 422);
        }
    }

    public function requestverifyCode(Request $request){
        $user = User::where('phone',$request->username)->orWhere('email', $request->username)->first();
        if($user){

            if(filter_var($request->post('username'), FILTER_VALIDATE_EMAIL)){
                $notification = $this->getEmailCode($request->input('username'));  
                return response()->json([
                    'status'        => 'success',
                    'message'       => 'Security code successfully sent.', 
                    'notification'  => $notification,
                ], 200);     
              
            } else{
               $notification = $this->getSMSCode($request->input('username'), $request->purpose);
               return response()->json([
                'status'        => 'success',
                'message'       => ' Resend Security Code successful.', 
                'notification'  => $notification,
            ], 200);   
            }
        }else{
            return response()->json([
                'status'=> 'fail',
                'message'=> 'Invalid Account' 
            ], 404);
        }
    }

}
