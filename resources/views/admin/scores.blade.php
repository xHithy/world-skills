@extends('layouts/admin-layout')
@section('content')
    <main class="score-list">
        <h2>Scores for {{ $game['title'] }}</h2>
        <div class="delete-score">
            <span>
                <h2>Delete all scores for user</h2>
                <br>
                <form method="POST" action="/api/v1/admin/delete/user-score/{{$game['slug']}}">
                    <select name="user">
                        @foreach($users as $user)
                            <option>{{ $user['username'] }}</option>
                        @endforeach
                    </select>
                    <button type="submit">Delete score</button>
                </form>
            </span>
        </div>
        @foreach($scores as $score)
            <div class="single-score">
                <span>
                    <b>Player</b>
                    {{ $score['player']['username'] }}
                </span>
                <span>
                    <b>Score</b>
                    {{ $score['score'] }}
                </span>
                <span>
                    <b>Version</b>
                    {{ $score['version'] }}
                </span>
                <span>
                    <form method="POST" action="/api/v1/admin/score/delete/{{$score['id']}}/{{$game['slug']}}">
                        <button type="submit">Delete score</button>
                    </form>
                </span>
            </div>
        @endforeach
    </main>
@endsection
