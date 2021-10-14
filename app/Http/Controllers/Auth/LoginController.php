<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function verify()
    {
        $email = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];
        $user = User::loginVerify($email, $password);
        if ($user != false){
            $token = Str::random('100');
            $user->token = $token;
            $user->save();
            return $this->successResponse(['user' => $user]);
        }
        return $this->failResponse([],401);
    }
}
