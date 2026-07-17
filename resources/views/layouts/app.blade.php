<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <header>
        <h1>OfficeHub</h1>

        @auth
            {{ Auth::user()->name }}

            <form action="/logout" method="post">
                @csrf
                <button>
                    ログアウト
                </button>
            </form>
        @endauth
    </header>

    <hr>

    <div style="display: flex">
        @auth

            <aside style="width: 220px">
                <ul>
                    <li><a href="/home">ホーム</a></li>
                    <li><a href="{{ route('products.index') }}">社内フリマ</a></li>
                    <li><a href="{{ route('products.create') }}">商品を出品する</a></li>
                    <li><a href="{{ route('favorites.index') }}">フリマお気に入り</a></li>

                    {{-- 以下は未実装。機能を作ったら順に有効化する --}}
                    <li><a href="#">チャット</a></li>
                    <li><a href="#">お知らせ</a></li>
                    <li><a href="#">イベント</a></li>
                    <li><a href="#">マイページ</a></li>
                </ul>
            </aside>
        @endauth

        <main style="margin-left: 30px">
            @yield('content')
        </main>
    </div>

</body>

</html>