<?php

namespace App\Http\Middleware\Task;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskMiddleware
{
    /**
     * Summary of handle
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @throws \Exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth('api')->user()->rule!='admin'){
           throw new \Exception('You are not authorized to access this resource');
        }
        return $next($request);
    }
}
