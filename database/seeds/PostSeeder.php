<?php

use Illuminate\Database\Seeder;
// # AUX tools #
use App\Post;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i<10; $i++) {
			$new_post = new Post();
			$new_post['title'] 	 = $faker->sentence(rand(2,6));
			$new_post['content'] = $faker->paragraphs($faker->numberBetween(5,20),true);
			$new_post['slug'] 	 = Str::slug($new_post->title,'-');
			$new_post->save(); // ! DB writing here ! 
		}
    }
}
