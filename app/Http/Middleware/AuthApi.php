<?php

namespace App\Http\Middleware;

use App\Models\ApiToken;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class AuthApi
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');

        if (strpos($token, 'Bearer ') === 0) {
            $token = substr($token, 7);
        }
        $apiToken = ApiToken::where('token', $token)->first();

        if (!$apiToken || !$apiToken->user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
