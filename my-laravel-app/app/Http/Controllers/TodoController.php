<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App;
use App\Todo;
use App\User;
use App\Http\Requests\TodoRequest;;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TodoController extends Controller
{
    public function index(Request $search) {
        $todos = Todo::getTodoList($search);
        $user = Auth::user();

        return view('todo.index', compact('todos', 'user'));
    }

    public function detail($id) {
        $record = Todo::with('user')->findOrFail($id);

        return view('todo.detail', compact('record'));
    }

    public function new() {
        $users = User::all();

        return view('todo.new', compact('users'));
    }

    public function store(TodoRequest $request) {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($request->user_id);
            $user->todos()->create($request->validated());

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
        $record = Todo::with('user')->findOrFail($id);
        $users = User::all();

        return view('todo.edit', compact('record', 'users'));
    }

    public function update(TodoRequest $request, $id) {        
        DB::beginTransaction();
        try {
            $todo = Todo::findOrFail($id);
            $todo->fill($request->validated())->save();

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
        DB::beginTransaction();
        try {
            $todo = Todo::findOrFail($id);
            $todo->deleted();
    
            $todo->save();
            DB::commit();
        } catch (\Exception $e) {
            $errorLog = sprintf( '[%s][%s][%s] %s user_id: %s params: %s',
                'TodoController',
                'delete',
                'error',
                'failed to delete todos.',
                $request->$user_id,
                json_encode($request)
            );
            Log::error($errorLog);
            
            DB::rollback();
        }

        return redirect('/index');
    }

    public function complete($id) {
        DB::beginTransaction();
        try {
            $todo = Todo::findOrFail($id);
            $todo->status = 1;
    
            $todo->save();
            DB::commit();
        } catch (\Exception $e) {
            $errorLog = sprintf( '[%s][%s][%s] %s user_id: %s params: %s',
                'TodoController',
                'edit',
                'error',
                'failed to edit todos.',
                $request->$user_id,
                json_encode($request)
            );
            Log::error($errorLog);
            
            DB::rollback();
        }

        return redirect('/index');
    }
}
