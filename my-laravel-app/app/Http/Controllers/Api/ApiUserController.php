<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Controllers\Controller;

use App\Todo;
use App\User;
use App\Aggregate;
use App\Traits\LogTrait;
use App\Http\Requests\StoreApiUserRequest;
use App\Http\Requests\UpdateApiUserRequest;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiUserController extends Controller
{
    use LogTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApiUserRequest $request)
    {
        $this->logStart();

        DB::beginTransaction();
        try {
            $aggregate = new Aggregate();
            $aggregate->save();
            $aggregate->user()->create($request->validated());

            DB::commit();
        } catch (\Exception $e) {
            $this->errorLog('users', $request);
            DB::rollback();
        }

        $this->logEnd();
        return response()->json($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApiUserRequest $request, $id)
    {
        $this->logStart();

        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $user->fill($request->validated())->save();

            DB::commit();
        } catch (\Exception $e) {
            $this->errorLog('users', $request);
            DB::rollback();
        }

        $this->logEnd();
        return response()->json($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->logStart();

        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $user->delete();

            $user->save();
            DB::commit();
        } catch (\Exception $e) {
            $this->errorLog('users', $request);
            DB::rollback();
        }

        $this->logEnd();
        return response()->json($user);
    }
}
