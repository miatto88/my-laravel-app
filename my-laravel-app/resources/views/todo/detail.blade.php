@extends('layouts.base')
@section('title', 'detail')

@section('content')
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
@endsection