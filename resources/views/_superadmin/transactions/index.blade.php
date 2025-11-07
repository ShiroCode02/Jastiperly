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
                                    <option value="refund" {{ request('status') == 'refund' ? 'selected' : '' }}>Refund</option>
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

                            <livewire:search-input route="superadmin.transactions" />

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

                    <div class="bg-white/70 rounded-xl shadow-md p-8 mx-auto border border-gray-200 max-w-4xl">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Kiri: Info Utama -->
                            <div class="space-y-4">
                                <div class="flex justify-between">
                                    <span class="font-semibold text-gray-700">ID Transaksi</span>
                                    <span class="font-medium">#JST{{ $transaction->id }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-semibold text-gray-700">Tanggal</span>
                                    <span>{{ $transaction->created_at->format('d-m-Y H:i') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-semibold text-gray-700">Jenis</span>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ request('type') === 'buy' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ request('type') === 'buy' ? 'Titip Beli' : 'Titip Kirim' }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-semibold text-gray-700">Status</span>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                        {{ $transaction->payment_status === 'approved' ? 'bg-green-100 text-green-700' :
                                           ($transaction->payment_status === 'declined' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                        {{ ucfirst($transaction->payment_status) }}
                                    </span>
                                </div>
                                @if($transaction instanceof \App\Models\BuyTransaction && $transaction->refund)
                                    <div class="flex justify-between">
                                        <span class="font-semibold text-gray-700">Refund</span>
                                        <span class="text-red-600 text-sm">{{ $transaction->refund->status }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Kanan: Pengguna -->
                            <div class="space-y-4">
                                @if(request('type') === 'buy')
                                    <div><strong>Penitip:</strong> {{ $transaction->buyer->name }}</div>
                                    <div><strong>Traveler:</strong> {{ $transaction->traveler->name }}</div>
                                @else
                                    <div><strong>Pengirim:</strong> {{ $transaction->sender->name }}</div>
                                    <div><strong>Penerima:</strong> {{ $transaction->reciever->name }}</div>
                                    <div><strong>Lokasi:</strong> {{ $transaction->delivery_type }}</div>
                                @endif
                                <div><strong>Metode:</strong> {{ $transaction->paymentMethod->name ?? '-' }}</div>
                            </div>
                        </div>

                        <!-- Barang -->
                        <div class="mt-8 border-t pt-6">
                            <h3 class="font-semibold text-lg mb-3">Detail Barang</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div><strong>Nama:</strong> {{ $transaction->product->name }}</div>
                                <div><strong>Harga:</strong> Rp{{ number_format($transaction->total_price ?? $transaction->product->price, 0, ',', '.') }}</div>
                                @if(request('type') === 'buy')
                                    <div><strong>Jumlah:</strong> {{ $transaction->quantity }}</div>
                                @else
                                    <div><strong>Berat:</strong> {{ $transaction->weight ?? '-' }}</div>
                                    <div><strong>Dimensi:</strong> {{ $transaction->dimension ?? '-' }}</div>
                                    <div><strong>Resi:</strong> {{ $transaction->delivery_code ?? '-' }}</div>
                                @endif
                            </div>
                            @if($transaction->payment_proof)
                                <div class="mt-4">
                                    <strong>Bukti Pembayaran:</strong>
                                    <img src="{{ asset('storage/' . $transaction->payment_proof) }}" class="mt-2 w-48 rounded border">
                                </div>
                            @endif
                        </div>
                    </div>

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
                                        <td class="p-3 text-center">
                                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                                {{ $trx->payment_status === 'approved' ? 'bg-green-100 text-green-700' :
                                                   ($trx->payment_status === 'declined' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                                {{ ucfirst($trx->payment_status) }}
                                            </span>
                                        </td>
                                        <td class="p-3 text-center font-medium">Rp{{ number_format($trx->total_price ?? 0, 0, ',', '.') }}</td>
                                        <td class="p-3 text-center">{{ $trx->paymentMethod->name ?? '-' }}</td>
                                        <td class="p-3 flex justify-center gap-2">
                                            <button class="p-2 rounded-md transition hover:scale-110" style="background-color: #FAB00580;">
                                                <x-icons.icon name="pencil" class="w-4 h-4 text-white" />
                                            </button>
                                            <a href="{{ route('superadmin.transactions', array_merge(request()->query(), ['transaction_id' => $trx->id])) }}"
                                               class="p-2 rounded-md transition hover:scale-110" style="background-color: #0095DA80;">
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