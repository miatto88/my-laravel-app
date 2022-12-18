<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Todo;
use App\User;
use App\Traits\LogTrait;
use App\Http\Requests\StoreApiTodoRequest;
use App\Http\Requests\UpdateApiTodoRequest;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiTodoController extends Controller
{
    use LogTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return json_encode(Todo::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApiTodoRequest $request)
    {
        $this->start();

        DB::beginTransaction();
        try {
            $user = User::findOrFail($request->user_id);
            $user->todos()->create($request->validated());

            DB::commit();
        } catch (\Exception $e) {
            $this->errorLog('todos', $request);
            DB::rollback();
        }

        $this->end();
        return json_encode($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $todo = Todo::with('user')->findOrFail($id);
        return json_encode($todo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApiTodoRequest $request, $id)
    {
        $this->start();

        DB::beginTransaction();
        try {
            $todo = Todo::findOrFail($id);
            $todo->fill($request->validated())->save();

            DB::commit();
        } catch (\Exception $e) {
            $this->errorLog('todos', $request);
            DB::rollback();
        }

        $this->end();
        return json_encode($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->start();

        DB::beginTransaction();
        try {
            $todo = Todo::findOrFail($id);
            $todo->delete();

            $todo->save();
            DB::commit();
        } catch (\Exception $e) {
            $this->errorLog('todos', 'delete id: ' . $id);
            DB::rollback();
            return json_encode($id);
        }

        $this->end();
        return json_encode($todo);
    }
}
