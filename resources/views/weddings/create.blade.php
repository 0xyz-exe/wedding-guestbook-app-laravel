<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif italic font-bold text-2xl text-stone-900 leading-tight">
            {{ __('Create Wedding Event & Invitation') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm p-6 sm:p-8">
                <form method="POST" action="{{ route('weddings.store') }}" class="space-y-6">
                    @csrf

                    @if ($errors->any())
                        <div class="p-4 bg-rose-50 text-rose-800 rounded-lg text-sm">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-stone-700 uppercase">Bride's Name *</label>
                            <input type="text" name="bride_name" value="{{ old('bride_name') }}" required placeholder="e.g. Olivia Vance" class="mt-1 w-full text-sm rounded-xl border-stone-300">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-stone-700 uppercase">Groom's Name *</label>
                            <input type="text" name="groom_name" value="{{ old('groom_name') }}" required placeholder="e.g. Liam Hayes" class="mt-1 w-full text-sm rounded-xl border-stone-300">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-stone-700 uppercase">Custom Invitation Slug (Optional)</label>
                        <div class="mt-1 flex rounded-xl shadow-sm">
                            <span class="inline-flex items-center px-3 rounded-l-xl border border-r-0 border-stone-300 bg-stone-50 text-stone-500 text-xs font-mono">
                                {{ url('/invite') }}/
                            </span>
                            <input type="text" name="slug" value="{{ old('slug') }}" placeholder="olivia-and-liam" class="flex-1 block w-full rounded-none rounded-r-xl text-sm border-stone-300 font-mono">
                        </div>
                        <p class="text-xs text-stone-400 mt-1">Leave empty to auto-generate from couple names.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-stone-700 uppercase">Date of Wedding *</label>
                            <input type="date" name="event_date" value="{{ old('event_date', date('Y-m-d')) }}" required class="mt-1 w-full text-sm rounded-xl border-stone-300">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-stone-700 uppercase">Time *</label>
                            <input type="text" name="event_time" value="{{ old('event_time', '11:00 AM') }}" required placeholder="e.g. 11:00 AM - 4:00 PM" class="mt-1 w-full text-sm rounded-xl border-stone-300">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-stone-700 uppercase">Venue Name *</label>
                        <input type="text" name="venue_name" value="{{ old('venue_name') }}" required placeholder="e.g. The Glasshouse Gardens, San Francisco" class="mt-1 w-full text-sm rounded-xl border-stone-300">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-stone-700 uppercase">Venue Address</label>
                        <input type="text" name="venue_address" value="{{ old('venue_address') }}" placeholder="124 Botanic Way, SF, CA" class="mt-1 w-full text-sm rounded-xl border-stone-300">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-stone-700 uppercase">Love Story / Notes for Guests</label>
                        <textarea name="story" rows="3" placeholder="Welcome note, dress code, reception agenda..." class="mt-1 w-full text-sm rounded-xl border-stone-300">{{ old('story') }}</textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <a href="{{ route('weddings.index') }}" class="px-5 py-2.5 bg-stone-100 text-stone-700 rounded-xl text-sm font-semibold hover:bg-stone-200">Cancel</a>
                        <button type="submit" class="px-6 py-2.5 bg-pink-600 text-white rounded-xl text-sm font-semibold hover:bg-pink-700 shadow-md shadow-pink-200">Create & Publish</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
