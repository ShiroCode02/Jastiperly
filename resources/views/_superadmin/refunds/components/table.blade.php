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
            @php $start = ($refunds->currentPage() - 1) * $refunds->perPage() + 1; @endphp
            @forelse($refunds as $index => $refund)
                @php
                    $transaction = $refund->buyTransaction;
                    $buyer = $transaction->buyer->detail ?? null;
                @endphp
                <tr class="border-b hover:bg-blue-100 transition">
                    <!-- No -->
                    <td class="p-3 text-center">{{ $start + $index }}</td>

                    <!-- Nama Penitip -->
                    <td class="p-3 text-center font-semibold">
                        {{ $buyer?->name ?? '-' }}
                    </td>

                    <!-- ID Transaksi -->
                    <td class="p-3 text-center font-mono">JST{{ $transaction->id }}</td>

                    <!-- Tanggal -->
                    <td class="p-3 text-center">{{ $refund->created_at->format('d-m-Y') }}</td>

                    <!-- Status Refund -->
                    <td class="p-3 text-center font-semibold">
                        @if($refund->status == 'pending')
                            <span class="text-yellow-500">Proses</span>
                        @elseif($refund->status == 'approved')
                            <span class="text-green-600">Disetujui</span>
                        @elseif($refund->status == 'declined')
                            <span class="text-red-500">Ditolak</span>
                        @else
                            <span class="text-gray-500">-</span>
                        @endif
                    </td>

                    <!-- Total Transaksi -->
                    <td class="p-3 text-center font-medium">
                        Rp{{ number_format($transaction->total_price, 0, ',', '.') }}
                    </td>

                    <!-- Pembayaran -->
                    <td class="p-3 text-center">
                        {{ $transaction->paymentMethod->name ?? '-' }}
                    </td>

                    <!-- Aksi -->
                    <td class="p-3 flex justify-center gap-2">
                        <!-- EDIT (belum ada rute) -->
                        <a href="#" 
                           class="p-2 rounded-md transition hover:scale-110" 
                           style="background-color: #FAB00580;"
                           title="Edit Refund">
                            <x-icons.icon name="pencil" class="w-4 h-4 text-white" />
                        </a>

                        <!-- LIHAT DETAIL -->
                        <a href="{{ route('superadmin.refunds.show', $refund->id) }}"
                           class="p-2 rounded-md transition hover:scale-110" 
                           style="background-color: #0095DA80;">
                            <x-icons.icon name="eye" class="w-4 h-4 text-white" />
                        </a>

                        <!-- HAPUS (belum ada) -->
                        <button type="button"
                                class="p-2 rounded-md transition hover:scale-110" 
                                style="background-color: #FA525280;"
                                title="Hapus Refund"
                                onclick="alert('Fitur hapus belum tersedia')">
                            <x-icons.icon name="trash" class="w-4 h-4 text-white" />
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-gray-500 py-6">
                        Tidak ada pengembalian dana
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Footer Tabel -->
<div class="flex justify-between items-center bg-white/50 p-3 shadow-md">
    <span class="text-gray-700 text-semibold">Total {{ $refunds->total() }}</span>
    <div class="flex gap-2 items-center">
        <button 
            onclick="window.location.href='{{ $refunds->appends(request()->query())->previousPageUrl() }}'" 
            class="px-2 py-1 rounded-lg hover:bg-gray-300 {{ $refunds->onFirstPage() ? 'hover:opacity-50 cursor-not-allowed' : '' }}" 
            {{ $refunds->onFirstPage() ? 'disabled' : '' }}>
            &lt;
        </button>

        @php
            $current = $refunds->currentPage();
            $last = $refunds->lastPage();
            $start = max(1, $current - 1);
            $end = min($last, $current + 1);
            if ($current == 1) $end = min($last, 2);
            if ($current == $last) $start = max(1, $last - 1);
        @endphp

        @for($i = $start; $i <= $end; $i++)
            <span 
                onclick="window.location.href='{{ $refunds->appends(request()->query())->url($i) }}'" 
                class="inline-block text-black font-semibold hover:bg-[#577BC1]/50 hover:text-white rounded-full px-2 transition cursor-pointer {{ $i == $current ? 'bg-[#577BC1]/70 text-white' : '' }}">
                {{ $i }}
            </span>
        @endfor

        <button 
            onclick="window.location.href='{{ $refunds->appends(request()->query())->nextPageUrl() }}'" 
            class="px-2 py-1 rounded-lg hover:bg-gray-300 {{ !$refunds->hasMorePages() ? 'hover:opacity-50 cursor-not-allowed' : '' }}" 
            {{ !$refunds->hasMorePages() ? 'disabled' : '' }}>
            &gt;
        </button>
    </div>
</div>