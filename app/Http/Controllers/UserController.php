<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiController
{
    public static function register(): JsonResponse
    {
        $validate = Validator::make(request()->all(), [
            'username' => 'required|unique:users|min:4|max:60',
            'password' => 'required|min:8|max:65536'
        ]);

        if($validate->fails()) return self::failResponseWithMessages($validate->messages());

        $user = User::create([
            'username' => request()->input('username'),
            'password' => request()->input('password'),
            'registered_at' => now()->toIso8601ZuluString('millisecond'),
            'last_login' => now()->toIso8601ZuluString('millisecond')
        ]);

        return self::createTokenWithResponse($user['id']);
    }


    public static function login(): JsonResponse
    {
        $validate = Validator::make(request()->all(), [
            'username' => 'required|min:4|max:60',
            'password' => 'required|min:8|max:65536'
        ]);
        if($validate->fails()) return self::failResponseWithMessages($validate->messages());
        if($user = User::where(['username' => request()->input('username'), 'password' => request()->input('password')])->first()) {
            return self::createTokenWithResponse($user['id']);
        } else {
            return self::invalidCredentialsResponse();
        }
    }


    public static function logout(): JsonResponse
    {
        // Request should always have a token, because it's validated in VerifyToken middleware
        Token::where('token', request()->bearerToken())->delete();
        return self::emptySuccessResponse();
    }

    public static function showUser($username): JsonResponse
    {
        $user = User::where('username', $username)->first();
        return response()->json([
            'username' => $user['username'],
            'registeredTimestamp' => $user['registered_at'],
            'authoredGames' => [],
            'highscores' => []
        ]);
    }
}
