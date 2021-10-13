<?php
namespace App\Http\myResponse;

class myResponse extends myResponses
{
    public function returnSuccess($message , $status){
        return response()->json([
            'success' => true,
            'message' => $message,
        ],$status);
    }

    public function returnError($message , $status){
        return response()->json([
            'success' => false,
            'message' => $message,
        ],$status);
    }

    public function returnData($message , $data , $status ){
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' =>  $data
        ],$status);
    }
}

