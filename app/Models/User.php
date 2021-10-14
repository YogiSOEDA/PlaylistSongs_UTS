<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    protected $hidden = [
        'password',
    ];

    public static function loginVerify($email, $password)
    {
        $user = self::where('email', '=', $email)->first();
        if($user != null){
            if (Hash::check($password, $user->password)){
                return $user;
            }
        }
        return false;
    }
}
