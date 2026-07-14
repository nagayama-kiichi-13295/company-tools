<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>新規登録</title>
</head>

<body>
    <h1>OfficeHub 新規登録</h1>

    @if($errors->any())
    <ul style="color: red;">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif

    <form action="/register" method="post">
        @csrf

        <div>
            <label>名前</label><br>
            <input type="text" name="name" value="{{ old('name') }}">
        </div>

        <br>

        <div>
            <label>メールアドレス</label><br>
            <input type="email" name="email" value="{{ old('email') }}">
        </div>

        <br>

        <div>
            <label>パスワード</label><br>
            <input type="password" name="password">
        </div>

        <br>

        <div>
            <label>パスワード確認</label><br>
            <input type="password" name="password_confirmation">
        </div>

        <br>

        <button type="submit">
            登録
        </button>
    </form>

    <p>
        <a href="/login">ログインはこちら</a>
    </p>
</body>

</html>