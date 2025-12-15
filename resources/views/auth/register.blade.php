<x-auth-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Username -->
        <div>
            <x-input-label for="name" :value="('Username')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Nama Lengkap -->
        <div class="mt-4">
            <x-input-label for="full_name" :value="('Nama Lengkap')" />
            <x-text-input id="full_name" class="block mt-1 w-full" type="text" name="full_name" 
                          :value="old('full_name')" required />
            <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- No. Telepon -->
        <div class="mt-4">
            <x-input-label for="phone" :value="('No. Telepon')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" 
                          :value="old('phone')" placeholder="08123456789" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>
        
        <!-- Tanggal Lahir -->
        <div class="mt-4">
            <x-input-label for="date_birth" :value="('Tanggal Lahir')" />
            <x-text-input id="date_birth" class="block mt-1 w-full" type="date" name="date_birth" 
                          :value="old('date_birth')" />
            <x-input-error :messages="$errors->get('date_birth')" class="mt-2" />
        </div>

        <!-- Jenis Kelamin -->
        <div class="mt-4">
            <x-input-label for="gender" :value="('Jenis Kelamin')" />
            <select id="gender" name="gender" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-center mt-4">
            <x-primary-button class="ms-4">
                {{ __('Simpan') }}
            </x-primary-button>
        </div>

        <div class="flex items-center justify-center mt-4 text-sm">
            <span class="text-gray-600">Sudah Punya Akun?</span>
            <a class="underline text-sm text-[#2C9DDE] hover:text-[#1b7fb8] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ms-2" href="{{ route('login') }}">
                {{ __('Masuk') }}
        </div>
    </form>
</x-auth-layout>