<x-auth-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="('Email')" />

            <div class="relative">

                <!-- Icon Email (Feather Icon) -->
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none">
                    <i data-feather="mail" class="w-5 h-5"></i>
                </span>

                <!-- Input -->
                <input id="email"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="username"
                    class="block mt-1 w-full pl-10 pr-3 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md">
                
                <script>feather.replace();</script>
            </div>

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="('Password')" />

            <div class="relative">

                <!-- Icon Gembok (Feather) -->
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none">
                    <i data-feather="lock" class="w-5 h-5"></i>
                </span>

                <input id="password" 
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="current-password"
                    class="block mt-1 w-full pl-10 pr-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md"
                >

                <!-- Toggle Button -->
                <button type="button"
                    onclick="togglePassword()"
                    class="absolute inset-y-0 right-3 flex items-center text-gray-600 hover:text-gray-800">
                    <i id="eyeIcon" data-feather="eye" class="w-5"></i>
                </button>

                <script>feather.replace();</script>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>


        <!-- Lupa Kata Sandi -->
        <div class="block mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-black hover:text-[#2C9DDE] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Lupa Kata Sandi?') }}
                </a>
            @endif
        </div>
        
        <div class="flex items-center justify-center mt-4">
            <x-primary-button class="ms-4">
                {{ __('Masuk') }}
            </x-primary-button>
        </div>

        <div class="flex items-center justify-center mt-4 text-sm">
            <span class="text-gray-600">Belum Punya Akun?</span>
            <a href="{{ route('register') }}"
            class="ml-1 font-semibold text-[#2C9DDE] hover:text-[#1b7fb8]">
                Daftar Disini
            </a>
        </div>
    </form>

    <script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');

        if (input.type === "password") {
            input.type = "text";
            icon.setAttribute('data-feather', 'eye');
        } else {
            input.type = "password";
            icon.setAttribute('data-feather', 'eye-off');
        }
        feather.replace();
    }
    </script>
</x-auth-layout>