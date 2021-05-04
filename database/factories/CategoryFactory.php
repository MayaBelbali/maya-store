<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        $name = $this->faker->unique()->words(2,true);
        return [
            'name' => $name ,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence,
            'image' => asset('assets/test/'.random_int(1,15).'.jpg'),
            'featured' => random_int(0,1)
        ];
    }
}
