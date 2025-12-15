<div class="rounded-t-lg overflow-hidden shadow-md bg-white/50">
    <table class="w-full text-sm border-collapse">
        <thead class="bg-[#577BC1]/40 text-blue-900">
            <tr>
                <th class="p-3 text-center font-semibold">{{ __('tables.columns.no') }}</th>
                <th class="p-3 text-center font-semibold">{{ __('tables.columns.customer') }}</th>
                <th class="p-3 text-center font-semibold">{{ __('tables.columns.transaction_id') }}</th>
                <th class="p-3 text-center font-semibold">{{ __('tables.columns.date') }}</th>
                <th class="p-3 text-center font-semibold">{{ __('tables.columns.status') }}</th>
                <th class="p-3 text-center font-semibold">{{ __('tables.columns.total_transactions') }}</th>
                <th class="p-3 text-center font-semibold">{{ __('tables.columns.payment_methods') }}</th>
                <th class="p-3 text-center font-semibold">{{ __('tables.columns.action') }}</th>
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
                            <span class="text-yellow-500">{{ __('messages.refunds_status.pending') }}</span>
                        @elseif($refund->status == 'approved')
                            <span class="text-green-600">{{ __('messages.refunds_status.approved') }}</span>
                        @elseif($refund->status == 'declined')
                            <span class="text-red-500">{{ __('messages.refunds_status.declined') }}</span>
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
                        <!-- EDIT -->
                        <a href="{{ route('superadmin.refunds.edit', $refund->id) }}" 
                           class="p-2 rounded-md transition hover:scale-110" 
                           style="background-color: #FAB00580;">
                            <x-icons.icon name="pencil" class="w-4 h-4 text-white" />
                        </a>

                        <!-- LIHAT DETAIL -->
                        <a href="{{ route('superadmin.refunds.show', $refund->id) }}"
                           class="p-2 rounded-md transition hover:scale-110" 
                           style="background-color: #0095DA80;">
                            <x-icons.icon name="eye" class="w-4 h-4 text-white" />
                        </a>

                        <!-- HAPUS -->
                        <button type="button"
                                class="p-2 rounded-md transition hover:scale-110" 
                                style="background-color: #FA525280;"
                                onclick="confirmDeleteRefund({{ $refund->id }})">
                            <x-icons.icon name="trash" class="w-4 h-4 text-white" />
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-gray-500 py-6">
                        {{ __('messages.no_refunds') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-4">
    @include('_superadmin.components.pagination-simple', ['paginator' => $refunds])
</div>