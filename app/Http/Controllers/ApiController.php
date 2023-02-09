<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Token;
use Illuminate\Http\JsonResponse;
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

    public static function createTokenWithResponse($user_id): JsonResponse
    {
        $token = Token::create([
            'user_id' => $user_id,
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
        return response()->json(['status' => 'success']);
    }

    public static function fetchUserID()
    {
        $token = Token::where('token', request()->bearerToken())->first();
        return $token['user_id'];
    }

    public static function verifyGameAuthor($slug): bool
    {
        // Get user id by token
        $user_id = self::fetchUserID();
        if(Game::where('slug', $slug)->where('author_id', $user_id)->exists()) return true;
        return false;
    }

    public static function invalidGameAuthorResponse(): JsonResponse
    {
        return response()->json([
            'status' => 'forbidden',
            'message' => 'You are not the game author'
        ], 403);
    }
}
