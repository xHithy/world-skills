@extends('layouts/admin-layout')

@section('content')
    <main class="admin-list">
        @foreach($admins as $admin)
            <div class="single-admin">
                <span>
                    <b>Username</b>
                    {{ $admin['username'] }}
                </span>
                <span>
                    <b>Registered at</b>
                    {{ $admin['registered_at'] }}
                </span>
                <span>
                    <b>Last login</b>
                    {{ $admin['last_login'] }}
                </span>
            </div>
        @endforeach
    </main>
@endsection
