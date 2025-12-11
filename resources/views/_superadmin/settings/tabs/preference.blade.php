@php
    $user = $user ?? auth()->user();
@endphp

<form action="{{ url()->current() }}?tab=preferensi" method="POST" class="space-y-6">
    @csrf

    <div class="grid grid-cols-2 gap-8 pb-8">
        <label class="block text-xl font-bold text-[#000957]">{{ __('messages.language') }}</label>
        <select name="language" class="border rounded px-3 py-2 bg-[#EAF3FF]">
            <option value="id" {{ old('language', $user->preference['language'] ?? '') === 'id' ? 'selected' : '' }}>{{ __('messages.indonesian') }}</option>
            <option value="en" {{ old('language', $user->preference['language'] ?? '') === 'en' ? 'selected' : '' }}>{{ __('messages.english') }}</option>
        </select>
    </div>

    <div class="pt-2 pb-8">
        <button type="submit" class="bg-[#FFEB00] hover:bg-[#FF5E1F] text-black font-bold px-16 py-1 rounded shadow">
            {{ __('messages.save') }}
        </button>
    </div>
</form>
