<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('css')
</head>

<body>
    <header>
        <h1>OfficeHub</h1>

        @auth
            <div class="header-user">
                <span>{{ Auth::user()->name }}</span>

                <form action="/logout" method="post">
                    @csrf
                    <button>ログアウト</button>
                </form>
            </div>
        @endauth
    </header>

    <div class="layout">
        @auth
            <aside class="sidebar">
                <ul>
                    <li><a href="/home">ホーム</a></li>
                    <li>
                        <a href="{{ route('chats.index') }}">
                            社内チャット
                            @if($unreadTotal > 0)
                                <span class="nav-badge">{{ $unreadTotal }}</span>
                            @endif
                        </a>
                    </li>
                    <li><a href="{{ route('products.index') }}">社内フリマ</a></li>
                    <li><a href="{{ route('products.create') }}">商品を出品する</a></li>
                    <li><a href="{{ route('favorites.index') }}">フリマお気に入り</a></li>
                    <li><a href="{{ route('announcements.index') }}">お知らせ</a></li>
                    <li><a href="{{ route('events.index') }}">イベント</a></li>
                    @if(auth()->user()->is_admin)
                        <li><a href="{{ route('admin.dashboard') }}">管理者ダッシュボード</a></li>
                    @endif
                    <li><a href="{{ route('mypage.index') }}">マイページ</a></li>
                </ul>
            </aside>
        @endauth

        <main>
            @yield('content')
        </main>
    </div>

</body>

</html>