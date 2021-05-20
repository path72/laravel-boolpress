<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','slug',];

	/**
	 * ! Category<1N>Post !
	 * 
	 * 1 Categoty ha molti Post
	 * >>> user() singolare
	 */
	public function posts()
	{
		return $this->hasMany('App\Post');
	}

}
