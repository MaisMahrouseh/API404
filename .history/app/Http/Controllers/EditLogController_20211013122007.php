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
    
}
