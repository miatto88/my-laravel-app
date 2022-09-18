@extends('layouts.base')
@section('title', 'index')

@section('content')
<div>
    あなたのタスク状況
</div>
<div>
    ◆今週 新たに追加したタスク　{{ $user->aggregate->aggregate_new_task_count }}
</div>
<div>
    ◆今週 完了したタスク　{{ $user->aggregate->aggregate_complete_task_count }}
</div>
<div>
    ◆未完了のタスク　{{ $user->aggregate->aggregate_incomplete_task_count }}
</div>
<hr>
<form action="" method="get">
    <div>
        <label for="" >タスク名：</label>
        <input type="text" name="title">
    </div>
    <div>
        <label for="" >担当者　：</label>
        <input type="text" name="user_name">
    </div>
    <div>
        <button type="submit">検索</button>
    </div>
</form>
<br>
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
{{ $todos->links() }}
@endsection