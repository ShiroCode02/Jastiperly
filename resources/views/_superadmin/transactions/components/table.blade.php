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
            @php $start = ($transactions->currentPage() - 1) * $transactions->perPage() + 1; @endphp
            @forelse($transactions as $index => $trx)
                <tr class="border-b hover:bg-blue-100 transition">
                    <td class="p-3 text-center">{{ $start + $index }}</td>
                    <td class="p-3 text-center font-semibold">
                        {{ $trx instanceof \App\Models\BuyTransaction ? $trx->buyer->detail->name : $trx->sender->detail->name }}
                    </td>
                    <td class="p-3 text-center">JSTP{{ $trx->id }}</td>
                    <td class="p-3 text-center">{{ $trx->created_at->format('d-m-Y') }}</td>
                    <td class="p-3 text-center font-semibold">
                        @if($trx->payment_status == 'pending') <span class="text-yellow-500">{{ __('messages.transactions_status.pending') }}</span>
                        @elseif($trx->payment_status == 'approved') <span class="text-green-600">{{ __('messages.transactions_status.approved') }}</span>
                        @elseif($trx->payment_status == 'declined') <span class="text-red-500">{{ __('messages.transactions_status.declined') }}</span>
                        @else <span class="text-gray-500">-</span> @endif
                    </td>
                    <td class="p-3 text-center font-medium">
                        @if($trx->total_price ?? false)
                            Rp{{ number_format($trx->total_price, 0, ',', '.') }}
                        @else
                            <span class="text-gray-500">-</span>
                        @endif
                    </td>
                    <td class="p-3 text-center">{{ $trx->paymentMethod->name ?? '-' }}</td>
                    <td class="p-3 flex justify-center gap-2">
                        <a href="{{ route('superadmin.transactions.edit', $trx->id) . '?type=' . ($trx instanceof \App\Models\BuyTransaction ? 'buy' : 'send') }}"
                           class="p-2 rounded-md transition hover:scale-110" style="background-color: #FAB00580;">
                            <x-icons.icon name="pencil" class="w-4 h-4 text-white" />
                        </a>
                        <a href="{{ route('superadmin.transactions.show', ['transaction' => $trx->id, 'type' => $trx instanceof \App\Models\BuyTransaction ? 'buy' : 'send']) }}"
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

<!-- Pagination -->
<div class="mt-4">
    @include('_superadmin.components.pagination-simple', ['paginator' => $transactions])
</div>