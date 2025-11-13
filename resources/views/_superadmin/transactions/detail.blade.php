<x-app-layout>
    <div class="flex min-h-screen">
        @include('layouts.sidebar-superadmin')
        <div id="main-content" class="flex-1 ml-97 transition-all duration-300 flex flex-col min-h-screen initial-hidden">
            @include('_superadmin.transactions.components.header')

            <div class="flex-1 px-6 pb-6 pt-48 space-y-6">
                <!-- KONTEN DETAIL -->
                @php
                    $isSend = request('type') === 'send';
                    $transaction = $isSend
                        ? \App\Models\SendTransaction::with(['sender', 'reciever', 'product', 'paymentMethod'])->findOrFail(request('transaction_id'))
                        : \App\Models\BuyTransaction::with(['buyer', 'traveler', 'product', 'paymentMethod', 'refund'])->findOrFail(request('transaction_id'));
                @endphp

                @if($isSend)
                    <!-- === TITIP KIRIM: DETAIL === -->
                    <div class="bg-white/70 rounded-xl shadow-md p-6 mx-auto border border-gray-200 max-w-5xl">
                        <!-- JUDUL -->
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Informasi Transaksi</h2>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- KIRI: PENGGUNA -->
                            <div class="space-y-6">

                                <!-- Informasi Pengirim -->
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800 mb-3">Informasi Pengirim</h3>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">ID Transaksi</label>
                                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">TKR{{ $transaction->id }}</div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Kontak Pengirim</label>
                                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                                {{ $transaction->sender->detail->phone ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                            {{ $transaction->sender->detail->name ?? $transaction->sender->name }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Informasi Penerima -->
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800 mb-3">Informasi Penerima</h3>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                                {{ $transaction->reciever->detail->name ?? $transaction->reciever->name }}
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Kontak Penerima</label>
                                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                                {{ $transaction->reciever->detail->phone ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Informasi Pengiriman -->
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800 mb-3">Informasi Pengiriman</h3>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Metode Pengiriman</label>
                                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                                {{ $transaction->delivery_method ?? 'Tidak tersedia' }}
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Pengambilan</label>
                                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white text-xs">
                                                {{ $transaction->pickup_address ?? 'Tidak tersedia' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                                    <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                        <span class="text-green-600 font-semibold">
                                            {{ $transaction->payment_status == 'approved' ? 'Selesai' : 'Belum Selesai' }}
                                        </span>
                                    </div>
                                </div>

                            </div>

                            <!-- KANAN: LOGISTIK -->
                            <div class="space-y-6 mt-10">

                                <!-- Resi -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Resi Pengiriman</label>
                                    <div class="border border-gray-300 rounded-md px-4 py-2 bg-white font-mono">
                                        {{ $transaction->delivery_code ?? '-' }}
                                    </div>
                                </div>

                                <!-- Alamat Tujuan -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Tujuan</label>
                                    <div class="border border-gray-300 rounded-md px-4 py-2 bg-white text-xs">
                                        {{ $transaction->delivery_address ?? 'Tidak tersedia' }}
                                    </div>
                                </div>

                                <!-- Jenis Pengiriman -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Pengiriman</label>
                                    <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                        {{ $transaction->delivery_type ?? 'Tidak diketahui' }}
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- DETAIL TITIPAN -->
                        <div class="mt-10 border-t pt-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-5">Detail Titipan</h3>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <!-- Kiri -->
                                <div class="space-y-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Barang</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">{{ $transaction->product->name }}</div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori Barang</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">{{ $transaction->product->category->name ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Ukuran Barang</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">{{ $transaction->dimension ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Berat Barang</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                            {{ $transaction->weight ? preg_replace('/[^0-9.]/', '', $transaction->weight) . ' kg' : '-' }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Kanan: Foto -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Foto Barang</label>
                                    <div class="border border-gray-300 rounded-md p-2 bg-white">
                                        @if($transaction->product->image)
                                            <img src="{{ asset('storage/' . $transaction->product->image) }}" class="w-full h-48 object-cover rounded-md" alt="Foto Barang">
                                        @else
                                            <div class="w-full h-48 bg-gray-200 border-2 border-dashed rounded-md flex items-center justify-center text-gray-500">
                                                Tidak ada foto
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- DESKRIPSI -->
                        <div class="mt-8">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Barang</label>
                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white min-h-24">
                                {{ $transaction->product->description ?? 'Tidak ada deskripsi.' }}
                            </div>
                        </div>

                        <!-- DETAIL TRANSAKSI BAWAH -->
                        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Transaksi</label>
                                <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">{{ $transaction->created_at->format('d-m-Y') }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Metode Pembayaran</label>
                                <div class="border border-gray-300 rounded-md px-4 py-2 bg-white flex justify-between items-center">
                                    <span>{{ $transaction->paymentMethod->name ?? '-' }}</span>
                                    @if($transaction->payment_proof)
                                        <button type="button" 
                                                onclick="showProofModal('{{ asset('storage/' . $transaction->payment_proof) }}')"
                                                class="text-blue-600 text-xs underline hover:text-blue-800">
                                            Lihat Bukti Transaksi
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- === TITIP BELI: DETAIL === -->
                    <div class="bg-white/70 rounded-xl shadow-md p-6 mx-auto border border-gray-200 max-w-5xl">
                        <!-- JUDUL -->
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Informasi Transaksi</h2>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- KIRI: Info Utama -->
                            <div class="space-y-5">
                                <!-- ID Transaksi -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">ID Transaksi</label>
                                    <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                        #JSTP{{ $transaction->id }}
                                    </div>
                                </div>

                                <!-- Tanggal -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Transaksi</label>
                                    <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                        {{ $transaction->created_at->format('d-m-Y') }}
                                    </div>
                                </div>

                                <!-- Total -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Total Transaksi</label>
                                    <div class="border border-gray-300 rounded-md px-4 py-2 bg-white font-medium">
                                        @if($transaction->total_price)
                                            Rp{{ number_format($transaction->total_price, 0, ',', '.') }}
                                        @elseif($transaction->product && $transaction->product->price)
                                            Rp{{ number_format($transaction->product->price, 0, ',', '.') }}
                                        @else
                                            <span class="text-gray-500">Belum tersedia</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Status -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                                    <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                        @if($transaction->payment_status == 'pending')
                                            <span class="text-yellow-500 font-semibold">Belum Bayar</span>
                                        @elseif($transaction->payment_status == 'approved')
                                            <span class="text-green-600 font-semibold">Selesai</span>
                                        @elseif($transaction->payment_status == 'declined')
                                            <span class="text-red-500 font-semibold">Dibatalkan</span>
                                        @else
                                            <span class="text-gray-500 font-semibold">-</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- KANAN: Pengguna & Metode -->
                            <div class="space-y-5">
                                @if(request('type') === 'buy')
                                    <!-- Penitip -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Penitip</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                            {{ $transaction->buyer->detail->name }}
                                        </div>
                                    </div>

                                    <!-- Traveler -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Traveler</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                            {{ $transaction->traveler->detail->name }}
                                        </div>
                                    </div>
                                @else
                                    <!-- Pengirim -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Pengirim</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                            {{ $transaction->sender->detail->name }}
                                        </div>
                                    </div>

                                    <!-- Penerima -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Penerima</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                            {{ $transaction->receiver->detail->name }}
                                        </div>
                                    </div>
                                @endif

                                <!-- Metode Pembayaran -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Metode Pembayaran</label>
                                    <div class="border border-gray-300 rounded-md px-4 py-2 bg-white flex justify-between items-center">
                                        <span>{{ $transaction->paymentMethod->name ?? '-' }}</span>
                                        @if($transaction->payment_proof)
                                            <button type="button" 
                                                    onclick="showProofModal('{{ asset('storage/' . $transaction->payment_proof) }}')"
                                                    class="text-blue-600 text-xs underline hover:text-blue-800">
                                                Lihat Bukti Transaksi
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- DETAIL BARANG -->
                        <div class="mt-10 border-t pt-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-5">Detail Barang</h3>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <!-- Kiri: Info Barang -->
                                <div class="space-y-5">
                                    <!-- Nama Barang -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Barang</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                            {{ $transaction->product->name }}
                                        </div>
                                    </div>

                                    <!-- Kategori -->
                                    @if(isset($transaction->product->category))
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori Barang</label>
                                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                                {{ $transaction->product->category->name ?? 'Tidak ada kategori' }}
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Asal Barang -->
                                    @if(request('type') === 'buy')
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Asal Barang</label>
                                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                                {{ $transaction->product->origin ?? 'Tidak tersedia' }}
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Jumlah / Berat -->
                                    @if(request('type') === 'buy')
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Jumlah Barang</label>
                                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                                {{ $transaction->quantity }} Unit
                                            </div>
                                        </div>
                                    @else
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Berat Barang</label>
                                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                                {{ $transaction->weight ?? '-' }} kg
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Kanan: Foto + Deskripsi -->
                                <div class="space-y-5">
                                    <!-- Foto Barang -->
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

                                    <!-- Deskripsi -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Barang</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white min-h-24">
                                            {{ $transaction->product->description ?? 'Tidak ada deskripsi.' }}
                                        </div>
                                        @if(request('type') === 'send')
                                            <p class="text-xs text-gray-500 mt-1">Dimensi: {{ $transaction->dimension ?? '-' }}</p>
                                            <p class="text-xs text-gray-500">No. Resi: {{ $transaction->delivery_code ?? '-' }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            @include('_superadmin.transactions.components.payment-proof-modal', ['proof' => $transaction->payment_proof])
        </div>
    </div>

    <script>
        document.getElementById('main-content').classList.remove('initial-hidden');
        document.getElementById('navbar-header').classList.remove('initial-hidden');
    </script>
</x-app-layout>