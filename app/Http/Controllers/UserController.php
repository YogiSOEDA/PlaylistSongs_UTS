<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\PbeBaseController;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends PbeBaseController
{
    /**
     * Function mendapatkan semua data tabel song
     * @return JsonResponse
     */
    public function getAllUser()
    {
        $users = User::all();
        return $this->successResponse(['users'=>$users]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getUserById($id)
    {
        $user = User::find($id);
        if ($user == null){
            throw new NotFoundHttpException();
        }
        return $this->successResponse(['user'=>$user]);
    }

    public function createUser()
    {
        $validate = Validator::make(request()->all(),[
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role' => 'required',
            'fullname' => 'required'
        ]);
        if($validate->fails()){
            return $this->failResponse($validate->errors()->getMessages(), 400);
        }
        $user = new User();
        $user->email = request('email');
        $pass = request('password');
        $user->password = Hash::make($pass);
        $user->role = request('role');
        $user->fullname = request('fullname');
        $user->save();
        return $this->successResponse(['user'=>$user], 201);
    }
}
