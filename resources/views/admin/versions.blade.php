@extends('layouts/admin-layout')
@section('content')
    <main class="version-list">
        <h2>Version list for {{ $game['title'] }}</h2>
        @foreach($versions as $version)
            <div class="single-version">
                <span>
                    <b>Version</b>
                    {{ $version['version'] }}
                </span>
                <span>
                    <b>Created at</b>
                    {{ $version['timestamp'] }}
                </span>
            </div>
        @endforeach
    </main>
@endsection
