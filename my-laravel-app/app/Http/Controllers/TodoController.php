<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class TodoController extends Controller
{
    public function index() {
        $data = [
            'records' => App\Todo::with('user')->get(),
        ];
        return view('todo.index', $data);
    }

    public function detail($id) {
        $data = [
            'record' => App\Todo::with('user')->find($id)
        ];
        return view('todo.detail', $data);
    }

    public function new() {
        $data = [
            'users' => App\User::all()
        ];
        return view('todo.new', $data);
    }

    public function store(Request $request) {
        $todo = new App\Todo();
        $todo->title = $request->title;
        $todo->user_id = $request->user_id;

        $todo->save();

        return redirect('/index');
    }

    public function edit($id) {
        $data = [
            'record' => App\Todo::with('user')->find($id),
            'users' => App\User::all()
        ];
        return view('todo.edit', $data);
    }

    public function update(Request $request, $id) {
        $todo = new App\Todo();
        $todo->title = $request->title;
        $todo->user_id = $request->user_id;

        $todo->save();

        return redirect('/index');
    }
}
