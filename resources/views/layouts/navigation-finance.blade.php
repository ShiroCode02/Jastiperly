@props(['title' => 'Dashboard'])

<nav class="flex items-center justify-between h-[78px] border border-[rgba(142,142,147,0.5)] shadow-sm px-6 rounded-xl" style="background-color: #FFFFFF;">
    <!-- Kiri: Judul Halaman -->
    <div class="flex items-center space-x-2">
        <h1 class="text-[35px] font-semibold text-gray-800 tracking-wide">
            {{ $title }}
        </h1>
    </div>

    <!-- Kanan: Profil User -->
    <div class="flex items-center space-x-4">
        <!-- Notifikasi (opsional, tetap dikomentari seperti aslinya) -->
        {{-- <button class="text-gray-500 hover:text-gray-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
        </button> --}}

        <!-- Profil -->
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="flex items-center gap-2 text-gray-700 focus:outline-none">
                    <span class="font-medium text-[20px] text-gray-800">{{ Auth::user()->name }}</span>
                    <img src="{{ asset('images/profile.jpg') }}" alt="Profile" class="w-[50px] h-[50px] rounded-full border">
                    <svg class="fill-current h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</nav>