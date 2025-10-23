<x-app-layout>
    <div class="flex">
        <!-- Sidebar -->
        @include('layouts.sidebar-admin')
        
        <!-- Area kanan (konten utama) -->
        <div class="flex-1 ml-64 flex flex-col bg-blue-50">
            
            <!-- Navbar + Header -->
            <div class="fixed top-0 left-64 right-0 z-20 bg-blue-50 border-b border-blue-200 shadow-sm px-6 pt-4 pb-4">
                @include('layouts.navigation', ['title' => 'Dashboard'])

                <div class="mt-2 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-blue-900">Hi, Bro Admin</h2>
                        <p class="text-gray-600">Welcome back to Dashboard</p>
                    </div>
                </div>
            </div>

            <!-- Konten utama -->
            <div class="flex-1 px-6 pb-6 pt-48">
                <div class="max-w-7xl mx-auto">
                    <div class="bg-white rounded-xl shadow p-6 text-gray-800 text-center">
                        <h3 class="text-xl font-semibold text-blue-900 mb-2">Halaman Dashboard</h3>
                        <p class="text-gray-600">Konten utama akan ditambahkan di sini.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
