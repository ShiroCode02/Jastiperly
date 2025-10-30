<x-app-layout>
    <div class="flex min-h-screen">
        @include('layouts.sidebar-superadmin')

        <div id="main-content" class="flex-1 ml-97 transition-all duration-300 flex flex-col min-h-screen initial-hidden">
            <div id="navbar-header" class="fixed top-0 left-97 right-0 z-20 transition-all duration-300 initial-hidden"
                 style="background-color: #DBEDFF; padding: 1rem 1.5rem;">
                @include('layouts.navigation', ['title' => $title])
            </div>

            <div class="flex-1 px-6 pb-6 pt-48 space-y-6">
                <div class="bg-white/50 backdrop-blur p-6 rounded-xl shadow-md text-center text-gray-700">
                    <h2 class="text-xl font-semibold mb-2">Halaman {{ $title }}</h2>
                    <p>Pengaturan sistem akan ditampilkan di sini nanti.</p>
                </div>
            </div>

            <script>
                document.getElementById('main-content').classList.remove('initial-hidden');
                document.getElementById('navbar-header').classList.remove('initial-hidden');
            </script>
        </div>
    </div>
</x-app-layout>