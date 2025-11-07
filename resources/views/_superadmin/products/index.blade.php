<x-app-layout>
    <div class="flex min-h-screen">
        @include('layouts.sidebar-superadmin')

        <div id="main-content" class="flex-1 ml-97 transition-all duration-300 flex flex-col min-h-screen initial-hidden">
            <div id="navbar-header" class="fixed top-0 left-97 right-0 z-20 transition-all duration-300 initial-hidden"
                 style="background-color: #DBEDFF; padding: 1rem 1.5rem;">
                @include('layouts.navigation-superadmin', ['title' => $title])

                <div class="mt-2 flex justify-between items-center">
                    @if(!request('product_id'))
                        <!-- TAB + FILTER + UNDUH (Hanya di daftar) -->
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
                                        <span class="text-gray-400 text-sm font-bold flex items-center justify-center ml-2">
                                            {{ $pendingCount }}
                                        </span>
                                    @endif
                                </a>

                                @if($i === 0)
                                    <div class="w-0.5 bg-black h-4"></div>
                                @endif
                            @endforeach
                        </div>

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
                    @else
                        <!-- DETAIL: Judul + Kembali + Unduh -->
                        <div class="flex justify-between items-center w-full mt-4">
                            <!-- Kiri: Panah + Judul -->
                            <div class="flex items-center gap-3 ml-6">
                                <a href="{{ route('superadmin.products', ['tab' => request('tab', 'Traveler')]) }}" 
                                class="text-blue-900 hover:text-blue-600 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </a>
                                <h2 class="text-[32px] font-semibold text-blue-900">Detail Produk</h2>
                            </div>

                            <!-- Kanan: Unduh Data -->
                            <div>
                                <a href="{{ route('superadmin.products.export', array_merge(request()->query(), ['product_id' => request('product_id')])) }}"
                                class="flex items-center gap-2 bg-yellow-200 hover:bg-yellow-300 text-black font-semibold px-4 py-1 rounded-md shadow transition">
                                    <span>Unduh Data</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Konten Utama -->
            <div class="flex-1 px-6 pb-6 pt-48 space-y-6">

                <!-- === DETAIL PRODUK (Hanya jika product_id ada) === -->
                @if(request('product_id'))
                    @php
                        $product = \App\Models\Product::with(['submiter', 'category'])->findOrFail(request('product_id'));
                    @endphp

                    <div class="bg-white/70 rounded-xl shadow-md p-20 mx-auto border border-gray-200">
                        <!-- Gambar Produk di Tengah -->
                        <div class="flex justify-center mb-8">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/sample-product.jpg') }}"
                                alt="{{ $product->name }}"
                                class="w-full max-w-md rounded-lg shadow-md object-cover border border-gray-200">
                        </div>

                        <!-- Informasi Produk (Vertikal) -->
                        <div class="space-y-2 text-[15px] text-gray-800 leading-relaxed">
                            <div class="flex items-start">
                                <p class="font-semibold w-44 text-gray-700">Nama Barang</p>
                                <p class="flex-1 text-gray-900 font-medium">: {{ $product->name }}</p>
                            </div>

                            <div class="flex items-start">
                                <p class="font-semibold w-44 text-gray-700">Deskripsi Barang</p>
                                <p class="flex-1 text-gray-800 leading-relaxed">: {!! nl2br(e($product->description ?? '-')) !!}</p>
                            </div>

                            <div class="flex items-start">
                                <p class="font-semibold w-44 text-gray-700">Harga Barang</p>
                                <p class="flex-1 text-blue-900 font-semibold">: Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>

                            <div class="flex items-start">
                                <p class="font-semibold w-44 text-gray-700">
                                    {{ request('tab') === 'Traveler' ? 'Nama Traveler' : 'Nama Penitip' }}
                                </p>
                                <p class="flex-1 text-gray-800">: {{ $product->submiter->name }}</p>
                            </div>

                            <div class="flex items-start">
                                <p class="font-semibold w-44 text-gray-700">Status</p>
                                <p class="flex-1">
                                    @if($product->approval === 'approved')
                                        : <span class="text-green-600 font-semibold">Disetujui</span>
                                    @elseif($product->approval === 'pending')
                                        : <span class="text-orange-600 font-semibold">Belum Validasi</span>
                                    @else
                                        : <span class="text-red-600 font-semibold">Ditolak</span>
                                    @endif
                                </p>
                            </div>
                            @if($product->approval === 'declined' && $product->reject_reason)
                                <div class="flex items-start">
                                    <p class="font-semibold w-44 text-gray-700">Alasan Penolakan</p>
                                    <p class="flex-1 text-black leading-relaxed">: {!! nl2br(e($product->reject_reason)) !!}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Tombol Aksi (Jika pending) -->
                        @if($product->approval === 'pending')
                            <div class="mt-10 flex justify-end gap-10">
                                <button type="button"
                                        onclick="openRejectModal({{ $product->id }})"
                                        class="w-40 h-12 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-md transition">
                                    Tolak
                                </button>

                                <form method="POST" action="{{ route('superadmin.products.approve', $product->id) }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="w-40 h-12 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition">
                                        Setujui
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- === DAFTAR PRODUK (Hanya jika tidak ada detail) === -->
                @if(!request('product_id'))
                    <div class="bg-white/50 rounded-t-lg shadow-md divide-y divide-blue-100">
                        <div class="px-5 py-3 bg-[#577BC166] text-black font-semibold rounded-t-xl text-xl">
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
                                    <div class="col-span-2 space-y-2 text-base text-gray-600">
                                        <p>Nama Barang</p>
                                        <p>Deskripsi Barang</p>
                                        <p>Harga Barang</p>
                                        <p>{{ request('tab') === 'Traveler' ? 'Nama Traveler' : 'Nama Penitip' }}</p>
                                        <p>Status</p>
                                    </div>

                                    <!-- Kolom 3: Isi -->
                                    <div class="col-span-3 space-y-2 text-base">
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
                                            <a href="{{ route('superadmin.products', array_merge(request()->query(), ['product_id' => $product->id])) }}"
                                               class="w-36 h-12 flex items-center justify-center bg-red-500 hover:bg-red-600 text-white rounded-md transition text-base">
                                                Validasi
                                            </a>
                                        @else
                                            <a href="{{ route('superadmin.products', array_merge(request()->query(), ['product_id' => $product->id])) }}"
                                               class="w-36 h-12 flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white rounded-md transition text-base">
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
                @endif
            </div>

            <!-- Modal Tolak -->
            <div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-xl">
                    <h3 class="text-lg font-semibold mb-4 text-red-600">Tolak Produk</h3>
                    <form method="POST" id="rejectForm">
                        @csrf
                        <input type="hidden" name="product_id" id="rejectProductId">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Alasan Penolakan <span class="text-red-500">(wajib)</span>
                                </label>
                                <textarea name="reason" rows="5" required
                                          class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm resize-none focus:ring-2 focus:ring-red-400"
                                          placeholder="Jelaskan alasan penolakan secara jelas..."></textarea>
                            </div>
                            <div class="flex justify-end gap-3">
                                <button type="button" onclick="closeRejectModal()"
                                        class="px-5 py-2 text-gray-600 hover:text-gray-800 font-medium">Batal</button>
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-md font-medium shadow transition">
                                    Kirim & Tolak
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openRejectModal(id) {
            document.getElementById('rejectProductId').value = id;
            document.getElementById('rejectForm').action = `/superadmin/products/${id}/reject`;
            document.getElementById('rejectModal').classList.remove('hidden');
        }
        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
        document.getElementById('main-content').classList.remove('initial-hidden');
        document.getElementById('navbar-header').classList.remove('initial-hidden');
    </script>
</x-app-layout>