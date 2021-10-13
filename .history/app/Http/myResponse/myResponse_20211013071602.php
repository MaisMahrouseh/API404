<?php
namespace App\Http\myResponse;

class myResponse extends myResponse
{
    public function returnSuccess($message , $status){
        return response()->json([
            'success' => true
            'message' => $message,
        ],$status);
    }

    public function returnError($message , $status){
        return response()->json([
            'success' => 'true',
            'message' => $message,
        ],$status);
    }
}

