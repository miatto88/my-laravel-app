<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
use App\Todo;
use App\User;
use App\Http\Requests\TodoRequest;;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TodoController extends Controller
{
    public function index(Request $request) {
        $todos = TOdo::query();
        if(isset($request->title)) {
            $todos->where('title', 'LIKE', "%$request->title%");
        }
        if(isset($request->user_name)) {
            $todos->whereIn('user_id', function($query) use ($request) {
                $query->select('id')
                    ->from('users')
                    ->where('name', 'LIKE', "%$request->user_name%");
            });
        }

        $todos = $todos->paginate(5);
        $user = User::find(Auth::user()->id);

        return view('todo.index', compact('todos', 'user'));
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

    public function store(TodoRequest $request) {
        // $request->validate([
        //     'title' => 'required | unique:todos',
        //     'user_id' => 'required | numeric'
        // ],
        // [
        //     'title.required' => 'タスク名は必須です',
        //     'title.unique' => '同じタスク名が既に存在しています'
        // ]);

        DB::beginTransaction();
        try {
            $todo = new Todo();
            $todo->title = $request->title;
            $todo->user_id = $request->user_id;
            $todo->status = 0;

            $todo->save();
            DB::commit();
        } catch (\Exception $e) {
            $errorLog = sprintf( '[%s][%s][%s] %s user_id: %s params: %s',
                'TodoController',
                'store',
                'error',
                'failed to update todos.',
                $request->user_id,
                json_encode($request)
            );
            Log::error($errorLog);

            DB::rollback();
        }

        return redirect('/index');
    }

    public function edit($id) {
        $record = Todo::with('user')->find($id);
        $users = User::all();

        return view('todo.edit', compact('record', 'users'));
    }

    public function update(TodoRequest $request, $id) {
        // $request->validate([
        //     'title' => 'required | unique:todos',
        //     'user_id' => 'required | numeric'
        // ],
        // [
        //     'title.required' => 'タスク名は必須です',
        //     'title.unique' => '同じタスク名が既に存在しています'
        // ]);
        
        DB::beginTransaction();
        try {
            $todo = Todo::find($id);
            $todo->title = $request->title;
            $todo->user_id = $request->user_id;

            $todo->save();
            DB::commit();
        } catch (\Exception $e) {
            $errorLog = sprintf( '[%s][%s][%s] %s user_id: %s params: %s',
                'TodoController',
                'store',
                'error',
                'failed to update todos.',
                $request->$user_id,
                json_encode($request)
            );
            Log::error($errorLog);
            
            DB::rollback();
        }

        return redirect('/index');
    }

    public function delete($id) {
        $todo = Todo::find($id);
        $todo->deleted();

        $todo->save();

        return redirect('/index');
    }
    
    public function complete($id) {
        $todo = Todo::find($id);
        $todo->status = 1;

        $todo->save();

        return redirect('/index');
    }
}
