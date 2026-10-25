<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $wedding->couple_title }} - Wedding Guestbook & RSVP</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=playfair-display:400,600,700,900|figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FAF8F5] text-stone-800 antialiased">
        <div class="min-h-screen">
            <!-- Hero / Invitation Banner -->
            <header class="py-16 px-6 text-center max-w-3xl mx-auto space-y-4">
                <span class="text-xs font-serif tracking-widest text-pink-700 uppercase font-semibold">
                    WEDDING CELEBRATION & GUESTBOOK
                </span>
                <h1 class="text-5xl sm:text-7xl font-serif italic text-stone-900 tracking-tight">
                    {{ $wedding->couple_title }}
                </h1>
                <div class="w-16 h-0.5 bg-pink-400 mx-auto my-4"></div>
                <p class="text-base text-stone-600 font-serif">
                    {{ $wedding->event_date->format('l, F d, Y') }} &bull; {{ $wedding->event_time }}
                </p>
                <p class="text-xs text-stone-500 font-medium">
                    {{ $wedding->venue_name }} &bull; {{ $wedding->venue_address }}
                </p>

                @if($wedding->story)
                    <div class="max-w-xl mx-auto mt-6 p-6 rounded-2xl bg-white/70 border border-stone-200/60 shadow-sm text-sm text-stone-600 font-light italic">
                        "{{ $wedding->story }}"
                    </div>
                @endif
            </header>

            <main class="max-w-5xl mx-auto px-6 pb-20 space-y-12">
                @if (session('status'))
                    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-center text-sm font-semibold shadow-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Split: RSVP Form & Wishes Feed -->
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 items-start">
                    <!-- RSVP & Wishes Submission Form -->
                    <div class="lg:col-span-2 bg-white rounded-3xl border border-stone-200 shadow-sm p-6 sm:p-8 space-y-6">
                        <div>
                            <span class="text-xs font-serif uppercase tracking-widest text-pink-600 font-bold">RSVP & BLESSINGS</span>
                            <h2 class="text-2xl font-serif text-stone-900 mt-1">Sign the Guestbook</h2>
                            <p class="text-xs text-stone-500 mt-1">Let the couple know you are attending and share your warm wishes.</p>
                        </div>

                        <form method="POST" action="{{ route('wedding.public.store', $wedding->slug) }}" class="space-y-4">
                            @csrf

                            <div>
                                <label class="block text-xs font-semibold text-stone-700 uppercase">Your Name *</label>
                                <input type="text" name="guest_name" required placeholder="Full Name" class="mt-1 w-full text-sm rounded-xl border-stone-300">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-stone-700 uppercase">Your Email (Optional)</label>
                                <input type="email" name="guest_email" placeholder="name@example.com" class="mt-1 w-full text-sm rounded-xl border-stone-300">
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-stone-700 uppercase">Relationship *</label>
                                    <select name="relationship" required class="mt-1 w-full text-sm rounded-xl border-stone-300">
                                        <option value="Friend">Friend</option>
                                        <option value="Family">Family</option>
                                        <option value="Colleague">Colleague</option>
                                        <option value="Relative">Relative</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-stone-700 uppercase">Headcount (Pax) *</label>
                                    <input type="number" name="pax_count" value="1" min="1" max="10" required class="mt-1 w-full text-sm rounded-xl border-stone-300">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-stone-700 uppercase">Attendance Status *</label>
                                <select name="attendance_status" required class="mt-1 w-full text-sm rounded-xl border-stone-300">
                                    <option value="attending">Yes, I will attend!</option>
                                    <option value="declined">Regretfully decline</option>
                                    <option value="tentative">Still tentative</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-stone-700 uppercase">Your Wishes & Blessings *</label>
                                <textarea name="wishes_message" rows="4" required placeholder="Leave a heartfelt message for the happy couple..." class="mt-1 w-full text-sm rounded-xl border-stone-300"></textarea>
                            </div>

                            <button type="submit" class="w-full py-3.5 bg-pink-600 text-white rounded-xl text-sm font-semibold hover:bg-pink-700 shadow-lg shadow-pink-200 transition">
                                Send Wishes & Submit RSVP
                            </button>
                        </form>
                    </div>

                    <!-- Live Wishes Feed -->
                    <div class="lg:col-span-3 space-y-4">
                        <div class="flex justify-between items-center px-2">
                            <h3 class="text-xl font-serif text-stone-900">Guest Wishes Wall ({{ $entries->total() }})</h3>
                            <span class="text-xs text-stone-400">Live Blessings</span>
                        </div>

                        <div class="space-y-4">
                            @forelse($entries as $entry)
                                <div class="bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm space-y-3">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-bold text-stone-900 text-base">{{ $entry->guest_name }}</h4>
                                            <span class="text-xs text-pink-600 font-medium">{{ $entry->relationship }}</span>
                                        </div>
                                        <div>
                                            @if($entry->attendance_status === 'attending')
                                                <span class="px-2.5 py-1 text-xs rounded-full font-bold bg-emerald-50 text-emerald-700">Attending ({{ $entry->pax_count }})</span>
                                            @elseif($entry->attendance_status === 'declined')
                                                <span class="px-2.5 py-1 text-xs rounded-full font-bold bg-stone-100 text-stone-500">Cannot Attend</span>
                                            @else
                                                <span class="px-2.5 py-1 text-xs rounded-full font-bold bg-amber-50 text-amber-700">Tentative</span>
                                            @endif
                                        </div>
                                    </div>

                                    <p class="text-sm text-stone-700 font-light leading-relaxed whitespace-pre-line italic">
                                        "{{ $entry->wishes_message }}"
                                    </p>

                                    <div class="pt-2 border-t border-stone-100 text-[11px] text-stone-400 flex justify-between">
                                        <span>Sent {{ $entry->created_at->diffForHumans() }}</span>
                                        @if($entry->is_confirmed)
                                            <span class="text-emerald-600 font-semibold">&check; Verified Guest Arrival</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="bg-white p-8 rounded-3xl text-center text-stone-400 text-sm">
                                    Be the first to sign the guestbook and send wishes!
                                </div>
                            @endforelse
                        </div>

                        @if($entries->hasPages())
                            <div class="pt-4">
                                {{ $entries->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
