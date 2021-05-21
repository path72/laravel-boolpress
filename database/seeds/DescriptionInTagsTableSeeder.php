<?php

use App\Tag;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class DescriptionInTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
		$tags = Tag::all();
        foreach ($tags as $tag) {
			$tag['description'] = $faker->paragraphs($faker->numberBetween(2,5), true);
			$tag->update();
		}
    }
}
