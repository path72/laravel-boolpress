<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
	/**
	 * All posts
	 */
    public function index() {
		$posts = Post::All();
		return view('guest.posts.index',compact('posts'));
	}

	/**
	 * Selected Post
	 */
    public function show($slug) {
		$post = Post::where('slug',$slug)->first();
		if(!$post) {
			abort(404);
		}
		return view('guest.posts.show',compact('post'));
	}
}
