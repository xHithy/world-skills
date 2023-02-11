@extends('layouts/admin-layout')

@section('content')
    <main class="user-list">
        @foreach($users as $user)
            <div class="single-user">
                <a href="/XX_module_c/user/{{$user['username']}}">
                    <span>
                        <b>Username</b>
                        {{ $user['username'] }}
                    </span>
                    <span>
                        <b>Registered at</b>
                        {{ $user['registered_at'] }}
                    </span>
                    <span>
                        <b>Last login</b>
                        {{ $user['registered_at'] }}
                    </span>
                </a>
                <span>
                    <form method="POST" @if($user['status'] == 'blocked') action="/api/v1/admin/unblock/{{$user['username']}}" @else action="/api/v1/admin/block/{{$user['username']}}" @endif>
                        <select name="reason" @if($user['status'] == 'blocked') disabled @endif>
                            @if($user['blocked']) <option selected>{{$user['blocked']['reason']}}</option> @endif
                            <option>You have been blocked by an administrator</option>
                            <option>You have been blocked for spamming</option>
                            <option>You have been blocked for cheating</option>
                        </select>
                        <button>@if($user['status']== 'blocked') Unblock @else Block @endif</button>
                    </form>
                </span>
            </div>
        @endforeach
    </main>
@endsection
