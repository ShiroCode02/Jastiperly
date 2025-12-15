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
                                    <form action="{{ route('superadmin.users.toggleStatus', $user) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                                class="w-[225px] h-[35px] rounded-md text-white font-semibold transition
                                                    {{ $user->account_status === 'active' 
                                                        ? 'bg-[#344CB7] hover:bg-[#FF5E1F]' 
                                                        : 'bg-green-600 hover:bg-[#FF5E1F]' }}">
                                            {{ $user->account_status === 'active' ? __('messages.actions.disable') : __('messages.actions.activate') }}
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- INFORMASI UMUM -->
                            <div class="flex-1">
                                <div class="bg-gray-50 border border-[#C0C0C0] rounded-lg p-5">
                                    <h3 class="text-lg font-medium text-[#000957] border-b-[2px] border-[#344CB7]">
                                        {{ __('messages.general_info') }}
                                    </h3>

                                    <table class="w-full text-[15px] font-medium">
                                        <tr class="border-b border-gray-500">
                                            <td class="w-40 py-2 text-gray-600">{{ __('messages.labels.full_name') }}</td>
                                            <td class="py-2 text-gray-600 text-right">{{ $user->detail->name ?? '-' }}</td>
                                        </tr>
                                        <tr class="border-b border-gray-500">
                                            <td class="py-2 text-gray-600">{{ __('messages.labels.username') }}</td>
                                            <td class="py-2 text-gray-600 text-right">{{ $user->name ?? '-' }}</td>
                                        </tr>
                                        <tr class="border-b border-gray-500">
                                            <td class="py-2 text-gray-600">{{ __('messages.labels.email') }}</td>
                                            <td class="py-2 text-gray-600 text-right">{{ $user->email }}</td>
                                        </tr>
                                        <tr class="border-b border-gray-500">
                                            <td class="py-2 text-gray-600">{{ __('messages.labels.phone') }}</td>
                                            <td class="py-2 text-gray-600 text-right">{{ $user->detail->phone ?? '-' }}</td>
                                        </tr>

                                        @if($user->role === 'traveler')
                                            <tr class="border-b border-gray-500">
                                                <td class="py-2 text-gray-600">{{ __('messages.labels.city_country') }}</td>
                                                <td class="py-2 text-gray-600 text-right">{{ $user->city_country }}</td>
                                            </tr>
                                        @endif

                                        <tr class="border-b border-gray-500">
                                            <td class="py-2 text-gray-600">{{ __('messages.labels.address') }}</td>
                                            <td class="py-2 text-gray-600 text-right">{{ $user->detail_address }}</td>
                                        </tr>
                                        <tr class="border-b border-gray-500">
                                            <td class="py-2 text-gray-600">{{ __('messages.labels.date_birth') }}</td>
                                            <td class="py-2 text-gray-600 text-right">
                                                {{ $user->detail->date_birth ? \Carbon\Carbon::parse($user->detail->date_birth)->format('d/m/Y') : '-' }}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-500">
                                            <td class="py-2 text-gray-600">{{ __('messages.labels.gender') }}</td>
                                            <td class="py-2 text-gray-600 text-right">{{ $user->detail->gender ?? '-' }}</td>
                                        </tr>

                                        @if(in_array($user->role, ['traveler', 'customer']))
                                            <tr class="border-b border-gray-500">
                                                <td class="py-2 text-gray-600">{{ __('messages.labels.bank_account') }}</td>
                                                <td class="py-2 text-gray-600 text-right">{{ $user->detail->bank_number . ' - ' . $user->detail->bank_name ?? '-' }}</td>
                                            </tr>
                                        @endif

                                        <tr class="border-b border-gray-500">
                                            <td class="py-2 text-gray-600">{{ __('messages.labels.joined_date') }}</td>
                                            <td class="py-2 text-gray-600 text-right">{{ $user->created_at->format('d F Y') }}</td>
                                        </tr>
                                        <tr class="border-b border-gray-500">
                                            <td class="py-2 text-gray-600">{{ __('messages.labels.account_status') }}</td>
                                            <td class="py-2 text-green-600 text-right">{{ ucfirst($user->role) }}</td>
                                        </tr>
                                        <tr class="border-b border-gray-500">
                                            <td class="py-2 text-gray-600">{{ __('messages.labels.password') }}</td>
                                            <td class="py-2 text-gray-600 text-right font-mono">{{ $user->password ? '•••••••••••••••••••' : '-' }}</td>
                                        </tr>

                                        @if (in_array($user->role, ['admin', 'finance']))
                                            <tr class="border-b border-gray-500">
                                                <td class="py-2 text-gray-600">{{ __('messages.labels.activity_status') }}</td>
                                                <td class="py-2 text-gray-600 text-right">
                                                    @php
                                                        $statusColors = [
                                                            __('messages.users_status.Online') => 'text-green-600',
                                                            __('messages.users_status.active') => 'text-blue-600',
                                                            __('messages.users_status.Offline') => 'text-gray-500',
                                                            __('messages.users_status.inactive') => 'text-red-600',
                                                        ];
                                                    @endphp
                                                    <span class="{{ $statusColors[$user->display_status] ?? 'text-gray-500' }}">
                                                        {{ $user->display_status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endif

                                        @if($user->role === 'traveler')
                                            <tr class="border-b border-gray-500">
                                                <td class="w-40 py-2 text-gray-600 align-top">{{ __('messages.labels.photo_id_card') }}</td>
                                                <td class="py-2 text-right">
                                                    @if($user->detail?->id_card_image)
                                                        <img src="{{ asset('storage/' . $user->detail->id_card_image) }}" 
                                                            alt="KTP" 
                                                            class="max-h-32 inline-block rounded-lg shadow border border-gray-300 hover:shadow-lg transition">
                                                    @else
                                                        <span class="text-gray-400 italic text-sm">{{ __('messages.not_uploaded') }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-500">
                                                <td class="w-40 py-2 text-gray-600 align-top">{{ __('messages.labels.photo_bank_account') }}</td>
                                                <td class="py-2 text-right">
                                                    @if($user->detail?->account_image)
                                                        <img src="{{ asset('storage/' . $user->detail->account_image) }}" 
                                                            alt="Rekening" 
                                                            class="max-h-32 inline-block rounded-lg shadow border border-gray-300 hover:shadow-lg transition">
                                                    @else
                                                        <span class="text-gray-400 italic text-sm">{{ __('messages.not_uploaded') }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-500">
                                                <td class="w-40 py-2 text-gray-600 align-top">{{ __('messages.labels.photo_passport') }}</td>
                                                <td class="py-2 text-right">
                                                    @if($user->detail?->pasport_image)
                                                        <img src="{{ asset('storage/' . $user->detail->pasport_image) }}" 
                                                            alt="Paspor" 
                                                            class="max-h-32 inline-block rounded-lg shadow border border-gray-300 hover:shadow-lg transition">
                                                    @else
                                                        <span class="text-gray-400 italic text-sm">{{ __('messages.not_uploaded') }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>

                                <!-- CARD AKTIVITAS-->
                                @if(in_array($user->role, ['traveler', 'customer']))
                                    <div class="mt-8 bg-gray-50 border border-[#C0C0C0] rounded-lg p-5">
                                        <h3 class="text-lg font-medium text-[#000957] border-b-[2px] border-[#344CB7]">{{ __('messages.activity') }}</h3>

                                        <table class="w-full text-[15px] font-medium">
                                            <tr class="border-b border-gray-500">
                                                <td class="py-2 text-gray-600">{{ __('messages.labels.status') }}</td>
                                                <td class="py-2 text-gray-600 text-right">
                                                    @php
                                                        $statusColors = [
                                                            __('messages.users_status.Online') => 'text-green-600',
                                                            __('messages.users_status.active') => 'text-blue-600',
                                                            __('messages.users_status.Offline') => 'text-gray-500',
                                                            __('messages.users_status.inactive') => 'text-red-600',
                                                        ];
                                                    @endphp
                                                    <span class="{{ $statusColors[$user->display_status] ?? 'text-gray-500' }}">
                                                        {{ $user->display_status }}
                                                    </span>
                                                </td>
                                            </tr>

                                            @if($user->role === 'traveler')
                                                <tr class="border-b border-gray-500">
                                                    <td class="w-40 py-2 text-gray-600">{{ __('messages.labels.ratings') }}</td>
                                                    <td class="py-2 text-gray-600 text-right">-</td>
                                                </tr>
                                                <tr class="border-b border-gray-500">
                                                    <td class="w-40 py-2 text-gray-600">{{ __('messages.labels.last_login') }}</td>
                                                    <td class="py-2 text-gray-600 text-right">
                                                        {{ $user->last_login_at 
                                                            ? $user->last_login_at->translatedFormat('d F Y, H:i') . ' WIB'
                                                            : '-' 
                                                        }}
                                                    </td>
                                                </tr>
                                                <tr class="border-b border-gray-500">
                                                    <td class="w-40 py-2 text-gray-600">{{ __('messages.labels.login_location') }}</td>
                                                    <td class="py-2 text-gray-600 text-right">
                                                        {{ $user->last_login_device }}
                                                    </td>
                                                </tr>
                                            @endif

                                            <tr class="border-b border-gray-500">
                                                <td class="w-40 py-2 text-gray-600">{{ __('messages.labels.total_transactions') }}</td>
                                                <td class="py-2 text-gray-600 text-right">{{ $user->total_transaction ?? 0 }}</td>
                                            </tr>
                                            <tr class="border-b border-gray-500">
                                                <td class="w-40 py-2 text-gray-600">{{ __('messages.labels.transaction_completed') }}</td>
                                                <td class="py-2 text-gray-600 text-right">{{ $user->successful_transaction ?? 0 }}</td>
                                            </tr>
                                            <tr class="border-b border-gray-500">
                                                <td class="w-40 py-2 text-gray-600">{{ __('messages.labels.transaction_cancelled') }}</td>
                                                <td class="py-2 text-gray-600 text-right">{{ $user->failed_transaction ?? 0 }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- STATISTIK -->
                        <div class="mt-10">
                            <h3 class="text-xl font-medium text-[#000957] border-b-[2px] border-[#344CB7] mb-4">
                                {{ __('messages.statistics.activity_duration') }}
                            </h3>

                            <canvas id="activityChart" height="100"></canvas>

                            <p class="text-lg text-gray-600 mt-3">
                                {{ __('messages.statistics.login_frequency_graph') }}
                            </p>
                        </div>

                        @if(in_array($user->role, ['traveler', 'customer']))
                            <div class="mt-10">
                                <h3 class="text-xl font-medium text-[#000957] border-b-[2px] border-[#FF5E1F] mb-4">
                                    {{ __('messages.statistics.transaction_count') }}
                                </h3>
                                <canvas id="transactionChart" height="100"></canvas>
                                <p class="text-lg text-gray-600 mt-3">
                                    {{ __('messages.statistics.transaction_frequency_graph') }}
                                </p>
                            </div>
                        @endif

                        <!-- RIWAYAT PERUBAHAN DATA -->
                        <div class="mt-10">
                            <h3 class="text-xl font-medium text-[#000957] border-b-[2px] border-[#344CB7]">
                                {{ __('tables.data_changes') }}
                            </h3>

                            <div id="history-table">
                                @include('_superadmin.users.components.history-table')
                            </div>
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

            const rawData = @json($user->chart_data);
            const labels = @json($user->chart_labels);
            const dataPoints = rawData.map(val => Math.min(val, 24));

            const hasData = dataPoints.some(val => val > 0);
            const maxValue = hasData ? Math.max(...dataPoints) : 6;

            let suggestedTop = Math.ceil(maxValue);
            if (Number.isInteger(maxValue)) {
                suggestedTop += 1;
            }

            if (maxValue >= 24) {
                suggestedTop = 25;
            }

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
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
                    plugins: { 
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const displayedHours = context.parsed.y;
                                    const originalHours = rawData[context.dataIndex]; // ambil data asli
                                    
                                    if (originalHours >= 24) {
                                        return 'Durasi: 24 jam+ (dibatasi grafik)';
                                    }
                                    const totalMinutes = Math.round(context.parsed.y * 60);
                                    const hours = Math.floor(totalMinutes / 60);
                                    const minutes = totalMinutes % 60;

                                    if (hours === 0) return `Durasi: ${minutes} menit`;
                                    if (minutes === 0) return `Durasi: ${hours} jam`;
                                    return `Durasi: ${hours} jam ${minutes} menit`;
                                }
                            }
                        }
                    },
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
                            suggestedMax: suggestedTop,

                            ticks: {
                                stepSize: function(context) {
                                    const max = context.chart.options.scales.y.suggestedMax;
                                    if (max <= 6) return 1;
                                    if (max <= 12) return 2;
                                    if (max <= 24) return 4;
                                    return 5;
                                },
                                color: '#5E5E5E',
                                font: { size: 18 },
                                padding: 10,
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
                                lineWidth: function(ctx) {
                                    return ctx.index === ctx.chart.scales.y.ticks.length - 1 ? 0 : 1;
                                }
                            }
                        }
                    }
                }
            });
            // GRAFIK TRANSAKSI — HANYA UNTUK TRAVELER & CUSTOMER
            @if(in_array($user->role, ['traveler', 'customer']))
                const ctx2 = document.getElementById('transactionChart')?.getContext('2d');
                if (ctx2) {
                    const transData = @json($user->transaction_data);
                    const transLabels = @json($user->transaction_labels);
                    const hasTrans = transData.some(val => val > 0);
                    const maxTrans = hasTrans ? Math.max(...transData) : 50;
                    let topTrans = Math.ceil(maxTrans);
                    if (Number.isInteger(maxTrans)) {
                        topTrans += 1;
                    }

                    new Chart(ctx2, {
                        type: 'bar',
                        data: {
                            labels: transLabels,
                            datasets: [{
                                label: 'Jumlah Transaksi',
                                data: transData,
                                backgroundColor: '#FF5E1F',
                                barThickness: 40
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    callbacks: {
                                        label: ctx => `Transaksi: ${ctx.parsed.y}`
                                    }
                                }
                            },
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
                                    suggestedMax: topTrans,
                                    ticks: {
                                        stepSize: function(context) {
                                            const max = context.chart.options.scales.y.suggestedMax;
                                            if (max <= 10) return 1;
                                            if (max <= 30) return 5;
                                            if (max <= 70) return 10;
                                            if (max <= 150) return 20;
                                            return 25;
                                        },
                                        color: '#5E5E5E',
                                        font: { size: 18 },
                                        padding: 10,
                                        callback: function(value, index, ticks) {
                                            return value === ticks[ticks.length - 1].value ? '' : value;
                                        }
                                    },
                                    title: {
                                        display: true,
                                        text: 'Jumlah Transaksi',
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
                                        lineWidth: function(ctx) {
                                            return ctx.index === ctx.chart.scales.y.ticks.length - 1 ? 0 : 1;
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            @endif
        });
    </script>
</x-app-layout>