<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminRegister
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         $user=auth('api')->user();
        if( !$user||$user->rule!=='admin'){
            return response()->json([
            'message'=>'You are not an admin Sorry!'
        ],401);
        }

         return $next($request);
    }
}
