<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;

use App\User;
use App\Service\ServiceAuth;

class ApiAuthController extends Controller
{
    protected $serviceAuth;

    public function __construct()
    {
        $this->serviceAuth = new ServiceAuth;
    }

    public function login(Request $request)
    {
        $user = User::where(['email' => $request->email])->first();

        if( !$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Unauthorized']);
        }

        $jwt = $this->serviceAuth->forgeAuth($user);
        return $jwt;
    }

    public function myTodoList(Request $request)
    {
        $user = $this->serviceAuth->findUserByToken($request->bearerToken());
        if( !$user) {
            abort('403', 'ユーザーが取得できません。');
        }

        return $user->todos;
    }

}
