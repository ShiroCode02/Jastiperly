<x-app-layout>
    <div class="flex" style="background-color: #DBEDFF;">
        <!-- Sidebar -->
        @include('layouts.sidebar-superadmin')

        <!-- Area kanan (konten utama) -->
        <div id="main-content" class="flex-1 ml-97 transition-all duration-300 flex flex-col initial-hidden" style="background-color: #DBEDFF;">
            
            <!-- Navbar + Header -->
            <div id="navbar-header" class="fixed top-0 left-97 right-0 z-20 transition-all duration-300 initial-hidden" style="background-color: #DBEDFF; padding: 1rem 1.5rem 1rem 1.5rem;">
                @include('layouts.navigation', ['title' => 'Users'])

                <div class="mt-2 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-blue-900">Hi, King</h2>
                        <p class="text-gray-600">Manage Users</p>
                    </div>
                </div>
            </div>

            <!-- Konten utama -->
            <div class="flex-1 px-6 pb-6 pt-48 space-y-6">
                <!-- Daftar Pengguna -->
                <div class="bg-[rgba(255,255,255,0.4)] p-4 rounded-xl shadow-[0_0_10px_rgba(0,0,0,0.25)]">
                    <h3 class="font-semibold mb-3">Daftar Pengguna</h3>
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-blue-100">
                                <th class="p-2 border">No</th>
                                <th class="p-2 border">Nama</th>
                                <th class="p-2 border">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $index => $user)
                            <tr class="text-center hover:bg-blue-50">
                                <td class="p-2 border">{{ $index + 1 }}</td>
                                <td class="p-2 border">{{ $user['name'] }}</td>
                                <td class="p-2 border">{{ $user['email'] }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-gray-500 py-4">Tidak ada pengguna</td></tr>
                            @endforelse
                        </tbody>
                    </table>
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