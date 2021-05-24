<?php

use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * ! http://localhost:8000/api/user/
 */
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * ! http://localhost:8000/api/posts/
 */
// Route::get('posts', 'Api\PostController@index'); // api senza protezione
Route::get('posts', 'Api\PostController@index')->middleware('api_token_check');