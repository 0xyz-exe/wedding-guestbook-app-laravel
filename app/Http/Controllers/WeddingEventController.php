<?php

namespace App\Http\Controllers;

use App\Models\WeddingEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class WeddingEventController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $weddings = $user->isAdmin() ? WeddingEvent::withCount('guestbookEntries')->latest()->get() : $user->weddingEvents()->withCount('guestbookEntries')->latest()->get();

        return view('weddings.index', compact('weddings'));
    }

    public function create(): View
    {
        return view('weddings.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'bride_name' => ['required', 'string', 'max:255'],
            'groom_name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'alpha_dash', 'max:100', 'unique:wedding_events,slug'],
            'event_date' => ['required', 'date'],
            'event_time' => ['required', 'string', 'max:50'],
            'venue_name' => ['required', 'string', 'max:255'],
            'venue_address' => ['nullable', 'string', 'max:500'],
            'story' => ['nullable', 'string', 'max:2000'],
        ]);

        if (empty($validated['slug'])) {
            $baseSlug = Str::slug("{$validated['bride_name']}-and-{$validated['groom_name']}");
            $slug = $baseSlug;
            $count = 1;
            while (WeddingEvent::where('slug', $slug)->exists()) {
                $slug = "{$baseSlug}-{$count}";
                $count++;
            }
            $validated['slug'] = $slug;
        }

        $wedding = auth()->user()->weddingEvents()->create($validated);

        return redirect()->route('weddings.show', $wedding)->with('status', 'Wedding invitation page & guestbook created.');
    }

    public function show(WeddingEvent $wedding): View
    {
        $this->authorizeAccess($wedding);

        $entries = $wedding->guestbookEntries()->latest()->paginate(15);

        return view('weddings.show', compact('wedding', 'entries'));
    }

    public function edit(WeddingEvent $wedding): View
    {
        $this->authorizeAccess($wedding);

        return view('weddings.edit', compact('wedding'));
    }

    public function update(Request $request, WeddingEvent $wedding): RedirectResponse
    {
        $this->authorizeAccess($wedding);

        $validated = $request->validate([
            'bride_name' => ['required', 'string', 'max:255'],
            'groom_name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'alpha_dash', 'max:100', 'unique:wedding_events,slug,' . $wedding->id],
            'event_date' => ['required', 'date'],
            'event_time' => ['required', 'string', 'max:50'],
            'venue_name' => ['required', 'string', 'max:255'],
            'venue_address' => ['nullable', 'string', 'max:500'],
            'story' => ['nullable', 'string', 'max:2000'],
        ]);

        $wedding->update($validated);

        return redirect()->route('weddings.show', $wedding)->with('status', 'Wedding details updated.');
    }

    public function destroy(WeddingEvent $wedding): RedirectResponse
    {
        $this->authorizeAccess($wedding);

        $wedding->delete();

        return redirect()->route('weddings.index')->with('status', 'Wedding event deleted.');
    }

    private function authorizeAccess(WeddingEvent $wedding): void
    {
        if ($wedding->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }
    }
}
