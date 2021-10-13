<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrie;
use App\Http\Requests\EditLoginTimeRequest;
use App\Http\Requests\EditLogoutTimeRequest;
use App\Http\myResponse\myResponse;

class EditLogController extends Controller
{
    public $entrie;
    public $response;

    public function __construct(Entrie $entrie , myResponse $response){
        $this->entrie = $entrie;
        $this->response = $response;
    }

    
    public  function updateLogin(EditLogin $request ,$id)
    {
        $validated = $request->validated();
        $time =  Entrie::find($id);
        if (!$time) {
            return response()->json([
                'success' => false,
                'message' => 'user not found'
            ], 400);
        }
        $updated = $time->update($validated);
        if ($updated)
            return response()->json([
                'success' => true,
                'message' => 'Edited successfully'
            ],200);
        else
            return response()->json([
                'success' => false,
                'message' => 'user can not be updated'
            ], 500);
    }

    public  function updateLogout(EditLogout $request , $id)
    {
        $validated = $request->validated();
        $time =  Entrie::find($id);
        if (!$time) {
            return response()->json([
                'success' => false,
                'message' => 'user not found'
            ], 400);
        }
        $updated = $time->update($validated);
        if ($updated)
            return response()->json([
                'success' => true,
                'message' => 'Edited successfully'
            ],200);
        else
            return response()->json([
                'success' => false,
                'message' => 'user can not be updated'
            ], 500);
    }
}
