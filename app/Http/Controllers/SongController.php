<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\PbeBaseController;
use App\Models\Playlistsong;
use App\Models\Song;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SongController extends PbeBaseController
{
    /**
     * Function mendapatkan semua data tabel song
     * @return JsonResponse
     */
    public function getAllSong()
    {
        $songs = Song::all();
        return $this->successResponse(['songs'=>$songs]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getSongById($id)
    {
        $song = Song::find($id);
        if ($song == null){
            throw new NotFoundHttpException();
        }
        return $this->successResponse(['song'=>$song]);
    }

    public function createSong()
    {
        $validate = Validator::make(request()->all(),[
            'title' => 'required',
            'year' => 'required',
            'artist' => 'required',
            'gendre' => 'required',
            'duration' => 'required'
        ]);
        if($validate->fails()){
            return $this->failResponse($validate->errors()->getMessages(), 400);
        }
        $song = new Song();
        $song->title = request('title');
        $song->year = request('year');
        $song->artist = request('artist');
        $song->gendre = request('gendre');
        $song->duration = request('duration');
        $song->save();
        return $this->successResponse(['song'=>$song], 201);
    }

    public function updateSong($id)
    {
        $song = Song::find($id);
        if($song == null){
            throw new NotFoundHttpException();
        }
        $validate = Validator::make(request()->all(),[
            'title' => 'required',
            'year' => 'required|digits:4',
            'artist' => 'required',
            'gendre' => 'required',
            'duration' => 'required'
        ]);
        if($validate->fails()){
            return $this->failResponse($validate->errors()->getMessages(), 400);
        }
        $song->title = request('title');
        $song->year = request('year');
        $song->artist = request('artist');
        $song->gendre = request('gendre');
        $song->duration = request('duration');
        $song->save();
        return $this->successResponse(['song'=>$song]);
    }

    public function deleteSong($id)
    {
        $song = Song::find($id);
        if($song == null){
            throw new NotFoundHttpException();
        }
        $songs = Playlistsong::where('song_id','=',$id)->first();
        if($songs == null){
            $song->delete();
            return $this->successResponse(['song'=>'Data berhasil dihapus']);
        }
        return $this->failResponse(['Data telah digunakan'],400);
    }
}
