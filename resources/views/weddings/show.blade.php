<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
            <div>
                <h2 class="font-serif italic font-bold text-2xl text-stone-900 leading-tight">
                    {{ $wedding->couple_title }}
                </h2>
                <p class="text-xs text-stone-500 mt-1">
                    {{ $wedding->event_date->format('l, F d, Y') }} &bull; {{ $wedding->venue_name }}
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('wedding.public', $wedding->slug) }}" target="_blank" class="px-3 py-1.5 bg-pink-50 border border-pink-200 text-pink-700 rounded-lg text-xs font-semibold hover:bg-pink-100">
                    Public Wall &rarr;
                </a>
                <a href="{{ route('weddings.export-csv', $wedding) }}" class="px-3 py-1.5 bg-emerald-600 text-white rounded-lg text-xs font-semibold hover:bg-emerald-700 shadow-sm">
                    &darr; Export CSV
                </a>
                <a href="{{ route('weddings.edit', $wedding) }}" class="px-3 py-1.5 bg-stone-800 text-white rounded-lg text-xs font-semibold hover:bg-stone-700">
                    Edit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Quick RSVP Summary Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-2xl border border-stone-200/80 shadow-sm text-center">
                    <span class="text-xs text-stone-400 uppercase font-semibold">Total Wishes</span>
                    <p class="text-2xl font-serif font-bold text-stone-900 mt-1">{{ $wedding->guestbookEntries->count() }}</p>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-stone-200/80 shadow-sm text-center">
                    <span class="text-xs text-stone-400 uppercase font-semibold">Attending RSVP</span>
                    <p class="text-2xl font-serif font-bold text-emerald-600 mt-1">{{ $wedding->attending_count }}</p>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-stone-200/80 shadow-sm text-center">
                    <span class="text-xs text-stone-400 uppercase font-semibold">Expected Pax</span>
                    <p class="text-2xl font-serif font-bold text-indigo-600 mt-1">{{ $wedding->total_pax }}</p>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-stone-200/80 shadow-sm text-center">
                    <span class="text-xs text-stone-400 uppercase font-semibold">Checked In (Door)</span>
                    <p class="text-2xl font-serif font-bold text-pink-600 mt-1">{{ $wedding->confirmed_pax }}</p>
                </div>
            </div>

            <!-- Guest Manifest Table -->
            <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-stone-100 flex justify-between items-center">
                    <h3 class="font-serif font-bold text-lg text-stone-900">Guest List & Attendance Check-in</h3>
                    <span class="text-xs text-stone-400">Click Check-in to confirm door arrival</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-stone-400 uppercase bg-stone-50 border-b border-stone-100">
                            <tr>
                                <th class="px-6 py-3">Guest Name</th>
                                <th class="px-6 py-3">Relationship</th>
                                <th class="px-6 py-3">RSVP Status</th>
                                <th class="px-6 py-3">Headcount</th>
                                <th class="px-6 py-3">Wishes / Message</th>
                                <th class="px-6 py-3 text-center">Door Check-In</th>
                                <th class="px-6 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @forelse($entries as $entry)
                                <tr class="hover:bg-stone-50/50 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-stone-900">{{ $entry->guest_name }}</div>
                                        <div class="text-xs text-stone-400">{{ $entry->guest_email ?: 'No email' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-xs font-medium text-stone-600">
                                        {{ $entry->relationship }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($entry->attendance_status === 'attending')
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">Attending</span>
                                        @elseif($entry->attendance_status === 'declined')
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-stone-100 text-stone-500">Declined</span>
                                        @else
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700">Tentative</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-bold text-stone-800">
                                        {{ $entry->pax_count }} pax
                                    </td>
                                    <td class="px-6 py-4 text-xs text-stone-600 max-w-xs">
                                        <p class="italic truncate">"{{ $entry->wishes_message }}"</p>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <form method="POST" action="{{ route('entries.toggle-confirm', $entry) }}">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 rounded-full text-xs font-bold transition {{ $entry->is_confirmed ? 'bg-emerald-600 text-white shadow-sm' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                                                {{ $entry->is_confirmed ? 'Checked In' : 'Not Checked In' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <form method="POST" action="{{ route('entries.destroy', $entry) }}" class="inline" onsubmit="return confirm('Delete this guest entry?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-500 hover:text-rose-700 font-semibold text-xs">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-stone-400">
                                        No RSVP entries yet. Share your invitation link with guests!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($entries->hasPages())
                    <div class="px-6 py-4 border-t border-stone-100">
                        {{ $entries->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
