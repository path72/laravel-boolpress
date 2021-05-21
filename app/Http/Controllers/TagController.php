<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;

class TagController extends Controller
{
	/**
	 * All tags
	 */
    public function index() {
		$tags = Tag::All();
		return view('guest.tags.index',compact('tags'));
	}

	/**
	 * Selected tag
	 */
    public function show($slug) {
		$tag = Tag::where('slug',$slug)->first();
		if(!$tag) {
			abort(404);
		}
		return view('guest.tags.show',compact('tag'));
	}
}
