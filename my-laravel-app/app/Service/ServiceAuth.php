<?php

namespace App\Service;

use Illuminate\Support\Facades\Auth;

use App\User;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ServiceAuth
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

    // JWTトークンを返却する処理
    public function forgeAuth($user)
    {
        $auth = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'expired_at' => $this->jwtExpire,
        ];

        $jwt = JWT::encode($auth, $this->key, $this->jwtAlgo);
        return $jwt;
    }

    // JWTトークンを受け取ってユーザーを返す処理
    public function findUserByToken($jwt)
    {
        $decoded = JWT::decode($jwt, new Key($this->key, $this->jwtAlgo));

        $user = User::find($decoded->id);
        return $user;
    }
}