<?php

namespace App\Service;

use Illuminate\Support\Facades\Auth;

use Firebase\JWT\JWT;

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

        $auth['token'] = JWT::encode($auth, $this->key, $this->jwtAlgo);
        return $auth;
    }
}