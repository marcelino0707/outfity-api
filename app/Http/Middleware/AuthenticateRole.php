<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;


class AuthenticateRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            
            if ($user && in_array($user->role, $roles)) {
                return $next($request);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Unauthorize'], 401);
        }

        return response()->json(['error' => 'Do not have permission'], 403);
    }
}
