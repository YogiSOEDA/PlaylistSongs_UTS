<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\PbeBaseController;
use App\Models\Playlist;
use App\Models\Playlistsong;
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

    public function getUserPlaylist($id)
    {
        $userplaylist = Playlist::where('user_id', '=', $id)->get();
        if ($userplaylist == null){
            throw new NotFoundHttpException();
        }
        return $this->successResponse(['user playlists' => $userplaylist]);
    }

    public function getUserPlaylistSong($id,$playlistid)
    {
        $playlist = Playlist::join('playlistsongs', 'playlists.id', '=', 'playlistsongs.playlist_id')
            ->join('songs','playlistsongs.song_id','=','songs.id')
            ->where('playlists.id','=', $playlistid)
            ->where('playlists.user_id','=', $id)
            ->select('playlists.name','songs.title','songs.year','songs.artist','songs.gendre','songs.duration','playlists.user_id','playlistsongs.playlist_id')
            ->get();
        if ($playlist->count()==0){
            throw new NotFoundHttpException();
        }
        return $this->successResponse(['Playlist Song'=> $playlist]);
    }
}
