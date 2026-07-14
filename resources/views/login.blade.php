<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>OfficeHub ログイン</title>
</head>

<body>
    <h1>OfficeHub</h1>

    @if($errors->any())
    <p style="color: red;">
        {{ $errors->first() }}
    </p>
    @endif

    <form action="/login" method="post">

        @csrf
        <div>
            <label>メールアドレス</label><br>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}">
        </div>

        <br>

        <div>
            <label>パスワード</label><br>
            <input
                type="password"
                name="password">
        </div>

        <br>

        <button type="submit">ログイン</button>
    </form>
</body>

</html>