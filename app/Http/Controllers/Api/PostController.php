<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
	/**
	 * Post endpoint 
	 * 
	 * restituisce in json tutta la tabella posts
	 * 
	 */
    public function index() 
	{
		$posts = Post::all();
		return response()->json([
			'success' => true,
			'results' => $posts
		]);
	}
}
