@php
    $user = $user ?? auth()->user();
@endphp

<form action="{{ url()->current() }}?tab=profil" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-base font-semibold text-[#000957] mb-2">Username</label>
            <input name="username" value="{{ old('username', $user->detail->name ?? '') }}" class="w-full border rounded px-3 py-2" />
        </div>

        <div>
            <label class="block text-base font-semibold text-[#000957] mb-2">Email</label>
            <input name="email" value="{{ old('email', $user->email ?? '') }}" class="w-full border rounded px-3 py-2" />
        </div>

        <div>
            <label class="block text-base font-semibold text-[#000957] mb-2">Nama Lengkap</label>
            <input name="full_name" value="{{ old('full_name', $user->name ?? '') }}" class="w-full border rounded px-3 py-2" />
        </div>

        <div>
            <label class="block text-base font-semibold text-[#000957] mb-2">Telepon</label>
            <input name="phone" value="{{ old('phone', $user->detail->phone ?? '') }}" class="w-full border rounded px-3 py-2" />
        </div>

        <div>
            <label class="block text-base font-semibold text-[#000957] mb-2">Jenis Kelamin</label>
            <select name="gender" class="w-full border rounded px-3 py-2">
                <option value="">Pilih</option>
                <option value="Laki-laki" {{ (old('gender', $user->detail->gender ?? '') === 'Laki-laki') ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ (old('gender', $user->detail->gender ?? '') === 'Perempuan') ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div>
            <label class="block text-base font-semibold text-[#000957] mb-2">Alamat</label>
            <textarea name="address" class="w-full border rounded px-3 py-2" rows="3">{{ old('address', $user->detail->address ?? '') }}</textarea>
        </div>
    </div>

    <div class="flex justify-left pt-2">
        <button type="submit" class="bg-[#FFEB00] hover:bg-[#FF5E1F] text-black font-bold px-16 py-1 rounded shadow">
            Simpan
        </button>
    </div>
    <div class="text-right text-gray-500 text-sm pt-2 pb-4">
        {{-- show last updated info if available --}}
        @if(isset($user->updated_at))
            Terakhir diperbarui: {{ $user->updated_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
        @endif
    </div>
</form>
