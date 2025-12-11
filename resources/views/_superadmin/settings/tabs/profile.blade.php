@php
    $user = $user ?? auth()->user();
@endphp

<form action="{{ url()->current() }}?tab=profil" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-base font-semibold text-[#000957] mb-2">{{ __('messages.username') }}</label>
            <input name="username" value="{{ old('username', $user->name ?? '') }}" class="w-full border rounded px-3 py-2" />
            @error('username')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block text-base font-semibold text-[#000957] mb-2">{{ __('messages.email') }}</label>
            <input name="email" value="{{ old('email', $user->email ?? '') }}" class="w-full border rounded px-3 py-2" />
            @error('email')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block text-base font-semibold text-[#000957] mb-2">{{ __('messages.full_name') }}</label>
            <input name="full_name" value="{{ old('full_name', $user->detail->name ?? '') }}" class="w-full border rounded px-3 py-2" />
            @error('full_name')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block text-base font-semibold text-[#000957] mb-2">{{ __('messages.phone') }}</label>
            <input name="phone" value="{{ old('phone', $user->detail->phone ?? '') }}" class="w-full border rounded px-3 py-2" />
            @error('phone')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block text-base font-semibold text-[#000957] mb-2">{{ __('messages.gender') }}</label>
            <select name="gender" class="w-full border rounded px-3 py-2">
                <option value="">{{ __('messages.choose') }}</option>
                <option value="Laki-laki" {{ (old('gender', $user->detail->gender ?? '') === 'Laki-laki') ? 'selected' : '' }}>{{ __('messages.male') }}</option>
                <option value="Perempuan" {{ (old('gender', $user->detail->gender ?? '') === 'Perempuan') ? 'selected' : '' }}>{{ __('messages.female') }}</option>
                @error('gender')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </select>
        </div>

        <div>
            <label class="block text-base font-semibold text-[#000957] mb-2">{{ __('messages.address') }}</label>
            <textarea name="address" class="w-full border rounded px-3 py-2" rows="3">{{ old('address', $user->detail->address ?? '') }}</textarea>
            @error('address')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="flex justify-left pt-2 pb-8">
        <button type="submit" class="bg-[#FFEB00] hover:bg-[#FF5E1F] text-black font-bold px-16 py-1 rounded shadow">
            {{ __('messages.save') }}
        </button>
    </div>
</form>
