<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::create([
            'name' => 'Sample Event',
            'description' => 'This is a sample event description.',
            'location' => 'Kajang, Selangor',
            'special_start_date' => now(),
            'special_end_date' => now()->addDays(1),
            'start_date' => now()->addDays(2),
            'end_date' => now()->addDays(6),
            'capacity' => 30,
            'ticket_price' => 100,
            'user_id' => 1,
        ]);
    }
}
