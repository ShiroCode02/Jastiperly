<x-app-layout>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('layouts.sidebar-superadmin')

        <!-- Area kanan (konten utama) -->
        <div id="main-content" class="flex-1 ml-97 transition-all duration-300 flex flex-col min-h-screen initial-hidden">
            
            <!-- Navbar + Header -->
            <div id="navbar-header" class="fixed top-0 left-97 right-0 z-20 transition-all duration-300 initial-hidden" style="background-color: #DBEDFF; padding: 1rem 1.5rem;">
                @include('layouts.navigation', ['title' => $title])

                <div class="mt-2 flex justify-between items-center">
                    <!-- Tab Navigasi -->
                    <div class="flex gap-3 mt-3">
                        @foreach (['Traveler', 'Penitip', 'Admin', 'Finance'] as $tab)
                            <a href="{{ route(Auth::user()->role === 'superadmin' ? 'superadmin.users' : 'admin.users', ['tab' => $tab]) }}"
                                class="px-6 py-0.5 border border-blue-400 rounded-md text-blue-800 font-medium 
                                        hover:bg-blue-200 transition {{ request('tab') === $tab ? 'bg-[#577BC1] text-white' : 'bg-transparent' }}">
                                {{ $tab }}
                            </a>
                        @endforeach
                    </div>

                    <!-- Tombol Unduh -->
                    <button class="flex items-center gap-2 mt-6 bg-yellow-200 hover:bg-yellow-300 text-black font-semibold px-4 py-1 rounded-md shadow transition">
                        <span>Unduh Data</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Konten utama -->
            <div class="flex-1 px-6 pb-6 pt-48 space-y-6">
                <!-- Daftar Pengguna -->
                <div class="rounded-t-lg overflow-hidden shadow-md bg-white/50">
                    <!-- Tabel -->
                    <table class="w-full text-sm border-collapse">
                        <thead class="bg-[#577BC166] text-blue-900">
                            <tr>
                                <th class="p-3 text-center font-semibold">ID</th>
                                <th class="p-3 text-center font-semibold">Foto</th>
                                <th class="p-3 text-center font-semibold">Nama</th>
                                <th class="p-3 text-center font-semibold">Email</th>
                                <th class="p-3 text-center font-semibold">Status</th>
                                <th class="p-3 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $index => $user)
                                <tr class="border-b hover:bg-blue-100 transition">
                                    <td class="p-3 text-center">{{ $user->id }}</td>
                                    <td class="p-3 justify-center flex">
                                        <img src="{{ $user->photo_url ?? asset('images/default-avatar.png') }}" 
                                             class="w-10 h-10 rounded-full object-cover">
                                    </td>
                                    <td class="p-3 text-center font-semibold">{{ $user->name }}</td>
                                    <td class="p-3 text-center text-gray-700">{{ $user->email }}</td>
                                    <td class="p-3 text-center">
                                        @php
                                            $statusColors = [
                                                'Online' => 'text-green-600',
                                                'Offline' => 'text-gray-500',
                                                'Aktif' => 'text-blue-600'
                                            ];
                                        @endphp
                                        <span class="{{ $statusColors[$user->status] ?? 'text-gray-500' }}">
                                            {{ $user->status }}
                                        </span>
                                    </td>
                                    <td class="p-3 flex justify-center gap-2">
                                        <!-- Edit -->
                                        <button class="p-2 rounded-md transition hover:scale-110" style="background-color: #FAB00580;">
                                            <x-icons.icon name="pencil" class="w-4 h-4" />
                                        </button>

                                        <!-- View -->
                                        <button class="p-2 rounded-md transition hover:scale-110" style="background-color: #0095DA80;">
                                            <x-icons.icon name="eye" class="w-4 h-4" />
                                        </button>

                                        <!-- Delete -->
                                        <button class="p-2 rounded-md transition hover:scale-110" style="background-color: #FA525280;">
                                            <x-icons.icon name="trash" class="w-4 h-4" />
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-gray-500 py-4">Tidak ada pengguna</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer tabel -->
                <div class="flex justify-between items-center bg-white/50 p-3 shadow-md hover:bg-blue-100 transition">
                    <span class="text-gray-700 text-sm">Total {{ count($users) }}</span>
                    <div class="flex gap-2 items-center">
                        <button class="px-2 py-1 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">&lt;</button>
                        <span class="text-blue-800 font-semibold">1</span>
                        <button class="px-2 py-1 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">&gt;</button>
                    </div>
                </div>
            </div>

            <!-- Inline script untuk hapus initial-hidden -->
            <script>
                document.getElementById('main-content').classList.remove('initial-hidden');
                document.getElementById('navbar-header').classList.remove('initial-hidden');
            </script>
        </div>
    </div>
</x-app-layout>