<x-app-layout>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('layouts.sidebar-superadmin')

        <!-- Area kanan (konten utama) -->
        <div id="main-content" class="flex-1 ml-97 transition-all duration-300 flex flex-col min-h-screen initial-hidden">
            <!-- Navbar + Header -->
            <div id="navbar-header" class="fixed top-0 left-97 right-0 z-20 transition-all duration-300 initial-hidden"
                 style="background-color: #DBEDFF; padding: 1rem 1.5rem;">
                
                @include('layouts.navigation', ['title' => $title])
                
                <div class="mt-2 flex justify-between items-center">
                    <!-- Filter Tipe & Status -->
                    <form method="GET" class="flex flex-wrap gap-3">
                        <select name="type" class="border border-blue-400 rounded-md px-3 py-2 text-blue-800 font-medium focus:ring focus:ring-blue-200">
                            <option value="all" {{ $filterType === 'all' ? 'selected' : '' }}>Semua Tipe</option>
                            <option value="buy" {{ $filterType === 'buy' ? 'selected' : '' }}>Titip Beli</option>
                            <option value="send" {{ $filterType === 'send' ? 'selected' : '' }}>Titip Kirim</option>
                        </select>
                        <select name="status" class="border border-blue-400 rounded-md px-3 py-2 text-blue-800 font-medium focus:ring focus:ring-blue-200">
                            <option value="all" {{ $filterStatus === 'all' ? 'selected' : '' }}>Semua Status</option>
                            <option value="pending" {{ $filterStatus === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $filterStatus === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="declined" {{ $filterStatus === 'declined' ? 'selected' : '' }}>Declined</option>
                        </select>
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md shadow transition">
                            Terapkan
                        </button>
                    </form>

                    <!-- Tombol Unduh Data -->
                    <button class="flex items-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-4 py-2 rounded-md shadow transition">
                        <span>Unduh Data</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Konten utama -->
            <div class="flex-1 px-6 pb-6 pt-48 space-y-6">
                <!-- Daftar Transaksi -->
                <div class="bg-white/70 backdrop-blur p-4 rounded-xl shadow-[0_0_10px_rgba(0,0,0,0.25)]">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border-collapse">
                            <thead>
                                <tr class="bg-[#BFD9FF] text-blue-900">
                                    <th class="p-3 font-semibold text-center">No</th>
                                    <th class="p-3 font-semibold text-center">Nama Penitip</th>
                                    <th class="p-3 font-semibold text-center">ID Transaksi</th>
                                    <th class="p-3 font-semibold text-center">Tanggal</th>
                                    <th class="p-3 font-semibold text-center">Status</th>
                                    <th class="p-3 font-semibold text-center">Total Transaksi</th>
                                    <th class="p-3 font-semibold text-center">Pembayaran</th>
                                    <th class="p-3 font-semibold text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $index => $trx)
                                    <tr class="border-b hover:bg-blue-50 transition text-gray-700">
                                        <td class="p-3 text-center font-medium align-middle">{{ $transactions->firstItem() + $index }}</td>
                                        <td class="p-3 font-semibold text-center align-middle">{{ $trx->buyer->name ?? '-' }}</td>
                                        <td class="p-3 text-center text-blue-700 font-semibold align-middle">#JSTP{{ $trx->id }}</td>
                                        <td class="p-3 text-center align-middle">{{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y') }}</td>
                                        <td class="p-3 text-center align-middle">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'text-yellow-600 bg-yellow-100',
                                                    'approved' => 'text-green-700 bg-green-100',
                                                    'declined' => 'text-red-600 bg-red-100'
                                                ];
                                            @endphp
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$trx->payment_status] ?? 'text-gray-500 bg-gray-100' }}">
                                                {{ ucfirst($trx->payment_status) }}
                                            </span>
                                        </td>
                                        <td class="p-3 text-center font-semibold text-blue-800 align-middle">
                                            Rp{{ number_format($trx->total_price, 0, ',', '.') }}
                                        </td>
                                        <td class="p-3 text-center align-middle">{{ $trx->paymentMethod->name ?? '-' }}</td>
                                        <td class="p-3 text-center align-middle">
                                            @php
                                                $detailRoute = $trx->type === 'buy'
                                                    ? route('superadmin.transaction.buy.show', $trx->id)
                                                    : route('superadmin.transaction.send.show', $trx->id);
                                                $editRoute = route('superadmin.transaction.edit', ['type' => $trx->type, 'id' => $trx->id]);
                                            @endphp
                                            <div class="flex justify-center gap-2">
                                                <a href="{{ $editRoute }}" class="p-2 bg-yellow-400 rounded-md hover:bg-yellow-500 transition" title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 text-white">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M15.232 5.232l3.536 3.536M9 11l6 6M4 21h4l12-12a1 1 0 00-1.414-1.414L6 19H4v2z" />
                                                    </svg>
                                                </a>
                                                <a href="{{ $detailRoute }}" class="p-2 bg-blue-400 rounded-md hover:bg-blue-500 transition" title="Detail">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 text-white">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M15 10l4.553 4.553a1 1 0 010 1.414L15 20.414m-6-10l-4.553 4.553a1 1 0 000 1.414L9 20.414M9 10l6 6" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-gray-500 py-8">Tidak ada transaksi ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $transactions->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>

            <!-- Inline script untuk hapus initial-hidden -->
            <script>
                document.getElementById('main-content').classList.remove('initial-hidden');
                document.getElementById('navbar-header').classList.remove('initial-hidden');
            </script>
        </div>
    </div>
</x-app-layout>