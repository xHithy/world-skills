<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;

class AdminController extends Controller
{
    public static function authAdmin(): bool
    {
        $logged_in = session('admin-session');
        if($logged_in) {
            return true;
        } else {
            return false;
        }
    }

    public static function panel(): Factory|View|Application
    {
        if(!self::authAdmin()) return view('admin.login');
        return view('admin.panel');
    }

    public static function login(Request $request): Factory|View|Application
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        return view('admin.panel');
    }
}
