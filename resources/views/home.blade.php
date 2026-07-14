<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>OfficeHub</title>
</head>

<body>
    <h1>OfficeHub</h1>
    <p>{{ Auth::user()->name }}さん ようこそ！</p>

    <form action="/logout" method="post">
        @csrf
        <button type="submit">
            ログアウト
        </button>
    </form>
</body>

</html>