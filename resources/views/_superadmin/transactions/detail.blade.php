<x-app-layout>
    <div class="flex min-h-screen">
        @include('layouts.sidebar-superadmin')
        <div id="main-content" class="flex-1 ml-97 transition-all duration-300 flex flex-col min-h-screen initial-hidden">
            @include('_superadmin.transactions.components.header')

            <div class="flex-1 px-6 pb-6 pt-48 space-y-6">
                <!-- KONTEN DETAIL -->
                @php
                    $isSend = $type === 'send';
                @endphp

                @if($isSend)
                    <!-- === TITIP KIRIM: DETAIL === -->
                    <div class="bg-white/70 rounded-xl shadow-md p-6 mx-auto border border-gray-200 max-w-5xl">
                        <!-- JUDUL -->
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.transaction_info') }}</h2>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- KIRI: PENGGUNA -->
                            <div class="space-y-6">

                                <!-- Informasi Pengirim -->
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800 mb-3">{{ __('messages.sender_info') }}</h3>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.transaction_id') }}</label>
                                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">TKR{{ $transaction->id }}</div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.sender_contact') }}</label>
                                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                                {{ $transaction->sender->detail->phone ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.full_name') }}</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                            {{ $transaction->sender->detail->name ?? $transaction->sender->name }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Informasi Penerima -->
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800 mb-3">{{ __('messages.labels.recipient_info') }}</h3>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.full_name') }}</label>
                                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                                {{ $transaction->reciever->detail->name ?? $transaction->reciever->name }}
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.recipient_contact') }}</label>
                                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                                {{ $transaction->reciever->detail->phone ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Informasi Pengiriman -->
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800 mb-3">{{ __('messages.labels.shipping_info') }}</h3>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.shipping_method') }}</label>
                                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                                {{ $transaction->delivery_method ?? 'Tidak tersedia' }}
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.pickup_address') }}</label>
                                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white text-xs">
                                                {{ $transaction->pickup_address ?? 'Tidak tersedia' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.status') }}</label>
                                    <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                        @if($transaction->payment_status == 'pending')
                                            <span class="text-yellow-500 font-semibold">{{ __('messages.transactions_status.pending') }}</span>
                                        @elseif($transaction->payment_status == 'approved')
                                            <span class="text-green-600 font-semibold">{{ __('messages.transactions_status.approved') }}</span>
                                        @elseif($transaction->payment_status == 'declined')
                                            <span class="text-red-500 font-semibold">{{ __('messages.transactions_status.declined') }}</span>
                                        @else
                                            <span class="text-gray-500 font-semibold">-</span>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <!-- KANAN: LOGISTIK -->
                            <div class="space-y-6 mt-10">

                                <!-- Resi -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.delivery_receipt') }}</label>
                                    <div class="border border-gray-300 rounded-md px-4 py-2 bg-white font-mono">
                                        {{ $transaction->delivery_code ?? '-' }}
                                    </div>
                                </div>

                                <!-- Alamat Tujuan -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.destination_address') }}</label>
                                    <div class="border border-gray-300 rounded-md px-4 py-2 bg-white text-xs">
                                        {{ $transaction->delivery_address ?? 'Tidak tersedia' }}
                                    </div>
                                </div>

                                <!-- Jenis Pengiriman -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.delivery_type') }}</label>
                                    <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                        {{ $transaction->delivery_type ?? __('messages.unknown.') }}
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- DETAIL TITIPAN -->
                        <div class="mt-10 border-t pt-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-5">{{ __('messages.labels.delivery_type') }}</h3>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <!-- Kiri -->
                                <div class="space-y-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.name_of_goods') }}</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">{{ $transaction->product->name }}</div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.item_category') }}</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">{{ $transaction->product->category->name ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.item_size') }}</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">{{ $transaction->dimension ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.item_weight') }}</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                            {{ $transaction->weight ? preg_replace('/[^0-9.]/', '', $transaction->weight) . ' kg' : '-' }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Kanan: Foto -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.item_photos') }}</label>
                                    <div class="border border-gray-300 rounded-md p-2 bg-white">
                                        @if($transaction->product->image)
                                            <img src="{{ asset('storage/' . $transaction->product->image) }}" class="w-full h-48 object-cover rounded-md" alt="Foto Barang">
                                        @else
                                            <div class="w-full h-48 bg-gray-200 border-2 border-dashed rounded-md flex items-center justify-center text-gray-500">
                                                {{ __('messages.no_photos') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- DESKRIPSI -->
                        <div class="mt-8">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.item_description') }}</label>
                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white min-h-24">
                                {{ $transaction->product->description ?? __('messages.no_description.') }}
                            </div>
                        </div>

                        <!-- DETAIL TRANSAKSI BAWAH -->
                        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.transaction_date') }}</label>
                                <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">{{ $transaction->created_at->format('d-m-Y') }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.payment_methods') }}</label>
                                <div class="border border-gray-300 rounded-md px-4 py-2 bg-white flex justify-between items-center">
                                    <span>{{ $transaction->paymentMethod->name ?? '-' }}</span>
                                    @if($transaction->payment_proof)
                                        <button type="button" 
                                                onclick="showProofModal('{{ asset('storage/' . $transaction->payment_proof) }}')"
                                                class="text-blue-600 text-xs underline hover:text-blue-800">
                                            {{ __('messages.actions.view_proof_of_transaction') }}
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
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.transaction_info') }}</h2>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- KIRI: Info Utama -->
                            <div class="space-y-5">
                                <!-- ID Transaksi -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.transaction_id') }}</label>
                                    <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                        #JSTP{{ $transaction->id }}
                                    </div>
                                </div>

                                <!-- Tanggal -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.transaction_date') }}</label>
                                    <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                        {{ $transaction->created_at->format('d-m-Y') }}
                                    </div>
                                </div>

                                <!-- Total -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.total_transactions') }}</label>
                                    <div class="border border-gray-300 rounded-md px-4 py-2 bg-white font-medium">
                                        @if($transaction->total_price)
                                            Rp{{ number_format($transaction->total_price, 0, ',', '.') }}
                                        @elseif($transaction->product && $transaction->product->price)
                                            Rp{{ number_format($transaction->product->price, 0, ',', '.') }}
                                        @else
                                            <span class="text-gray-500">{{ __('messages.not_yet_available') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Status -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.status') }}</label>
                                    <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                        @if($transaction->payment_status == 'pending')
                                            <span class="text-yellow-500 font-semibold">{{ __('messages.transactions_status.pending') }}</span>
                                        @elseif($transaction->payment_status == 'approved')
                                            <span class="text-green-600 font-semibold">{{ __('messages.transactions_status.approved') }}</span>
                                        @elseif($transaction->payment_status == 'declined')
                                            <span class="text-red-500 font-semibold">{{ __('messages.transactions_status.declined') }}</span>
                                        @else
                                            <span class="text-gray-500 font-semibold">-</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- KANAN: Pengguna & Metode -->
                            <div class="space-y-5">
                                @if($type === 'buy')
                                    <!-- Penitip -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.names.customer') }}</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                            {{ $transaction->buyer->detail->name }}
                                        </div>
                                    </div>

                                    <!-- Traveler -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.names.traveler') }}</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                            {{ $transaction->traveler->detail->name }}
                                        </div>
                                    </div>
                                @else
                                    <!-- Pengirim -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.sender_name') }}</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                            {{ $transaction->sender->detail->name }}
                                        </div>
                                    </div>

                                    <!-- Penerima -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.recipient_name') }}</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                            {{ $transaction->receiver->detail->name }}
                                        </div>
                                    </div>
                                @endif

                                <!-- Metode Pembayaran -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.payment_methods') }}</label>
                                    <div class="border border-gray-300 rounded-md px-4 py-2 bg-white flex justify-between items-center">
                                        <span>{{ $transaction->paymentMethod->name ?? '-' }}</span>
                                        @if($transaction->payment_proof)
                                            <button type="button" 
                                                    onclick="showProofModal('{{ asset('storage/' . $transaction->payment_proof) }}')"
                                                    class="text-blue-600 text-xs underline hover:text-blue-800">
                                                {{ __('messages.actions.view_proof_of_transaction') }}
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- DETAIL BARANG -->
                        <div class="mt-10 border-t pt-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-5">{{ __('messages.item_details') }}</h3>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <!-- Kiri: Info Barang -->
                                <div class="space-y-5">
                                    <!-- Nama Barang -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.name_of_goods') }}</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                            {{ $transaction->product->name }}
                                        </div>
                                    </div>

                                    <!-- Kategori -->
                                    @if(isset($transaction->product->category))
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.item_category') }}</label>
                                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                                {{ $transaction->product->category->name ?? 'Tidak ada kategori' }}
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Asal Barang -->
                                    @if($type === 'buy')
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.origin_of_goods') }}</label>
                                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                                {{ $transaction->product->origin ?? __('messages.not_available') }}
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Jumlah / Berat -->
                                    @if($type === 'buy')
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.the_amount_of_goods') }}</label>
                                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">
                                                {{ $transaction->quantity }} {{ __('messages.units') }}
                                            </div>
                                        </div>
                                    @else
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.item_weight') }}</label>
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
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.item_photos') }}</label>
                                        <div class="border border-gray-300 rounded-md p-2 bg-white">
                                            @if($transaction->product->image)
                                                <img src="{{ asset('storage/' . $transaction->product->image) }}" 
                                                    class="w-full h-48 object-cover rounded-md" alt="Foto Barang">
                                            @else
                                                <div class="w-full h-48 bg-gray-200 border-2 border-dashed rounded-md flex items-center justify-center text-gray-500">
                                                    {{ __('messages.no_photos') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Deskripsi -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.item_description') }}</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white min-h-24">
                                            {{ $transaction->product->description ?? __('messages.no_description') }}
                                        </div>
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