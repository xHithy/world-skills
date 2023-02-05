<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class GameController extends ApiController
{
    public static function index(): JsonResponse
    {
        request()->input('page') ? $page = request()->input('page'): $page = 0;
        request()->input('size') ? $size = request()->input('size'): $size = 10;
        request()->input('sortBy') ? $sortBy = request()->input('sortBy'): $sortBy = 'title';
        request()->input('sortDir') ? $sortDir = request()->input('sortDir'): $sortDir = 'asc';

        return response()->json([
            'page' => (int) $page,
            'size' => (int) $size
        ]);
    }
}
