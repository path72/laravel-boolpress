<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','slug',];

	/**
	 * ! Category<1N>Post !
	 * 
	 * Ogni Category ha molti Post
	 * >>> posts() plurale
	 */
	public function posts()
	{
		return $this->hasMany('App\Post');
	}

}
