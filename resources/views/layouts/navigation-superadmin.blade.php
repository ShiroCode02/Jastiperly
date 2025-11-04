@php
    // Daftar halaman yang BUTUH search bar
    $pagesWithSearch = [
        'superadmin.users',
        'superadmin.products',
        'superadmin.transactions',
        'superadmin.refunds',
    ];

    // Cek apakah halaman saat ini butuh search
    $showSearch = in_array(request()->route()->getName(), $pagesWithSearch);

    // Cek apakah ini halaman detail produk
    $isProductDetail = request()->route()->getName() === 'superadmin.products' && request('product_id');
@endphp

<nav class="flex items-center justify-between h-[78px] border border-[rgba(142,142,147,0.5)] shadow-sm px-6 rounded-xl" style="background-color: transparent;">
    <!-- Kiri: Judul Halaman -->
    @if(!$isProductDetail)
        <div class="flex items-center space-x-2">
            <h1 class="text-[35px] font-semibold text-gray-800 tracking-wide">
                {{ $title }}
            </h1>
        </div>
    @else
        <div></div> <!-- Kosongkan kiri -->
    @endif

    <!-- Kanan: Profil User -->
    <div class="flex items-center space-x-4">
        <!-- SEARCH BAR – Hanya di halaman tertentu -->
        @if($showSearch && !$isProductDetail)
            <div class="relative mr-6">
                <form action="{{ route(request()->route()->getName()) }}" method="GET" class="flex items-center">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari nama, email, ID..." 
                           class="w-64 pl-10 pr-4 py-1.5 bg-white/70 border border-blue-300 rounded-md text-sm 
                                  focus:outline-none focus:ring-2 focus:ring-blue-400 shadow-sm backdrop-blur-sm">
                    
                    <!-- Ikon kaca pembesar -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                         class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-blue-600 pointer-events-none">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>

                    <!-- Hidden input untuk tab (jika ada) -->
                    @if(request('tab'))
                        <input type="hidden" name="tab" value="{{ request('tab') }}">
                    @endif
                </form>
            </div>
        @endif

        <!-- Profil -->
        <div class="flex items-center space-x-4">
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
    </div>
</nav>