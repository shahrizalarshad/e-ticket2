<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some sample events using the factory
        Event::factory()->count(5)->create();
        
        // Create specific event types
        Event::factory()->conference()->count(2)->create();
        Event::factory()->workshop()->count(3)->create();
        Event::factory()->concert()->count(2)->create();
        
        // Create a specific featured event
        $user = User::first() ?? User::factory()->create();
        
        Event::create([
            'name' => 'Laravel Conference 2024',
            'description' => 'Join us for the biggest Laravel conference of the year! Learn from industry experts, network with fellow developers, and discover the latest trends in web development.',
            'location' => 'Kuala Lumpur Convention Centre, Malaysia',
            'special_start_date' => now()->addDays(30),
            'special_end_date' => now()->addDays(32),
            'start_date' => now()->addDays(30),
            'end_date' => now()->addDays(32),
            'capacity' => 500,
            'ticket_price' => 299.99,
            'user_id' => $user->id,
        ]);
    }
}
