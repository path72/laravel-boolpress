<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
	/**
	 * All users
	 */
    public function index() {
		$users = User::All();
		return view('guest.users.index',compact('users'));
	}

	/**
	 * Selected user
	 */
    public function show($id) {
		$user = User::where('id',$id)->first();
		if(!$user) {
			abort(404);
		}
		return view('guest.users.show',compact('user'));
	}
}
