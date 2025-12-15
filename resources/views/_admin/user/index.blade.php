<x-app-layout>
    <div class="flex min-h-screen">
        <!-- Sidebar admin (lebar 312px) -->
        @include('layouts.sidebar-admin')

        <!-- Konten utama – offset 312px -->
        <div id="main-content" class="flex-1 ml-[312px] transition-all duration-300 flex flex-col min-h-screen initial-hidden">
            <!-- Navbar (tetap di atas konten) -->
            <div id="navbar-header" class="fixed top-0 left-[312px] right-0 z-20 transition-all duration-300 initial-hidden" style="background-color: #DBEDFF; padding: 1rem 1.5rem;">
                @include('layouts.navigation', ['title' => $title])

                <div class="mt-2 flex justify-between items-center">
                    <!-- Tab filter (hanya Traveler & Penitip untuk admin) -->
                    <div class="flex gap-3">
                        @foreach (['Traveler', 'Penitip'] as $tab)
                            <a href="{{ route('admin.users', ['tab' => $tab]) }}"
                               class="px-5 py-2 border border-blue-400 rounded-md text-blue-800 font-medium bg-transparent hover:bg-blue-200 transition {{ request('tab') === $tab ? 'bg-blue-200' : '' }}">
                                {{ $tab }}
                            </a>
                        @endforeach
                    </div>

                    <!-- Tombol Unduh -->
                    <button class="flex items-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-4 py-2 rounded-md shadow transition">
                        <span>Unduh Data</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Isi tabel -->
            <div class="flex-1 px-6 pb-6 pt-48 space-y-6">
                <div class="bg-white/70 backdrop-blur p-4 rounded-xl shadow-[0_0_10px_rgba(0,0,0,0.25)]">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-[#BFD9FF] text-blue-900">
                                <th class="p-3 text-left font-semibold">ID</th>
                                <th class="p-3 text-left font-semibold">Foto</th>
                                <th class="p-3 text-left font-semibold">Nama</th>
                                <th class="p-3 text-left font-semibold">Email</th>
                                <th class="p-3 text-left font-semibold">Status</th>
                                <th class="p-3 text-left font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $index => $user)
                                <tr class="border-b hover:bg-blue-50 transition">
                                    <td class="p-3">{{ $user->id }}</td>
                                    <td class="p-3">
                                        <img src="{{ $user->photo_url ?? asset('images/default-avatar.png') }}" class="w-10 h-10 rounded-full object-cover">
                                    </td>
                                    <td class="p-3 font-semibold">{{ $user->name }}</td>
                                    <td class="p-3 text-gray-700">{{ $user->email }}</td>
                                    <td class="p-3">
                                        @php
                                            $statusColors = [
                                                'Online' => 'text-green-600',
                                                'Offline' => 'text-gray-500',
                                                'Aktif' => 'text-blue-600'
                                            ];
                                        @endphp
                                        <span class="{{ $statusColors[$user->status] ?? 'text-gray-500' }}">{{ $user->status }}</span>
                                    </td>
                                    <td class="p-3 flex gap-2">
                                        <button class="p-2 bg-yellow-400 rounded-md hover:bg-yellow-500 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 text-white">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l2-2m0 0l2-2m-2 2H3m9-2a9 9 0 110 18 9 9 0 010-18z" />
                                            </svg>
                                        </button>
                                        <button class="p-2 bg-blue-400 rounded-md hover:bg-blue-500 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 text-white">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553 4.553a1 1 0 010 1.414L15 20.414m-6-10l-4.553 4.553a1 1 0 000 1.414L9 20.414M9 10l6 6" />
                                            </svg>
                                        </button>
                                        <button class="p-2 bg-red-400 rounded-md hover:bg-red-500 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 text-white">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-gray-500 py-4">Tidak ada pengguna</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Hapus initial-hidden setelah render -->
            <script>
                document.getElementById('main-content').classList.remove('initial-hidden');
                document.getElementById('navbar-header').classList.remove('initial-hidden');
            </script>
        </div>
    </div>
</x-app-layout>