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
        <p>タスク名　：　{{ $records->title }}</p>
        <p>担当者　　：　{{ $records->user->name }}</p>
        <p>登録日　　：　{{ $records->created_at }}</p>
        <p>更新日　　：　{{ $records->updated_at }}</p>
    </div>
    <div>
        <a href="{{ route('edit', ['id'=>$records->id]) }}">編集</a>
    </div>
    <hr>
    <div>
        <a href="{{ route('index') }}">一覧へ戻る</a>
    </div>
</body>
</html>