@php
    // current tab (profil, preferensi, keamanan)
    $tab = request('tab', 'profil');
    // user object should be passed from controller; fallback example:
    $user = $user ?? auth()->user();
@endphp

<div class="max-w-full mx-auto">
    <div class="bg-white/50 rounded-xl shadow overflow-hidden">
        <!-- TOP: header image + avatar + name -->
        <div class="relative">
            {{-- background banner (replace url with actual asset if available) --}}
            <div class="h-[250px] w-full bg-cover bg-center"
                 style="background-image: url('{{ asset('images/settings-bg.jpg') }}');">
                <div class="absolute inset-0 bg-black/25"></div>
            </div>

            <div class="absolute left-4 top-6 flex items-center gap-6">
                <div class="relative group">
                    <div class="w-[200px] h-[200px] rounded-full overflow-hidden border-4 border-white shadow">
                        <img src="{{ $user->profile_image_url }}" alt="avatar" class="w-full h-full object-cover">
                    </div>

                    <div class="absolute right-0 bottom-0 bg-yellow-400 rounded-full p-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                    </div>
                </div>

                <div class="text-[#000957]">
                    <h1 class="text-[50px] font-bold leading-tight drop-shadow">
                        {{ $user->name ?? 'Nama Pengguna' }}
                    </h1>
                    @if(isset($user->account_status))
                        <div class="mt-1 flex items-center gap-2">
                            <span class="inline-block w-4 h-4 rounded-full {{ $user->account_status === 'active' ? 'bg-green-400' : 'bg-gray-400' }}"></span>
                            <span class="italic text-[25px]">
                                {{ $user->account_status === 'active' ? 'Online' : ucfirst($user->account_status) }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="absolute right-4 bottom-3 text-right text-[#000957] text-sm">
                @if(isset($user->updated_at) || isset($user->detail->updated_at))
                    Terakhir diperbarui: {{ max($user->updated_at, $user->detail->updated_at ?? $user->updated_at)->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                @endif
            </div>
        </div>

        <!-- NAV TABS -->
        <div class="font-bold py-6 px-8">
            <nav class="flex gap-8 justify-center">
                <a href="{{ url()->current() }}?tab=profil"
                   class="text-xl {{ $tab === 'profil' ? 'text-[#000957] underline underline-offset-8' : 'text-gray-400' }}">
                    Profil
                </a>
                <a href="{{ url()->current() }}?tab=preferensi"
                   class="text-xl font-medium {{ $tab === 'preferensi' ? 'text-[#000957] underline underline-offset-8' : 'text-gray-400' }}">
                    Preferensi
                </a>
                <a href="{{ url()->current() }}?tab=keamanan"
                   class="text-xl font-medium {{ $tab === 'keamanan' ? 'text-[#000957] underline underline-offset-8' : 'text-gray-400' }}">
                    Keamanan
                </a>
            </nav>
        </div>

        <!-- CONTENT -->
        <div class="px-8">
            @if($tab === 'profil')
                @include('_superadmin.settings.tabs.profile', ['user' => $user])
            @elseif($tab === 'preferensi')
                @include('_superadmin.settings.tabs.preference', ['user' => $user])
            @elseif($tab === 'keamanan')
                @include('_superadmin.settings.tabs.security', ['user' => $user])
            @else
                {{-- fallback to profile --}}
                @include('_superadmin.settings.tabs.profile', ['user' => $user])
            @endif
        </div>
    </div>
</div>
