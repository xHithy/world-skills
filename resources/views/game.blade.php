<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <title>Game</title>
</head>
<body>
    <h1>{{$game['title']}}</h1>
    <iframe src="/storage/games/{{$game['slug']}}/{{$game['latest']['version']}}"></iframe>
</body>
</html>
