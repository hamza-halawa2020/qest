<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Qest>
 */
class QestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory()->create()->id,
            'user_id' => User::factory()->create()->id,
            'product_name' => $this->faker->text(),
            'normal_price' => $this->faker->randomFloat(2, 10, 100), // Adjust the range as needed
            'price_with_extra' => $this->faker->randomFloat(2, 10, 100), // Adjust the range as needed
            'notes' => $this->faker->text(),
        ];
    }
}
