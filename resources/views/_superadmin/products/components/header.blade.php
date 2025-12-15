<div id="navbar-header" class="fixed top-0 left-97 right-0 z-20 transition-all duration-300 initial-hidden"
     style="background-color: #DBEDFF; padding: 1rem 1.5rem;">
    @include('layouts.navigation-superadmin', ['title' => __('messages.product_management')])
    <div class="mt-2 flex justify-between items-center">
        @if(!request('product_id'))
            <!-- TAB + FILTER + UNDUH -->
            <div class="flex gap-3 bg-[#FFF6E3] mt-3 px-6 py-1 rounded-md items-center">
                @foreach (['traveler', 'customer'] as $i => $role)
                    @php
                        $pendingCount = \App\Models\Product::where('approval', 'pending')
                            ->whereHas('submiter', fn($q) => $q->where('role', $role))
                            ->count();
                    @endphp
                    <a href="{{ route('superadmin.products', ['tab' => $role]) }}"
                    class="flex items-center gap-2 px-4 py-1.5 rounded-md text-black font-medium
                            hover:bg-white transition {{ (request('tab') ?? 'traveler') === $role ? 'bg-white text-black' : 'bg-transparent' }}">
                        <span>{{ __('messages.roles.' . $role) }}</span>
                        @if($pendingCount > 0)
                            <span class="text-gray-400 text-sm font-bold flex items-center justify-center ml-2">
                                {{ $pendingCount }}
                            </span>
                        @endif
                    </a>
                    @if($i === 0)
                        <div class="w-0.5 bg-black h-4"></div>
                    @endif
                @endforeach
            </div>
            <div class="flex items-center gap-3 mt-6">
                <form method="GET" class="flex items-center gap-2">
                    <select name="filter" onchange="this.form.submit()"
                            class="border border-gray-300 rounded-md px-6 py-1.5 text-sm focus:outline-none">
                        <option value="">{{ __('messages.filters.all') }}</option>
                        <option value="validation" {{ request('filter') == 'validation' ? 'selected' : '' }}>{{ __('messages.filters.validation') }}</option>
                        <option value="approved" {{ request('filter') == 'approved' ? 'selected' : '' }}>{{ __('messages.filters.approved') }}</option>
                        <option value="rejected" {{ request('filter') == 'rejected' ? 'selected' : '' }}>{{ __('messages.filters.rejected') }}</option>
                    </select>
                    <input type="hidden" name="tab" value="{{ request('tab', 'Traveler') }}">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                </form>
                <a href="{{ route('superadmin.products.export', request()->query()) }}"
                   class="flex items-center gap-2 bg-[#FFEB00] hover:bg-[#FF5E1F] text-black font-semibold px-4 py-1 rounded-md shadow transition">
                    <span>{{ __('messages.actions.download') }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                    </svg>
                </a>
            </div>
        @else
            <!-- DETAIL: Kembali + Unduh -->
            <div class="flex justify-between items-center w-full mt-4">
                <div class="flex items-center gap-3 ml-6">
                    <a href="{{ route('superadmin.products', ['tab' => request('tab', 'Traveler')]) }}"
                       class="text-blue-900 hover:text-blue-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <h2 class="text-[32px] font-semibold text-blue-900">Detail Produk</h2>
                </div>
                <a href="{{ route('superadmin.products.export', array_merge(request()->query(), ['product_id' => request('product_id')])) }}"
                   class="flex items-center gap-2 bg-[#FFEB00] hover:bg-[#FF5E1F] text-black font-semibold px-4 py-1 rounded-md shadow transition">
                    <span>{{ __('messages.actions.download') }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                    </svg>
                </a>
            </div>
        @endif
    </div>
</div>