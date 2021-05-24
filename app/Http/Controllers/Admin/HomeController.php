<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
	/**
	 * home page utente loggato
	 */
    public function index()
    {
        return view('admin.home'); // ! HERE [3] !
    }

	/**
	 * vista utente loggato
	 */
	public function profile()
    {
        return view('user.profile');
    }

	/**
	 * generazione token per api
	 */
	public function generateToken()
    {
		$api_token = Str::random(80);
		$user = Auth::user();
		$user->api_token = $api_token;
		$user->save();

		// @dd($api_token,$user);

        return redirect()->route('admin-profile');
    }

}
