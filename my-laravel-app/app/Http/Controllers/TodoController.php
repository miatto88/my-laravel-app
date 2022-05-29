<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use App\Todo;
use App\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

        DB::beginTransaction();
        try {
            $todo = new Todo();
            $todo->title = $request->title;
            $todo->user_id = $request->user_id;

            $todo->save();
            DB::commit();
            Log::info('DBに新しいレコードが追加されました - todos.id : ' . $todo->id);
        } catch (\Exception $e) {
            DB::rollback();
        }

        return redirect('/index');
    }

    public function edit($id) {
        $record = Todo::with('user')->find($id);
        $users = User::all();

        return view('todo.edit', compact('record', 'users'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'title' => 'required | unique:todos',
            'user_id' => 'required | numeric'
        ],
        [
            'title.required' => 'タスク名は必須です',
            'title.unique' => '同じタスク名が既に存在しています'
        ]);
        
        DB::beginTransaction();
        try {
            $todo = Todo::find($id);
            $todo->title = $request->title;
            $todo->user_id = $request->user_id;

            $todo->save();
            DB::commit();
            Log::info('DBの値が更新されました - todos.id : ' . $request->id);
        } catch (\Exception $e) {
            DB::rollback();
        }

        return redirect('/index');
    }
}
