<?php

namespace App\CamCyber;


use Illuminate\Http\Request;
use Image;

class FileUpload{
    
    public static function image(Request $request, $imageName ="", $folders = array(), $sizes = array()){
        if($request->hasFile($imageName)) {
            $image = $request->file($imageName);
            $extension = $image->getClientOriginalExtension(); 
            
         
            $directories = "";
            for($i=0; $i< sizeof($folders); $i++){
                $directories .= $folders[$i];
            }
            if(!file_exists(public_path($directories))){
                mkdir(public_path($directories) , 0777, true);
            }

            $uploadedImage = array();
            foreach($sizes as $size){
                $myImage = '/'.$size[1].'x'.$size[2].'.'.$extension;
                Image::make($image->getRealPath())->resize($size[1], $size[2])->save(public_path($directories).$myImage);
                $uploadedImage[$size[0]] = 'public/'.$directories.$myImage;
            }

            return json_encode($uploadedImage);


        }else{
            return "";
        }
    }

    public static function fileUpload(Request $request, $fileName ="", $folders = array()){
        if($request->hasFile($fileName)) {
            $file = $request->file($fileName);
            //dd($file);
            $extension = $file->getClientOriginalExtension(); 
            
         
            $directories = "";
            for($i=0; $i< sizeof($folders); $i++){
                $directories .= $folders[$i];
            }

            if(!file_exists(public_path($directories))){
                mkdir(public_path($directories) , 0777, true);
            }
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $path = $file->move(public_path($directories), $fileName);
            return 'public/'.$directories.'/'.$fileName;

        }else{
            return "";
        }
    }

    public static function uploadImage(Request $request, $imageName ="", $folders = array(), $sizes = array()){
        if($request->hasFile($imageName)) {
            $image = $request->file($imageName);
            $extension = $image->getClientOriginalExtension(); 
            
         
            $directories = "";
            for($i=0; $i< sizeof($folders); $i++){
                $directories .= $folders[$i];
            }
            if(!file_exists(public_path($directories))){
                mkdir(public_path($directories) , 0777, true);
            }


            $uploadedImage = array();
            foreach($sizes as $size){
                $myImage = '/'.$size[1].'x'.$size[2].'.'.$extension;
                Image::make($image->getRealPath())->resize($size[1], $size[2])->save(public_path($directories).$myImage);
                $uploadedImage[$size[0]] = 'public/'.$directories.$myImage;
            }

            // return json_encode($uploadedImage);
            return 'public/'.$directories.$myImage;

        }else{
            return "";
        }
    }
   
    public static function resize(Request $request, $imageName ="", $folders = array(), $sizes = array()){
       
        if($request->hasFile($imageName)) {
            $image = $request->file($imageName);
            $extension = $image->getClientOriginalExtension(); 
            
         
            $directories = "";
            for($i=0; $i< sizeof($folders); $i++){
                $directories .= $folders[$i];
            }
            if(!file_exists(public_path($directories))){
                mkdir(public_path($directories) , 0777, true);
            }


            $uploadedImage = array();
            foreach($sizes as $size){
                $myImage = '/'.$size[1].'x'.$size[2].'.'.$extension;
                Image::make($image->getRealPath())->resize($size[1], $size[2],
                function($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path($directories).$myImage);
                $uploadedImage[$size[0]] = 'public/'.$directories.$myImage;
            }

            // return json_encode($uploadedImage);
            return 'public/'.$directories.$myImage;

        }else{
            return "";
        }
    }

    public static function uploadFileV2($file, $folder, $resize){

        $data = [
                    'project'               => 'JongTinh',
                    'file'                  => $file,
                    'folder'                => $folder,
                    'resize'                => $resize,
                    'is_return_full_url'    => 0
        ];

        $curl = curl_init();

       curl_setopt_array($curl, array(
        CURLOPT_URL => env('FILE_URL')."/api/attach/image",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_FAILONERROR => true,
        CURLOPT_HTTPHEADER => array(
            "Authorization: Basic ZmlsZXVzZXI6RiFMRVdRMTI="
        ),
        ));

        if (curl_errno($curl)) {
            return   ['url' => ''];
            //$error_msg = curl_error($curl);
        }
        $response = curl_exec($curl);
      
        curl_close($curl);
        return   json_decode( $response, true );

    }
  
}
