<x-app-layout>
    <div class="flex min-h-screen">
        @include('layouts.sidebar-superadmin')

        <div id="main-content" class="flex-1 ml-97 transition-all duration-300 flex flex-col min-h-screen initial-hidden">
            <div id="navbar-header" class="fixed top-0 left-97 right-0 z-20 transition-all duration-300 initial-hidden"
                 style="background-color: #DBEDFF; padding: 1rem 1.5rem;">
                @include('layouts.navigation-superadmin', ['title' => 'Transaksi'])

                <div class="mt-2 flex justify-between items-center">
                    @if(!request('transaction_id'))
                        <!-- TAB + FILTER + UNDUH (Hanya di daftar) -->
                        <div class="flex gap-3 bg-[#FFF6E3] mt-3 px-6 py-1 rounded-md items-center">
                            @foreach (['buy' => 'Titip Beli', 'send' => 'Titip Kirim'] as $type => $label)
                                @php
                                    $count = $type === 'buy'
                                        ? \App\Models\BuyTransaction::count()
                                        : \App\Models\SendTransaction::count();
                                @endphp
                                <a href="{{ route('superadmin.transactions', ['type' => $type]) }}"
                                   class="flex items-center gap-2 px-4 py-1.5 rounded-md text-black font-medium
                                          hover:bg-white transition {{ request('type', 'buy') === $type ? 'bg-white text-black' : 'bg-transparent' }}">
                                    <span>{{ $label }}</span>
                                    <span class="text-gray-400 text-xs font-bold flex items-center justify-center ml-1">
                                        {{ $count }}
                                    </span>
                                </a>
                                @if($loop->first)<div class="w-0.5 bg-black h-4"></div>@endif
                            @endforeach
                        </div>

                        <div class="flex items-center gap-3 mt-6">
                            <form method="GET" class="flex items-center gap-2">
                                <select name="status" onchange="this.form.submit()"
                                        class="border border-gray-300 rounded-md px-4 py-1.5 text-sm focus:outline-none">
                                    <option value="">Semua Status</option>
                                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="berjalan" {{ request('status') == 'berjalan' ? 'selected' : '' }}>Berjalan</option>
                                    <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>

                                <select name="location" onchange="this.form.submit()"
                                        class="border border-gray-300 rounded-md px-4 py-1.5 text-sm focus:outline-none">
                                    <option value="">Semua Lokasi</option>
                                    <option value="dalam" {{ request('location') == 'dalam' ? 'selected' : '' }}>Dalam Negeri</option>
                                    <option value="luar" {{ request('location') == 'luar' ? 'selected' : '' }}>Luar Negeri</option>
                                </select>

                                <input type="hidden" name="type" value="{{ request('type', 'buy') }}">
                                @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}"> @endif
                            </form>

                            <a href="{{ route('superadmin.transactions.export', request()->query()) }}"
                               class="flex items-center gap-2 bg-yellow-200 hover:bg-yellow-300 text-black font-semibold px-4 py-1 rounded-md shadow transition">
                                <span>Unduh Data</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                                </svg>
                            </a>
                        </div>
                    @else
                        <!-- DETAIL: Kembali + Unduh -->
                        <div class="flex justify-between items-center w-full mt-4">
                            <div class="flex items-center gap-3 ml-6">
                                <a href="{{ route('superadmin.transactions', request()->except('transaction_id')) }}"
                                   class="text-blue-900 hover:text-blue-600 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </a>
                                <h2 class="text-[32px] font-semibold text-blue-900">
                                    Detail {{ request('type') === 'buy' ? 'Titip Beli' : 'Titip Kirim' }}
                                </h2>
                            </div>
                            <a href="{{ route('superadmin.transactions.export', array_merge(request()->query(), ['transaction_id' => request('transaction_id')])) }}"
                               class="flex items-center gap-2 bg-yellow-200 hover:bg-yellow-300 text-black font-semibold px-4 py-1 rounded-md shadow transition">
                                <span>Unduh Data</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Konten Utama -->
            <div class="flex-1 px-6 pb-6 pt-48 space-y-6">

                @if(request('transaction_id'))
                    <!-- === DETAIL TRANSAKSI === -->
                    @php
                        $transaction = request('type') === 'buy'
                            ? \App\Models\BuyTransaction::with(['buyer', 'traveler', 'product', 'paymentMethod', 'refund'])->findOrFail(request('transaction_id'))
                            : \App\Models\SendTransaction::with(['sender', 'reciever', 'product', 'paymentMethod'])->findOrFail(request('transaction_id'));
                    @endphp

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
                                            <span class="text-red-500 font-semibold">Belum Bayar</span>
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
                                            {{ $transaction->buyer->name }}
                                        </div>
                                    </div>

                                    <!-- Traveler -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Traveler</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                            {{ $transaction->traveler->name }}
                                        </div>
                                    </div>
                                @else
                                    <!-- Pengirim -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Pengirim</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                            {{ $transaction->sender->name }}
                                        </div>
                                    </div>

                                    <!-- Penerima -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Penerima</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                            {{ $transaction->reciever->name }}
                                        </div>
                                    </div>
                                @endif

                                <!-- Metode Pembayaran -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Metode Pembayaran</label>
                                    <div class="border border-gray-300 rounded-md px-4 py-2 bg-white flex justify-between items-center">
                                        <span>{{ $transaction->paymentMethod->name ?? '-' }}</span>
                                        @if($transaction->payment_proof)
                                            <button onclick="document.getElementById('proofModal').classList.remove('hidden')"
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

                    <!-- MODAL BUKTI TRANSAKSI -->
                    @if($transaction->payment_proof)
                    <div id="proofModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
                        <div class="bg-white rounded-lg max-w-2xl w-full p-6 relative">
                            <button onclick="document.getElementById('proofModal').classList.add('hidden')"
                                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                            <h3 class="text-lg font-semibold mb-4">Bukti Pembayaran</h3>
                            <img src="{{ asset('storage/' . $transaction->payment_proof) }}" class="w-full rounded-md" alt="Bukti">
                        </div>
                    </div>
                    @endif

                @else
                    <!-- === DAFTAR TRANSAKSI === -->
                    <div class="rounded-t-lg overflow-hidden shadow-md bg-white/50">
                        <table class="w-full text-sm border-collapse">
                            <thead class="bg-[#577BC1]/40 text-blue-900">
                                <tr>
                                    <th class="p-3 text-center font-semibold">No</th>
                                    <th class="p-3 text-center font-semibold">Nama Penitip</th>
                                    <th class="p-3 text-center font-semibold">ID Transaksi</th>
                                    <th class="p-3 text-center font-semibold">Tanggal</th>
                                    <th class="p-3 text-center font-semibold">Status</th>
                                    <th class="p-3 text-center font-semibold">Total Transaksi</th>
                                    <th class="p-3 text-center font-semibold">Pembayaran</th>
                                    <th class="p-3 text-center font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $start = ($transactions->currentPage() - 1) * $transactions->perPage() + 1;
                                @endphp
                                @forelse($transactions as $index => $trx)
                                    <tr class="border-b hover:bg-blue-100 transition">
                                        <td class="p-3 text-center">{{ $start + $index }}</td>
                                        <td class="p-3 text-center font-semibold">
                                            {{ $trx instanceof \App\Models\BuyTransaction ? $trx->buyer->name : $trx->sender->name }}
                                        </td>
                                        <td class="p-3 text-center">JST{{ $trx->id }}</td>
                                        <td class="p-3 text-center">{{ $trx->created_at->format('d-m-Y') }}</td>
                                        <td class="p-3 text-center font-semibold">
                                            @if($trx->payment_status == 'pending')
                                                <span class="text-red-500">Belum Bayar</span>
                                            @elseif($trx->payment_status == 'approved')
                                                <span class="text-green-600">Selesai</span>
                                            @elseif($trx->payment_status == 'declined')
                                                <span class="text-red-500">Dibatalkan</span>
                                            @else
                                                <span class="text-gray-500">-</span>
                                            @endif
                                        </td>
                                        <td class="p-3 text-center font-medium">
                                            @if($trx->total_price)
                                                Rp{{ number_format($trx->total_price, 0, ',', '.') }}
                                            @elseif($trx->calculated_total ?? false)
                                                Rp{{ number_format($trx->calculated_total, 0, ',', '.') }}
                                            @else
                                                <span class="text-gray-500">-</span>
                                            @endif
                                        </td>
                                        <td class="p-3 text-center">{{ $trx->paymentMethod->name ?? '-' }}</td>
                                        <td class="p-3 flex justify-center gap-2">
                                            <button class="p-2 rounded-md transition hover:scale-110" style="background-color: #FAB00580;">
                                                <x-icons.icon name="pencil" class="w-4 h-4 text-white" />
                                            </button>
                                            <a href="{{ route('superadmin.transactions', array_merge(request()->query(), [
                                                'type' => $trx instanceof \App\Models\BuyTransaction ? 'buy' : 'send',
                                                'transaction_id' => $trx->id
                                            ])) }}" class="p-2 rounded-md transition hover:scale-110" style="background-color: #0095DA80;">
                                                <x-icons.icon name="eye" class="w-4 h-4 text-white" />
                                            </a>
                                            <button class="p-2 rounded-md transition hover:scale-110" style="background-color: #FA525280;"
                                                    onclick="confirmDelete({{ $trx->id }})">
                                                <x-icons.icon name="trash" class="w-4 h-4 text-white" />
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="8" class="text-center text-gray-500 py-6">Tidak ada transaksi</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer Tabel -->
                    <div class="flex justify-between items-center bg-white/50 p-3 shadow-md">
                        <span class="text-gray-700 text-semibold">Total {{ $transactions->total() }}</span>
                        <div class="flex gap-2 items-center">
                            <button 
                                onclick="window.location.href='{{ $transactions->appends(request()->query())->previousPageUrl() }}'" 
                                class="px-2 py-1 rounded-lg hover:bg-gray-300 {{ $transactions->onFirstPage() ? 'hover:opacity-50 cursor-not-allowed' : '' }}" 
                                {{ $transactions->onFirstPage() ? 'disabled' : '' }}>
                                &lt;
                            </button>

                            @php
                                $current = $transactions->currentPage();
                                $last = $transactions->lastPage();
                                $start = max(1, $current - 1);
                                $end = min($last, $current + 1);
                                if ($current == 1) $end = min($last, 2);
                                if ($current == $last) $start = max(1, $last - 1);
                            @endphp

                            @for($i = $start; $i <= $end; $i++)
                                <span 
                                    onclick="window.location.href='{{ $transactions->appends(request()->query())->url($i) }}'" 
                                    class="inline-block text-black font-semibold hover:bg-[#577BC1]/50 hover:text-white rounded-full px-2 transition cursor-pointer {{ $i == $current ? 'bg-[#577BC1]/70 text-white' : '' }}">
                                    {{ $i }}
                                </span>
                            @endfor

                            <button 
                                onclick="window.location.href='{{ $transactions->appends(request()->query())->nextPageUrl() }}'" 
                                class="px-2 py-1 rounded-lg hover:bg-gray-300 {{ !$transactions->hasMorePages() ? 'hover:opacity-50 cursor-not-allowed' : '' }}" 
                                {{ !$transactions->hasMorePages() ? 'disabled' : '' }}>
                                &gt;
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Hapus -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-xl">
            <h3 class="text-lg font-semibold mb-4 text-red-600">Hapus Transaksi?</h3>
            <p class="text-gray-600 mb-6">Data akan dihapus permanen dan tidak dapat dikembalikan.</p>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeDeleteModal()" class="px-5 py-2 text-gray-600 hover:text-gray-800 font-medium">Batal</button>
                <form id="deleteForm" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-md font-medium shadow transition">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            document.getElementById('deleteForm').action = `/superadmin/transactions/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
        document.getElementById('main-content').classList.remove('initial-hidden');
        document.getElementById('navbar-header').classList.remove('initial-hidden');
    </script>
</x-app-layout>