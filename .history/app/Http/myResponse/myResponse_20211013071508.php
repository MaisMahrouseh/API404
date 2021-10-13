<?php
namespace App\Http\myResponse;

class myResponse extends myResponse
{
    public function returnSuccess($message , $stats){
        return response()->json([
            'success' => 'true',
            'message' => '$message',
        ],200);
    }
}

