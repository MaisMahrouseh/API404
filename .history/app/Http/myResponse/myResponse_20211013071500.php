<?php
namespace App\Http\myResponse;

class myResponse extends myResponse
{
    public function returnSuccess($message , ){
        return response()->json([
            'success' => 'true',
            'message' => '$message',
        ],200);
    }
}

