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
                    <!-- Fitur Daftar Refund -->
                     <button class="p-1 rounded-md transition-all hover:scale-110">
                        <img src="{{ asset('iconsfinance/financetransaksiselesai.svg') }}"
                            alt="Icon Transaksi"
                            class="w-6 h-6 object-contain transition-all filter hover:brightness-0 hover:invert-[20%] hover:sepia hover:saturate-[700%] hover:hue-rotate-[190deg]">
                    </button>
                    <button class="text-[#000957] text-xl font-bold px-2 py-1 rounded-md hover:text-blue-700 transition-all">
                        Daftar Penitip
                    </button>
                </div>


                    <!-- Filter Search Bar + Unduh Data -->
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-2 -mt-2">
                        <!-- Search Bar -->
                        <form method="GET" class="relative">
                            <input type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari disini..."
                                class="w-72 pl-10 pr-4 py-2 bg-white border border-gray-300 rounded-md text-gray-700
                                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">

                            <!-- Icon Kaca Pembesar -->
                            <div class="absolute inset-y-0 left-0 w-9 flex items-center justify-center text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                                    stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </form>
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

                    <!-- Tabel Data Refund -->
                    <div class="overflow-x-auto bg-white rounded-xl shadow-md">
                    <table class="w-full border border-gray-200 text-sm text-left">
                        <thead class="bg-[#bfd9fff3] text-black font-semibold">
                            <tr>
                                <th class="border px-4 py-3 text-center w-[5%]">No</th>
                                <th class="border px-4 py-3 text-center w-[15%]">Nama Penitip</th>
                                <th class="border px-4 py-3 text-center w-[10%]">Username</th>
                                <th class="border px-4 py-3 text-center w-[10%]">Tanggal</th>
                                <th class="border px-4 pydealer text-center w-[20%]">Nomor Rekening</th>
                                <th class="border px-4 py-3 text-center w-[15%]">Total Transaksi</th>
                                <th class="border px-4 py-3 text-center w-[5%]">Pembayaran</th>
                                <th class="border px-4 py-3 text-center w-[30%]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                           @php
                            $consignors = [
                                ['Anya Geraldine', 'anya1245', '07-03-2025', '123-456-7890', 12, 'BRI'],
                                ['Komang Lau', 'komangl40', '07-03-2025', '123-456-7890', 8, 'BRI'],
                                ['Budi Solihin', 'budis_1', '07-03-2025', '123-456-7890', 4, 'BRI'],
                                ['Sehun Doremi', 'sdoremi12', '07-03-2025', '123-456-7890', 2, 'BRI'],
                                ['Khai Zayn', 'zaynkhai00', '07-03-2025', '123-456-7890', 5, 'BRI'],
                                ['Roberto Bob', 'rbob67', '07-03-2025', '123-456-7890', 10, 'BRI'],
                                ['Malika Sapena', 'maikaspn89', '07-03-2025', '123-456-7890', 7, 'BRI'],
                                ['Anggi Marino', 'annmarino7', '07-03-2025', '123-456-7890', 2, 'BRI'],
                                ['Anggi Marino', 'annmarino7', '07-03-2025', '123-456-7890', 7, 'BRI'],
                                ['Anggi Marino', 'annmarino7', '07-03-2025', '123-456-7890', 9, 'BRI'],
                                ['Anggi Marino', 'annmarino7', '07-03-2025', '123-456-7890', 3, 'BRI'],
                                ['Anggi Marino', 'annmarino7', '07-03-2025', '123-456-7890', 2, 'BRI'],
                                ['Anggi Marino', 'annmarino7', '07-03-2025', '123-456-7890', 6, 'BRI'],
                            ];

                            // --- FILTER PENCARIAN ---
                            if (request('search')) {
                                $search = strtolower(request('search'));

                                $consignors = array_filter($consignors, function ($item) use ($search) {
                                    return str_contains(strtolower($item[0]), $search) ||   // Nama Penitip
                                        str_contains(strtolower($item[1]), $search) ||   // Username
                                        str_contains(strtolower($item[2]), $search) ||   // Tanggal
                                        str_contains(strtolower($item[3]), $search) ||   // Nomor Rekening
                                        str_contains(strtolower((string)$item[4]), $search) || // Total Transaksi
                                        str_contains(strtolower($item[5]), $search);     // Pembayaran
                                });
                            }
                        @endphp


                            @foreach ($consignors as $i => $r)
                                <tr class="hover:bg-blue-50 transition-all">
                                    <td class="border px-4 py-3 text-center truncate">{{ $i + 1 }}</td>
                                    <td class="border px-4 py-3 text-center font-medium truncate">{{ $r[0] }}</td>
                                    <td class="border px-4 py-3 text-center font-semibold truncate">{{ $r[1] }}</td>
                                    <td class="border px-4 py-3 text-center truncate">{{ $r[2] }}</td>
                                    <td class="border px-4 py-3 text-center">
                                        <span class="font-semibold whitespace-nowrap">{{ $r[3] }}</span>
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
