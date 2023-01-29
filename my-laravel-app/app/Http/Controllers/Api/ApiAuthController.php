<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;

use App\User;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ApiAuthController extends Controller
{
    protected $key;
    protected $jwtAlgo;
    protected $jwtExpire;

    public function __construct()
    {
        $this->key = config('jwt.JWT_SECRET');
        $this->jwtAlgo = 'HS512';
        $this->jwtExpire = time() + 3600;
    }

    public function login(Request $request)
    {
        $user = User::where(['email' => $request->email])->first();

        if( !$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Unauthorized']);
        }

        return $this->forgeAuth($user);
    }

    // JWTトークンを返却する処理
    public function forgeAuth($user)
    {
        $auth = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'expired_at' => $this->jwtExpire,
        ];

        $auth['token'] = JWT::encode($auth, $this->key, $this->jwtAlgo);
        return $auth;
    }
}
