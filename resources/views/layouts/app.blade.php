<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
</head>

<body>
    <header>
        <h1>OfficeHub</h1>

        @auth
        <p>{{ Auth::user()->name }} さん</p>

        <form action="/logout" method="post">
            @csrf
            <button>ログアウト</button>
        </form>
        @endauth
    </header>

    <hr>

    @yield('content')

</body>

</html>