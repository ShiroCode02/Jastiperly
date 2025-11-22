<x-app-layout>
    <div class="flex min-h-screen">
        @include('layouts.sidebar-superadmin')

        <div id="main-content" class="flex-1 ml-97 transition-all duration-300 flex flex-col min-h-screen initial-hidden">
            @include('_superadmin.users.components.header')

            <div class="flex-1 px-6 pb-6 pt-48">
                <div class="bg-white/70 rounded-xl shadow-lg border border-gray-200 max-w-6xl mx-auto overflow-hidden">

                    <div class="p-8 bg-white/70 rounded-xl shadow-md border border-gray-200">

                        <!-- FOTO + DETAIL -->
                        <div class="flex flex-col md:flex-row gap-10">

                            <!-- FOTO -->
                            <div class="w-[200px]">
                                <img src="{{ $user->profile_image_url }}"
                                    alt="Foto Profil {{ $user->name }}"
                                    class="w-[200px] h-[300px] object-cover rounded-3xl border border-gray-300 shadow">

                                <!-- NAMA -->
                                <h2 class="text-[25px] font-bold text-center mt-4 text-gray-900 leading-tight">
                                    {{ $user->detail->name ?? '-' }}
                                </h2>

                                <!-- TOMBOL STATUS AKUN -->
                                <div class="mt-3 flex justify-center">
                                    @if($user->account_status === 'active')
                                        <!-- Jika aktif → tampilkan tombol Nonaktif -->
                                        <button class="w-[225px] h-[35px] rounded-md text-white font-semibold
                                                    bg-[#344CB7] hover:bg-[#FF5E1F] transition">
                                            Nonaktif
                                        </button>
                                    @else
                                        <!-- Jika nonaktif → tampilkan tombol Aktif -->
                                        <button class="w-[225px] h-[35px] rounded-md text-white font-semibold
                                                    bg-green-600 hover:bg-green-700 transition">
                                            Aktif
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <!-- INFORMASI UMUM -->
                            <div class="flex-1">
                                <div class="bg-gray-50 border border-[#C0C0C0] rounded-lg p-5">
                                    <h3 class="text-lg font-medium text-[#000957] border-b-[2px] border-[#344CB7]">
                                        Informasi Umum
                                    </h3>

                                    <table class="w-full text-[15px] font-medium">
                                        <tr class="border-b border-gray-500">
                                            <td class="w-40 py-2 text-gray-600">Nama Lengkap</td>
                                            <td class="py-2 text-gray-600 text-right">{{ $user->name ?? '-' }}</td>
                                        </tr>
                                        <tr class="border-b border-gray-500">
                                            <td class="py-2 text-gray-600">Username</td>
                                            <td class="py-2 text-gray-600 text-right">{{ $user->detail->name ?? '-' }}</td>
                                        </tr>
                                        <tr class="border-b border-gray-500">
                                            <td class="py-2 text-gray-600">Email</td>
                                            <td class="py-2 text-gray-600 text-right">{{ $user->email }}</td>
                                        </tr>
                                        <tr class="border-b border-gray-500">
                                            <td class="py-2 text-gray-600">Telepon</td>
                                            <td class="py-2 text-gray-600 text-right">{{ $user->detail->phone ?? '-' }}</td>
                                        </tr>
                                        <tr class="border-b border-gray-500">
                                            <td class="py-2 text-gray-600">Negara/Kota Asal</td>
                                            <td class="py-2 text-gray-600 text-right">-</td>
                                        </tr>
                                        <tr class="border-b border-gray-500">
                                            <td class="py-2 text-gray-600">Alamat</td>
                                            <td class="py-2 text-gray-600 text-right">{{ $user->detail->address ?? '-' }}</td>
                                        </tr>
                                        <tr class="border-b border-gray-500">
                                            <td class="py-2 text-gray-600">Tanggal Lahir</td>
                                            <td class="py-2 text-gray-600 text-right">
                                                {{ $user->detail->date_birth ? \Carbon\Carbon::parse($user->detail->date_birth)->format('d/m/Y') : '-' }}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-500">
                                            <td class="py-2 text-gray-600">Jenis Kelamin</td>
                                            <td class="py-2 text-gray-600 text-right">{{ $user->detail->gender ?? '-' }}</td>
                                        </tr>
                                        <tr class="border-b border-gray-500">
                                            <td class="py-2 text-gray-600">Tanggal Bergabung</td>
                                            <td class="py-2 text-gray-600 text-right">{{ $user->created_at->format('d F Y') }}</td>
                                        </tr>
                                        <tr class="border-b border-gray-500">
                                            <td class="py-2 text-gray-600">Status Akun</td>
                                            <td class="py-2 text-gray-600 text-right font-semibold text-blue-800">{{ ucfirst($user->role) }}</td>
                                        </tr>
                                        <tr class="border-b border-gray-500">
                                            <td class="py-2 text-gray-600">Password (hash)</td>
                                            <td class="py-2 text-gray-600 text-right font-mono">{{ $user->password ? '•••••••••••••••••••' : '-' }}</td>
                                        </tr>
                                        <tr class="border-b border-gray-500">
                                            <td class="py-2 text-gray-600">Status Aktivitas</td>
                                            <td class="py-2 text-gray-600 text-right">
                                                @php
                                                    $statusColors = [
                                                        'Online'    => 'text-green-600',
                                                        'Aktif'     => 'text-blue-600',
                                                        'Offline'   => 'text-gray-500',
                                                        'Nonaktif'  => 'text-red-600',
                                                    ];
                                                @endphp
                                                <span class="{{ $statusColors[$user->display_status] ?? 'text-gray-500' }}">
                                                    {{ $user->display_status }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-500">
                                            <td class="w-40 py-2 text-gray-600 align-top">Foto KTP</td>
                                            <td class="py-2 text-right">
                                                @if($user->detail?->id_card_image)
                                                    <img src="{{ asset('storage/' . $user->detail->id_card_image) }}" 
                                                        alt="KTP" 
                                                        class="max-h-32 inline-block rounded-lg shadow border border-gray-300 hover:shadow-lg transition">
                                                @else
                                                    <span class="text-gray-400 italic text-sm">Belum upload</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-500">
                                            <td class="w-40 py-2 text-gray-600 align-top">Foto Rekening</td>
                                            <td class="py-2 text-right">
                                                @if($user->detail?->account_image)
                                                    <img src="{{ asset('storage/' . $user->detail->account_image) }}" 
                                                        alt="Rekening" 
                                                        class="max-h-32 inline-block rounded-lg shadow border border-gray-300 hover:shadow-lg transition">
                                                @else
                                                    <span class="text-gray-400 italic text-sm">Belum upload</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-500">
                                            <td class="w-40 py-2 text-gray-600 align-top">Foto Paspor</td>
                                            <td class="py-2 text-right">
                                                @if($user->detail?->pasport_image)
                                                    <img src="{{ asset('storage/' . $user->detail->pasport_image) }}" 
                                                        alt="Paspor" 
                                                        class="max-h-32 inline-block rounded-lg shadow border border-gray-300 hover:shadow-lg transition">
                                                @else
                                                    <span class="text-gray-400 italic text-sm">Belum upload</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <!-- CARD AKTIVITAS-->
                                <div class="mt-8 bg-gray-50 border border-[#C0C0C0] rounded-lg p-5">
                                    <h3 class="text-lg font-medium text-[#000957] border-b-[2px] border-[#344CB7]">Aktivitas</h3>

                                    <table class="w-full text-[15px] font-medium">
                                        <tr class="border-b border-gray-500">
                                            <td class="py-2 text-gray-600">Status</td>
                                            <td class="py-2 text-gray-600 text-right">
                                                @php
                                                    $statusColors = [
                                                        'Online'    => 'text-green-600',
                                                        'Aktif'     => 'text-blue-600',
                                                        'Offline'   => 'text-gray-500',
                                                        'Nonaktif'  => 'text-red-600',
                                                    ];
                                                @endphp
                                                <span class="{{ $statusColors[$user->display_status] ?? 'text-gray-500' }}">
                                                    {{ $user->display_status }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-500">
                                            <td class="w-40 py-2 text-gray-600">Rating</td>
                                            <td class="py-2 text-gray-600 text-right">-</td>
                                        </tr>
                                        <tr class="border-b border-gray-500">
                                            <td class="w-40 py-2 text-gray-600">Login Terakhir</td>
                                            <td class="py-2 text-gray-600 text-right">
                                                {{ $user->last_login_at 
                                                    ? $user->last_login_at->setTimezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') . ' WIB'
                                                    : '-' 
                                                }}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-500">
                                            <td class="w-40 py-2 text-gray-600">Lokasi Login</td>
                                            <td class="py-2 text-gray-600 text-right">
                                                {{ $user->last_login_device }}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-500">
                                            <td class="w-40 py-2 text-gray-600">Total Transaksi</td>
                                            <td class="py-2 text-gray-600 text-right">{{ $user->total_transaction ?? 0 }}</td>
                                        </tr>
                                        <tr class="border-b border-gray-500">
                                            <td class="w-40 py-2 text-gray-600">Transaksi Berhasil</td>
                                            <td class="py-2 text-gray-600 text-right">{{ $user->successful_transaction ?? 0 }}</td>
                                        </tr>
                                        <tr class="border-b border-gray-500">
                                            <td class="w-40 py-2 text-gray-600">Transaksi Dibatalkan</td>
                                            <td class="py-2 text-gray-600 text-right">{{ $user->failed_transaction ?? 0 }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- STATISTIK -->
                        <div class="mt-10">
                            <h3 class="text-xl font-medium text-[#000957] border-b-[2px] border-[#344CB7] mb-4">
                                Statistik Durasi Aktivitas
                            </h3>

                            <canvas id="activityChart" height="120"></canvas>

                            <p class="text-lg text-gray-600 mt-3">
                                Grafik ini menunjukkan frekuensi login selama seminggu terakhir.
                            </p>
                        </div>


                        <!-- RIWAYAT PERUBAHAN DATA -->
                        <div class="mt-10">
                            <h3 class="text-xl font-medium text-[#000957] border-b-[2px] border-[#344CB7]">
                                Riwayat Perubahan Data
                            </h3>

                            @if($user->detailHistories->count() > 0)
                                <table class="w-full text-sm border-collapse">

                                    <!-- Header -->
                                    <thead>
                                        <tr class="border-b border-black">
                                            <th class="py-3 pl-4 text-left font-semibold text-[#344CB7] w-[20%]">Hari, Tanggal</th>
                                            <th class="py-3 pl-4 text-left font-semibold text-[#344CB7] w-[20%]">Field</th>
                                            <th class="py-3 pl-4 text-left font-semibold text-[#344CB7] w-[60%]">Perubahan</th>
                                        </tr>
                                    </thead>

                                    <!-- Body -->
                                    <tbody>
                                        @foreach($user->detailHistories as $log)
                                            <tr class="border-b border-gray-300">
                                                <td class="py-3 pl-4 text-gray-600">{{ $log->tanggal }}</td>
                                                <td class="py-3 pl-4 text-gray-600 font-medium">{{ $log->field }}</td>
                                                <td class="py-3 pl-4 text-gray-600">
                                                    {{ $log->old_value }} → <span class="font-semibold text-[#344CB7]">{{ $log->new_value }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="mt-4 text-gray-500 italic">Belum ada perubahan data.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('main-content').classList.remove('initial-hidden');
            document.getElementById('navbar-header')?.classList.remove('initial-hidden');

            const ctx = document.getElementById('activityChart').getContext('2d');

            const dataPoints = [4, 6, 6.2, 3.8, 5.6, 4.4, 5];
            const maxValue = Math.max(...dataPoints);
            let suggestedTop = Math.ceil(maxValue);
            if (Number.isInteger(maxValue)) {
                suggestedTop += 1;
            }

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [
                        'Senin, 1 April',
                        'Selasa, 1 April',
                        'Rabu, 1 April',
                        'Kamis, 1 April',
                        'Jumat, 1 April',
                        'Sabtu, 1 April',
                        'Minggu, 1 April'
                    ],
                    datasets: [{
                        label: 'Durasi (Jam)',
                        data: dataPoints,
                        backgroundColor: '#9DFFAF',
                        barThickness: 40
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,

                    plugins: { legend: { display: false } },

                    scales: {
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: {
                                color: '#5E5E5E',
                                font: { size: 10 }
                            }
                        },

                        y: {
                            beginAtZero: true,
                            suggestedMax: suggestedTop,   // ← otomatis berdasarkan data minggu ini

                            ticks: {
                                stepSize: 1,
                                color: '#5E5E5E',
                                font: { size: 18 },
                                padding: 10,

                                // sembunyikan angka paling atas
                                callback: function(value) {
                                    return value === suggestedTop ? '' : value;
                                }
                            },

                            title: {
                                display: true,
                                text: 'Durasi Waktu (Jam)',
                                color: '#5E5E5E',
                                font: { size: 18 },
                            },

                            border: {
                                display: true,
                                color: '#000000',
                            },

                            grid: {
                                display: true,
                                color: '#000000',
                                drawTicks: false,

                                // sembunyikan garis horizontal paling atas
                                lineWidth: function(ctx) {
                                    return ctx.index === ctx.chart.scales.y.ticks.length - 1 ? 0 : 1;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>