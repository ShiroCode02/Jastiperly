@php
    $product = \App\Models\Product::with(['submiter', 'category'])->findOrFail(request('product_id'));
@endphp

<x-app-layout>
    <div class="flex min-h-screen">
        @include('layouts.sidebar-superadmin')
        <div id="main-content" class="flex-1 ml-97 transition-all duration-300 flex flex-col min-h-screen initial-hidden">
            
            <!-- HEADER -->
            @include('_superadmin.products.components.header')

            <!-- DETAIL PRODUK -->
            <div class="flex-1 px-6 pb-6 pt-48 space-y-6">
                <div class="bg-white/70 rounded-xl shadow-md p-20 mx-auto border border-gray-200">
                    <!-- Gambar -->
                    <div class="flex justify-center mb-8">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/sample-product.jpg') }}"
                             alt="{{ $product->name }}"
                             class="w-full max-w-md rounded-lg shadow-md object-cover border border-gray-200">
                    </div>
                    <!-- Info -->
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
                            <p class="flex-1 text-gray-800">: {{ $product->submiter->detail->name }}</p>
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
                    <!-- Tombol Aksi -->
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
            </div>

            <!-- MODAL TOLAK -->
            @include('_superadmin.products.components.reject-modal')
        </div>
    </div>

    <script>
        document.getElementById('main-content')?.classList.remove('initial-hidden');
        document.getElementById('navbar-header')?.classList.remove('initial-hidden');
    </script>
</x-app-layout>