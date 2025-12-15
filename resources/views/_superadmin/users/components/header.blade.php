<div id="navbar-header" class="fixed top-0 left-97 right-0 z-20 transition-all duration-300 initial-hidden"
     style="background-color: #DBEDFF; padding: 1rem 1.5rem;">
    @include('layouts.navigation-superadmin', ['title' => __('messages.user_management')])

    <div class="mt-2 flex justify-between items-center">
        @if(!request()->route('user'))
            <!-- HANYA DI DAFTAR: TAB + UNDUH -->
            <div class="flex gap-3 mt-3">
                @foreach (['traveler', 'customer', 'admin', 'finance'] as $role)
                    <a href="{{ route('superadmin.users', ['tab' => $role]) }}"
                    class="px-6 py-0.5 border border-blue-400 rounded-md text-blue-800 font-medium
                            hover:bg-blue-200 transition {{ request('tab') === $role ? 'bg-[#577BC1] text-white' : 'bg-transparent' }}">
                        {{ __('messages.roles.' . $role) }}
                    </a>
                @endforeach
            </div>

            <!-- UNDUH DI DAFTAR -->
            <a href="{{ route('superadmin.users.export', request()->query()) }}"
               class="flex items-center gap-2 mt-6 bg-[#FFEB00] hover:bg-[#FF5E1F] text-black font-semibold px-4 py-1 rounded shadow transition">
                <span>{{ __('messages.actions.download') }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                </svg>
            </a>
        @else
            <!-- DI DETAIL & EDIT: KEMBALI + UNDUH -->
            <div class="flex justify-between items-center w-full mt-4">
                <div class="flex items-center gap-3 ml-6">
                    <a href="{{ route('superadmin.users') }}"
                    class="text-blue-900 hover:text-blue-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <h2 class="text-[32px] font-semibold text-blue-900">
                        {{ request()->routeIs('*.edit') 
                            ? __('messages.actions.edit') . ' ' 
                            : __('messages.actions.details') . ' ' 
                        }}{{ $user->role === 'traveler' ? __('messages.roles.traveler') : ($user->role === 'customer' ? __('messages.roles.customer') : ucfirst($user->role)) }}
                    </h2>
                </div>

                <!-- UNDUH HANYA MUNCUL DI DETAIL -->
                @if(!request()->routeIs('*.edit'))
                    <a href="{{ route('superadmin.users.export', ['user' => $user->id]) }}"
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