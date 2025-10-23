<aside class="w-64 bg-blue-900 text-white min-h-screen flex flex-col fixed top-0 left-0">
    <!-- Logo -->
    <div class="flex items-center gap-3 px-5 py-4 border-b border-blue-800">
        <img src="{{ asset('images/logo.png') }}" class="w-10 h-10" alt="Logo">
        <span class="text-2xl font-semibold">Jastiperly</span>
    </div>

    <!-- Menu Navigasi -->
    <nav class="flex-1 px-3 py-6 space-y-1">
        <a href="{{ route('superadmin.dashboard') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('superadmin.dashboard') ? 'bg-blue-700' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h7v7H3V3zm0 11h7v7H3v-7zm11-11h7v7h-7V3zm0 11h7v7h-7v-7z" />
            </svg>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('superadmin.dashboard') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('superadmin.dashboard') ? 'bg-blue-700' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h7v7H3V3zm0 11h7v7H3v-7zm11-11h7v7h-7V3zm0 11h7v7h-7v-7z" />
            </svg>
            <span>Manajemen Pelanggan</span>
        </a>
        
        <a href="{{ route('superadmin.dashboard') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('superadmin.dashboard') ? 'bg-blue-700' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h7v7H3V3zm0 11h7v7H3v-7zm11-11h7v7h-7V3zm0 11h7v7h-7v-7z" />
            </svg>
            <span>Transaksi</span>
        </a>

        <a href="{{ route('superadmin.dashboard') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('superadmin.dashboard') ? 'bg-blue-700' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h7v7H3V3zm0 11h7v7H3v-7zm11-11h7v7h-7V3zm0 11h7v7h-7v-7z" />
            </svg>
            <span>Manajemen Produk</span>
        </a>

        <a href="{{ route('superadmin.dashboard') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('superadmin.dashboard') ? 'bg-blue-700' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h7v7H3V3zm0 11h7v7H3v-7zm11-11h7v7h-7V3zm0 11h7v7h-7v-7z" />
            </svg>
            <span>Pengaturan</span>
        </a>
    </nav>

    <!-- Footer -->
    <div class="px-4 py-3 text-sm border-t border-blue-800 text-gray-300">
        © 2025 Jastiperly
    </div>
</aside>
