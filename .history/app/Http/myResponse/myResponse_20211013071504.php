<?php
namespace App\Http\myResponse;

class myResponse extends myResponse
{
    public function returnSuccess($message , $st){
        return response()->json([
            'success' => 'true',
            'message' => '$message',
        ],200);
    }
}

