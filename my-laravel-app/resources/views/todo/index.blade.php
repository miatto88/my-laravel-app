<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
</head>

<body>
    <div>
        <a href="{{ route('new') }}">タスクを追加</a>
    </div>
    <table border='1'>
        <tr>
            <th width='200'>タスク名</th>
            <th width='200'>担当者</th>
            <th width='250'>登録日</th>
            <th width='100'>完了</th>
            <th width='100'>詳細</th>
        </tr>
        @foreach ($records as $record)
        <tr>
            <th>{{ $record->title }}</th>
            <th>{{ $record->user->name }}</th>
            <th>{{ $record->created_at }}</th>
            <th><a href="{{ route('complete', ['id'=>$record->id]) }}">完了</a></th>
            <th><a href="{{ route('detail', ['id'=>$record->id]) }}">詳細</a></th>
        </tr>
        @endforeach
    </table>
</body>
</html>