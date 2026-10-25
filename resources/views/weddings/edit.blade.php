<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif italic font-bold text-2xl text-stone-900 leading-tight">
            {{ __('Edit: ') }} {{ $wedding->couple_title }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm p-6 sm:p-8">
                <form method="POST" action="{{ route('weddings.update', $wedding) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-stone-700 uppercase">Bride's Name *</label>
                            <input type="text" name="bride_name" value="{{ old('bride_name', $wedding->bride_name) }}" required class="mt-1 w-full text-sm rounded-xl border-stone-300">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-stone-700 uppercase">Groom's Name *</label>
                            <input type="text" name="groom_name" value="{{ old('groom_name', $wedding->groom_name) }}" required class="mt-1 w-full text-sm rounded-xl border-stone-300">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-stone-700 uppercase">Invitation Slug *</label>
                        <div class="mt-1 flex rounded-xl shadow-sm">
                            <span class="inline-flex items-center px-3 rounded-l-xl border border-r-0 border-stone-300 bg-stone-50 text-stone-500 text-xs font-mono">
                                {{ url('/invite') }}/
                            </span>
                            <input type="text" name="slug" value="{{ old('slug', $wedding->slug) }}" required class="flex-1 block w-full rounded-none rounded-r-xl text-sm border-stone-300 font-mono">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-stone-700 uppercase">Date of Wedding *</label>
                            <input type="date" name="event_date" value="{{ old('event_date', $wedding->event_date->format('Y-m-d')) }}" required class="mt-1 w-full text-sm rounded-xl border-stone-300">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-stone-700 uppercase">Time *</label>
                            <input type="text" name="event_time" value="{{ old('event_time', $wedding->event_time) }}" required class="mt-1 w-full text-sm rounded-xl border-stone-300">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-stone-700 uppercase">Venue Name *</label>
                        <input type="text" name="venue_name" value="{{ old('venue_name', $wedding->venue_name) }}" required class="mt-1 w-full text-sm rounded-xl border-stone-300">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-stone-700 uppercase">Venue Address</label>
                        <input type="text" name="venue_address" value="{{ old('venue_address', $wedding->venue_address) }}" class="mt-1 w-full text-sm rounded-xl border-stone-300">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-stone-700 uppercase">Love Story / Notes for Guests</label>
                        <textarea name="story" rows="3" class="mt-1 w-full text-sm rounded-xl border-stone-300">{{ old('story', $wedding->story) }}</textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <a href="{{ route('weddings.show', $wedding) }}" class="px-5 py-2.5 bg-stone-100 text-stone-700 rounded-xl text-sm font-semibold hover:bg-stone-200">Cancel</a>
                        <button type="submit" class="px-6 py-2.5 bg-stone-900 text-white rounded-xl text-sm font-semibold hover:bg-stone-800">Update Invitation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
