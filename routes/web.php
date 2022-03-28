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
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\CommentController;

$router->get('/books', [
    'as' => 'books.index', 'uses' => 'BookController@index'
]);


$router->get('/books/{id}', [
    'as' => 'books.show', 'uses' => 'BookController@show'
]);

$router->get('/sort-books', [
    'as' => 'books.sort', 'uses' => 'BookController@sort'
]);

$router->post('/sort-characters', [
    'as' => 'character.sort', 'uses' => 'CharacterController@sort'
]);

// create comments
$router->post('/comments', [
    'as' => 'comments.store', 'uses' => 'CommentController@store'
]);

// get all comments
$router->get('/comments', [
    'as' => 'comments.index', 'uses' => 'CommentController@index'
]);

// get comments by name
$router->get('/comments/show', [
    'as' => 'comments.show.name', 'uses' => 'CommentController@showByName'
]);