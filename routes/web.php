<?php

use Illuminate\Support\Facades\Route;

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

// ! HERE [1] !

// % GUEST ROUTES % 
Route::get('/', 'HomeController@index')->name('guest-home');

Auth::routes();

// % ADMIN ROUTES % 
// Route::get('/admin', 'HomeController@index')->name('admin-home')->middleware('auth');
// oppure raggruppamento sorro prefisso URI 'admin'
Route::prefix('admin')   	// prefisso URI raggruppamento sezione /admin/...
	->namespace('Admin')	// ubicazione Controller admin /app/Http/Controllers/Admin/
	->middleware('auth')	// controllore autenticazione
	->group(function () {	// rotte specifiche admin
		Route::get('/', 'HomeController@index')->name('admin-home');
	});


/*****************************************************************************
 
**LARAVEL: avvio progetto con autenticazione e Model con CRUD**
1. *Framework setup*
   1. laravel: installazione in progetto 		[composer create-project --prefer-dist laravel/laravel:^7.0 project_name]
   2. laravel/ui: installazione 				[composer require laravel/ui:^2.4]
   3. scaffolding auth bootstrap: installazione	[php artisan ui bootstrap --auth]
   4. dependencies: installazione 				[npm install | npm audit fix | npm run dev]
   5. faker: sostituzione						[composer remove fzaninotto/faker | composer require fakerphp/faker]
2. *Controller-View setup: struttura guest-admin*
   1. creazione Controller Admin				[php artisan make:controller Admin/HomeController]
   2. alberatura base Controller-View con struttura guest-admin
   		/app/Http/Controllers/HomeController.php		: guest views Controller 
   		/app/Http/Controllers/Admin/HomeController.php	: admin views Controller
		/app/Http/Providers/RouteServiceProvider		: path to home view (admin)
		/resources/views/admin/home.blade.php			: admin home (default /views/home.blade.php)
   		/resources/views/guest/home.blade.php			: guest home (default /views/welcome.blade.php)
		/routes/web.php									: routes
3. *Controller-View setup: allineamento routes<->views sotto guest/admin*
   [1] /routes/web.php	   	
		Route::get('/', 'HomeController@index')->name('guest-home');
		Auth::routes();
		Route::prefix('admin')   	// prefisso URI raggruppamento sezione /admin/...
			->namespace('Admin')	// ubicazione Controller admin /app/Http/Controllers/Admin/
			->middleware('auth')	// controllore autenticazione
			->group(function () {	// rotte specifiche admin
				Route::get('/', 'HomeController@index')->name('admin-home');
			});
   [2] /app/Http//Providers/RouteServiceProvider
   		public const HOME = '/admin';
   [3] /app/Http/Controllers/Admin/HomeController.php
		index(): return view('admin.home');
   [4] /app/Http/Controllers/HomeController.php
		no __construct() with middleware('auth')
        index(): return view('guest.home');
   [5] /resources/views/guest/home.blade.php
		@auth
			<a href="{{ url('/admin') }}">Home</a>
		@else    
4. *Controller-Model setup: struttura users-posts* 
   1. DB: creazione e collegamento					[.env: DB_DATABASE=... DB_USERNAME=... DB_PASSWORD=...]
   2. creazione Model (Post) e CRUD					[php artisan make:model ModelName -rcms]
   3. alberatura base Model con struttura users-posts
   		/app/Post.php					: Model for posts table
		/database/migrations/{...}.php	: migrations for DB users & posts tables
		/database/seeds/PostSeeder.php	: seeder for DB posts table
   4. MIGRATION: creazione tabelle users e posts 	[php artisan migrate]
   5. SEED: popolamento tabella posts				[php artisan db:seed]
   6. SIGNUP: popolamento tabella users

*******************************************************************************/
