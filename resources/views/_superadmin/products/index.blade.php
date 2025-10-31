<x-app-layout>
    <div class="flex min-h-screen">
        @include('layouts.sidebar-superadmin')

        <div id="main-content" class="flex-1 ml-97 transition-all duration-300 flex flex-col min-h-screen initial-hidden">
            <div id="navbar-header" class="fixed top-0 left-97 right-0 z-20 transition-all duration-300 initial-hidden"
                 style="background-color: #DBEDFF; padding: 1rem 1.5rem;">
                @include('layouts.navigation-superadmin', ['title' => $title])

                <div class="mt-2 flex justify-between items-center">
                    <!-- Tab Navigasi -->
                    <div class="flex gap-3 mt-3">
                        @foreach (['Traveler', 'Customer'] as $tabName)
                            <a href="{{ route('superadmin.products', ['tab' => $tabName]) }}"
                               class="px-6 py-0.5 border border-blue-400 rounded-md text-blue-800 font-medium
                                      hover:bg-blue-200 transition {{ request('tab') === $tabName ? 'bg-[#577BC1] text-white' : 'bg-transparent' }}">
                                {{ $tabName }}
                            </a>
                        @endforeach
                    </div>

                    <!-- Filter + Unduh -->
                    <div class="flex items-center gap-3 mt-6">
                        <form method="GET" class="flex items-center gap-2">
                            <select name="filter" onchange="this.form.submit()"
                                    class="border border-gray-300 rounded-md px-3 py-1 text-sm focus:outline-none">
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
                    <div class="px-5 py-3 bg-[#577BC166] text-blue-900 font-semibold rounded-t-xl">
                        Daftar Produk
                    </div>

                    <div class="divide-y divide-blue-100">
                        @forelse ($products as $product)
                            <div class="flex items-center justify-between px-5 py-4 hover:bg-blue-100 transition">
                                <div class="flex items-center gap-4 w-1/4">
                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/sample-product.jpg') }}"
                                         alt="Foto {{ $product->name }}"
                                         class="w-28 h-24 object-cover rounded-lg shadow-sm">
                                </div>

                                <!-- Detail Produk -->
                                <div class="flex-1 ml-4 space-y-1">
                                    <p class="text-base font-semibold text-gray-900">Nama Barang: {{ $product->name }}</p>
                                    <p class="text-sm text-gray-600">Deskripsi Barang: <span class="text-gray-800">{{ Str::limit($product->description ?? '-', 120) }}</span></p>
                                    <p class="text-sm text-gray-600">Harga Barang: <span class="text-blue-900 font-semibold">Rp{{ number_format($product->price, 0, ',', '.') }}</span></p>

                                    @if (request('tab') === 'Traveler')
                                        <p class="text-sm text-gray-600">Nama Traveler: <span class="text-gray-800">{{ $product->submiter->name }}</span></p>
                                    @else
                                        <p class="text-sm text-gray-600">Nama Penitip: <span class="text-gray-800">{{ $product->submiter->name }}</span></p>
                                    @endif

                                    <p class="text-sm text-gray-600">
                                        Status:
                                        @if ($product->approval === 'approved')
                                            <span class="text-green-600 font-medium">Disetujui</span>
                                        @elseif ($product->approval === 'pending')
                                            <span class="text-orange-600 font-medium">Validasi</span>
                                        @else
                                            <span class="text-red-600 font-medium">Ditolak</span>
                                        @endif
                                    </p>
                                </div>

                                <!-- Aksi -->
                                <div class="w-32 text-center">
                                    @if ($product->approval === 'pending')
                                        <button onclick="openValidationModal({{ $product->id }})"
                                                class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-1 rounded-md transition text-sm">
                                            Validasi
                                        </button>
                                    @elseif ($product->approval === 'approved')
                                        <button class="bg-green-500 text-white font-semibold px-4 py-1 rounded-md cursor-default text-sm">
                                            Disetujui
                                        </button>
                                    @else
                                        <button class="bg-gray-400 text-white font-semibold px-4 py-1 rounded-md cursor-default text-sm">
                                            Ditolak
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-gray-500">Tidak ada produk untuk ditampilkan</div>
                        @endforelse
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            </div>

            <!-- Modal Validasi -->
            <div id="validationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                <div class="bg-white rounded-lg p-6 w-full max-w-md">
                    <h3 class="text-lg font-semibold mb-4">Validasi Produk</h3>
                    <form id="validationForm" method="POST">
                        @csrf
                        <div class="space-y-3">
                            <button type="submit" formaction="" id="approveBtn"
                                    class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-md transition">
                                Setujui
                            </button>

                            <div class="border-t pt-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan (akan dikirim ke pengguna)</label>
                                <textarea name="reason" rows="3" required
                                          class="w-full border rounded-md px-3 py-2 text-sm"
                                          placeholder="Wajib diisi jika menolak"></textarea>
                            </div>

                            <button type="submit" formaction="" id="rejectBtn"
                                    class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-md transition">
                                Tolak
                            </button>
                        </div>
                    </form>
                    <button onclick="closeModal()" class="mt-3 text-sm text-gray-500 underline">Batal</button>
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