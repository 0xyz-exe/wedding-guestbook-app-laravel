<?php

namespace App\Http\Controllers;

use App\Models\GuestbookEntry;
use App\Models\WeddingEvent;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $user = auth()->user();

        $weddings = $user->isAdmin() ? WeddingEvent::latest()->get() : $user->weddingEvents()->latest()->get();
        $weddingIds = $weddings->pluck('id');

        $totalWishes = GuestbookEntry::whereIn('wedding_event_id', $weddingIds)->count();
        $totalAttending = GuestbookEntry::whereIn('wedding_event_id', $weddingIds)->where('attendance_status', 'attending')->count();
        $totalPax = GuestbookEntry::whereIn('wedding_event_id', $weddingIds)->where('attendance_status', 'attending')->sum('pax_count');
        $confirmedPax = GuestbookEntry::whereIn('wedding_event_id', $weddingIds)->where('is_confirmed', true)->sum('pax_count');

        $recentEntries = GuestbookEntry::whereIn('wedding_event_id', $weddingIds)
            ->with('weddingEvent')
            ->latest()
            ->take(6)
            ->get();

        return view('dashboard', compact(
            'weddings',
            'totalWishes',
            'totalAttending',
            'totalPax',
            'confirmedPax',
            'recentEntries'
        ));
    }
}
