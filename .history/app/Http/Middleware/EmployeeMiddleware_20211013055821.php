<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EmployeeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if ($user->Permittivity  == 'Employee'){
         return $next($request);
        }
        return response()->json([
            'success' => false,
            'error' => 'you are not employee'
        ], 401);
    }
}
