<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use App\Todo;
use App\User;

class TodoController extends Controller
{
    public function index() {
        $records = Todo::with('user')->get();

        return view('todo.index', compact('records'));
    }

    public function detail($id) {
        if (is_null(Todo::with('user')->find($id))) {
            return App::abort(404);
        }
        // $record = Todo::with('user')->findOrFail($id);

        $record = Todo::with('user')->find($id);

        return view('todo.detail', compact('record'));
    }

    public function new() {
        $users = User::all();

        return view('todo.new', compact('users'));
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required | unique:todos',
            'user_id' => 'required | numeric'
        ],
        [
            'title.required' => 'タスク名は必須です',
            'title.unique' => '同じタスク名が既に存在しています'
        ]);

        $todo = new Todo();
        $todo->title = $request->title;
        $todo->user_id = $request->user_id;

        $todo->save();

        return redirect('/index');
    }

    public function edit($id) {
        $record = Todo::with('user')->find($id);
        $users = User::all();

        return view('todo.edit', compact('record', 'users'));
    }

    public function update(Request $request, $id) {
        $todo = new Todo();
        $todo->title = $request->title;
        $todo->user_id = $request->user_id;

        $todo->save();

        return redirect('/index');
    }
}
