<x-app-layout>
    <div class="flex min-h-screen">
        @include('layouts.sidebar-superadmin')
        <div id="main-content" class="flex-1 ml-97 transition-all duration-300 flex flex-col min-h-screen initial-hidden">
            @include('_superadmin.transactions.components.header')

            <div class="flex-1 px-6 pb-6 pt-48 space-y-6">
                @php $isSend = $type === 'send'; @endphp

                <form id="editForm" action="{{ route('superadmin.transactions.update', $transaction->id) }}" 
                      method="POST" 
                      enctype="multipart/form-data" 
                      class="bg-white/70 rounded-xl shadow-md p-6 mx-auto border border-gray-200 max-w-5xl">
                    @csrf @method('PUT')
                    <input type="hidden" name="type" value="{{ $type }}">

                    @if($isSend)
                        <!-- === TITIP KIRIM: EDIT === -->
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.edit_transaction_info') }}</h2>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <!-- KIRI: PENGGUNA -->
                                <div class="space-y-6">
                                    <!-- Informasi Pengirim -->
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-800 mb-3">{{ __('messages.labels.shipping_info') }}</h3>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.transaction_id') }}</label>
                                                <div class="border border-gray-300 rounded-md px-4 py-2 bg-gray-50">TKR{{ $transaction->id }}</div>
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

                                    <!-- Informasi Pengiriman (EDITABLE) -->
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-800 mb-3">{{ __('messages.labels.shipping_info') }}</h3>
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.shipping_method') }}</label>
                                                <input type="text" name="delivery_method" value="{{ $transaction->delivery_method }}" 
                                                       class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.pickup_address') }}</label>
                                                <textarea name="pickup_address" rows="2" 
                                                          class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500">{{ $transaction->pickup_address }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.status') }}</label>
                                        <select name="payment_status" required 
                                                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500">
                                            <option value="pending" {{ $transaction->payment_status == 'pending' ? 'selected' : '' }}>{{ __('messages.transactions_status.pending') }}</option>
                                            <option value="approved" {{ $transaction->payment_status == 'approved' ? 'selected' : '' }}>{{ __('messages.transactions_status.approved') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- KANAN: LOGISTIK (EDITABLE) -->
                                <div class="space-y-6 mt-10">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.delivery_receipt') }}</label>
                                        <input type="text" name="delivery_code" value="{{ $transaction->delivery_code }}" 
                                               class="w-full border border-gray-300 rounded-md px-4 py-2 font-mono focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.destination_address') }}</label>
                                        <textarea name="delivery_address" rows="2" 
                                                  class="w-full border border-gray-300 rounded-md px-4 py-2 text-xs focus:ring-2 focus:ring-blue-500">{{ $transaction->delivery_address }}</textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.delivery_type') }}</label>
                                        <select name="delivery_type" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500">
                                            <option value="Dalam Negeri" {{ $transaction->delivery_type == 'Dalam Negeri' ? 'selected' : '' }}>{{ __('messages.filters.domestic') }}</option>
                                            <option value="Luar Negeri" {{ $transaction->delivery_type == 'Luar Negeri' ? 'selected' : '' }}>{{ __('messages.filters.overseas') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- DETAIL TITIPAN (EDITABLE) -->
                            <div class="mt-10 border-t pt-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-5">{{ __('messages.labels.order_details') }}</h3>
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
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
                                            <input type="text" name="dimension" value="{{ $transaction->dimension }}" 
                                                   class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.item_weight') }}</label>
                                            <div class="flex items-center gap-2">
                                                <input type="number" step="0.01" name="weight" value="{{ old('weight', preg_replace('/[^0-9.]/', '', $transaction->weight)) }}" 
                                                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500"
                                                    placeholder="0.00" min="0">
                                                <span class="text-gray-600 font-medium whitespace-nowrap">kg</span>
                                            </div>
                                        </div>
                                    </div>
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
                                    {{ $transaction->product->description ?? 'Tidak ada deskripsi.' }}
                                </div>
                            </div>

                            <!-- DETAIL BAWAH -->
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

                            <!-- BUKTI PEMBAYARAN BARU -->
                            <div class="mt-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.upload_payment') }}</label>
                                <input type="file" name="payment_proof" accept="image/*" class="w-full border border-gray-300 rounded-md px-4 py-2">
                            </div>
                        </div>

                    @else
                        <!-- === TITIP BELI: EDIT === -->
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.edit_transaction_info') }}</h2>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div class="space-y-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.transaction_id') }}</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-gray-50">#JSTP{{ $transaction->id }}</div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.transaction_date') }}</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">{{ $transaction->created_at->format('d-m-Y') }}</div>
                                    </div>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-600 font-medium">Rp</span>
                                        <input type="number" name="total_price" value="{{ (int) $transaction->total_price }}" required 
                                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="0" min="0">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                                        <select name="payment_status" required 
                                                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500">
                                            <option value="pending" {{ $transaction->payment_status == 'pending' ? 'selected' : '' }}>{{ __('messages.transactions_status.pending') }}</option>
                                            <option value="approved" {{ $transaction->payment_status == 'approved' ? 'selected' : '' }}>{{ __('messages.transactions_status.approved') }}</option>
                                            <option value="declined" {{ $transaction->payment_status == 'declined' ? 'selected' : '' }}>{{ __('messages.transactions_status.declined') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="space-y-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.names.customer') }}</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">{{ $transaction->buyer->detail->name }}</div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.names.traveler') }}</label>
                                        <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">{{ $transaction->traveler->detail->name }}</div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.the_amount_of_goods') }}</label>
                                        <input type="number" name="quantity" value="{{ $transaction->quantity }}" required 
                                               class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500">
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

                            <!-- DETAIL BARANG -->
                            <div class="mt-10 border-t pt-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-5">{{ __('messages.item_details') }}</h3>
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    <div class="space-y-5">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.name_of_goods') }}</label>
                                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">{{ $transaction->product->name }}</div>
                                        </div>
                                        @if($transaction->product->category)
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.item_category') }}</label>
                                                <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">{{ $transaction->product->category->name }}</div>
                                            </div>
                                        @endif
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.origin_of_goods') }}</label>
                                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white">{{ $transaction->product->origin ?? 'Tidak tersedia' }}</div>
                                        </div>
                                    </div>
                                    <div class="space-y-5">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.item_photos') }}</label>
                                            <div class="border border-gray-300 rounded-md p-2 bg-white">
                                                @if($transaction->product->image)
                                                    <img src="{{ asset('storage/' . $transaction->product->image) }}" class="w-full h-48 object-cover rounded-md" alt="Foto">
                                                @else
                                                    <div class="w-full h-48 bg-gray-200 border-2 border-dashed rounded-md flex items-center justify-center text-gray-500">
                                                        {{ __('messages.no_photos') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.labels.item_description') }}</label>
                                            <div class="border border-gray-300 rounded-md px-4 py-2 bg-white min-h-24">
                                                {{ $transaction->product->description ?? 'Tidak ada deskripsi.' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- BUKTI PEMBAYARAN BARU -->
                            <div class="mt-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('messages.upload_payment') }}</label>
                                <input type="file" name="payment_proof" accept="image/*" class="w-full border border-gray-300 rounded-md px-4 py-2">
                            </div>
                        </div>
                    @endif
                </form>
            </div>
            @include('_superadmin.transactions.components.payment-proof-modal', ['proof' => $transaction->payment_proof])
        </div>
    </div>

    <script>
        document.getElementById('main-content').classList.remove('initial-hidden');
        document.getElementById('navbar-header').classList.remove('initial-hidden');
    </script>
</x-app-layout>