<?php

namespace App\Http\Controllers;

use App\Models\GuestbookEntry;
use App\Models\WeddingEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GuestbookEntryController extends Controller
{
    public function toggleConfirm(GuestbookEntry $entry): RedirectResponse
    {
        $this->authorizeAccess($entry->weddingEvent);

        $entry->update([
            'is_confirmed' => !$entry->is_confirmed,
        ]);

        $status = $entry->is_confirmed ? 'marked as present/confirmed' : 'unmarked';

        return back()->with('status', "Guest {$entry->guest_name} {$status}.");
    }

    public function destroy(GuestbookEntry $entry): RedirectResponse
    {
        $this->authorizeAccess($entry->weddingEvent);

        $entry->delete();

        return back()->with('status', 'Guestbook entry deleted.');
    }

    public function exportCsv(WeddingEvent $wedding): StreamedResponse
    {
        $this->authorizeAccess($wedding);

        $fileName = "guestbook-{$wedding->slug}-" . now()->format('Ymd') . ".csv";

        return response()->streamDownload(function () use ($wedding) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Guest Name', 'Email', 'Relationship', 'RSVP Status', 'Pax', 'Attendance Checked In', 'Wishes / Message', 'Submitted At']);

            $wedding->guestbookEntries()->orderBy('created_at')->chunk(100, function ($entries) use ($handle) {
                foreach ($entries as $e) {
                    fputcsv($handle, [
                        $e->id,
                        $e->guest_name,
                        $e->guest_email ?: 'N/A',
                        $e->relationship,
                        strtoupper($e->attendance_status),
                        $e->pax_count,
                        $e->is_confirmed ? 'YES' : 'NO',
                        $e->wishes_message,
                        $e->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ]);
    }

    private function authorizeAccess(WeddingEvent $wedding): void
    {
        if ($wedding->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }
    }
}
