<?php

namespace App\Http\Controllers;

use App\Models\GuestbookEntry;
use App\Models\WeddingEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicGuestbookController extends Controller
{
    public function show(string $slug): View
    {
        $wedding = WeddingEvent::where('slug', $slug)->firstOrFail();
        $entries = $wedding->guestbookEntries()->latest()->paginate(10);

        return view('public.guestbook', compact('wedding', 'entries'));
    }

    public function store(Request $request, string $slug): RedirectResponse
    {
        $wedding = WeddingEvent::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'guest_name' => ['required', 'string', 'max:255'],
            'guest_email' => ['nullable', 'email', 'max:255'],
            'relationship' => ['required', 'string', 'in:Family,Friend,Colleague,Relative,Other'],
            'attendance_status' => ['required', 'in:attending,declined,tentative'],
            'pax_count' => ['required', 'integer', 'min:1', 'max:10'],
            'wishes_message' => ['required', 'string', 'max:2000'],
        ]);

        $wedding->guestbookEntries()->create($validated);

        return redirect()->route('wedding.public', $slug)
            ->with('status', 'Thank you! Your RSVP and wishes have been posted to the guestbook.');
    }
}
