<x-app-layout>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('layouts.sidebar-superadmin')

        <!-- Area kanan (konten utama) -->
        <div id="main-content" class="flex-1 ml-97 transition-all duration-300 flex flex-col min-h-screen initial-hidden">
            
            <!-- Navbar + Header -->
            <div id="navbar-header" class="fixed top-0 left-97 right-0 z-20 transition-all duration-300 initial-hidden" style="background-color: #DBEDFF; padding: 1rem 1.5rem 1rem 1.5rem;">
                @include('layouts.navigation-superadmin', ['title' => __('messages.dashboard')])

                <div class="mt-2 px-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-blue-900">
                            {{ __('messages.hi') }}, {{ Auth::user()->detail->name }}
                        </h2>
                        <p class="text-gray-600">{{ __('messages.welcome_back') }}</p>
                    </div>
                </div>
            </div>

            <!-- Konten utama -->
            <div class="flex-1 px-10 pb-6 pt-48 space-y-6">
                <!-- Statistik -->
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div class="flex items-center gap-4 bg-white/40 px-6 py-4 rounded-2xl shadow-[0_0_10px_rgba(0,0,0,0.25)]">
                        <!-- Ikon SVG -->
                        <img src="{{ asset('icons/superadmin/card-bag.svg') }}" alt="Total Pengguna" class="w-8 h-8">
                        <div class="flex flex-col leading-tight">
                            <p class="text-[22px] font-extrabold text-gray-900">{{ number_format($totalUsers) }}</p>
                            <span class="text-gray-500 text-sm font-medium">{{ __('messages.labels.total_users') }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 bg-white/40 px-6 py-4 rounded-2xl shadow-[0_0_10px_rgba(0,0,0,0.25)]">
                        <img src="{{ asset('icons/superadmin/card-bag.svg') }}" alt="Total Transaksi" class="w-8 h-8">
                        <div class="flex flex-col leading-tight">
                            <p class="text-[22px] font-extrabold text-gray-900">{{ number_format($totalTransactions) }}</p>
                            <span class="text-gray-500 text-sm font-medium">{{ __('messages.labels.total_transactions') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Grafik & Aktivitas -->
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-white/40 p-4 rounded-xl shadow-[0_0_10px_rgba(0,0,0,0.25)]">
                        <h3 class="font-semibold mb-3">{{ __('messages.user_chart') }}</h3>
                        <canvas id="userChart"></canvas>
                    </div>

                    <div class="bg-white/40 p-4 rounded-xl shadow-[0_0_10px_rgba(0,0,0,0.25)]">
                        <h3 class="font-semibold mb-6 text-lg text-black">{{ __('messages.total_activities') }}</h3>
                        @php
                            $activities = [
                                ['label' => __('messages.labels.transaction_completed'), 'value' => $transactionCompleted, 'color' => 'bg-green-500'],
                                ['label' => __('messages.labels.transaction_in_progress'), 'value' => $transactionInProgress, 'color' => 'bg-yellow-400'],
                                ['label' => __('messages.labels.transaction_cancelled'), 'value' => $transactionCancelled, 'color' => 'bg-red-500'],
                                ['label' => __('messages.transaction_types.send'), 'value' => $sendIt, 'color' => 'bg-blue-500'],
                            ];

                            $max = collect($activities)->max('value');
                            if($max == 0) $max = 1; // biar ga error division by zero
                        @endphp

                        @foreach($activities as $act)
                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-gray-700 font-medium">{{ $act['label'] }}</span>
                                    <span class="font-bold text-gray-900 text-lg">{{ number_format($act['value']) }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3 mb-4">
                                    <div class="{{ $act['color'] }} h-3 rounded-full"
                                        style="width: {{ $act['value'] / $max * 100 }}%">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Tabel Transaksi Terbaru -->
                <div class="bg-white/40 p-4 rounded-xl shadow-[0_0_10px_rgba(0,0,0,0.25)]">
                    <h3 class="font-semibold mb-3 flex items-center gap-2">
                        {{ __('messages.latest_transactions') }}
                        <span id="loading-spinner" class="htmx-indicator hidden">
                            <svg class="animate-spin h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </h3>

                    <!-- CARD KOSONG → HTMX ISI -->
                    <div id="latest-transactions-card"
                        hx-get="{{ route('superadmin.dashboard.transactions') }}"
                        hx-trigger="load"
                        hx-target="#latest-transactions-card"
                        hx-swap="innerHTML"
                        hx-indicator="#loading-spinner">
                        <!-- Kosong -->
                    </div>
                </div>
            </div>

            <!-- Chart.js -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
            const ctx = document.getElementById('userChart').getContext('2d');

            const labels = @json($chartData['months']);
            const customerData = @json($chartData['customer']);
            const travelerData = @json($chartData['traveler']);
            const allValues = [...customerData, ...travelerData];

            // hitung min & max dari dataset
            const minValue = allValues.length ? Math.min(...allValues) : 0;
            const maxValue = allValues.length ? Math.max(...allValues) : 0;

            // default option: biarkan Chart.js menentukan range (seperti sebelum diubah)
            let yOptions = {
                beginAtZero: true
            };

            // Jika data (maks <= 50), gunakan step 10 dan sesuaikan max ke kelipatan 10
            if (maxValue <= 50) {
                const computedMax = Math.max(50, Math.ceil(maxValue / 10) * 10); // minimal 10
                yOptions = {
                    beginAtZero: true,
                    min: 0,
                    max: computedMax,
                    ticks: {
                        stepSize: 10,
                        precision: 0
                    }
                };
            }

            // Untuk dataset yang lebih besar (>50), tetap biarkan Chart.js otomatis (tanpa stepSize)
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        { label: 'Penitip', data: customerData, backgroundColor: '#FFF500' },
                        { label: 'Traveler', data: travelerData, backgroundColor: '#8FD14F' }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: yOptions
                    }
                }
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