<?php

use App\Category;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class DescriptionInCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
		$categories = Category::all();
        foreach ($categories as $category) {
			$category['description'] = $faker->paragraphs($faker->numberBetween(2,5), true);
			$category->update();
		}
    }
}
