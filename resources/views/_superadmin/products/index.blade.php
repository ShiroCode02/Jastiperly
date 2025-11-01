<x-app-layout>
    <div class="flex min-h-screen">
        @include('layouts.sidebar-superadmin')

        <div id="main-content" class="flex-1 ml-97 transition-all duration-300 flex flex-col min-h-screen initial-hidden">
            <div id="navbar-header" class="fixed top-0 left-97 right-0 z-20 transition-all duration-300 initial-hidden"
                 style="background-color: #DBEDFF; padding: 1rem 1.5rem;">
                @include('layouts.navigation-superadmin', ['title' => $title])

                <div class="mt-2 flex justify-between items-center">
                    <!-- Tab Navigasi -->
                    <div class="flex gap-3 bg-[#FFF6E3] mt-3 px-6 py-1 rounded-md items-center">
                        @foreach (['Traveler', 'Customer'] as $i => $tabName)
                            @php
                                $pendingCount = \App\Models\Product::where('approval', 'pending')
                                    ->whereHas('submiter', fn($q) => $q->where('role', strtolower($tabName)))
                                    ->count();
                            @endphp

                            <a href="{{ route('superadmin.products', ['tab' => $tabName]) }}"
                            class="flex items-center gap-2 px-4 py-1.5 rounded-md text-black font-medium
                                    hover:bg-white transition {{ request('tab') === $tabName ? 'bg-white text-black' : 'bg-transparent' }}">
                                <span>{{ $tabName }}</span>
                                @if($pendingCount > 0)
                                    <span class="text-gray-500 text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center ml-2">
                                        {{ $pendingCount }}
                                    </span>
                                @endif
                            </a>

                            @if($i === 0)
                                <div class="w-px bg-gray-400 h-8"></div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Filter + Unduh -->
                    <div class="flex items-center gap-3 mt-6">
                        <form method="GET" class="flex items-center gap-2">
                            <select name="filter" onchange="this.form.submit()"
                                    class="border border-gray-300 rounded-md px-8 py-1.5 text-sm focus:outline-none">
                                <option value="">Semua</option>
                                <option value="Validasi" {{ request('filter') == 'Validasi' ? 'selected' : '' }}>Validasi</option>
                                <option value="Disetujui" {{ request('filter') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="Ditolak" {{ request('filter') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            <input type="hidden" name="tab" value="{{ request('tab', 'Traveler') }}">
                            
                            <!-- TAMBAH INI: biar search ikut -->
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                        </form>

                        <a href="{{ route('superadmin.products.export', request()->query()) }}"
                           class="flex items-center gap-2 bg-yellow-200 hover:bg-yellow-300 text-black font-semibold px-4 py-1 rounded-md shadow transition">
                            <span>Unduh Data</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Konten Utama -->
            <div class="flex-1 px-6 pb-6 pt-48 space-y-4">
                <div class="bg-white/50 rounded-t-lg shadow-md divide-y divide-blue-100">
                    <div class="px-5 py-3 bg-[#577BC166] text-black font-semibold rounded-t-xl">
                        Daftar Produk
                    </div>

                    <div class="divide-y divide-blue-100">
                        @forelse ($products as $product)
                            <div class="grid grid-cols-12 gap-4 px-5 py-4 hover:bg-blue-100 transition items-center">
                                
                                <!-- Kolom 1: Gambar -->
                                <div class="col-span-3 flex justify-center">
                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/sample-product.jpg') }}"
                                        alt="Foto {{ $product->name }}"
                                        class="w-full h-full object-cover rounded-lg shadow-sm">
                                </div>

                                <!-- Kolom 2: Label -->
                                <div class="col-span-2 space-y-2 text-sm text-gray-600">
                                    <p>Nama Barang</p>
                                    <p>Deskripsi Barang</p>
                                    <p>Harga Barang</p>
                                    <p>{{ request('tab') === 'Traveler' ? 'Nama Traveler' : 'Nama Penitip' }}</p>
                                    <p>Status</p>
                                </div>

                                <!-- Kolom 3: Isi -->
                                <div class="col-span-3 space-y-2 text-sm">
                                    <p class="text-gray-900 font-medium truncate">: {{ $product->name }}</p>
                                    <p class="text-gray-800 truncate">: {{ Str::limit($product->description ?? '-', 100) }}</p>
                                    <p class="text-blue-900 font-semibold truncate">: Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                                    <p class="text-gray-800 truncate">: {{ $product->submiter->name }}</p>
                                    <p class="truncate">
                                        @if ($product->approval === 'approved')
                                            <span class="text-green-600 font-medium">: Disetujui</span>
                                        @elseif ($product->approval === 'pending')
                                            <span class="text-orange-600 font-medium">: Validasi</span>
                                        @else
                                            <span class="text-red-600 font-medium">: Ditolak</span>
                                        @endif
                                    </p>
                                </div>

                                <!-- Kolom 4: Aksi -->
                                <div class="col-span-4 flex justify-center">
                                    @if ($product->approval === 'pending')
                                        <a href="{{ route('superadmin.products.show', $product->id) }}"
                                        class="bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-1.5 rounded-md transition text-sm">
                                            Validasi
                                        </a>
                                    @else
                                        <a href="{{ route('superadmin.products.show', $product->id) }}"
                                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-1.5 rounded-md transition text-sm">
                                            Detail
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-gray-500 col-span-12">Tidak ada produk untuk ditampilkan</div>
                        @endforelse
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentProductId = null;

        function openValidationModal(productId) {
            currentProductId = productId;
            document.getElementById('validationModal').classList.remove('hidden');
            document.getElementById('approveBtn').setAttribute('formaction', `/superadmin/products/${productId}/approve`);
            document.getElementById('rejectBtn').setAttribute('formaction', `/superadmin/products/${productId}/reject`);
        }

        function closeModal() {
            document.getElementById('validationModal').classList.add('hidden');
            document.getElementById('validationForm').reset();
        }

        document.getElementById('main-content').classList.remove('initial-hidden');
        document.getElementById('navbar-header').classList.remove('initial-hidden');
    </script>
</x-app-layout>