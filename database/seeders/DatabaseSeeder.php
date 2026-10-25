<?php

namespace Database\Seeders;

use App\Models\GuestbookEntry;
use App\Models\User;
use App\Models\WeddingEvent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Users
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        $testUser = User::create([
            'name' => 'Olivia & Liam',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // 2. Wedding Event
        $wedding = WeddingEvent::create([
            'user_id' => $testUser->id,
            'bride_name' => 'Olivia Vance',
            'groom_name' => 'Liam Hayes',
            'slug' => 'olivia-and-liam',
            'event_date' => now()->addDays(20)->toDateString(),
            'event_time' => '11:00 AM - 4:00 PM',
            'venue_name' => 'The Conservatory at Presidio',
            'venue_address' => 'Montgomery St, San Francisco, CA 94129',
            'story' => 'We met seven years ago on a rainy Tuesday in Seattle over spilled coffee and mutual love for architectural photography. We cannot wait to celebrate this new chapter surrounded by the people who mean the most to us.',
        ]);

        // 3. Seed Guestbook Entries
        GuestbookEntry::create([
            'wedding_event_id' => $wedding->id,
            'guest_name' => 'Sophia & Lucas Martinez',
            'guest_email' => 'sophia.m@example.com',
            'relationship' => 'Friend',
            'attendance_status' => 'attending',
            'pax_count' => 2,
            'wishes_message' => 'So thrilled for you both! Watching your journey together has been an absolute joy. See you on the dance floor!',
            'is_confirmed' => true,
            'created_at' => now()->subDays(5),
        ]);

        GuestbookEntry::create([
            'wedding_event_id' => $wedding->id,
            'guest_name' => 'Uncle Robert Vance',
            'guest_email' => 'robert.v@example.com',
            'relationship' => 'Family',
            'attendance_status' => 'attending',
            'pax_count' => 3,
            'wishes_message' => 'Wishing my wonderful niece Olivia and Liam a lifetime of laughter, mutual patience, and endless adventure. The whole Vance clan will be there!',
            'is_confirmed' => false,
            'created_at' => now()->subDays(4),
        ]);

        GuestbookEntry::create([
            'wedding_event_id' => $wedding->id,
            'guest_name' => 'David Miller',
            'guest_email' => 'david.miller@example.com',
            'relationship' => 'Colleague',
            'attendance_status' => 'attending',
            'pax_count' => 1,
            'wishes_message' => 'Congratulations Liam! Honored to celebrate your big day with you.',
            'is_confirmed' => true,
            'created_at' => now()->subDays(3),
        ]);

        GuestbookEntry::create([
            'wedding_event_id' => $wedding->id,
            'guest_name' => 'Emma Watson',
            'guest_email' => 'emma.w@example.com',
            'relationship' => 'Friend',
            'attendance_status' => 'declined',
            'pax_count' => 1,
            'wishes_message' => 'So heartbroken to miss this due to international work travel, but sending all my deepest love and congratulations from London!',
            'is_confirmed' => false,
            'created_at' => now()->subDays(2),
        ]);
    }
}
