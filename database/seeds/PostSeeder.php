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
        for ($i=0; $i<30; $i++) {
			$new_post = new Post();
			$new_post['title'] 	 = $faker->sentence(rand(2,6));
			$new_post['content'] = $faker->paragraphs($faker->numberBetween(5,20),true);

			// slug deve essere unico
			$slug = Str::slug($new_post->title,'-');
			$slug_tmp = $slug;
			$slug_is_present = Post::where('slug',$slug)->first();
			$counter = 1;
			while ($slug_is_present) {
				$slug = $slug_tmp.'-'.$counter;
				$counter++;
				$slug_is_present = Post::where('slug',$slug)->first();
			}

			$new_post['slug'] 	 = $slug;
			$new_post['user_id'] = 1;
			$new_post->save(); // ! DB writing here ! 
		}
    }
}
