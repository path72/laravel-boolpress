<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{	
    /**
	 * ! Post<N1>User !
	 * 
	 * 1 Post appartiene a 1 User
	 * >>> user() singolare
	 */
	public function user()
	{
		return $this->belongsTo('App\User');
	}

	protected $fillable = [
		'title',
		'content',
		'slug',
		'user_id'
	];

}
