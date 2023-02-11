<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Game;
use App\Models\Score;
use App\Models\User;
use App\Models\Version;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class AdminController extends Controller
{
    public static function login(Request $request): Redirector|Application|RedirectResponse
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        $username = $request->input('username');
        $password = $request->input('password');
        if(Admin::where('username', $username)->where('password', $password)->exists()) {
            session(['admin-session' => true ]);
            return redirect(route('panel'));
        }
        return redirect(route('login'));
    }

    public static function logout(): Redirector|Application|RedirectResponse
    {
        request()->session()->forget('admin-session');
        return redirect('login');
    }

    public static function loginScreen(): Factory|View|Application
    {
        return view('admin.login');
    }

    public static function panel(): Factory|View|Application
    {
        $admins = Admin::get();
        return view('admin.panel', [
            'admins' => $admins
        ]);
    }

    public static function users(): Factory|View|Application
    {
        $users = User::with('blocked')->get();
        return view('admin.users', [
           'users' => $users
        ]);
    }

    public static function games(): Factory|View|Application
    {
        $games = Game::with('score')->with('versions')->with('author')->get();
        return view('admin.games', [
            'games' => $games
        ]);
    }

    public static function scores($slug): Factory|View|Application
    {
        $game = Game::where('slug', $slug)->first();
        $scores = Score::where('game_id', $game['id'])->with('player')->get();
        return view('admin.scores', [
            'users' => User::get(),
            'game' => $game,
            'scores' => $scores
        ]);
    }

    public static function versions($slug): Factory|View|Application
    {
        $game = Game::where('slug', $slug)->first();
        $versions = Version::where('game_id', $game['id'])->get();
        return view('admin.versions', [
            'game' => $game,
            'versions' => $versions
        ]);
    }

    public static function searchGames(): Factory|View|Application
    {
        $keyword = request()->input('keyword');
        $games = Game::where('title', 'like', '%'.$keyword.'%')->with('score')->with('versions')->with('author')->get();
        return view('admin.games', [
            'games' => $games
        ]);
    }
}
