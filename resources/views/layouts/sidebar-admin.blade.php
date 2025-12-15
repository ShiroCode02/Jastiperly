<aside class="fixed top-0 left-0 w-[312px] text-white min-h-screen flex flex-col z-30" style="background: #344CB7;">
    <!-- Logo -->
    <div class="flex items-center gap-3 px-5 py-4 border-b border-blue-800">
        <img src="{{ asset('images/logo.png') }}" class="w-10 h-10" alt="Logo">
        <span class="text-2xl font-semibold">Jastiperly</span>
    </div>

    <!-- Menu Navigasi -->
    <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
        @php
            $adminMenus = [
                [
                    'name' => 'Dashboard',
                    'route' => 'admin.dashboard',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h7v7H3V3zm0 11h7v7H3v-7zm11-11h7v7h-7V3zm0 11h7v7h-7v-7z" /></svg>'
                ],
                [
                    'name' => 'Manajemen Pelanggan',
                    'route' => 'admin.users',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>'
                ],
                [
                    'name' => 'Transaksi',
                    # 'route' => 'admin.transactions',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>'
                ],
                [
                    'name' => 'Manajemen Produk',
                    # 'route' => 'admin.products',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0v6a2 2 0 01-2 2H6a2 2 0 01-2-2V7m16 0v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7" /></svg>'
                ],
                [
                    'name' => 'Pengaturan',
                    # 'route' => 'admin.settings',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37 1 .608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>'
                ],
            ];
        @endphp

        @foreach ($adminMenus as $menu)
            <a href="{{ isset($menu['route']) && Route::has($menu['route']) ? route($menu['route']) : '#' }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs($menu['route'] ?? '') ? 'bg-blue-700' : '' }}">
                {!! $menu['icon'] !!}
                <span>{{ $menu['name'] }}</span>
            </a>
        @endforeach
    </nav>

    <!-- Footer -->
    <div class="px-4 py-3 text-sm border-t border-blue-800 text-gray-300">
        © {{ date('Y') }} Jastiperly
    </div>
</aside>