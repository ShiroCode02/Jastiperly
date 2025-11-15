<div id="latest-transactions-card"
     hx-get="{{ route('superadmin.dashboard.transactions') }}?page={{ $latestTransactions->currentPage() }}"
     hx-target="#latest-transactions-card"
     hx-swap="outerHTML"
     hx-indicator="#loading-spinner">

    <div class="overflow-x-auto">
        <table class="w-full text-sm border-collapse border-black">
            <thead>
                <tr class="bg-[#577BC1] text-white">
                    <th class="p-2 border border-black">No</th>
                    <th class="p-2 border border-black">ID Transaksi</th>
                    <th class="p-2 border border-black">Nama Traveler</th>
                    <th class="p-2 border border-black">Nama Penitip</th>
                    <th class="p-2 border border-black">Total Transaksi</th>
                    <th class="p-2 border border-black">Layanan</th>
                    <th class="p-2 border border-black">Metode Pembayaran</th>
                    <th class="p-2 border border-black">Status</th>
                    <th class="p-2 border border-black">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($latestTransactions as $index => $trx)
                <tr class="text-center hover:bg-blue-50">
                    <td class="p-2 border border-black">
                        {{ ($latestTransactions->currentPage() - 1) * $latestTransactions->perPage() + $loop->iteration }}
                    </td>
                    <td class="p-2 border border-black">#JSTP{{ $trx->id }}</td>
                    <td class="p-2 border border-black">{{ $trx->traveler?->detail->name ?? ($trx->sender?->detail->name ?? '-') }}</td>
                    <td class="p-2 border border-black">{{ $trx->buyer?->detail->name ?? ($trx->reciever?->detail->name ?? '-') }}</td>
                    <td class="p-2 border border-black">Rp{{ number_format($trx->total_price ?? 0, 0, ',', '.') }}</td>
                    <td class="p-2 border border-black">
                        @php
                            $type = $trx->type ?? ($trx instanceof \App\Models\BuyTransaction ? 'buy' : 'send');
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $type === 'buy' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $type === 'buy' ? 'Titip Beli' : 'Titip Kirim' }}
                        </span>
                    </td>
                    <td class="p-2 border border-black">{{ $trx->paymentMethod?->name ?? '-' }}</td>
                    <td class="p-2 border border-black">
                        @if($trx->payment_status == 'pending')
                            <span class="text-yellow-500 font-semibold">Belum Bayar</span>
                        @elseif($trx->payment_status == 'approved')
                            <span class="text-green-600 font-semibold">Selesai</span>
                        @elseif($trx->payment_status == 'declined')
                            <span class="text-red-500">Dibatalkan</span>
                        @else
                            <span class="text-gray-500">-</span>
                        @endif
                    </td>
                    <td class="p-2 border border-black">
                        @php
                            $type = $trx->type ?? ($trx instanceof \App\Models\BuyTransaction ? 'buy' : 'send');
                            $detailRoute = route('superadmin.transactions.show', [
                                'transaction' => $trx->id,
                                'type' => $type
                            ]);
                        @endphp
                        <a href="{{ $detailRoute }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded-lg transition">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center text-gray-500 py-4">Tidak ada transaksi</td></tr>
                @endforelse
            </tbody>
        </table>

        <!-- PAGINATION HTMX -->
        <div class="mt-4">
            @include('_superadmin.components.pagination-htmx', ['paginator' => $latestTransactions])
        </div>
    </div>
</div>