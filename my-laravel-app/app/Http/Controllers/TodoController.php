<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App;
use App\Todo;
use App\User;
use App\Http\Requests\TodoRequest;;
use App\Traits\LogTrait;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TodoController extends Controller
{
    use LogTrait;

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
        $this->logStart();

        DB::beginTransaction();
        try {
            $user = User::findOrFail($request->user_id);
            $user->todos()->create($request->validated());

            DB::commit();
        } catch (\Exception $e) {
            $this->errorLog('todos', $request);

            DB::rollback();
        }

        $this->logEnd();
        return redirect('/index');
    }

    public function edit($id) {
        $record = Todo::with('user')->findOrFail($id);
        $users = User::all();

        return view('todo.edit', compact('record', 'users'));
    }

    public function update(TodoRequest $request, $id) {        
        $this->logStart();

        DB::beginTransaction();
        try {
            throw new \Exception('error');
            $todo = Todo::findOrFail($id);
            $todo->fill($request->validated())->save();

            DB::commit();
        } catch (\Exception $e) {
            $this->errorLog('todos', $request);

            DB::rollback();
        }

        $this->logEnd();
        return redirect('/index');
    }

    public function delete($id) {
        $this->logStart();

        DB::beginTransaction();
        try {
            $todo = Todo::findOrFail($id);
            $todo->deleted();

            $todo->save();
            DB::commit();
        } catch (\Exception $e) {
            $this->errorLog('todos', $request);

            DB::rollback();
        }

        $this->logEnd();
        return redirect('/index');
    }

    public function complete($id) {
        $this->logStart();

        DB::beginTransaction();
        try {
            $todo = Todo::findOrFail($id);
            $todo->status = 1;
    
            $todo->save();
            DB::commit();
        } catch (\Exception $e) {
            $this->errorLog('todos', $request);

            DB::rollback();
        }

        $this->logEnd();
        return redirect('/index');
    }
}
