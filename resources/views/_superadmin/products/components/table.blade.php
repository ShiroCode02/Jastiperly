<div class="bg-white/50 rounded-t-lg shadow-md divide-y divide-blue-100">
    <div class="px-5 py-3 bg-[#577BC166] text-black font-semibold rounded-t-xl text-xl">
        Daftar Produk
    </div>
    <div class="divide-y divide-blue-100">
        @forelse ($products as $product)
            <div class="grid grid-cols-12 gap-4 px-5 py-4 hover:bg-blue-100 transition items-center">
                <!-- Gambar -->
                <div class="col-span-3 flex justify-center">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/sample-product.jpg') }}"
                         alt="Foto {{ $product->name }}"
                         class="w-full h-full object-cover rounded-lg shadow-sm">
                </div>
                <!-- Label -->
                <div class="col-span-2 space-y-2 text-base text-gray-600">
                    <p>Nama Barang</p>
                    <p>Deskripsi Barang</p>
                    <p>Harga Barang</p>
                    <p>{{ request('tab') === 'Traveler' ? 'Nama Traveler' : 'Nama Penitip' }}</p>
                    <p>Status</p>
                </div>
                <!-- Isi -->
                <div class="col-span-3 space-y-2 text-base">
                    <p class="text-gray-900 font-medium truncate">: {{ $product->name }}</p>
                    <p class="text-gray-800 truncate">: {{ Str::limit($product->description ?? '-', 100) }}</p>
                    <p class="text-blue-900 font-semibold truncate">: Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="text-gray-800 truncate">: {{ $product->submiter->detail->name }}</p>
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
                <!-- Aksi -->
                <div class="col-span-4 flex justify-center">
                    @if ($product->approval === 'pending')
                        <a href="{{ route('superadmin.products.detail', array_merge(request()->query(), ['product_id' => $product->id])) }}"
                           class="w-36 h-12 flex items-center justify-center bg-red-500 hover:bg-red-600 text-white rounded-md transition text-base">
                            Validasi
                        </a>
                    @else
                        <a href="{{ route('superadmin.products.detail', array_merge(request()->query(), ['product_id' => $product->id])) }}"
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
    @include('_superadmin.components.pagination', ['paginator' => $products])
</div>