<?php

namespace Tests\Feature;

use App\Models\GuestbookEntry;
use App\Models\User;
use App\Models\WeddingEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeddingGuestbookTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Wedding Management Dashboard');
    }

    public function test_user_can_create_wedding_event(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('weddings.store'), [
            'bride_name' => 'Emma Watson',
            'groom_name' => 'Arthur Pendelton',
            'event_date' => now()->addMonth()->toDateString(),
            'event_time' => '14:00',
            'venue_name' => 'Rosewood Estate',
            'venue_address' => '100 Rosewood Lane',
        ]);

        $wedding = WeddingEvent::where('bride_name', 'Emma Watson')->first();
        $this->assertNotNull($wedding);
        $response->assertRedirect(route('weddings.show', $wedding));

        $this->assertDatabaseHas('wedding_events', [
            'user_id' => $user->id,
            'bride_name' => 'Emma Watson',
            'groom_name' => 'Arthur Pendelton',
        ]);
    }

    public function test_public_guest_can_view_invitation_and_submit_rsvp(): void
    {
        $user = User::factory()->create();
        $wedding = WeddingEvent::create([
            'user_id' => $user->id,
            'bride_name' => 'Sarah',
            'groom_name' => 'Michael',
            'slug' => 'sarah-and-michael',
            'event_date' => now()->addDays(15)->toDateString(),
            'event_time' => '12:00 PM',
            'venue_name' => 'Beachside Pavilion',
        ]);

        // View public guestbook wall
        $response = $this->get('/invite/sarah-and-michael');
        $response->assertStatus(200);
        $response->assertSee('Sarah & Michael');
        $response->assertSee('Sign the Guestbook');

        // Submit RSVP
        $rsvpResponse = $this->post('/invite/sarah-and-michael/rsvp', [
            'guest_name' => 'Uncle Charlie',
            'guest_email' => 'charlie@example.com',
            'relationship' => 'Family',
            'attendance_status' => 'attending',
            'pax_count' => 2,
            'wishes_message' => 'Cannot wait to celebrate with you both!',
        ]);

        $rsvpResponse->assertRedirect('/invite/sarah-and-michael');
        $this->assertDatabaseHas('guestbook_entries', [
            'wedding_event_id' => $wedding->id,
            'guest_name' => 'Uncle Charlie',
            'attendance_status' => 'attending',
            'pax_count' => 2,
        ]);
    }

    public function test_organizer_can_toggle_door_check_in(): void
    {
        $user = User::factory()->create();
        $wedding = WeddingEvent::create([
            'user_id' => $user->id,
            'bride_name' => 'Chloe',
            'groom_name' => 'Daniel',
            'slug' => 'chloe-and-daniel',
            'event_date' => now()->addDays(5)->toDateString(),
            'event_time' => '15:00',
            'venue_name' => 'Grand Ballroom',
        ]);

        $entry = GuestbookEntry::create([
            'wedding_event_id' => $wedding->id,
            'guest_name' => 'Best Man Kevin',
            'relationship' => 'Friend',
            'attendance_status' => 'attending',
            'pax_count' => 1,
            'wishes_message' => 'Cheers to the happy couple!',
            'is_confirmed' => false,
        ]);

        $this->actingAs($user)->post(route('entries.toggle-confirm', $entry));

        $entry->refresh();
        $this->assertTrue($entry->is_confirmed);
    }

    public function test_organizer_can_export_csv(): void
    {
        $user = User::factory()->create();
        $wedding = WeddingEvent::create([
            'user_id' => $user->id,
            'bride_name' => 'Alice',
            'groom_name' => 'Bob',
            'slug' => 'alice-and-bob',
            'event_date' => now()->addDays(10)->toDateString(),
            'event_time' => '10:00 AM',
            'venue_name' => 'Garden Gazebo',
        ]);

        GuestbookEntry::create([
            'wedding_event_id' => $wedding->id,
            'guest_name' => 'Guest One',
            'relationship' => 'Friend',
            'attendance_status' => 'attending',
            'pax_count' => 2,
            'wishes_message' => 'Best wishes!',
        ]);

        $response = $this->actingAs($user)->get(route('weddings.export-csv', $wedding));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
    }
}
