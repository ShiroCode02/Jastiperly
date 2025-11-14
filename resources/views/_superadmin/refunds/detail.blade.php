<x-app-layout>
    <div class="flex min-h-screen">
        @include('layouts.sidebar-superadmin')
        <div id="main-content" class="flex-1 ml-97 transition-all duration-300 flex flex-col min-h-screen initial-hidden">
            @include('_superadmin.refunds.components.header')
           
            <div class="flex-1 px-6 pb-6 pt-48 space-y-6">
                @php
                    $transaction = $refund->buyTransaction;
                @endphp

                <!-- === DETAIL REFUND === -->
                <div class="bg-white/70 rounded-xl shadow-md p-6 mx-auto border border-gray-200 max-w-5xl">
                    <!-- ID TRANSAKSI -->
                    <div class="text-right mb-4">
                        <h3 class="text-lg font-bold text-gray-800">ID Transaksi</h3>
                        <p class="text-xl font-mono text-blue-600">#JSTP{{ $transaction->id }}</p>
                    </div>

                    <!-- INFORMASI TITIPAN -->
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Informasi Titipan</h2>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                        <!-- KIRI -->
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Barang</label>
                                <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                    {{ $transaction->product->name }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Harga</label>
                                <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                    Rp{{ number_format($transaction->total_price / $transaction->quantity, 0, ',', '.') }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Metode Pembayaran</label>
                                <div class="border border-gray-300 rounded-md px-4 py-2 bg-white flex justify-between items-center">
                                    <span>{{ $transaction->paymentMethod->name ?? '-' }}</span>
                                    @if($transaction->payment_proof)
                                        <button type="button"
                                                onclick="showProofModal('{{ asset('storage/' . $transaction->payment_proof) }}')"
                                                class="text-blue-600 text-xs underline hover:text-blue-800">
                                            Lihat Bukti Transfer
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Rekening</label>
                                <div class="border border-gray-300 rounded-md px-4 py-2 bg-white font-mono">
                                    {{ $transaction->buyer->detail->account_number ?? '08928389249932874' }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Barang</label>
                                <div class="border border-gray-300 rounded-md px-4 py-2 bg-white min-h-24 text-sm">
                                    {{ $transaction->product->description ?? 'Boneka standard size 40cm, bisa dipakaikan costume yg dijual terpisah. Khusus STELLA LOU dikenakan ongkir 2 kg karena telinganya rentan terlipat, jadi akan dikirim menggunakan dus yg lebih besar. Khusus Variasi LINABELL 55cm HK' }}
                                </div>
                            </div>
                        </div>

                        <!-- KANAN -->
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori Barang</label>
                                <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                    {{ $transaction->product->category->name ?? 'Aksesoris dan Koleksi' }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Asal Barang</label>
                                <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                    {{ $transaction->product->origin ?? 'Jepang' }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Jumlah Barang</label>
                                <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                    {{ $transaction->quantity }} pcs
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Foto Barang</label>
                                <div class="border border-gray-300 rounded-md p-2 bg-white">
                                    @if($transaction->product->image)
                                        <img src="{{ asset('storage/' . $transaction->product->image) }}"
                                             class="w-full h-48 object-cover rounded-md" alt="Foto Barang">
                                    @else
                                        <div class="w-full h-48 bg-gray-200 border-2 border-dashed rounded-md flex items-center justify-center text-gray-500">
                                            Tidak ada foto
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TOTAL HARGA & REFUND -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 text-lg">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Total Harga yang sudah dibayar</label>
                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white font-bold text-green-600">
                                Rp{{ number_format($transaction->total_price, 0, ',', '.') }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Total Refund</label>
                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white font-bold text-red-600">
                                Rp{{ number_format($transaction->total_price, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>

                    <!-- LINK BUKTI + ALASAN REFUND -->
                    <div class="flex items-center gap-2 mb-4">
                        <button type="button"
                                onclick="showProofModal('{{ asset('storage/' . $transaction->payment_proof) }}')"
                                class="inline-flex items-center gap-1.5 px-4 py-1.5 text-sm font-medium text-blue-700 bg-white border border-blue-600 rounded-full hover:bg-blue-50 hover:border-blue-700 hover:text-blue-800 transition-all duration-200 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Lihat Bukti Transaksi
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Alasan Refund Transaksi</label>
                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                {{ $refund->reason }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                @if($refund->status == 'pending')
                                    <span class="text-yellow-600 font-bold">Menunggu Validasi</span>
                                @elseif($refund->status == 'approved')
                                    <span class="text-green-600 font-bold">Selesai</span>
                                @elseif($refund->status == 'declined')
                                    <span class="text-red-600 font-bold">Ditolak</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('_superadmin.transactions.components.payment-proof-modal', ['proof' => $transaction->payment_proof])
        </div>
    </div>

    <!-- SCRIPT UNTUK MUNCULKAN HEADER & CONTENT -->
    <script>
        document.getElementById('main-content')?.classList.remove('initial-hidden');
        document.getElementById('navbar-header')?.classList.remove('initial-hidden');
    </script>
</x-app-layout>