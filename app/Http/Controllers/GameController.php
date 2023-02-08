<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\JsonResponse;

class GameController extends ApiController
{
    public static function index(): JsonResponse
    {
        $sortBy = 'title';
        request()->input('page') ? $page = request()->input('page') : $page = 0;
        request()->input('size') ? $size = request()->input('size') : $size = 10;
        request()->input('sortDir') ? $sortDir = request()->input('sortDir'): $sortDir = 'asc';

        // Switch the request inputs to actual database columns, so sorting is possible
        if(request()->input('sortBy') == 'uploaddate') $sortBy = 'version.timestamp';
        if(request()->input('sortBy') == 'popular') $sortBy = 'score_count';

        $games = Game::where('status', 'active')
            ->withCount('score')
            ->with('author')
            ->with('latest')
            ->orderBy($sortBy, $sortDir)
            ->paginate($size);

        $content = [];
        foreach($games as $game) {
            $content[] = [
                'slug' => $game['slug'],
                'title' => $game['title'],
                'description' => $game['description'],
                'thumbnail' => $game['latest']['thumbnail'],
                'uploadTimestamp' => $game['latest']['timestamp'],
                'author' => $game['author']['username'],
                'scoreCount' => $game['score_count']
            ];
        }

        return response()->json([
            'page' => (int) $page,
            'size' => (int) $size,
            'totalElements' => Game::count(),
            'content' => $content
        ]);
    }
}
