<div id="navbar-header" class="fixed top-0 left-97 right-0 z-20 transition-all duration-300 initial-hidden"
     style="background-color: #DBEDFF; padding: 1rem 1.5rem;">
    @include('layouts.navigation-superadmin', ['title' => 'Transaksi'])

    <div class="mt-2 flex justify-between items-center">
        @if(!request()->route('transaction') && !request()->is('*edit*'))
            <!-- TAB + FILTER + UNDUH (Hanya di daftar) -->
            <div class="flex gap-3 items-center">
                <div class="flex gap-3 bg-[#FFF6E3] mt-3 px-6 py-1 rounded-md items-center">
                    @foreach (['buy' => 'Titip Beli', 'send' => 'Titip Kirim'] as $type => $label)
                        @php
                            $count = $type === 'buy'
                                ? \App\Models\BuyTransaction::count()
                                : \App\Models\SendTransaction::count();
                        @endphp
                        <form method="GET" action="{{ route('superadmin.transactions') }}" class="inline">
                            <input type="hidden" name="type" value="{{ $type }}">
                            <button type="submit"
                                    class="flex items-center gap-2 px-4 py-1.5 rounded-md text-black font-medium
                                        hover:bg-white transition {{ request('type', 'buy') === $type ? 'bg-white text-black' : 'bg-transparent' }}">
                                <span>{{ $label }}</span>
                                <span class="text-gray-400 text-sm font-bold flex items-center justify-center ml-1">
                                    {{ $count }}
                                </span>
                            </button>
                        </form>
                        @if($loop->first)<div class="w-0.5 bg-black h-4"></div>@endif
                    @endforeach
                </div>
                <!-- FILTER LOKASI: DI KANAN TAB -->
                @if(request('type', 'buy') === 'send')
                    <form method="GET" class="flex items-center">
                        <div class="relative">
                            <select name="location" onchange="this.form.submit()"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <option value="">Semua Lokasi</option>
                                <option value="dalam" {{ request('location') == 'dalam' ? 'selected' : '' }}>Dalam Negeri</option>
                                <option value="luar" {{ request('location') == 'luar' ? 'selected' : '' }}>Luar Negeri</option>
                            </select>
                            <div class="border border-gray-300 rounded-md mt-3 px-4 py-3 text-sm bg-white flex items-center justify-between pointer-events-none min-w-[110px]">
                                <span class="text-left">
                                    {{ request('location') == 'dalam' ? 'Dalam Negeri' : (request('location') == 'luar' ? 'Luar Negeri' : 'Semua Lokasi') }}
                                </span>
                                <svg class="w-4 h-4 text-gray-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        <input type="hidden" name="type" value="{{ request('type', 'buy') }}">
                        @if(request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif
                        @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    </form>
                @endif
            </div>

            <div class="flex items-center gap-3 mt-6">
                <form method="GET" class="flex items-center gap-2">
                    <!-- CUSTOM SELECT: STATUS -->
                    <div class="relative">
                        <select name="status" onchange="this.form.submit()"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="berjalan" {{ request('status') == 'berjalan' ? 'selected' : '' }}>Berjalan</option>
                            <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        <div class="border border-gray-300 rounded-md px-4 py-1.5 text-sm bg-white flex items-center justify-between pointer-events-none">
                            <span class="text-left">
                                {{ request('status') == 'selesai' ? 'Selesai' : (request('status') == 'berjalan' ? 'Berjalan' : (request('status') == 'dibatalkan' ? 'Dibatalkan' : 'Semua Status')) }}
                            </span>
                            <svg class="w-4 h-4 text-gray-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    <input type="hidden" name="type" value="{{ request('type', 'buy') }}">
                    @if(request('location'))
                        <input type="hidden" name="location" value="{{ request('location') }}">
                    @endif
                    @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}"> @endif
                </form>

                <a href="{{ route('superadmin.transactions.export', request()->query()) }}"
                   class="flex items-center gap-2 bg-yellow-200 hover:bg-yellow-300 text-black font-semibold px-4 py-1 rounded-md shadow transition">
                    <span>Unduh Data</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                    </svg>
                </a>
            </div>
        @else
            <!-- DETAIL / EDIT: Kembali + Simpan/Unduh -->
            <div class="flex justify-between items-center w-full mt-4">
                <div class="flex items-center gap-3 ml-6">
                    <a href="{{ route('superadmin.transactions', request()->except('transaction')) }}"
                       class="text-blue-900 hover:text-blue-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <h2 class="text-[32px] font-semibold text-blue-900">
                        {{ request()->is('*edit*') ? 'Edit Detail' : 'Detail' }} {{ request('type') === 'buy' ? 'Titip Beli' : 'Titip Kirim' }}
                    </h2>
                </div>

                @if(request()->is('*edit*'))
                    <button form="editForm" type="submit" 
                            class="flex items-center gap-2 bg-yellow-200 hover:bg-yellow-300 text-black font-semibold px-10 py-1 rounded-md shadow transition">
                        <span>Simpan</span>
                    </button>
                @else
                    <a href="{{ route('superadmin.transactions.export', array_merge(request()->query(), ['transaction' => request()->route('transaction')])) }}"
                       class="flex items-center gap-2 bg-yellow-200 hover:bg-yellow-300 text-black font-semibold px-4 py-1 rounded-md shadow transition">
                        <span>Unduh Data</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                        </svg>
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>