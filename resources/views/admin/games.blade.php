@extends('layouts/admin-layout')

@section('content')
    <main class="game-list">
        <form class="search-container" method="POST" action="/XX_module_c/admin/games/">
            @csrf
            <input name="keyword" placeholder="Search game by title">
            <button>Search</button>
        </form>
        @if(count($games) == 0)
            <div class="single-game">
                <span><b>No results found</b></span>
                <a href="/XX_module_c/admin/games">Show all games</a>
            </div>
        @endif
        @foreach($games as $game)
            <div class="single-game">
                <a class="single-game" href="/XX_module_c/game/{{$game['slug']}}">
                    <span>
                        <b>Title</b>
                        {{ $game['title'] }}
                    </span>
                    <span>
                        <b>Description</b>
                        {{ $game['description'] }}
                    </span>
                    <span>
                        <b>Thumbnail</b>
                        @if($game['latest'])
                            @if($game['latest']['thumbnail'])
                                <img src="/storage/{{$game['latest']['thumbnail']}}" alt="">
                            @else
                                No thumbnail
                            @endif
                        @else
                            No thumbnail
                        @endif
                    </span>
                    <span>
                        <b>Author</b>
                        {{ $game['author']['username'] }}
                    </span>
                </a>
                <div class="buttons">
                    <form method="POST" action="/api/v1/admin/delete/{{$game['slug']}}">
                        @if($game['status'] == "deleted")
                            <button type="submit" disabled>Game deleted</button>
                        @else
                            <button type="submit">Delete game</button>
                        @endif
                    </form>
                    <form method="GET" action="/XX_module_c/admin/scores/{{$game['slug']}}">
                        <button type="submit">Show scores</button>
                    </form>
                    <form method="GET" action="/XX_module_c/admin/versions/{{$game['slug']}}">
                        <button type="submit">Versions</button>
                    </form>
                </div>
            </div>
        @endforeach
    </main>
@endsection
