<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-serif italic font-bold text-2xl text-stone-900 leading-tight">
                {{ __('Wedding Management Dashboard') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('weddings.create') }}" class="px-4 py-2 bg-pink-600 text-white rounded-lg text-sm font-semibold hover:bg-pink-700 transition shadow">
                    + Create Wedding
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

            <!-- High-Level Metrics -->
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-2xl border border-stone-200/80 shadow-sm">
                    <p class="text-xs font-semibold text-stone-400 uppercase tracking-wider">Events Managed</p>
                    <p class="text-3xl font-extrabold text-stone-900 mt-2 font-serif">{{ $weddings->count() }}</p>
                    <p class="text-xs text-stone-400 font-medium mt-1">Active wedding guestbooks</p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-stone-200/80 shadow-sm">
                    <p class="text-xs font-semibold text-stone-400 uppercase tracking-wider">Total Wishes</p>
                    <p class="text-3xl font-extrabold text-pink-600 mt-2 font-serif">{{ $totalWishes }}</p>
                    <p class="text-xs text-stone-400 font-medium mt-1">Heartfelt guest greetings</p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-stone-200/80 shadow-sm">
                    <p class="text-xs font-semibold text-stone-400 uppercase tracking-wider">Expected Headcount</p>
                    <p class="text-3xl font-extrabold text-indigo-600 mt-2 font-serif">{{ $totalPax }} pax</p>
                    <p class="text-xs text-emerald-600 font-medium mt-1">{{ $totalAttending }} RSVPs attending</p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-stone-200/80 shadow-sm">
                    <p class="text-xs font-semibold text-stone-400 uppercase tracking-wider">Checked In At Door</p>
                    <p class="text-3xl font-extrabold text-emerald-600 mt-2 font-serif">{{ $confirmedPax }} pax</p>
                    <p class="text-xs text-stone-400 font-medium mt-1">Confirmed reception arrivals</p>
                </div>
            </div>

            <!-- Content Split: Weddings List & Recent Wishes Stream -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- My Weddings -->
                <div class="lg:col-span-2 bg-white rounded-2xl border border-stone-200/80 shadow-sm p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-base font-serif font-bold text-stone-900">Active Wedding Events</h3>
                        <a href="{{ route('weddings.index') }}" class="text-xs font-semibold text-pink-600 hover:text-pink-800">
                            All Events &rarr;
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse($weddings as $w)
                            <div class="p-5 rounded-2xl border border-stone-200 bg-stone-50/50 flex flex-col md:flex-row justify-between md:items-center gap-4">
                                <div>
                                    <h4 class="font-serif italic font-bold text-xl text-stone-900">
                                        {{ $w->couple_title }}
                                    </h4>
                                    <p class="text-xs text-stone-500 mt-1">
                                        {{ $w->event_date->format('l, F d, Y') }} &bull; {{ $w->event_time }} &bull; {{ $w->venue_name }}
                                    </p>
                                    <div class="mt-2 flex items-center gap-2">
                                        <a href="{{ route('wedding.public', $w->slug) }}" target="_blank" class="font-mono text-xs text-pink-600 hover:underline">
                                            {{ route('wedding.public', $w->slug) }}
                                        </a>
                                        <span class="text-xs text-stone-300">&bull;</span>
                                        <span class="text-xs font-bold text-stone-600">{{ $w->guestbook_entries_count ?? $w->guestbookEntries->count() }} wishes</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('weddings.export-csv', $w) }}" class="px-3 py-1.5 bg-white border border-stone-300 text-stone-700 rounded-lg text-xs font-semibold hover:bg-stone-50">
                                        Export CSV
                                    </a>
                                    <a href="{{ route('weddings.show', $w) }}" class="px-4 py-2 bg-pink-600 text-white rounded-lg text-xs font-bold hover:bg-pink-700 transition">
                                        Manage & Check-in &rarr;
                                    </a>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-stone-400 italic py-6 text-center">No wedding events registered yet.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Wishes Feed -->
                <div class="bg-white rounded-2xl border border-stone-200/80 shadow-sm p-6 space-y-4">
                    <h3 class="text-base font-serif font-bold text-stone-900">Latest Guest Wishes</h3>
                    <div class="space-y-3">
                        @forelse($recentEntries as $entry)
                            <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-100 text-xs space-y-1.5">
                                <div class="flex justify-between items-start font-bold">
                                    <span class="text-stone-900">{{ $entry->guest_name }}</span>
                                    @if($entry->attendance_status === 'attending')
                                        <span class="px-2 py-0.5 rounded text-[10px] bg-emerald-50 text-emerald-700 font-semibold">Attending ({{ $entry->pax_count }})</span>
                                    @elseif($entry->attendance_status === 'declined')
                                        <span class="px-2 py-0.5 rounded text-[10px] bg-stone-100 text-stone-500 font-semibold">Declined</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[10px] bg-amber-50 text-amber-700 font-semibold">Tentative</span>
                                    @endif
                                </div>
                                <p class="text-stone-600 font-light italic">"{{ $entry->wishes_message }}"</p>
                                <div class="pt-1 flex justify-between text-[10px] text-stone-400">
                                    <span>{{ $entry->relationship }}</span>
                                    <span>{{ $entry->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-stone-400 italic py-6 text-center">No guest wishes submitted yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
