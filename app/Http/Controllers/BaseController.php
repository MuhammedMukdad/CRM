<?php

namespace App\Http\Controllers;

class BaseController
{
    public function sendResponse($result, $message,$code=200){ // fun sends theResponse to user with result and massage
       $response = [


        'status' => true,
        'data' => $result, //the date that comes from the database is stored  in result variable
        'message' =>$message,
        'code'=>$code
        //succes is Key and true is  value
       ] ;


       return response()->json( $response, $code); // 200 is http protocol // send data to user as json

    }

    public function sendError($errorMessage=[], $code = 404){
        $response = [
         'status' => false,
         'message' =>$errorMessage,
         'code'=>$code
        ];
        return response()->json($response, $code);
}
}
