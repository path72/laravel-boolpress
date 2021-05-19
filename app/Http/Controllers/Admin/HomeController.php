<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
	// ! HERE [3] !
    public function index()
    {
        return view('admin.home');
    }
}
