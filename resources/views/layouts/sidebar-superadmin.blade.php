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

<aside id="main-sidebar"
       class="fixed top-0 left-0 h-screen text-white z-30 
              transition-all duration-300
              w-[97px]   <!-- default closed -->
              overflow-hidden">

    <!-- Lapisan Depan: Biru tua (statis) -->
    <div class="absolute inset-0 w-[97px] bg-[#000957] z-20"></div>

    <!-- Lapisan Belakang: Biru muda dan teks (dinamis) -->
    <div id="sidebar-content" class="absolute inset-0 flex -translate-x-full transition-all duration-300 z-10">
        <div class="w-[97px]"></div>
        <div class="flex-1 bg-[#344CB7] flex flex-col">
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
                                    {{ request()->routeIs($menu['route'] . '*') ? 'bg-[#000957] font-semibold rounded-r-full' : 'hover:bg-[#000957]/70 hover:rounded-r-full' }}">
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
    <div class="relative w-[97px] flex flex-col h-full">
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

        <div class="pb-5 px-4 z-30">
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit"
                        class="w-full group flex justify-center py-3 rounded-lg">
                    
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-[25px] h-[25px]
                                stroke-white 
                                group-hover:stroke-[#FFEB00]   <!-- ini yang penting! -->
                                transition-all duration-300 ease-in-out"
                        viewBox="0 0 24 24" fill="none" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>