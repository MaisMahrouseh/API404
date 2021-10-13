<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        
         if ($user->Permittivity  == 'Admin'){
          return $next($request);
         }

         return response()->json([
            'success' => false,
            'error' => 'you are not admin!'
        ], 401);
    }
}
