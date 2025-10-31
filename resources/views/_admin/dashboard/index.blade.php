<x-app-layout>
    <div class="flex min-h-screen">
        <!-- Sidebar admin (lebar 312px) -->
        @include('layouts.sidebar-admin')

        <!-- Konten utama – offset 312px -->
        <div id="main-content" class="flex-1 ml-[312px] transition-all duration-300 flex flex-col min-h-screen initial-hidden">
            <!-- Navbar (tetap di atas konten) -->
            <div id="navbar-header" class="fixed top-0 left-[312px] right-0 z-20 transition-all duration-300 initial-hidden" style="background-color: #DBEDFF; padding: 1rem 1.5rem;">
                @include('layouts.navigation-admin', ['title' => 'Dashboard'])

                <div class="mt-2 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-blue-900">Hi, {{ Auth::user()->name }}</h2>
                        <p class="text-gray-600">Welcome back to Dashboard</p>
                    </div>
                </div>
            </div>

            <!-- Konten utama -->
            <div class="flex-1 px-6 pb-6 pt-48 space-y-6">
                <div class="max-w-7xl mx-auto">
                    <div class="bg-white/70 backdrop-blur p-6 rounded-xl shadow-[0_0_10px_rgba(0,0,0,0.25)] text-gray-800 text-center">
                        <h3 class="text-xl font-semibold text-blue-900 mb-2">Halaman Dashboard</h3>
                        <p class="text-gray-600">Konten utama akan ditambahkan di sini.</p>
                    </div>
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