<?php

namespace App\Http\Middleware;

use App\Models\Token;
use Closure;
use Illuminate\Http\Request;

class VerifyToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        // Token doesn't exist
        if(!$token) {
            return response()->json([
                'status' => 'unauthenticated',
                'message' => 'Missing token'
            ], 401);
        }

        // Token invalid
        if(!Token::where('token', $token)->exists()){
            return response()->json([
                'status' => 'unauthenticated',
                'message' => 'Invalid token'
            ], 401);
        }

        // Token valid - check if user is blocked
        if($reason = Token::where('token', $token)->has('blocked')->first()){
            return response()->json([
                'status' => 'blocked',
                'message' => 'User blocked',
                'reason' => $reason["blocked"]['reason']
            ]);
        }

        return $next($request);
    }
}
