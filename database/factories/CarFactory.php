<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    private static $models = ['Toyota Prado'=>2000, 'Lanos'=>500, 'Corrola'=>1000, 'Nissan Juke'=>1500];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomKey = array_rand(self::$models);
        return [
            'model'=>$randomKey,
            'price'=>self::$models[$randomKey],
            'image' => $this->faker->imageUrl(640, 480, 'cars', true, $randomKey)
        ];
    }
}
