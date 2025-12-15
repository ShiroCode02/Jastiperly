<x-app-layout>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('layouts.sidebar-superadmin')

        <!-- Area kanan -->
        <div id="main-content" class="flex-1 ml-97 transition-all duration-300 flex flex-col min-h-screen initial-hidden">

            <!-- Navbar -->
            <div id="navbar-header"
                 class="fixed top-0 left-97 right-0 z-20 transition-all duration-300 initial-hidden"
                 style="background-color: #DBEDFF; padding: 1rem 1.5rem;">
                 
                @include('layouts.navigation', ['title' => $title])

                <div class="mt-2 flex justify-between items-center">
                    <!-- Filter Placeholder -->
                    <div class="flex gap-3">
                        <button class="px-4 py-2 border border-blue-400 rounded-md text-blue-800 font-medium bg-transparent hover:bg-blue-200 transition">
                            Semua Produk
                        </button>
                        <button class="px-4 py-2 border border-blue-400 rounded-md text-blue-800 font-medium bg-transparent hover:bg-blue-200 transition">
                            Pending
                        </button>
                        <button class="px-4 py-2 border border-blue-400 rounded-md text-blue-800 font-medium bg-transparent hover:bg-blue-200 transition">
                            Disetujui
                        </button>
                        <button class="px-4 py-2 border border-blue-400 rounded-md text-blue-800 font-medium bg-transparent hover:bg-blue-200 transition">
                            Ditolak
                        </button>
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

            <!-- Konten utama -->
            <div class="flex-1 px-6 pb-6 pt-48 space-y-6">
                <div class="bg-white/70 backdrop-blur p-4 rounded-xl shadow-[0_0_10px_rgba(0,0,0,0.25)]">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-[#BFD9FF] text-blue-900">
                                <th class="p-3 text-center font-semibold">ID</th>
                                <th class="p-3 text-center font-semibold">Nama Produk</th>
                                <th class="p-3 text-center font-semibold">Kategori</th>
                                <th class="p-3 text-center font-semibold">Traveler</th>
                                <th class="p-3 text-center font-semibold">Harga</th>
                                <th class="p-3 text-center font-semibold">Status</th>
                                <th class="p-3 text-center font-semibold">Approval</th>
                                <th class="p-3 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr class="border-b hover:bg-blue-50 transition">
                                    <td class="p-3 text-center">{{ $product->id }}</td>
                                    <td class="p-3 text-center font-semibold">{{ $product->name }}</td>
                                    <td class="p-3 text-center">{{ $product->category->name ?? '-' }}</td>
                                    <td class="p-3 text-center">{{ $product->submiter->name ?? '-' }}</td>
                                    <td class="p-3 text-center font-semibold text-blue-800">
                                        Rp{{ number_format($product->price, 0, ',', '.') }}
                                    </td>
                                    <td class="p-3 text-center">
                                        <span class="px-3 py-1 text-xs rounded-full
                                            {{ $product->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                            {{ ucfirst($product->status) }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-center">
                                        <span class="px-3 py-1 text-xs rounded-full
                                            @if($product->approval === 'approved') bg-green-100 text-green-700
                                            @elseif($product->approval === 'pending') bg-yellow-100 text-yellow-700
                                            @else bg-red-100 text-red-700 @endif">
                                            {{ ucfirst($product->approval) }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-center flex justify-center gap-2">
                                        <button class="p-2 bg-blue-400 rounded-md hover:bg-blue-500 transition" title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 text-white">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553 4.553a1 1 0 010 1.414L15 20.414m-6-10l-4.553 4.553a1 1 0 000 1.414L9 20.414M9 10l6 6" />
                                            </svg>
                                        </button>
                                        <button class="p-2 bg-yellow-400 rounded-md hover:bg-yellow-500 transition" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 text-white">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6 6M4 21h4l12-12a1 1 0 00-1.414-1.414L6 19H4v2z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-gray-500 py-4">Tidak ada produk ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Reveal anim -->
            <script>
                document.getElementById('main-content').classList.remove('initial-hidden');
                document.getElementById('navbar-header').classList.remove('initial-hidden');
            </script>
        </div>
    </div>
</x-app-layout>