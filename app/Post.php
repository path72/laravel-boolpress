<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{	
	protected $fillable = ['title','content','slug','user_id'];

	/**
	 * ! Post<N1>User !
	 * 
	 * Ogni Post appartiene a 1 User
	 * >>> user() singolare
	 */
	public function user()
	{
		return $this->belongsTo('App\User');
	}

	/**
	 * ! Post<N1>Category !
	 * 
	 * Ogni Post appartiene a 1 Category
	 * >>> category() singolare
	 */
	public function category()
	{
		return $this->belongsTo('App\Category');
	}
}
