<aside class="fixed top-0 left-0 h-screen w-[312px] text-white z-30">
    <!-- Lapisan dua warna -->
    <div class="absolute inset-0 flex">
        <div class="w-[97px] bg-[#0A0E5C]"></div>
        <div class="flex-1 bg-[#1E2EB8]"></div>
    </div>

    <!-- Konten Sidebar -->
    <div class="relative flex flex-col h-full">
        <!-- Logo -->
        <div class="flex items-center gap-6 px-6 py-5">
            <img src="{{ asset('images/logo.svg') }}" alt="Logo Jastiperly" class="w-[70px] h-[70px]">
            <span class="text-[40px] font-bold">Jastiperly</span>
        </div>

        <!-- Menu Navigasi -->
        <nav class="flex-1 py-6 overflow-y-auto">
            @php
                $menus = [
                    ['name' => 'Dashboard', 'icon' => 'dashboard.svg', 'route' => 'superadmin.dashboard'],
                    ['name' => 'Manajemen Pengguna', 'icon' => 'users.svg'],
                    ['name' => 'Manajemen Produk', 'icon' => 'product.svg'],
                    ['name' => 'Transaksi', 'icon' => 'transaction.svg'],
                    ['name' => 'Refund', 'icon' => 'refund.svg'],
                    ['name' => 'Pengaturan', 'icon' => 'settings.svg'],
                ];
            @endphp

            <ul class="space-y-1">
                @foreach ($menus as $menu)
                    <li>
                        <a href="{{ isset($menu['route']) ? route($menu['route']) : '#' }}"
                           class="group flex items-center gap-6 px-5 py-3 rounded-lg transition-all duration-200 
                                  {{ request()->routeIs($menu['route'] ?? '') ? 'bg-[#0A0E5C] font-semibold rounded-r-full' : 'hover:bg-[#0A0E5C]/70 hover:rounded-r-full' }}">
                            
                            <!-- Kolom ikon (fixed width) -->
                            <div class="w-[60px] flex justify-center">
                                <img src="{{ asset('icons/' . $menu['icon']) }}" 
                                     alt="{{ $menu['name'] }}" 
                                     class="w-[20px] h-[20px] filter brightness-0 invert group-hover:opacity-90">
                            </div>
                            
                            <!-- Kolom teks -->
                            <span class="flex-1 text-[17px] font-bold tracking-wide text-gray-100 group-hover:text-white">
                                {{ $menu['name'] }}
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</aside>