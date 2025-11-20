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
                            <div class="w-56">
                                <img src="{{ $user->detail->account_image ? asset('storage/'.$user->detail->account_image) : asset('images/default-avatar.png') }}"
                                    class="w-56 h-72 object-cover rounded-xl border border-gray-300 shadow">

                                <h2 class="text-xl font-bold text-center mt-4 text-gray-900">
                                    {{ $user->detail->name ?? '-' }}
                                </h2>

                                <div class="mt-2 text-center">
                                    <span class="px-6 py-2 rounded-md text-white text-sm font-semibold
                                        {{ $user->account_status === 'active' ? 'bg-green-600' : 'bg-blue-900' }}">
                                        {{ $user->account_status === 'active' ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </div>
                            </div>

                            <!-- INFORMASI UMUM -->
                            <div class="bg-gray-50/80 flex-1 border rounded-lg p-5">
                                <h3 class="text-lg font-bold text-blue-900 border-b pb-1 mb-4">
                                    Informasi Umum
                                </h3>

                                <table class="w-full text-sm">
                                    <tr class="border-b">
                                        <td class="w-40 py-2 text-gray-600">Nama Lengkap</td>
                                        <td class="py-2">{{ $user->detail->name ?? '-' }}</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-2 text-gray-600">Username</td>
                                        <td class="py-2">{{ $user->username ?? '-' }}</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-2 text-gray-600">Email</td>
                                        <td class="py-2">{{ $user->email }}</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-2 text-gray-600">Telepon</td>
                                        <td class="py-2">{{ $user->detail->phone ?? '-' }}</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-2 text-gray-600">Alamat</td>
                                        <td class="py-2">{{ $user->detail->address ?? '-' }}</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-2 text-gray-600">Tanggal Lahir</td>
                                        <td class="py-2">
                                            {{ $user->detail->date_birth ? \Carbon\Carbon::parse($user->detail->date_birth)->format('d/m/Y') : '-' }}
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-2 text-gray-600">Jenis Kelamin</td>
                                        <td class="py-2">{{ $user->detail->gender ?? '-' }}</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-2 text-gray-600">Tanggal Bergabung</td>
                                        <td class="py-2">{{ $user->created_at->format('d F Y') }}</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-2 text-gray-600">Role</td>
                                        <td class="py-2 font-semibold text-blue-800">{{ ucfirst($user->role) }}</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-2 text-gray-600">Password (hash)</td>
                                        <td class="py-2 text-gray-500 font-mono">•••••••••••••••••••</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 text-gray-600">Status Aktivitas</td>
                                        <td class="py-2 text-green-700">Online</td>
                                    </tr>
                                </table>
                            </div>

                        </div>

                        <!-- STATISTIK -->
                        <div class="mt-10">
                            <h3 class="text-lg font-bold text-blue-900 border-b pb-1 mb-3">Statistik Durasi Aktivitas</h3>

                            <div class="bg-white rounded-md border p-4">
                                <canvas id="activityChart" height="120"></canvas>

                                <p class="text-xs text-gray-500 mt-2">
                                    Grafik ini menunjukkan frekuensi login selama seminggu terakhir.
                                </p>
                            </div>
                        </div>

                        <!-- RIWAYAT PERUBAHAN DATA -->
                        <div class="mt-10">
                            <h3 class="text-lg font-bold text-blue-900 border-b pb-1 mb-4">Riwayat Perubahan Data</h3>

                            <table class="w-full text-sm border-collapse">
                                <thead class="bg-blue-100 text-blue-900">
                                    <tr>
                                        <th class="p-3 text-left">Hari, Tanggal</th>
                                        <th class="p-3 text-left">Field</th>
                                        <th class="p-3 text-left">Perubahan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b">
                                        <td class="p-3">Senin, 7 April 2025</td>
                                        <td class="p-3">Email</td>
                                        <td class="p-3">teslama@gmail.com → tesbaru@gmail.com</td>
                                    </tr>
                                    <tr>
                                        <td class="p-3">Senin, 12 April 2025</td>
                                        <td class="p-3">Alamat</td>
                                        <td class="p-3">Jl. Lama → Jl. Baru, Yogyakarta</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js + Grafik Dummy 7 Hari (mirip banget Figma) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('main-content').classList.remove('initial-hidden');
            document.getElementById('navbar-header')?.classList.remove('initial-hidden');

            const ctx = document.getElementById('activityChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Senin, 1 Apr', 'Selasa, 1 Apr', 'Rabu, 1 Apr', 'Kamis, 1 Apr', 'Jumat, 1 Apr', 'Sabtu, 1 Apr', 'Minggu, 1 Apr'],
                    datasets: [{
                        label: 'Durasi (Jam)',
                        data: [7, 6.8, 7.2, 6.5, 7, 6.9, 6.7],
                        backgroundColor: '#86efac',
                        borderColor: '#22c55e',
                        borderWidth: 2,
                        borderRadius: 6,
                        barThickness: 30,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, max: 8, ticks: { stepSize: 1 } }
                    }
                }
            });
        });
    </script>
</x-app-layout>