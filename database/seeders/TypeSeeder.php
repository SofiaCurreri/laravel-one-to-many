<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $labels = ["HTML 5", "CSS 3", "Javascript", "PHP", "GIT"];

        foreach ($labels as $label) {
            $type = new Type();

            $type->label = $label ;
            $type->color = $faker->hexColor();

            $type->save();
        }
    }
}