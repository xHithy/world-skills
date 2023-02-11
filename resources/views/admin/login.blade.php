<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <title>Admin Login</title>
</head>
<body>
    <main class="login-container">
        <h1>Admin Login</h1>
        <form method="POST" action="/XX_module_c/admin">
            @csrf
            <input name="username" type="text" placeholder="Username"/>
            <input name="password" type="password" placeholder="Password"/>
            <button type="submit">Login</button>
        </form>
    </main>
</body>
</html>
