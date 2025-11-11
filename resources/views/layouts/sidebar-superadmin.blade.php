@php
    // Menu Superadmin
    $menus = [
        ['name' => 'Dashboard', 'icon' => 'superadmin/dashboard.svg', 'route' => 'superadmin.dashboard'],
        ['name' => 'Manajemen Pengguna', 'icon' => 'superadmin/users.svg', 'route' => 'superadmin.users'],
        ['name' => 'Manajemen Produk', 'icon' => 'superadmin/product.svg', 'route' => 'superadmin.products'],
        ['name' => 'Transaksi', 'icon' => 'superadmin/transaction.svg', 'route' => 'superadmin.transactions'],
        ['name' => 'Refund', 'icon' => 'superadmin/refund.svg' , 'route' => 'superadmin.refunds'],
        ['name' => 'Pengaturan', 'icon' => 'superadmin/settings.svg', 'route' => 'superadmin.settings'],
    ];
@endphp

<aside class="fixed top-0 left-0 h-screen w-[312px] text-white z-30">
    <!-- Lapisan Depan: Biru tua (statis) -->
    <div class="absolute inset-0 w-[97px] bg-[#0A0E5C] z-20"></div>

    <!-- Lapisan Belakang: Biru muda dan teks (dinamis) -->
    <div id="sidebar-content" class="absolute inset-0 flex -translate-x-full transition-all duration-300 z-10">
        <div class="w-[97px]"></div>
        <div class="flex-1 bg-[#1E2EB8] flex flex-col">
            <div class="flex items-center gap-6 px-6 py-5">
                <div class="w-[60px]"></div>
                <span id="logo-text" class="text-[40px] font-bold transition-all duration-300 opacity-100 translate-x-0">Jastiperly</span>
            </div>
            <nav class="flex-1 overflow-y-auto">
                <ul class="space-y-1">
                    @foreach ($menus as $menu)
                        <li>
                            <a href="{{ isset($menu['route']) ? route($menu['route']) : '#' }}"
                            class="group flex items-center gap-6 px-5 py-3 rounded-lg transition-all duration-200 
                                    {{ request()->routeIs($menu['route'] . '*') ? 'bg-[#0A0E5C] font-semibold rounded-r-full' : 'hover:bg-[#0A0E5C]/70 hover:rounded-r-full' }}">
                                <div class="w-[60px]"></div>
                                <span class="menu-text flex-1 text-[17px] font-bold tracking-wide text-gray-100 group-hover:text-white transition-all duration-300 opacity-100 translate-x-0">
                                    {{ $menu['name'] }}
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>

    <!-- Konten Sidebar Statis: Logo dan Ikon -->
    <div class="relative flex flex-col h-full">
        <div class="flex items-center px-6 py-5 z-30">
            <div id="toggle-sidebar" class="w-[70px] cursor-pointer">
                <img src="{{ asset('images/superadmin/logo.svg') }}" alt="Logo Jastiperly" class="w-[60px] h-[60px]">
            </div>
            <div class="flex-1"></div>
        </div>
        <nav class="flex-1 overflow-y-auto">
            <div id="icon-content" class="w-[97px] flex justify-center">
                <ul class="space-y-1 w-full">
                    @foreach ($menus as $menu)
                        <li>
                            <a href="{{ isset($menu['route']) ? route($menu['route']) : '#' }}"
                               class="group flex items-center py-3 rounded-lg transition-all duration-200 
                                    {{ request()->routeIs($menu['route'] . '*') ? 'bg-[#0A0E5C] font-semibold' : 'hover:bg-[#FFFFFF]/20' }}">
                                <div class="w-[97px] flex justify-center z-30">
                                    <img src="{{ asset('icons/' . $menu['icon']) }}" 
                                        alt="{{ $menu['name'] }}" 
                                        class="w-[25px] h-[25px] filter brightness-0 invert group-hover:opacity-90">
                                </div>
                                <div class="flex-1"></div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </nav>
    </div>
</aside>