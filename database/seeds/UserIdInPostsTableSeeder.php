<?php

use Illuminate\Database\Seeder;
use App\Post;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class UserIdInPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
		$posts = Post::all();
        foreach ($posts as $post) {
			$post['user_id'] = $faker->numberBetween(1,5);
			$post->update();
		}
    }
}
