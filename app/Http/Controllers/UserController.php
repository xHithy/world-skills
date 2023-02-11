<?php

namespace App\Http\Controllers;

use App\Models\Blocked;
use App\Models\Game;
use App\Models\Score;
use App\Models\Token;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
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
        // Get games that are not deleted by an admin
        $games = Game::where('author_id', $user['id'])->where('status', 'active')->with('latest')->get();

        $authored_games = [];
        foreach($games as $game) {
            $authored_games[] = [
                'slug' => $game['slug'],
                'title' => $game['title'],
                'description' => $game['description']
            ];
        }

        $games = Game::where('status', 'active')->get();
        $highscores = [];
        foreach($games as $game)
        {
            if($highscore = Score::where('user_id', $user['id'])->where('game_id', $game['id'])->orderBy('score', 'desc')->first()) {
                $highscores[] = [
                    'game' => [
                        'slug' => $game['slug'],
                        'title' => $game['title'],
                        'description' => $game['description']
                    ],
                    'score' => (int)$highscore['score'],
                    'timestamp' => $highscore['timestamp']
                ];
            }
        }

        return response()->json([
            'username' => $user['username'],
            'registeredTimestamp' => $user['registered_at'],
            'authoredGames' => $authored_games,
            'highscores' => $highscores
        ]);
    }

    public static function blockUser($username): Redirector|Application|RedirectResponse
    {
        User::where('username', $username)->update(['status' => 'blocked',]);
        $user = User::where('username', $username)->first();

        // Delete previous block if exists
        Blocked::where('user_id', $user['id'])->delete();

        Blocked::create([
            'user_id' => $user['id'],
            'reason' => request()->input('reason')
        ]);

        return redirect(route('users'));
    }

    public static function unblockUser($username): Redirector|Application|RedirectResponse
    {
        User::where('username', $username)->update(['status' => 'active']);
        $user = User::where('username', $username)->first();
        Blocked::where('user_id', $user['id'])->delete();
        return redirect(route('users'));
    }

    public static function profile($username): Application|Factory|View
    {
        if($user = User::where('username', $username)->where('status', 'active')->first())
        {
            return view('profile', [
                'user' => $user
            ]);
        } else abort(404);
    }
}
