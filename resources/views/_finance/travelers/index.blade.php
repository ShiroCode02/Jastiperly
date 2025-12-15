<x-app-layout>
    <div class="flex">
        @include('layouts.sidebar-finance')
        <!-- Konten utama -->
        <div class="flex-1 ml-[312px] flex flex-col bg-[#DBEDFF] min-h-screen">
           
            <!-- Navbar -->
             <div class="fixed top-0 left-[312px] right-0 z-20 bg-[#DBEDFF] px-6 pt-4 pb-4">
                @include('layouts.navigation-finance', ['title' => $title])
            </div>
            
            <!-- Isi konten -->
            <div class="flex-1 px-2 pb-6 pt-28">
                <div class="rounded-xl shadow-sm p-6">
                  <div class="flex items-center gap-2 mb-6">
                    <!-- Fitur Komisi Traveler -->
                    <button class="p-1 rounded-md transition-all hover:scale-110">
                        <img src="{{ asset('iconsfinance/financetransaksiselesai.svg') }}"
                            alt="Icon Transaksi"
                            class="w-6 h-6 object-contain transition-all filter hover:brightness-0 hover:invert-[20%] hover:sepia hover:saturate-[700%] hover:hue-rotate-[190deg]">
                    </button>
                    <button class="text-[#000957] text-xl font-bold px-2 py-1 rounded-md hover:text-blue-700 transition-all">
                        Komisi Traveler
                    </button>
                  </div>

                    <!-- Filter + Unduh Data -->
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-2 -mt-2">
                        <div>
                            <select class="w-60 border-gray-300 rounded-md px-5 py-2.5 hover:bg-blue-400 text-black hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all shadow-sm">
                                <option>Semua</option>
                                <option>Sudah divalidasi</option>
                                <option>belum divalidasi</option>
                            </select>
                        </div>
                        <div>
                            <button class="flex items-center gap-2 bg-[#f3ef18] hover:bg-yellow-400 text-black font-semibold px-5 py-2.5 rounded-md shadow-md transition-all hover:shadow-lg whitespace-nowrap">
                                <span>Unduh Data</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Tabel Data Traveler -->
                    <div class="overflow-x-auto bg-white rounded-xl shadow-md">
                    <table class="w-full border border-gray-200 text-sm text-left">
                        <thead class="bg-[#bfd9fff3] text-black font-semibold">
                            <tr>
                                <th class="border px-4 py-3 text-center w-[5%]">No</th>
                                <th class="border px-4 py-3 text-center w-[20%]">Username</th>
                                <th class="border px-4 py-3 text-center w-[15%]">ID Transaksi</th>
                                <th class="border px-4 py-3 text-center w-[15%]">Tanggal</th>
                                <th class="border px-4 pydealer text-center w-[15%]">Status</th>
                                <th class="border px-4 py-3 text-center w-[15%]">Total Transaksi</th>
                                <th class="border px-4 py-3 text-center w-[5%]">Pembayaran</th>
                                <th class="border px-4 py-3 text-center w-[15%]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                             @php
                                $travelers = [
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

                                // --- FILTER PENCARIAN ---
                                if (request('search')) {
                                    $search = strtolower(request('search'));

                                    $travelers = array_filter($travelers, function ($item) use ($search) {
                                        return str_contains(strtolower($item[0]), $search) ||   // Username
                                            str_contains(strtolower($item[1]), $search) ||   // ID Transaksi
                                            str_contains(strtolower($item[2]), $search) ||   // Tanggal
                                            str_contains(strtolower($item[3]), $search) ||   // Status
                                            str_contains(strtolower((string)$item[4]), $search) || // Total Transaksi
                                            str_contains(strtolower($item[5]), $search);     // Pembayaran
                                    });
                            }
                            @endphp
                            
                            @foreach ($travelers as $i => $r)
                                <tr class="hover:bg-blue-50 transition-all">
                                    <td class="border px-4 py-3 text-center truncate">{{ $i + 1 }}</td>
                                    <td class="border px-4 py-3 text-center font-medium truncate">{{ $r[0] }}</td>
                                    <td class="border px-4 py-3 text-center font-semibold truncate">{{ $r[1] }}</td>
                                    <td class="border px-4 py-3 text-center truncate">{{ $r[2] }}</td>
                                    <td class="border px-4 py-3 text-center">
                                        @if ($i % 3 == 0)
                                            <span class="text-green-600 font-semibold whitespace-nowrap">Dibayar</span>
                                        @else
                                            <span class="text-red-600 font-semibold whitespace-nowrap">Belum Dibayar</span>
                                        @endif
                                    </td>
                                    <td class="border px-4 py-3 text-center font-semibold truncate">{{ $r[4] }}</td>
                                    <td class="border px-4 py-3 text-center truncate">{{ $r[5] }}</td>
                                    <td class="border px-2 py-3 text-center">
                                        <div class="flex justify-center gap-1 items-center">
                                            @if ($i % 3 != 0)
                                                <button class="bg-red-500 text-white text-xs px-2 py-1 rounded-full hover:bg-red-600 transition-all whitespace-nowrap text-[10px]">
                                                    Validasi
                                                </button>
                                            @endif
                                            <button class="bg-blue-100 hover:bg-blue-200 p-2 rounded-full transition-all">
                                                <i class="fas fa-eye text-xs"></i>
                                            </button>
                                            <button class="bg-red-100 hover:bg-red-200 p-2 rounded-full transition-all">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
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
    </div>
 </x-app-layout>