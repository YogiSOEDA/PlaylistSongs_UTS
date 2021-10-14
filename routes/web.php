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

$router->group(['prefix' => 'api/v1'], function ($router) {
    #To Get All Songs
    $router->get('/songs', 'SongController@getAllSong');
    #To Get Song By Id
    $router->get('/songs/{id}', 'SongController@getSongById');
    #To Insert Song
    $router->post('/songs', 'SongController@createSong');
    #To Update Song
    $router->put('/songs/{id}', 'SongController@updateSong');
    #To Delete Song
    $router->delete('/songs/{id}', 'SongController@deleteSong');

    #To Get All Users
    $router->get('/users', 'UserController@getAllUser');
    #To Get User By Id
    $router->get('/users/{id}', 'UserController@getUserById');
    #To Insert User
    $router->post('/users', 'UserController@createUser');
});
