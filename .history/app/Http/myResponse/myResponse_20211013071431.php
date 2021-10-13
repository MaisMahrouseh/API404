<?php
namespace App\Http\myResponse;

class myResponse extends myResponse
{
    public function returnSuccess(){
        return response()->json([
            'success' => 'true',
            'message' => 'All Users',
            'data' => $users
        ],200);
    }
}

