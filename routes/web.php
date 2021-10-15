<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('api/v1/login', 'Auth\LoginController@verify');

$router->group(['prefix' => 'api/v1', 'middleware' => 'pbe.auth'], function ($router) {
    #To Get All Songs
    $router->get('/songs', 'SongController@getAllSong');
    #To Get Song By Id
    $router->get('/songs/{id}', 'SongController@getSongById');

    $router->post('/playlists', 'PlaylistController@createPlaylist');

    $router->get('/playlists', 'PlaylistController@getOwnPlaylist');

    $router->get('/playlists/{id}', 'PlaylistController@getMyPlaylist');

    $router->post('/playlists/{id}/songs', 'PlaylistController@insertSongPlaylist');

    $router->get('/playlists/{id}/songs', 'PlaylistController@getPlaylistSong');

    $router->group(['middleware' => 'pbe.superuser'], function ($router) {
        #To Get All Users
        $router->get('/users', 'UserController@getAllUser');
        #To Get User By Id
        $router->get('/users/{id}', 'UserController@getUserById');
        #To Insert User
        $router->post('/users', 'UserController@createUser');

        #To Insert Song
        $router->post('/songs', 'SongController@createSong');
        #To Update Song
        $router->put('/songs/{id}', 'SongController@updateSong');
        #To Delete Song
        $router->delete('/songs/{id}', 'SongController@deleteSong');

        $router->get('/users/{id}/playlists', 'UserController@getUserPlaylist');

        $router->get('/users/{id}/playlists/{playlistid}/songs', 'UserController@getUserPlaylistSong');
    });
});
