<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <form action="" method='post'>
            @csrf
            <p>タスク名　：　<input type='text' name='title' value=''></p>
            <p>担当者　　：　<select name='user_id' id="name">
                    @foreach ($users as $user)
                    <option value='{{ $user->id }}'>{{ $user->name }}</option>
                    @endforeach
                </select>
            </p>
            <p><input type="submit" value='登録する'></p>
        </form>
        @if ($errors->any())
        <div class='alert alert-danger'>
            @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif
    </div>
    <hr>
    <div>
        <a href="{{ route('index') }}">一覧へ戻る</a>
    </div>
</body>
</html>