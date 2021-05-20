<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
	/**
	 * All categories
	 */
    public function index() {
		$categories = Category::All();
		return view('guest.categories.index',compact('categories'));
	}

	/**
	 * Selected Category
	 */
    public function show($slug) {
		$category = Category::where('slug',$slug)->first();
		if(!$category) {
			abort(404);
		}
		return view('guest.categories.show',compact('category'));
	}
}
