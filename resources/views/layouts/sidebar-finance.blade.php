<aside class="fixed top-0 left-0 h-screen w-[312px] bg-[#2643A7] text-white flex flex-col justify-between shadow-lg">
    <!-- Header / Logo -->
    <div class="flex flex-col items-center py-6 border-b border-blue-800">
        <img src="{{ asset('images/LogoSidebar.png') }}" alt="Logo" class="w-12 h-12 mb-2">
        <h1 class="text-xl font-bold leading-tight">Finance</h1>
        <span class="text-sm text-blue-100 -mt-1">Jastiperly</span>
    </div>

    <div>
        <!-- Menu Navigasi -->
        <nav class="mt-5 space-y-2 px-5">
            @php
                $menus = [
                    ['name' => 'Dashboard', 'icon' => 'dashboard.svg', 'route' => 'finance.dashboard'],
                    ['name' => 'Transaksi', 'icon' => 'transaction.svg'],
                    ['name' => 'Traveler', 'icon' => 'traveler.svg'],
                    ['name' => 'Penitip', 'icon' => 'penitip.svg'],
                    ['name' => 'Refund', 'icon' => 'refund.svg'],
                    ['name' => 'Pengaturan', 'icon' => 'settings.svg'],
                ];
            @endphp

            <ul class="space-y-2">
                @foreach ($menus as $menu)
                    <li>
                        <a href="{{ isset($menu['route']) ? route($menu['route']) : '#' }}"
                           class="group flex items-center gap-3 px-4 py-2.5 rounded-md font-medium transition-all duration-200 
                           {{ request()->routeIs($menu['route'] ?? '') 
                                ? 'bg-[#0A0E5C] text-white' 
                                : 'bg-white text-[#1E3A8A] hover:bg-blue-100' }}">
                            <img src="{{ asset('icons/' . $menu['icon']) }}"
                                 alt="{{ $menu['name'] }}"
                                 class="w-[20px] h-[20px] filter {{ request()->routeIs($menu['route'] ?? '') ? 'invert brightness-0' : '' }}">
                            <span class="text-[15px] font-semibold">{{ $menu['name'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>

    <!-- Tombol Logout -->
    <div class="px-5 pb-6">
        <a href="#" class="flex items-center gap-2 text-white hover:text-blue-200 transition-all">
            <img src="{{ asset('icons/logout.svg') }}" class="w-[20px] h-[20px]" alt="Logout">
            <span class="font-semibold">Logout</span>
        </a>
    </div>
</aside>