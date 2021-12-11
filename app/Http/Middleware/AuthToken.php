<?php

namespace App\Http\Middleware;

use App\Helper\GeneralHelper;
use Closure;


class AuthToken
{
    public function handle($request, Closure $next)
    {
         if( ! GeneralHelper::validateToken($request))
             return response()->json([
                 'status' => 'false',
                 'message' => 'Invalid Token'
             ],401);

         return $next($request);
    }
}
