<?php

namespace App\Traits;
 
trait ResponseTrait {

    public function json_response($error_status =false ,$errors =null , $message="", $data=null,$status) {
         $arr =[
             'error_status' =>$error_status,
             'errors'=>$errors,
             'message'=>$message,
             'data'=>$data
         ];

         return response()->json($arr ,$status);
    }
}