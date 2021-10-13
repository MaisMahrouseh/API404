<?php
namespace App\Http\myResponse;

class myResponse extends myResponse
{
    public function returnSuccess($messa){
        return response()->json([
            'success' => 'true',
            'message' => 'All Users',
        ],200);
    }
}

