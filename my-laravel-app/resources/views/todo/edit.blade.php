@extends('layouts.base')
@section('title', 'edit')

@section('content')
<div>
    <form action="" method='post'>
        @csrf
        <p>タスク名　：　<input type='text' name='title' value='{{ $record->title }}'></p>
        <p>担当者　　：　<select name='user_id' id="name">
                @foreach ($users as $user)
                <option value='{{ $user->id }}'>{{ $user->name }}</option>
                @endforeach
            </select>
        </p>
        <p><input type="submit" value='更新する'></p>
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
@endsection