<div id="navbar-header" class="fixed top-0 left-97 right-0 z-20 transition-all duration-300 initial-hidden"
     style="background-color: #DBEDFF; padding: 1rem 1.5rem;">
    @include('layouts.navigation-superadmin', ['title' => __('messages.refunds')])
    <div class="mt-2 flex justify-between items-center">
        @if(!request('refund'))
            <!-- FILTER LOKASI + UNDUH (Hanya di daftar) -->
            <div class="flex gap-3 items-center">
                <!-- FILTER LOKASI -->
                <form method="GET" class="flex items-center">
                    <div class="relative">
                        <select name="location" onchange="this.form.submit()"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <option value="">{{ __('messages.filters.all_locations') }}</option>
                            <option value="dalam" {{ request('location') == 'dalam' ? 'selected' : '' }}>{{ __('messages.filters.domestic') }}</option>
                            <option value="luar" {{ request('location') == 'luar' ? 'selected' : '' }}>{{ __('messages.filters.overseas') }}</option>
                        </select>
                        <div class="border border-gray-300 rounded-md mt-3 px-4 py-3 text-sm bg-white flex items-center justify-between pointer-events-none min-w-[110px]">
                            <span class="text-left">
                                {{ request('location') == 'dalam' ? __('messages.filters.domestic') : (request('location') == 'luar' ? __('messages.filters.overseas') : __('messages.filters.all_locations')) }}
                            </span>
                            <svg class="w-4 h-4 text-gray-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}"> @endif
                </form>
            </div>
            <!-- UNDUH DAFTAR -->
            <div class="flex items-center gap-3 mt-6">
                <a href="{{ route('superadmin.refunds.export', request()->query()) }}"
                   class="flex items-center gap-2 bg-[#FFEB00] hover:bg-[#FF5E1F] text-black font-semibold px-4 py-1 rounded-md shadow transition">
                    <span>{{ __('messages.actions.download') }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                    </svg>
                </a>
            </div>
        @else
            <!-- DETAIL / EDIT: Kembali + Simpan/Unduh -->
            <div class="flex justify-between items-center w-full mt-4">
                <div class="flex items-center gap-3 ml-6">
                    <a href="{{ route('superadmin.refunds', request()->except('refund')) }}"
                       class="text-blue-900 hover:text-blue-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <h2 class="text-[32px] font-semibold text-blue-900">
                        {{ request()->is('*edit*') ? 'Edit Refund' : 'Detail Refund' }}
                    </h2>
                </div>

                @if(request()->is('*edit*'))
                    <!-- TOMBOL SIMPAN -->
                    <button form="editForm" type="submit"
                            class="flex items-center gap-2 bg-[#FFEB00] hover:bg-[#FF5E1F] text-black font-semibold px-10 py-1 rounded-md shadow transition">
                        <span>{{ __('messages.actions.save') }}</span>
                    </button>
                @else
                    <!-- TOMBOL UNDUH (DETAIL) -->
                    <a href="{{ route('superadmin.refunds.export', array_merge(request()->query(), ['refund' => request('refund')])) }}"
                       class="flex items-center gap-2 bg-[#FFEB00] hover:bg-[#FF5E1F] text-black font-semibold px-4 py-1 rounded-md shadow transition">
                        <span>{{ __('messages.actions.download') }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                        </svg>
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>