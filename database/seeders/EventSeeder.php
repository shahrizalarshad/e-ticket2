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
        // Option B: Keep only curated, realistic events. Remove factory-generated samples.

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

        // Realistic example events
        Event::create([
            'name' => 'Coldplay: Music of the Spheres – Kuala Lumpur',
            'description' => 'Experience Coldplay live with an immersive stadium concert in Kuala Lumpur.',
            'location' => 'Bukit Jalil National Stadium, Kuala Lumpur',
            'special_start_date' => now()->addDays(60),
            'special_end_date' => now()->addDays(61),
            'start_date' => now()->addDays(60),
            'end_date' => now()->addDays(60)->addHours(3),
            'capacity' => 60000,
            'ticket_price' => 299.00,
            'user_id' => $user->id,
        ]);

        Event::create([
            'name' => 'DevFest Malaysia 2025',
            'description' => 'A full-day developer festival featuring talks, workshops, and networking with the tech community.',
            'location' => 'KL Convention Centre, Kuala Lumpur',
            'special_start_date' => now()->addDays(15),
            'special_end_date' => now()->addDays(16),
            'start_date' => now()->addDays(15),
            'end_date' => now()->addDays(15)->addHours(8),
            'capacity' => 1200,
            'ticket_price' => 49.00,
            'user_id' => $user->id,
        ]);

        Event::create([
            'name' => 'KL Marathon 2025',
            'description' => 'Malaysia’s premier marathon event across the heart of Kuala Lumpur. Choose your category and run with the city.',
            'location' => 'Dataran Merdeka, Kuala Lumpur',
            'special_start_date' => now()->addDays(90),
            'special_end_date' => now()->addDays(91),
            'start_date' => now()->addDays(90),
            'end_date' => now()->addDays(90)->addHours(6),
            'capacity' => 15000,
            'ticket_price' => 120.00,
            'user_id' => $user->id,
        ]);

        Event::create([
            'name' => 'Penang Food Festival',
            'description' => 'A celebration of Penang’s world-famous street food and culinary heritage.',
            'location' => 'George Town, Penang',
            'special_start_date' => now()->addDays(40),
            'special_end_date' => now()->addDays(42),
            'start_date' => now()->addDays(40),
            'end_date' => now()->addDays(42),
            'capacity' => 5000,
            'ticket_price' => 20.00,
            'user_id' => $user->id,
        ]);

        Event::create([
            'name' => 'Johor Tech Meetup',
            'description' => 'A casual meetup for developers and tech enthusiasts in Johor Bahru. Lightning talks and networking.',
            'location' => 'Johor Bahru, Johor',
            'special_start_date' => now()->addDays(10),
            'special_end_date' => now()->addDays(10)->addHours(3),
            'start_date' => now()->addDays(10),
            'end_date' => now()->addDays(10)->addHours(3),
            'capacity' => 200,
            'ticket_price' => 0.00,
            'user_id' => $user->id,
        ]);
    }
}
