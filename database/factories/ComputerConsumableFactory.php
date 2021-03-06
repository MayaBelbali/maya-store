<?php

namespace Database\Factories;

use App\Models\ComputerConsumable;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComputerConsumableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ComputerConsumable::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2,true),
            'category_id' => random_int(1,10)
        ];
    }
}
