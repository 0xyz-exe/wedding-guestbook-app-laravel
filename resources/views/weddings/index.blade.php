<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-serif italic font-bold text-2xl text-stone-900 leading-tight">
                {{ __('My Wedding Invitations & Guestbooks') }}
            </h2>
            <a href="{{ route('weddings.create') }}" class="px-4 py-2 bg-pink-600 text-white rounded-lg text-sm font-semibold hover:bg-pink-700 transition shadow">
                + Create Wedding Event
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($weddings as $wedding)
                    <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm p-6 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start">
                                <span class="px-3 py-1 bg-pink-50 text-pink-700 border border-pink-200 rounded-full text-xs font-serif font-bold">
                                    Wedding Event
                                </span>
                                <div class="flex gap-2">
                                    <a href="{{ route('weddings.edit', $wedding) }}" class="text-xs font-semibold text-stone-600 hover:text-stone-900">Edit</a>
                                    <form method="POST" action="{{ route('weddings.destroy', $wedding) }}" class="inline" onsubmit="return confirm('Delete this wedding event and all entries?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-semibold text-rose-500 hover:text-rose-700">Delete</button>
                                    </form>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h3 class="text-2xl font-serif italic font-bold text-stone-900">{{ $wedding->couple_title }}</h3>
                                <p class="text-xs text-stone-500 mt-1">{{ $wedding->event_date->format('l, F d, Y') }} at {{ $wedding->event_time }}</p>
                                <p class="text-xs text-stone-600 font-medium mt-1">{{ $wedding->venue_name }}</p>
                            </div>

                            <div class="mt-4 p-4 rounded-2xl bg-stone-50 border border-stone-100 grid grid-cols-3 gap-2 text-center text-xs">
                                <div>
                                    <span class="text-stone-400">Total Wishes</span>
                                    <p class="font-bold text-stone-900 text-sm mt-0.5">{{ $wedding->guestbook_entries_count }}</p>
                                </div>
                                <div>
                                    <span class="text-stone-400">Expected Pax</span>
                                    <p class="font-bold text-indigo-600 text-sm mt-0.5">{{ $wedding->total_pax }}</p>
                                </div>
                                <div>
                                    <span class="text-stone-400">Checked In</span>
                                    <p class="font-bold text-emerald-600 text-sm mt-0.5">{{ $wedding->confirmed_pax }}</p>
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-t text-xs">
                                <span class="text-stone-400">Public RSVP URL:</span>
                                <a href="{{ route('wedding.public', $wedding->slug) }}" target="_blank" class="block font-mono text-pink-600 hover:underline truncate mt-0.5">
                                    {{ route('wedding.public', $wedding->slug) }}
                                </a>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t flex justify-between items-center">
                            <a href="{{ route('weddings.export-csv', $wedding) }}" class="text-xs font-bold text-stone-700 hover:underline">
                                &darr; Download CSV
                            </a>
                            <a href="{{ route('weddings.show', $wedding) }}" class="px-4 py-2 bg-stone-900 text-white rounded-xl text-xs font-bold hover:bg-stone-800 transition">
                                Guest Manifest &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 bg-white p-8 rounded-3xl text-center text-stone-400">
                        No wedding events created yet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
