<x-app-layout>
    <div class="flex" style="background-color: #DBEDFF;">
        <!-- Sidebar -->
        @include('layouts.sidebar-superadmin')

        <!-- Area kanan (konten utama) -->
        <div id="main-content" class="flex-1 ml-97 transition-all duration-300 flex flex-col initial-hidden" style="background-color: #DBEDFF;">
            
            <!-- Navbar + Header -->
            <div id="navbar-header" class="fixed top-0 left-97 right-0 z-20 transition-all duration-300 initial-hidden" style="background-color: #DBEDFF; padding: 1rem 1.5rem 1rem 1.5rem;">
                @include('layouts.navigation', ['title' => 'Dashboard'])

                <div class="mt-2 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-blue-900">Hi, King</h2>
                        <p class="text-gray-600">Welcome back to SuperAdmin Dashboard</p>
                    </div>
                </div>
            </div>

            <!-- Konten utama -->
            <div class="flex-1 px-6 pb-6 pt-48 space-y-6">
                <!-- Statistik -->
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-[rgba(255,255,255,0.4)] p-4 rounded-xl shadow-[0_0_10px_rgba(0,0,0,0.25)] text-center">
                        <h3 class="text-gray-500 text-sm">Total Pengguna</h3>
                        <p class="text-3xl font-bold">{{ number_format($totalUsers) }}</p>
                    </div>
                    <div class="bg-[rgba(255,255,255,0.4)] p-4 rounded-xl shadow-[0_0_10px_rgba(0,0,0,0.25)] text-center">
                        <h3 class="text-gray-500 text-sm">Total Transaksi</h3>
                        <p class="text-3xl font-bold">{{ number_format($totalTransactions) }}</p>
                    </div>
                </div>

                <!-- Grafik & Aktivitas -->
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-[rgba(255,255,255,0.4)] p-4 rounded-xl shadow-[0_0_10px_rgba(0,0,0,0.25)]">
                        <h3 class="font-semibold mb-3">Grafik Total Pengguna</h3>
                        <canvas id="userChart"></canvas>
                    </div>

                    <div class="bg-[rgba(255,255,255,0.4)] p-4 rounded-xl shadow-[0_0_10px_rgba(0,0,0,0.25)]">
                        <h3 class="font-semibold mb-3">Total Aktivitas</h3>
                        <ul class="space-y-3">
                            <li class="flex justify-between"><span>Transaksi Selesai</span> <span class="text-green-600 font-bold">{{ $transaksiSelesai }}</span></li>
                            <li class="flex justify-between"><span>Transaksi Berjalan</span> <span class="text-yellow-500 font-bold">{{ $transaksiBerjalan }}</span></li>
                            <li class="flex justify-between"><span>Transaksi Dibatalkan</span> <span class="text-red-500 font-bold">{{ $transaksiDibatalkan }}</span></li>
                            <li class="flex justify-between"><span>Titip Kirim</span> <span class="text-blue-500 font-bold">{{ $titipKirim }}</span></li>
                        </ul>
                    </div>
                </div>

                <!-- Tabel Transaksi Terbaru -->
                <div class="bg-[rgba(255,255,255,0.4)] p-4 rounded-xl shadow-[0_0_10px_rgba(0,0,0,0.25)]">
                    <h3 class="font-semibold mb-3">Transaksi Terbaru</h3>
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-blue-100">
                                <th class="p-2 border">No</th>
                                <th class="p-2 border">ID Transaksi</th>
                                <th class="p-2 border">Nama Traveler</th>
                                <th class="p-2 border">Nama Penitip</th>
                                <th class="p-2 border">Total Transaksi</th>
                                <th class="p-2 border">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($latestTransactions as $index => $trx)
                            <tr class="text-center hover:bg-blue-50">
                                <td class="p-2 border">{{ $index + 1 }}</td>
                                <td class="p-2 border">#JSTP{{ $trx->id }}</td>
                                <td class="p-2 border">{{ $trx->traveler->name ?? '-' }}</td>
                                <td class="p-2 border">{{ $trx->buyer->name ?? '-' }}</td>
                                <td class="p-2 border">Rp{{ number_format($trx->total_price, 0, ',', '.') }}</td>
                                <td class="p-2 border">
                                    @if($trx->payment_status == 'pending')
                                        <span class="text-red-500 font-semibold">Belum Bayar</span>
                                    @elseif($trx->payment_status == 'approved')
                                        <span class="text-green-600 font-semibold">Selesai</span>
                                    @else
                                        <span class="text-gray-500">Dibatalkan</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center text-gray-500 py-4">Tidak ada transaksi</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Chart.js -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
            const ctx = document.getElementById('userChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($chartData['months']),
                    datasets: [
                        { label: 'Penitip', data: @json($chartData['customer']), backgroundColor: '#FFF500' },
                        { label: 'Traveler', data: @json($chartData['traveler']), backgroundColor: '#8FD14F' }
                    ]
                },
                options: { responsive: true, scales: { y: { beginAtZero: true } } }
            });
            </script>

            <!-- Inline script untuk hapus initial-hidden -->
            <script>
                document.getElementById('main-content').classList.remove('initial-hidden');
                document.getElementById('navbar-header').classList.remove('initial-hidden');
            </script>
        </div>
    </div>
</x-app-layout>