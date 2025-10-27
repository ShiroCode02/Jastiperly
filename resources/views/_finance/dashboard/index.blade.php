<x-app-layout>
    <div class="flex">
        <!-- Sidebar -->
        @include('layouts.sidebar-finance')

        <!-- Konten utama -->
        <div class="flex-1 ml-[312px] flex flex-col bg-blue-50 min-h-screen">

            <!-- Navbar + Header -->
            <div
                class="fixed top-0 left-[312px] right-0 z-20 bg-blue-50 px-6 pt-4 pb-4">
                @include('layouts.navigation-finance', ['title' => 'Dashboard'])
            </div>

            <!-- Konten Dashboard -->
            <div class="flex-1 px-6 pb-6 pt-32 space-y-6">

                <!-- Kartu Pendapatan -->
                <div
                    class="bg-white rounded-xl p-8 shadow-[0_6px_16px_rgba(0,0,0,0.1),0_-6px_16px_rgba(0,0,0,0.1),6px_0_16px_rgba(0,0,0,0.1),-6px_0_16px_rgba(0,0,0,0.1)] transition-shadow duration-300">

                    <!-- Header -->
                    <div class="mb-6">
                        <h2 class="text-3xl font-bold text-blue-900">Hi, Finance</h2>
                        <p class="text-gray-600 text-lg">Welcome back to Finance Dashboard</p>
                    </div>

                    <!-- Grid Pendapatan -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Pendapatan Hari Ini -->
                        <div class="rounded-xl flex justify-center">
                            <div
                                class="bg-yellow-100 rounded-2xl p-4 shadow-[0_6px_14px_rgba(0,0,0,0.1)] hover:shadow-[0_8px_20px_rgba(0,0,0,0.15)] transition-shadow duration-300 flex items-center justify-center w-full">
                                <div class="flex items-center gap-4">
                                    <img src="{{ asset('images/finance1.png') }}" alt="icon-harian"
                                        class="w-12 h-12 object-contain">
                                    <div class="text-left">
                                        <h3 class="text-gray-700 font-medium text-lg leading-tight">
                                            Total Pendapatan Hari Ini
                                        </h3>
                                        <p class="text-3xl font-bold text-gray-900 mt-1">
                                            Rp. {{ number_format($todayIncome ?? 2300000, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pendapatan Bulan Ini -->
                        <div class="rounded-xl flex justify-center">
                            <div
                                class="bg-yellow-100 rounded-2xl p-4 shadow-[0_6px_14px_rgba(0,0,0,0.1)] hover:shadow-[0_8px_20px_rgba(0,0,0,0.15)] transition-shadow duration-300 flex items-center justify-center w-full">
                                <div class="flex items-center gap-4">
                                    <img src="{{ asset('images/finance2.png') }}" alt="icon-bulanan"
                                        class="w-12 h-12 object-contain">
                                    <div class="text-left">
                                        <h3 class="text-gray-700 font-medium text-lg leading-tight">
                                            Total Pendapatan Bulan Ini
                                        </h3>
                                        <p class="text-3xl font-bold text-gray-900 mt-1">
                                            Rp. {{ number_format($monthIncome ?? 2300000, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grafik & Pengguna Aktif -->
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Grafik -->
                    <div class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition">
                        <h3 class="text-lg font-semibold text-blue-900 mb-3">Total Titip Beli Barang & Titip Kirim</h3>
                        <canvas id="financeChart" height="150"></canvas>
                    </div>

                    <!-- Pengguna Aktif -->
                    <div class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition">
                        <h3 class="text-lg font-semibold text-blue-900 mb-3">Pengguna yang Sering Aktif</h3>

                        <table class="w-full text-sm border-collapse">
                            <thead style="background-color: #FFF500;" class="text-blue-900">
                                <tr>
                                    <th class="p-2 border">No</th>
                                    <th class="p-2 border">Username</th>
                                    <th class="p-2 border">Nama</th>
                                    <th class="p-2 border">Total Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activeUsers ?? [
                                    ['username' => 'anya1245', 'nama' => 'Anya Geraldine', 'total' => 130],
                                    ['username' => 'nathasa9090', 'nama' => 'Nathasa Wilona', 'total' => 124],
                                    ['username' => 'zivamaaa0', 'nama' => 'Ziva Magnolia', 'total' => 120],
                                ] as $index => $user)
                                    <tr class="text-center hover:bg-yellow-50">
                                        <td class="border p-2">{{ $index + 1 }}</td>
                                        <td class="border p-2">{{ $user['username'] }}</td>
                                        <td class="border p-2">{{ $user['nama'] }}</td>
                                        <td class="border p-2 font-semibold">{{ $user['total'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tabel Transaksi Terbaru -->
                <div class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition">
                    <h3 class="text-lg font-semibold text-blue-900 mb-3">Transaksi Terbaru</h3>

                    <table class="w-full text-sm border-collapse">
                        <thead class="bg-blue-500 text-white">
                            <tr>
                                <th class="p-2 border">No</th>
                                <th class="p-2 border">ID Transaksi</th>
                                <th class="p-2 border">Nama Traveler</th>
                                <th class="p-2 border">Nama Penitip</th>
                                <th class="p-2 border">Total Transaksi</th>
                                <th class="p-2 border">Layanan</th>
                                <th class="p-2 border">Metode Pembayaran</th>
                                <th class="p-2 border">Status</th>
                                <th class="p-2 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestTransactions ?? [] as $index => $trx)
                                <tr class="text-center hover:bg-blue-50">
                                    <td class="border p-2">{{ $index + 1 }}</td>
                                    <td class="border p-2">{{ $trx['id'] }}</td>
                                    <td class="border p-2">{{ $trx['traveler'] }}</td>
                                    <td class="border p-2">{{ $trx['penitip'] }}</td>
                                    <td class="border p-2">Rp{{ number_format($trx['total'], 0, ',', '.') }}</td>
                                    <td class="border p-2">{{ $trx['layanan'] }}</td>
                                    <td class="border p-2">{{ $trx['metode'] }}</td>
                                    <td class="border p-2 text-red-500 font-semibold">{{ $trx['status'] }}</td>
                                    <td class="border p-2 text-blue-600 font-semibold hover:underline cursor-pointer">
                                        Detail
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-gray-500 py-4">
                                        Tidak ada Transaksi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Chart.js -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const ctx = document.getElementById('financeChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr'],
                        datasets: [
                            {
                                label: 'Titip Kirim',
                                data: [20000000, 30000000, 15000000, 40000000],
                                backgroundColor: '#FFF500'
                            },
                            {
                                label: 'Titip Beli Barang',
                                data: [15000000, 45000000, 35000000, 38000000],
                                backgroundColor: '#8FD14F'
                            }
                        ]
                    },
                    options: { responsive: true, scales: { y: { beginAtZero: true } } }
                });
            </script>
        </div>
    </div>
</x-app-layout>