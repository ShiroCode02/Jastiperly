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
    $isProductDetail = request()->route()->getName() === 'superadmin.products.detail' && request('product_id');

    // Cek apakah ini halaman detail transaksi
    $isTransactionDetail = request()->route()->getName() === 'superadmin.transactions.show' && request('transaction');

    // Cek apakah ini halaman edit transaksi
    $isEditTransaction = request()->route()->getName() === 'superadmin.transactions.edit';

    // Cek apakah ini halaman detail refund
    $isRefundDetail = request()->route()->getName() === 'superadmin.refunds.show' && request('refund');
    
    // Gabungkan semua kondisi detail
    $isAnyDetail = $isProductDetail || $isTransactionDetail || $isRefundDetail || $isEditTransaction;
@endphp

<nav class="flex items-center justify-between h-[78px] border border-[rgba(142,142,147,0.5)] shadow-sm px-6 rounded-xl" style="background-color: transparent;">
    <!-- Kiri: Judul Halaman (HILANG DI DETAIL) -->
    @if(!$isAnyDetail)
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
        <!-- SEARCH BAR – Hanya di halaman tertentu & BUKAN DETAIL -->
        @if($showSearch && !$isAnyDetail)
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

                    <!-- Hidden input untuk tab -->
                    @if(request('tab'))
                        <input type="hidden" name="tab" value="{{ request('tab') }}">
                    @endif

                    <!-- Transaksi Filter -->
                    <input type="hidden" name="type" value="{{ request('type', 'buy') }}">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    @if(request('location'))
                        <input type="hidden" name="location" value="{{ request('location') }}">
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
                        <img src="{{ Auth::user()->profile_image_url }}" 
                            alt="Foto Profil {{ Auth::user()->name }}"
                            class="w-[50px] h-[50px] rounded-full">
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('superadmin.settings')">
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