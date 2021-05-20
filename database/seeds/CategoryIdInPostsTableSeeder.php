<?php

use Illuminate\Database\Seeder;
// # AUX tools #
use App\Post;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class CategoryIdInPostsTableSeeder extends Seeder
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
			$post['category_id'] = $faker->numberBetween(1,10);
			$post->update();
		}
    }
}
