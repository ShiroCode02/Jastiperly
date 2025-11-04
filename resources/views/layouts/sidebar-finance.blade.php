<aside class="fixed top-0 left-0 h-screen w-[312px] bg-[#2643A7] text-white flex flex-col justify-start shadow-lg">
   <!-- Header / Logo -->
    <div class="flex items-center gap-4 px-7 py-6 pl-10">
        <!-- Logo di kiri -->
        <img src="{{ asset('images/finance/logo.svg') }}" 
            alt="Logo" 
            class="w-[50px] h-[50px] object-contain">

        <!-- Teks di kanan logo -->
        <div class="flex flex-col leading-tight">
            <h1 class="text-4xl font-bold">Finance</h1>
            <span class="text-3xl text-blue-100 -mt-2">Jastiperly</span>
        </div>
    </div>
    
    <div>
        <!-- Menu Navigasi -->
       <nav class="px-7 py-6">
            @php
                $menus = [
                    ['name' => 'Dashboard', 'icon' => 'financedashboard.svg', 'route' => 'finance.dashboard'],
                    ['name' => 'Transaksi', 'icon' => 'financetransaksi.svg'],
                    ['name' => 'Traveler', 'icon' => 'financetraveler.svg'],
                    ['name' => 'Penitip', 'icon' => 'financepenitip.svg'],
                    ['name' => 'Refund', 'icon' => 'financerefund.svg'],
                    ['name' => 'Pengaturan', 'icon' => 'financerefund.svg'],
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
                            
                            <!-- Ikon di kiri -->
                            <img src="{{ asset('icons/' . $menu['icon']) }}"
                                 alt="{{ $menu['name'] }}"
                                 class="w-[20px] h-[20px] object-contain 
                                 {{ request()->routeIs($menu['route'] ?? '') 
                                    ? 'filter invert brightness-0' 
                                    : 'filter brightness-0 invert-0 group-hover:brightness-0 group-hover:invert' }}">
                            
                            <!-- Teks -->
                            <span class="text-[15px] font-semibold">{{ $menu['name'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>

    <!-- Tombol Logout -->
    <div class="px-5 pb-6 mt-auto">
        <a href="{{ route('logout') }}" 
        class="group flex items-center gap-3 text-white hover:text-blue-200 transition-all">
            <!-- Ikon Logout -->
            <img src="{{ asset('financelogout.svg') }}" 
                alt="Logout Icon" 
                class="w-[20px] h-[20px] object-contain transition duration-200 
                        group-hover:brightness-0 group-hover:invert group-hover:opacity-90">
            
            <!-- Teks Logout -->
            <span class="font-semibold text-[15px] transition duration-200">
                Logout
            </span>
        </a>
    </div>
</aside>