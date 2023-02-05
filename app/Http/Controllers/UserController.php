<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends ApiController
{
    public static function register(): JsonResponse
    {
        $validate = Validator::make(request()->all(), [
            'username' => 'required|unique:users|min:4|max:60',
            'password' => 'required|min:8|max:65536'
        ]);

        if($validate->fails()) return self::failResponseWithMessages($validate->messages());

        User::create([
            'username' => request()->input('username'),
            'password' => request()->input('password'),
            'registered_at' => now()->toIso8601ZuluString('millisecond'),
            'last_login' => now()->toIso8601ZuluString('millisecond')
        ]);

        return self::createTokenWithResponse();
    }


    public static function login(): JsonResponse
    {
        $validate = Validator::make(request()->all(), [
            'username' => 'required|min:4|max:60',
            'password' => 'required|min:8|max:65536'
        ]);

        if($validate->fails()) return self::failResponseWithMessages($validate->messages());

        if(User::where(['username' => request()->input('username'), 'password' => request()->input('password')])->exists()) {
            return self::createTokenWithResponse();
        } else {
            return self::invalidCredentialsResponse();
        }
    }


    public static function logout(): JsonResponse
    {
        Token::where('token', cookie('token'))->delete();
        return self::emptySuccessResponse();
    }

}
