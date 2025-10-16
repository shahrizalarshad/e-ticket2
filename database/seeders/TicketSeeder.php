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

        // Option B: Remove generic faker tickets. We will only create realistic tickets linked to demo users.

        // Create specific, realistic tickets for demo users so "My Tickets" shows real data
        $demoUser = \App\Models\User::where('email', 'user@example.com')->first();
        $adminUser = \App\Models\User::where('email', 'admin@example.com')->first();

        // Helper to create a ticket for a specific user and event
        $createForUser = function ($user, $eventName, $buyerName, $buyerEmail, $quantity = 2, $status = 'confirmed') {
            if (!$user) return;
            $event = Event::where('name', $eventName)->first();
            if (!$event) return;
            Ticket::create([
                'event_id' => $event->id,
                'buyer_name' => $buyerName,
                'buyer_email' => $buyerEmail,
                'quantity' => $quantity,
                'status' => $status,
                'user_id' => $user->id,
            ]);
        };

        // Tickets for demo user
        $createForUser($demoUser, 'Laravel Conference 2024', 'Ahmad Farid', 'user@example.com', 2, 'confirmed');
        $createForUser($demoUser, 'DevFest Malaysia 2025', 'Nur Aisyah', 'user@example.com', 1, 'pending');
        $createForUser($demoUser, 'Johor Tech Meetup', 'John Tan', 'user@example.com', 3, 'confirmed');

        // Tickets for admin user
        $createForUser($adminUser, 'Coldplay: Music of the Spheres – Kuala Lumpur', 'Michael Lim', 'admin@example.com', 4, 'confirmed');
        $createForUser($adminUser, 'Penang Food Festival', 'Siti Amina', 'admin@example.com', 2, 'cancelled');
    }
}
