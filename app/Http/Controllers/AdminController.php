<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

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
}
