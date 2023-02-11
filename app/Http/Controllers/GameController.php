<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Score;
use App\Models\User;
use App\Models\Version;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use ZipArchive;

class GameController extends ApiController
{
    public static function allGames(): JsonResponse
    {
        $sortBy = 'title';
        request()->input('page') ? $page = request()->input('page') : $page = 0;
        request()->input('size') ? $size = request()->input('size') : $size = 10;
        request()->input('sortDir') ? $sortDir = request()->input('sortDir'): $sortDir = 'asc';

        // Switch the request inputs to actual database columns, so sorting is possible
        if(request()->input('sortBy') == 'uploaddate') $sortBy = 'timestamp';
        if(request()->input('sortBy') == 'popular') $sortBy = 'score_count';

        $games = Game::where('status', 'active')->withCount('score')->with('author')->has('latest')->orderBy($sortBy, $sortDir)->paginate($size);

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

    public static function createGame(): JsonResponse
    {
        $validator = Validator::make(request()->all(), [
            'title' => 'required|min:3|max:60',
            'description' => 'required|min:0|max:200'
        ]);

        if($validator->fails()) return self::failResponseWithMessages($validator->messages());

        $title = request()->input('title');
        $slug = str_replace(' ', '-', $title);

        // Slug exists
        if(Game::where('slug', $slug)->exists()) {
            return response()->json([
                'status' => 'invalid',
                'slug' => 'Game title already exists'
            ], 400);
        }

        Game::create([
            'title' => $title,
            'description' => request()->input('description'),
            'thumbnail' => null,
            'slug' => strtolower($slug),
            'status' => 'active',
            'author_id' => self::fetchUserID()
        ]);

        return response()->json([
            'status' => 'success',
            'slug' => $slug
        ], 201);
    }

    public static function showGame($slug): JsonResponse
    {
        // Task didn't ask to verify the slugs existance in database!
        $game = Game::where('slug', $slug)->with('latest')->with('author')->withCount('score')->first();
        return response()->json([
            'slug' => $game['slug'],
            'title' => $game['title'],
            'description' => $game['description'],
            'thumbnail' => $game['thumbnail'],
            'uploadTimestamp' => $game['latest']['timestamp'],
            'author' => $game['author']['username'],
            'scoreCount' => $game['score_count'],
            'gamePath' => $game['latest']['path']
        ]);
    }

    public static function uploadGame($slug)
    {
        if(!self::verifyGameAuthor($slug)) return "User not author of game";
        $game = Game::where('slug', $slug)->first();
        $validator = Validator::make(request()->all(), ['zipfile' => 'required|file|mimes:zip']);
        if($validator->fails()) return 'File must be a ZIP file';

        $zip = new ZipArchive();
        $zip->open(request()->file('zipfile')->getRealPath());
        $indexFile = false;
        $thumbnail = null;
        for($i = 0; $i < $zip->count(); $i++) {
            $file = $zip->getNameIndex($i);
            $fileName = explode('/', $file);
            if($fileName[1] == 'index.html') $indexFile = true;
            if($fileName[1] == 'thumbnail.png') $thumbnail = true;
        }
        if(!$indexFile) return 'ZIP must contain index.html file';

        $file_name = $zip->statIndex(0)['name'];
        $game_path = storage_path('app/public/games/' . $slug . '/');
        if (!$zip->extractTo($game_path)) return "ZIP extraction has failed";
        $zip->close();
        $version = 1;
        if($v = Game::where('slug', $slug)->with('latest')->first()) $version = $v['latest']['version'] + 1;
        rename($game_path . $file_name, $game_path . $version . '/');

        if($thumbnail) $thumbnail = 'games/'.$slug.'/'.$version .'/thumbnail.png';

        Version::create([
            'game_id' => $game['id'],
            'version' => $version,
            'timestamp' => now()->toIso8601ZuluString('milliseconds'),
            'thumbnail' => $thumbnail,
            'path' => 'games/'.$slug.'/'.$version
        ]);
    }

    public static function serveGame($slug, $version): Application|RedirectResponse|Redirector|JsonResponse
    {
        // API links can match on these endpoints
        // api/v1/games/:slug/:version
        // api/v1/games/:slug/scores
        if($version == 'scores') return self::showScores($slug);

        // Redirects an iframe to the game directory so it can display the game
        return redirect('/storage/games/'.$slug.'/'.$version);
    }

    public static function updateGame($slug): JsonResponse
    {
        if(!self::verifyGameAuthor($slug)) return self::invalidGameAuthorResponse();

        $validator = Validator::make(request()->all(), [
            'title' => 'required|min:3|max:60',
            'description' => 'required|min:0|max:200'
        ]);

        if($validator->fails()) return self::failResponseWithMessages($validator->messages());

        Game::update([
            'title' => request()->input('title'),
            'description' => request()->input('description')
        ]);

        return self::emptySuccessResponse();
    }

    public static function removeGame($slug): JsonResponse
    {
        if(!self::verifyGameAuthor($slug)) return self::invalidGameAuthorResponse();
        $game = Game::where('slug', $slug)->first();
        self::deleteGameDirectory('storage/games/'.$slug.'/');
        Game::where('id', $game['id'])->delete();
        Version::where('game_id', $game['id'])->delete();
        Score::where('game_id', $game['id'])->delete();
        return response()->json([],204);
    }

    public static function deleteGameDirectory($dir)
    {
        // Removes the files under directory, so it can then delete the directory itself
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir") self::deleteGameDirectory($dir . "/" . $object); else unlink($dir."/".$object);
                }
            }
            rmdir($dir);
        }
    }

    public static function showScores($slug): JsonResponse
    {
        $game = Game::where('slug', $slug)->where('status', 'active')->first();
        // Check only for users that arent blocked
        $users = User::where('status', 'active')->get();
        $highscores = [];
        foreach($users as $user) {
            // If I use max() here, I can only get the max value, not other needed values such as username or timestamp
            if($score = Score::where('user_id', $user['id'])->where('game_id', $game['id'])->orderBy('score', 'desc')->first()) {
                $highscores[] = [
                    'username' => $user['username'],
                    'score' => $score['score'],
                    'timestamp' => $score['timestamp']
                ];
            }
        }
        return response()->json(['scores' => $highscores]);
    }

    // Admin function of deleting a game, files exist, but not visible to users
    public static function deleteGame($slug): Redirector|Application|RedirectResponse
    {
        Game::where('slug', $slug)->update([
            'status' => 'deleted'
        ]);
        return redirect(route('games'));
    }

    public static function resetHighscores($slug): Redirector|Application|RedirectResponse
    {
        $game = Game::where('slug', $slug)->first();
        Score::where('game_id', $game['id'])->delete();
        return redirect(route('games'));
    }

    public static function deleteScore($id, $slug): Redirector|Application|RedirectResponse
    {
        Score::where('id', $id)->delete();
        return redirect('XX_module_c/admin/scores/'.$slug);
    }

    public static function deleteUserScore($slug): Redirector|Application|RedirectResponse
    {
        $user = User::where('username', request()->input('user'))->first();
        $game = Game::where('slug', $slug)->first();
        Score::where('user_id', $user['id'])->where('game_id', $game['id'])->delete();
        return redirect('XX_module_c/admin/scores/'.$slug);
    }

    public static function page($slug): Factory|View|Application
    {
        $game = Game::where('slug', $slug)->where('status', 'active')->with('latest')->first();
        return view('game', [
            'game' => $game,
        ]);
    }
}
