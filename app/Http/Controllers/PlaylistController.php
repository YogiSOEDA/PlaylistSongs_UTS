<?php

namespace App\Http\Controllers;

use App\Exceptions\PbeNotAuthorizedException;
use App\Http\Controllers\Base\PbeBaseController;
use App\Models\Playlist;
use App\Models\Playlistsong;
use App\Models\Song;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PlaylistController extends PbeBaseController
{

    public function createPlaylist()
    {
        $validate = Validator::make(request()->all(),[
            'name' => 'required'
        ]);
        if ($validate->fails()){
            return $this->failResponse($validate->errors()->getMessages(), 400);
        }
        $playlist = new Playlist();
        $playlist->name = request('name');
        $playlist->user_id = request()->user->id;
        $playlist->save();
        return $this->successResponse(['playlist' => $playlist], 201);
    }

    public function getOwnPlaylist()
    {
        $list = request()->user->id;
        $playlists = Playlist::where('user_id','=', $list)->get();
        return $this->successResponse(['playlists' => $playlists]);
    }

    public function getMyPlaylist($id)
    {
        $list = request()->user->id;
        $playlist = Playlist::find($id);
        if ($playlist == null){
            throw new NotFoundHttpException();
        }
        if ($playlist->user_id != $list){
            throw new PbeNotAuthorizedException();
        }
        return $this->successResponse(['playlist' => $playlist]);

    }

    public function insertSongPlaylist($id)
    {
        $list = request()->user->id;
        $playlist = Playlist::find($id);
        if ($playlist == null){
            throw new NotFoundHttpException();
        }
        if ($playlist->user_id != $list){
            throw new PbeNotAuthorizedException();
        }

        $validate = Validator::make(request()->all(),[
            'song_id' => 'required'
        ]);
        if ($validate->fails()){
            return $this->failResponse($validate->errors()->getMessages(), 400);
        }
        $playlistsong = new Playlistsong();
        $playlistsong->song_id = request('song_id');
        $playlistsong->playlist_id = $playlist->id;
        $playlistsong->save();
        return $this->successResponse(['plalist' => $playlistsong]);
    }

    public function getPlaylistSong($id)
    {
        $list = request()->user->id;
        $playlist = Playlist::find($id);
        if ($playlist == null){
            throw new NotFoundHttpException();
        }
        if ($playlist->user_id != $list){
            throw new PbeNotAuthorizedException();
        }

        $playlistsong = Playlistsong::join('playlists','playlists.id','=','playlistsongs.playlist_id')
            ->join('songs','songs.id','=','playlistsongs.song_id')
            ->where('playlists.id','=',$id)
            ->select('playlists.id','playlists.name','playlistsongs.song_id','songs.title','songs.year','songs.artist','songs.gendre','songs.duration')
            ->get();
        //$playlistsong = Playlistsong::where('playlist_id', '=', $playlist->id)->get();
        return $this->successResponse(['playlist' => $playlistsong,]);
    }
}
