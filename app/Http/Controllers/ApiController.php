<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    public static function failResponseWithMessages($messages): JsonResponse
    {
        return response()->json([
            'status' => 'invalid',
            'message' => 'Request body is not valid',
            'violations' => $messages
        ], 400);
    }

    public static function createTokenWithResponse(): JsonResponse
    {
        $token = Token::create([
            'token' => Str::random(60),
            'expiring_at' => now()->addHour()->toIso8601ZuluString('millisecond')
        ]);

        return response()->json([
            'status' => 'success',
            'token' => $token['token']
        ], 201);
    }

    public static function invalidCredentialsResponse(): JsonResponse
    {
        return response()->json([
            'status' => 'invalid',
            'message' => 'Wrong username or password'
        ], 401);
    }

    public static function emptySuccessResponse(): JsonResponse
    {
        return response()->json([
            'status' => 'success'
        ]);
    }
}
