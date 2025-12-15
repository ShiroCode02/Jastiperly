<x-app-layout> 
    <div class="flex"> 
        <!-- Sidebar --> 
        @include('layouts.sidebar-finance') 
 
        <!-- Konten utama --> 
        <div class="flex-1 ml-[312px] flex flex-col bg-[#DBEDFF] min-h-screen"> 
 
            <!-- Navbar + Header --> 
            <div 
                class="fixed top-0 left-[312px] right-0 z-20 bg-[#DBEDFF] px-6 pt-4 pb-2"> 
                @include('layouts.navigation-finance', ['title' => 'Dashboard']) 
            </div> 
 
            <!-- Konten Dashboard --> 
            <div class="flex-1 px-6 pb-6 pt-28 space-y-6"> 
 
                <!-- Kartu Pendapatan --> 
                <div 
                    class="bg-white rounded-xl p-8 shadow-[0_6px_16px_rgba(0,0,0,0.1),0_-6px_16px_rgba(0,0,0,0.0),6px_0_16px_rgba(0,0,0,0.0),-6px_0_16px_rgba(0,0,0,0.0)] transition-shadow duration-300"> 
 
                    <!-- Header --> 
                    <div class="mb-6"> 
                        <h2 class="text-3xl font-bold text-blue-900">Hi, Finance</h2> 
                        <p class="text-gray-600 text-lg">Welcome back to Finance Dashboard</p> 
                    </div> 
 
                    <!-- Grid Card Pendapatan --> 
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10"> 
                        <!-- Pendapatan Hari Ini --> 
                        <div class="rounded-xl flex justify-center"> 
                            <div 
                                class="bg-yellow-100 rounded-2xl p-4 shadow-[0_6px_14px_rgba(0,0,0,0.3)] hover:shadow-[0_8px_20px_rgba(0,0,0,0.14)] transition-shadow duration-300 flex items-center justify-center w-full"> 
                                <div class="flex items-center gap-4"> 
                                    <img src="{{ asset('iconsfinance/card-income.svg') }}" alt="icon-harian" 
                                        class="w-11 h-11 object-contain"> 
                                    <div class="text-left"> 
                                        <h3 class="text-gray-700 font-medium text-lg leading-tight"> 
                                            Total Pendapatan Hari Ini 
                                        </h3> 
                                        <p class="text-3xl font-bold text-gray-900 mt-1"> 
                                            Rp. {{ number_format($todayIncome, 0, ',', '.') }} 
                                        </p> 
                                    </div> 
                                </div> 
                            </div> 
                        </div> 
 
                        <!-- Pendapatan Bulan Ini --> 
                        <div class="rounded-xl flex justify-center"> 
                            <div 
                                class="bg-yellow-100 rounded-2xl p-4 shadow-[0_6px_14px_rgba(0,0,0,0.3)] hover:shadow-[0_8px_20px_rgba(0,0,0,0.14)] transition-shadow duration-300 flex items-center justify-center w-full"> 
                                <div class="flex items-center gap-4"> 
                                    <img src="{{ asset('iconsfinance/card-income2.svg') }}" alt="icon-bulanan" 
                                        class="w-12 h-12 object-contain"> 
                                    <div class="text-left"> 
                                        <h3 class="text-gray-700 font-medium text-lg leading-tight"> 
                                            Total Pendapatan Bulan Ini 
                                        </h3> 
                                        <p class="text-3xl font-bold text-gray-900 mt-1"> 
                                            Rp. {{ number_format($monthIncome, 0, ',', '.') }} 
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
 
                    <!-- Pengguna Yang Sering Aktif --> 
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
                                @forelse($activeUsers as $index => $user)
                                    <tr class="text-center hover:bg-yellow-50">
                                        <td class="border p-2">{{ $user->no }}</td>
                                        <td class="border p-2">{{ Str::limit($user->email, 20) }}</td>
                                        <td class="border p-2">{{ $user->name ?? 'Belum isi nama' }}</td>
                                        <td class="border p-2 font-semibold">{{ $user->total_transactions }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="border p-4 text-center text-gray-500">
                                            Belum ada transaksi
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="border-0 p-4 bg-gray-50">
                                        {{ $activeUsers->links() }}
                                    </td>
                                </tr>
                            </tfoot>
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
                    data: @json($chartData),  
                    options: { responsive: true, scales: { y: { beginAtZero: true } } } 
                }); 
            </script> 
        </div> 
    </div> 
</x-app-layout>