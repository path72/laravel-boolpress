<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name','description','slug'];

	/**
	 * ! Tag<MN>Post !
	 * 
	 * Ogni Tag appartiene a molti Post
	 * >>> posts() plurale
	 */
	public function posts()
	{
		/**
		 * se la pivot table si chiamasse tag_post
		 * return $this->belongsToMany('App\Post');
		 */ 
		return $this->belongsToMany('App\Post', 'tags_posts');
	}
}
