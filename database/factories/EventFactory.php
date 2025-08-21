<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('now', '+6 months');
        $endDate = $this->faker->dateTimeBetween($startDate, $startDate->format('Y-m-d H:i:s') . ' +7 days');
        
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(3),
            'location' => $this->faker->address,
            'special_start_date' => $startDate,
            'special_end_date' => $endDate,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'capacity' => $this->faker->numberBetween(50, 1000),
            'ticket_price' => $this->faker->randomFloat(2, 10, 500),
            'user_id' => User::factory(),
        ];
    }
    
    /**
     * Indicate that the event is a conference.
     */
    public function conference(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Tech Conference ' . $this->faker->year,
            'description' => 'A comprehensive technology conference featuring industry leaders and cutting-edge innovations.',
            'capacity' => $this->faker->numberBetween(200, 500),
            'ticket_price' => $this->faker->randomFloat(2, 100, 300),
        ]);
    }
    
    /**
     * Indicate that the event is a workshop.
     */
    public function workshop(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => $this->faker->words(2, true) . ' Workshop',
            'description' => 'An interactive workshop designed to provide hands-on learning experience.',
            'capacity' => $this->faker->numberBetween(20, 100),
            'ticket_price' => $this->faker->randomFloat(2, 50, 150),
        ]);
    }
    
    /**
     * Indicate that the event is a concert.
     */
    public function concert(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => $this->faker->name . ' Live Concert',
            'description' => 'An unforgettable live music experience featuring amazing performances.',
            'capacity' => $this->faker->numberBetween(500, 2000),
            'ticket_price' => $this->faker->randomFloat(2, 25, 200),
        ]);
    }
}
