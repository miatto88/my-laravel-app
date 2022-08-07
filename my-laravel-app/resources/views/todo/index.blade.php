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
        あなたのタスク状況
    </div>
    <div>
        ◆今週 新たに追加したタスク　{{ $user->aggregate->aggregate_new_task_count }}
    </div>
    <div>
        ◆今週 新たに追加したタスク　{{ $user->aggregate->aggregate_complete_task_count }}
    </div>
    <div>
        ◆週 新たに追加したタスク　{{ $user->aggregate->aggregate_incomplete_task_count }}
    </div>
    <hr>
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
        @foreach ($todos as $todo)
        <tr>
            <th>{{ $todo->title }}</th>
            <th>{{ $todo->user->name }}</th>
            <th>{{ $todo->created_at }}</th>
            <th><a href="{{ route('complete', ['id'=>$todo->id]) }}">完了</a></th>
            <th><a href="{{ route('detail', ['id'=>$todo->id]) }}">詳細</a></th>
        </tr>
        @endforeach
    </table>
</body>
</html>