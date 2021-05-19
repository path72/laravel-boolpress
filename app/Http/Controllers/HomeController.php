<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
	
	// ! HERE [4] !
	
	/**
	 * no __construct() with middleware('auth')
	 * (middleware('auth') in routes)
	 */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('guest.home');
    }
}
