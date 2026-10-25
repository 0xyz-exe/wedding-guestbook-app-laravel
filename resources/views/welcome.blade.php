<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'EverAfter') }} - Elegant Wedding Guestbook & RSVP</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=playfair-display:400,600,700|figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-[#FAF8F5] text-stone-800">
        <div class="min-h-screen flex flex-col justify-between">
            <header class="max-w-7xl w-full mx-auto px-6 py-6 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center text-pink-600 shadow-sm border border-pink-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span class="text-2xl font-serif italic font-bold text-stone-900 tracking-tight">EverAfter</span>
                </div>
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-stone-900 text-white rounded-full text-sm font-semibold hover:bg-stone-800 transition shadow">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-stone-700 hover:text-pink-600 transition">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2.5 bg-pink-600 text-white rounded-full text-sm font-semibold hover:bg-pink-700 transition shadow">Host an Event</a>
                        @endif
                    @endauth
                </div>
            </header>

            <main class="max-w-7xl mx-auto px-6 py-12 flex-1 flex flex-col justify-center">
                <div class="text-center max-w-3xl mx-auto space-y-6">
                    <span class="px-4 py-1.5 bg-pink-50 border border-pink-200 text-pink-700 rounded-full text-xs font-semibold uppercase tracking-widest font-serif">
                        Digital RSVP & Keepsake Guestbook
                    </span>
                    <h1 class="text-4xl sm:text-6xl font-serif font-normal text-stone-900 tracking-tight leading-tight">
                        Cherish Every Warm Wish & Seamlessly Manage Guests
                    </h1>
                    <p class="text-lg text-stone-600 leading-relaxed font-light">
                        A digital wedding invitation and live guestbook. Let family & friends send heartfelt blessings, confirm headcount attendance, and check in on your special day.
                    </p>
                    <div class="flex flex-wrap justify-center gap-4 pt-4">
                        <a href="{{ url('/invite/olivia-and-liam') }}" class="px-6 py-3.5 bg-pink-600 text-white rounded-full font-semibold shadow-lg shadow-pink-200 hover:bg-pink-700 transition">
                            View Demo Guestbook &rarr;
                        </a>
                        @auth
                            <a href="{{ route('dashboard') }}" class="px-6 py-3.5 bg-stone-900 text-white rounded-full font-semibold shadow-lg hover:bg-stone-800 transition">
                                Organizer Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-6 py-3.5 bg-white border border-stone-300 text-stone-800 rounded-full font-semibold hover:bg-stone-50 transition">
                                Demo Login
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-16 text-stone-700">
                    <div class="bg-white p-8 rounded-3xl border border-stone-200/80 shadow-sm text-center">
                        <div class="w-12 h-12 bg-pink-50 text-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-serif font-bold text-stone-900 mb-2">Public RSVP Portal</h3>
                        <p class="text-sm text-stone-500 font-light">Custom branded link for guests to RSVP their attendance status (Attending, Declined, Tentative) with guest headcount.</p>
                    </div>

                    <div class="bg-white p-8 rounded-3xl border border-stone-200/80 shadow-sm text-center">
                        <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                        <h3 class="text-xl font-serif font-bold text-stone-900 mb-2">Live Wishes Wall</h3>
                        <p class="text-sm text-stone-500 font-light">Friends & loved ones leave heartfelt blessings and memories in a chronological interactive social stream.</p>
                    </div>

                    <div class="bg-white p-8 rounded-3xl border border-stone-200/80 shadow-sm text-center">
                        <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-serif font-bold text-stone-900 mb-2">Reception Check-in & CSV</h3>
                        <p class="text-sm text-stone-500 font-light">Hosts can toggle guest attendance check-in status at the front desk and export the complete manifest to CSV spreadsheet.</p>
                    </div>
                </div>
            </main>

            <footer class="max-w-7xl w-full mx-auto px-6 py-6 border-t border-stone-200 text-center text-xs text-stone-400">
                EverAfter &bull; Laravel 13 &bull; SQLite &bull; Breeze &bull; Tailwind CSS
            </footer>
        </div>
    </body>
</html>
