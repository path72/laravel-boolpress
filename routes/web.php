<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * ! http://localhost:8000/
 * 
 * URI contattabile in get/post
 */

// ! HERE [1] !

// % GUEST ROUTES % 

Route::get('/', 'HomeController@index')->name('guest-homepage');

// # MODE 1: singole rotte, eventualmente con parametro {} # 
// Route::get('/posts', 'PostController@index')->name('posts.index');
// Route::get('/posts/{slug}', 'PostController@show')->name('posts.show');
// Route::get('/categories', 'CategoryController@index')->name('categories.index');
// Route::get('/categories/{slug}', 'CategoryController@show')->name('categories.show');
// Route::get('/users', 'UserController@index')->name('users.index');
// Route::get('/users/{id}', 'UserController@show')->name('users.show');
// # MODE 2: raggruppamento con prefix # 
Route::prefix('posts')
	->group(function() {
		Route::get('/', 'PostController@index')->name('posts.index');
		Route::get('/{slug}', 'PostController@show')->name('posts.show');		
	});
Route::prefix('categories')
	->group(function() {
		Route::get('/', 'CategoryController@index')->name('categories.index');
		Route::get('/{slug}', 'CategoryController@show')->name('categories.show');		
	});
Route::prefix('tags')
	->group(function() {
		Route::get('/', 'TagController@index')->name('tags.index');
		Route::get('/{slug}', 'TagController@show')->name('tags.show');		
	});
Route::prefix('users')
	->group(function() {
		Route::get('/', 'UserController@index')->name('users.index');
		Route::get('/{id}', 'UserController@show')->name('users.show');		
	});

Auth::routes(); // signup presente in guest home
// Auth::routes(['register'=>false]); // disattivazione signup in guest home 

// % ADMIN ROUTES % 

// Route::get('/admin', 'HomeController@index')->name('admin-home')->middleware('auth');
// oppure raggruppamento sotto prefisso URI 'admin'
Route::prefix('admin')   	// prefisso URI raggruppamento sezione /admin/...
	->namespace('Admin')	// ubicazione Controller admin /app/Http/Controllers/Admin/
	->middleware('auth')	// controllore autenticazione
	->group(function () {	// rotte specifiche admin
		Route::get('/', 'HomeController@index')->name('admin-home');

		// le robe del token
		Route::get('/profile', 'HomeController@profile')->name('admin-profile');
		Route::post('/profile/generate-token', 'HomeController@generateToken')->name('admin.generate_token');

		Route::resource('/posts', PostController::class)->names([
			'index' 	=> 'admin.posts.index',
			'show' 		=> 'admin.posts.show',
			'create' 	=> 'admin.posts.create',
			'store' 	=> 'admin.posts.store',
			'edit' 		=> 'admin.posts.edit',
			'update' 	=> 'admin.posts.update',
			'destroy' 	=> 'admin.posts.destroy',
		]);
		Route::resource('/categories', CategoryController::class)->names([
			'index' 	=> 'admin.categories.index',
			'show' 		=> 'admin.categories.show',
			'create' 	=> 'admin.categories.create',
			'store' 	=> 'admin.categories.store',
			'edit' 		=> 'admin.categories.edit',
			'update' 	=> 'admin.categories.update',
			'destroy' 	=> 'admin.categories.destroy',
		]);
		Route::resource('/tags', TagController::class)->names([
			'index' 	=> 'admin.tags.index',
			'show' 		=> 'admin.tags.show',
			'create' 	=> 'admin.tags.create',
			'store' 	=> 'admin.tags.store',
			'edit' 		=> 'admin.tags.edit',
			'update' 	=> 'admin.tags.update',
			'destroy' 	=> 'admin.tags.destroy',
		]);
	});

