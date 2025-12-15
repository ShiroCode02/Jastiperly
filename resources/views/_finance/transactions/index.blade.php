<x-app-layout>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('layouts.sidebar-finance')
        <!-- Konten kanan -->
       <div class="flex-1 ml-[312px] flex flex-col bg-[#DBEDFF] min-h-screen">
            <!-- Header (navbar) -->
            <div class="fixed top-0 left-[312px] right-0 z-20 bg-[#DBEDFF] px-6 pt-4 pb-4">
                @include('layouts.navigation-finance', ['title' => $title])
            </div>
            <!-- Konten utama -->
            <div class="flex-1 px-1 pb-6 pt-28">
            <div class="rounded-xl shadow-sm p-6">
                  
                <!-- Fitur Transaksi Selesai -->
                <div class="flex items-center gap-2 mb-4">
                    <button class="p-1 rounded-md transition-all hover:scale-110">
                        <img src="{{ asset('iconsfinance/financetransaksiselesai.svg') }}"
                            alt="Icon Transaksi"
                            class="w-6 h-6 object-contain transition-all filter hover:brightness-0 hover:invert-[20%] hover:sepia hover:saturate-[700%] hover:hue-rotate-[190deg]">
                    </button>
                    <button class="text-[#000957] text-xl font-bold px-2 py-1 rounded-md hover:text-blue-700 transition-all">
                        Transaksi Selesai
                    </button>
                </div>

                <!-- FILTER Titip Beli & Titip Kirim  (DISESUAIKAN POSISI) -->
                <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-2 -mt-1">
                    <!-- KIRI: Titip Beli & Titip Kirim -->
                    <div class="w-full md:w-1/2">
                        <div class="flex items-center">
                            <div class="flex gap-3 bg-[#FFF6E3] px-3 py-2 rounded-md items-center shadow-sm">
                                <button class="bg-[#FFF6E3] text-black font-semibold px-4 py-2 rounded-md hover:bg-white transition">
                                    Titip Beli 150
                                </button>
                                <div class="w-0.5 bg-black h-6"></div>
                                <button class="bg-[#FFF6E3] text-black font-semibold px-4 py-2 rounded-md hover:bg-white transition">
                                    Titip Kirim 130
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- KANAN: Pilih, Status, Unduh Data -->
                    <!-- Perubahan penting: gunakan flex-nowrap supaya item tidak pindah baris -->
                    <div class="w-full md:w-1/2 flex justify-end">
                        <!-- gunakan flex-nowrap, items-center agar semua sejajar, dan whitespace-nowrap untuk hindari pecah teks -->
                        <div class="flex flex-nowrap items-center gap-3 whitespace-nowrap">
                            <!-- pastikan select dan button memiliki py yang sama agar tinggi konsisten -->
                            <select class="w-44 border-gray-300 rounded-md px-3 py-2 hover:bg-blue-400 text-black hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all shadow-sm">
                                <option>Pilih</option>
                                <option>Dalam Negeri</option>
                                <option>Luar Negeri</option>
                            </select>

                            <select class="w-52 border-gray-300 rounded-md px-3 py-2 hover:bg-blue-400 text-black hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all shadow-sm">
                                <option>Status</option>
                                <option>Selesai</option>
                                <option>Proses</option>
                                <option>Tidak Selesai</option>
                            </select>

                            <button class="flex items-center gap-2 bg-[#f3ef18] hover:bg-yellow-400 text-black font-semibold px-5 py-2 rounded-md shadow-md transition-all hover:shadow-lg whitespace-nowrap">
                                <span>Unduh Data</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tabel Transaksi -->
                <div class="overflow-x-auto bg-white rounded-xl shadow-md">
                    <table class="w-full border border-gray-200 text-sm text-left">
                        <thead class="bg-[#bfd9fff3] text-black font-semibold">
                            <tr>
                                <th class="border px-4 py-3 text-center w-[5%]">No</th>
                                <th class="border px-4 py-3 text-center w-[20%]">Nama Penitip</th>
                                <th class="border px-4 py-3 text-center w-[15%]">ID Transaksi</th>
                                <th class="border px-4 py-3 text-center w-[15%]">Tanggal</th>
                                <th class="border px-4 pydealer text-center w-[10%]">Status</th>
                                <th class="border px-4 py-3 text-center w-[15%]">Total Transaksi</th>
                                <th class="border px-4 py-3 text-center w-[5%]">Pembayaran</th>
                                <th class="border px-4 py-3 text-center w-[20%]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @php
                                $transactions = [
                                    ['Anya Geraldine', 'JSTP1234', '07-03-2025', 'Menunggu', 'Rp 450.000', 'BRI'],
                                    ['Komang Lau', 'JSTP1234', '07-03-2025', 'Menunggu', 'Rp 450.000', 'BRI'],
                                    ['Budi Solihin', 'JSTP1234', '07-03-2025', 'Menunggu', 'Rp 450.000', 'BRI'],
                                    ['Sehun Doremi', 'JSTP1234', '07-03-2025', 'Menunggu', 'Rp 450.000', 'BRI'],
                                    ['Khai Zayn', 'JSTP1234', '07-03-2025', 'Menunggu', 'Rp 450.000', 'BRI'],
                                    ['Roberto Bob', 'JSTP1234', '07-03-2025', 'Menunggu', 'Rp 450.000', 'BRI'],
                                    ['Malika Sapena', 'JSTP1234', '07-03-2025', 'Menunggu', 'Rp 450.000', 'BRI'],
                                    ['Anggi Marino', 'JSTP1234', '07-03-2025', 'Menunggu', 'Rp 450.000', 'BRI'],
                                    ['Anggi Marino', 'JSTP1234', '07-03-2025', 'Menunggu', 'Rp 450.000', 'BRI'],
                                    ['Anggi Marino', 'JSTP1234', '07-03-2025', 'Menunggu', 'Rp 450.000', 'BRI'],
                                    ['Anggi Marino', 'JSTP1234', '07-03-2025', 'Menunggu', 'Rp 450.000', 'BRI'],
                                    ['Anggi Marino', 'JSTP1234', '07-03-2025', 'Menunggu', 'Rp 450.000', 'BRI'],
                                    ['Anggi Marino', 'JSTP1234', '07-03-2025', 'Menunggu', 'Rp 450.000', 'BRI'],
                                ];

                                // --- FILTER PENCARIAN --- (pastikan kurung & semicolon lengkap)
                                if (request('search')) {
                                    $search = strtolower(request('search'));

                                    $transactions = array_filter($transactions, function ($item) use ($search) {
                                        return str_contains(strtolower($item[0]), $search) ||   // Nama Penitip
                                               str_contains(strtolower($item[1]), $search) ||   // ID Transaksi
                                               str_contains(strtolower($item[2]), $search) ||   // Tanggal
                                               str_contains(strtolower($item[3]), $search) ||   // Status
                                               str_contains(strtolower((string)$item[4]), $search) || // Total Transaksi
                                               str_contains(strtolower($item[5]), $search);     // Pembayaran
                                    });
                                }
                            @endphp

                            @forelse ($transactions as $i => $r)
                                <tr class="hover:bg-blue-50 transition-all">
                                  <td class="border px-4 py-3 text-center truncate">{{ $i + 1 }}</td>
                                    <td class="border px-4 py-3 text-center font-medium truncate">{{ $r[0] }}</td>
                                    <td class="border px-4 py-3 text-center font-semibold truncate">{{ $r[1] }}</td>
                                    <td class="border px-4 py-3 text-center truncate">{{ $r[2] }}</td>
                                    <td class="border px-4 py-3 text-center">
                                        <span class="text-green-600 font-semibold whitespace-nowrap">Selesai</span>
                                    </td>
                                    <td class="border px-4 py-3 text-center font-semibold truncate">{{ $r[4] }}</td>
                                    <td class="border px-4 py-3 text-center truncate">{{ $r[5] }}</td>
                                    <td class="border px-2 py-3 text-center">
                                        <div class="flex justify-center gap-1 items-center">
                                            <button class="bg-blue-200 hover:bg-blue-300 px-3 py-2 rounded-lg transition-all">
                                                <img src="{{ asset('iconsfinance/financedetail.svg') }}" 
                                                alt="Detail"
                                                class="w-4 h-4">
                                            </button>
                                            <button class="bg-red-200 hover:bg-red-300 px-3 py-2 rounded-lg transition-all">
                                                <img src="{{ asset('iconsfinance/financedelete.svg') }}" 
                                                alt="Hapus"
                                                class="w-4 h-4">
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-6 text-center text-gray-500">Tidak ada data transaksi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="flex justify-center items-center gap-2 mt-6">
                    <button class="px-4 py-2 border rounded-lg bg-white hover:bg-blue-50 transition-all">Previous</button>
                    <button class="px-4 py-2 border rounded-lg bg-blue-400 text-white hover:bg-blue-500 transition-all">1</button>
                    <button class="px-4 py-2 border rounded-lg bg-white hover:bg-blue-50 transition-all">2</button>
                    <button class="px-4 py-2 border rounded-lg bg-white hover:bg-blue-50 transition-all">3</button>
                    <button class="px-4 py-2 border rounded-lg bg-white hover:bg-blue-50 transition-all">Next</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
