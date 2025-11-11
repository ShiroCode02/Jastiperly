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
            @php $start = ($transactions->currentPage() - 1) * $transactions->perPage() + 1; @endphp
            @forelse($transactions as $index => $trx)
                <tr class="border-b hover:bg-blue-100 transition">
                    <td class="p-3 text-center">{{ $start + $index }}</td>
                    <td class="p-3 text-center font-semibold">
                        {{ $trx instanceof \App\Models\BuyTransaction ? $trx->buyer->detail->name : $trx->sender->detail->name }}
                    </td>
                    <td class="p-3 text-center">JST{{ $trx->id }}</td>
                    <td class="p-3 text-center">{{ $trx->created_at->format('d-m-Y') }}</td>
                    <td class="p-3 text-center font-semibold">
                        @if($trx->payment_status == 'pending') <span class="text-red-500">Belum Bayar</span>
                        @elseif($trx->payment_status == 'approved') <span class="text-green-600">Selesai</span>
                        @elseif($trx->payment_status == 'declined') <span class="text-red-500">Dibatalkan</span>
                        @else <span class="text-gray-500">-</span> @endif
                    </td>
                    <td class="p-3 text-center font-medium">
                        @if($trx->total_price) Rp{{ number_format($trx->total_price, 0, ',', '.') }}
                        @elseif($trx->calculated_total ?? false) Rp{{ number_format($trx->calculated_total, 0, ',', '.') }}
                        @else <span class="text-gray-500">-</span> @endif
                    </td>
                    <td class="p-3 text-center">{{ $trx->paymentMethod->name ?? '-' }}</td>
                    <td class="p-3 flex justify-center gap-2">
                        <a href="{{ route('superadmin.transactions.edit', $trx->id) . '?type=' . ($trx instanceof \App\Models\BuyTransaction ? 'buy' : 'send') }}"
                           class="p-2 rounded-md transition hover:scale-110" style="background-color: #FAB00580;">
                            <x-icons.icon name="pencil" class="w-4 h-4 text-white" />
                        </a>
                        <a href="{{ route('superadmin.transactions', array_merge(request()->query(), ['type' => $trx instanceof \App\Models\BuyTransaction ? 'buy' : 'send', 'transaction_id' => $trx->id])) }}"
                           class="p-2 rounded-md transition hover:scale-110" style="background-color: #0095DA80;">
                            <x-icons.icon name="eye" class="w-4 h-4 text-white" />
                        </a>
                        <button class="p-2 rounded-md transition hover:scale-110" style="background-color: #FA525280;" onclick="confirmDelete({{ $trx->id }})">
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