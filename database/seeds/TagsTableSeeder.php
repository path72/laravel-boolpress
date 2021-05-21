<?php

use Illuminate\Database\Seeder;
// # AUX tools #
use App\Tag;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i<15; $i++) {
			$new_tag = new Tag();
			$new_tag['name'] = $faker->sentence(rand(1,3));

			// slug deve essere unico
			$slug = Str::slug($new_tag->name,'-');
			$slug_tmp = $slug;
			$slug_is_present = Tag::where('slug',$slug)->first();
			$counter = 1;
			while ($slug_is_present) {
				$slug = $slug_tmp.'-'.$counter;
				$counter++;
				$slug_is_present = Tag::where('slug',$slug)->first();
			}

			$new_tag['slug'] = $slug;
			$new_tag->save(); // ! DB writing here ! 
		}
    }
}
