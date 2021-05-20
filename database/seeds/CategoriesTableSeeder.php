<?php

use Illuminate\Database\Seeder;
// # AUX tools #
use App\Category;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i<10; $i++) {
			$new_category = new Category();
			$new_category['name'] = $faker->sentence(rand(1,3));

			// slug deve essere unico
			$slug = Str::slug($new_category->name,'-');
			$slug_tmp = $slug;
			$slug_is_present = Category::where('slug',$slug)->first();
			$counter = 1;
			while ($slug_is_present) {
				$slug = $slug_tmp.'-'.$counter;
				$counter++;
				$slug_is_present = Category::where('slug',$slug)->first();
			}

			$new_category['slug'] = $slug;
			$new_category->save(); // ! DB writing here ! 
		}
    }
}
