<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Ticket;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all events to create tickets for
        $events = Event::all();
        
        if ($events->isEmpty()) {
            $this->command->warn('No events found. Please run EventSeeder first.');
            return;
        }
        
        // Create tickets for each event
        foreach ($events as $event) {
            // Create 3-8 tickets per event with different statuses
            $ticketCount = rand(3, 8);
            
            for ($i = 0; $i < $ticketCount; $i++) {
                $status = match($i % 3) {
                    0 => 'confirmed',
                    1 => 'pending', 
                    2 => 'canceled',
                };
                
                Ticket::factory()
                    ->for($event)
                    ->{$status}()
                    ->create();
            }
        }
        
        // Create some additional confirmed tickets for the featured event
        $featuredEvent = Event::where('name', 'Laravel Conference 2024')->first();
        if ($featuredEvent) {
            Ticket::factory()
                ->for($featuredEvent)
                ->confirmed()
                ->count(10)
                ->create();
        }
    }
}
