<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;

use App\User;
use App\Service\ServiceAuth;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

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

        return $this->serviceAuth->forgeAuth($user);
    }

}
