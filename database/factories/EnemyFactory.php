<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enemy>
 */
class EnemyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'health' => $this->faker->numberBetween(60, 200),
            'damage' => $this->faker->numberBetween(1, 10),
            'loot' => $this->faker->numberBetween(1, 50),
            'location_id' => Location::factory()->create(),
        ];
    }
}
