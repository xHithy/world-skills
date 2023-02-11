<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Admin panel</title>
</head>
<body>
    <nav>
        <h1>Admin Panel</h1>
        <div>
            <a href="/XX_module_c/admin/panel">Admins</a>
            <a href="/XX_module_c/admin/users">Users</a>
            <a href="/XX_module_c/admin/games">Games</a>
        </div>
    </nav>
    @yield('content')
</body>
</html>
