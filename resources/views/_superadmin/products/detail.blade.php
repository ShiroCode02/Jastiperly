<x-app-layout>
    <div class="flex min-h-screen">
        @include('layouts.sidebar-superadmin')

        <div id="main-content" class="flex-1 ml-97 transition-all duration-300 flex flex-col min-h-screen">
            <div id="navbar-header" class="fixed top-0 left-97 right-0 z-20 transition-all duration-300"
                 style="background-color: #DBEDFF; padding: 1rem 1.5rem;">
                @include('layouts.navigation-superadmin', ['title' => $title])
            </div>

            <!-- Konten Utama -->
            <div class="flex-1 px-6 pb-6 pt-48 space-y-6">
                <div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
                    <div class="flex justify-between items-start mb-6">
                        <h2 class="text-2xl font-bold text-blue-900">Detail Produk</h2>
                        <a href="{{ route('superadmin.products') }}" class="text-blue-600 hover:underline text-sm">
                            ← Kembali
                        </a>
                    </div>

                    <!-- Gambar + Info Utama -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Gambar -->
                        <div class="md:col-span-1">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/sample-product.jpg') }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-64 object-cover rounded-lg shadow-md">
                        </div>

                        <!-- Info -->
                        <div class="md:col-span-2 space-y-4">
                            <div>
                                <p class="text-sm text-gray-600">Nama Barang</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $product->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Deskripsi</p>
                                <p class="text-gray-800">{!! nl2br(e($product->description ?? '-')) !!}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Harga</p>
                                <p class="text-xl font-bold text-blue-900">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">{{ request('tab') === 'Traveler' ? 'Traveler' : 'Penitip' }}</p>
                                <p class="text-gray-800">{{ $product->submiter->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Kategori</p>
                                <p class="text-gray-800">{{ $product->category->name ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Status Pengajuan</p>
                                <p>
                                    @if ($product->approval === 'approved')
                                        <span class="text-green-600 font-bold">Disetujui</span>
                                    @elseif ($product->approval === 'pending')
                                        <span class="text-orange-600 font-bold">Menunggu Validasi</span>
                                    @else
                                        <span class="text-red-600 font-bold">Ditolak</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi (Hanya jika pending) -->
                    @if ($product->approval === 'pending')
                        <div class="mt-8 pt-6 border-t flex justify-center gap-4">
                            <form method="POST" action="{{ route('superadmin.products.approve', $product->id) }}" class="inline">
                                @csrf
                                <button type="submit"
                                        class="bg-green-500 hover:bg-green-600 text-white font-semibold px-8 py-2.5 rounded-md transition">
                                    Setujui
                                </button>
                            </form>

                            <form method="POST" action="{{ route('superadmin.products.reject', $product->id) }}" class="inline">
                                @csrf
                                <button type="button" onclick="openRejectModal()"
                                        class="bg-red-500 hover:bg-red-600 text-white font-semibold px-8 py-2.5 rounded-md transition">
                                    Tolak
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Modal Tolak -->
            <div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                <div class="bg-white rounded-lg p-6 w-full max-w-md">
                    <h3 class="text-lg font-semibold mb-4">Tolak Produk</h3>
                    <form method="POST" action="{{ route('superadmin.products.reject', $product->id) }}" id="rejectForm">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Alasan Penolakan <span class="text-red-500">(wajib)</span>
                                </label>
                                <textarea name="reason" rows="4" required
                                          class="w-full border rounded-md px-3 py-2 text-sm resize-none"
                                          placeholder="Jelaskan alasan penolakan..."></textarea>
                            </div>
                            <div class="flex justify-end gap-3">
                                <button type="button" onclick="closeRejectModal()"
                                        class="px-4 py-2 text-gray-600 hover:text-gray-800">Batal</button>
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-md font-medium">
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
        function openRejectModal() {
            document.getElementById('rejectModal').classList.remove('hidden');
        }
        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
        document.getElementById('main-content').classList.remove('initial-hidden');
        document.getElementById('navbar-header').classList.remove('initial-hidden');
    </script>
</x-app-layout>