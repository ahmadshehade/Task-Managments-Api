<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminRegister
{
 /**
  * Undocumented function
  *
  * @param Request $request
  * @param Closure $next
  * @return Response
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
