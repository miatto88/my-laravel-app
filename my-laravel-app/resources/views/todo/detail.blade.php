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
        <p>タスク名　：　{{ $record->title }}</p>
        <p>担当者　　：　{{ $record->user->name }}</p>
        <p>登録日　　：　{{ $record->created_at }}</p>
        <p>更新日　　：　{{ $record->updated_at }}</p>
    </div>
    <p>
        <a href="{{ route( 'edit', ['id' => $record->id] ) }}">編集</a>
    </p>
    <p>
        <a href="{{ route( 'delete', ['id' => $record->id] ) }}">削除</a>
    </p>
    <hr>
    <div>
        <a href="{{ route('index') }}">一覧へ戻る</a>
    </div>
</body>
</html>