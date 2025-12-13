<x-app-layout>
    <div class="flex min-h-screen">
        @include('layouts.sidebar-superadmin')
        <div id="main-content" class="flex-1 ml-97 transition-all duration-300 flex flex-col min-h-screen initial-hidden">
            @include('_superadmin.users.components.header')

            <div class="flex-1 px-6 pb-6 pt-48">
                <div class="bg-white/70 rounded-xl shadow-lg border border-gray-200 max-w-6xl mx-auto overflow-hidden">
                    <div class="p-8 bg-white/70 rounded-xl shadow-md border border-gray-200">
                        <form action="{{ route('superadmin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- FOTO + DETAIL -->
                            <div class="flex flex-col md:flex-row gap-10">
                                <!-- FOTO -->
                                <div class="w-[200px]">
                                    <img src="{{ $user->profile_image_url }}"
                                        alt="Foto Profil {{ $user->name }}"
                                        class="w-[200px] h-[300px] object-cover rounded-3xl border border-gray-300 shadow">
                                    <h2 class="text-[25px] font-bold text-center mt-4 text-gray-900 leading-tight">
                                        {{ $user->detail->name ?? '-' }}
                                    </h2>
                                    <div class="mt-3 flex justify-center">
                                        <button type="submit"
                                            class="w-[225px] h-[35px] rounded-md text-black font-semibold bg-[#FFEB00] hover:bg-[#FF5E1F] hover:text-white transition">
                                            {{ __('messages.save') }}
                                        </button>
                                    </div>
                                    <div class="mt-2 flex justify-center">
                                        <a href="{{ route('superadmin.users.show', $user) }}"
                                            class="w-[225px] h-[35px] rounded-md text-center leading-[35px] text-black bg-gray-200 font-semibold hover:bg-gray-300 transition">
                                            {{ __('messages.cancel') }}
                                        </a>
                                    </div>
                                </div>

                                <!-- FORM EDIT -->
                                <div class="flex-1">
                                    <div class="bg-gray-50 border border-[#C0C0C0] rounded-lg p-5">
                                        <h3 class="text-lg font-medium text-[#000957] border-b-[2px] border-[#344CB7] mb-6">
                                            {{ __('messages.edit_user_data') }}
                                        </h3>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <!-- Data Utama -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.full_name') }}</label>
                                                <input type="text" name="detail[name]" value="{{ old('detail.name', $user->detail->name) }}" required
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#344CB7]">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.email') }}</label>
                                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#344CB7]">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.account_status') }}</label>
                                                <select name="role" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#344CB7]">
                                                    @foreach(['traveler','customer','admin','finance','superadmin'] as $role)
                                                        <option value="{{ $role }}" {{ $user->role === $role ? 'selected' : '' }}>
                                                           {{ __('messages.roles.' . $role) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.activity_status') }}</label>
                                                <select name="account_status" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#344CB7]">
                                                    <option value="active" {{ $user->account_status === 'active' ? 'selected' : '' }}>{{ __('messages.users_status.active') }}</option>
                                                    <option value="inactive" {{ $user->account_status === 'inactive' ? 'selected' : '' }}>{{ __('messages.users_status.inactive') }}</option>
                                                </select>
                                            </div>

                                            <!-- Detail User -->
                                            <div class="md:col-span-2 mt-6 pt-6 border-t border-gray-300">
                                                <h4 class="text-base font-semibold text-[#000957] mb-4">{{ __('messages.user_details') }}</h4>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.username') }}</label>
                                                <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}"
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.phone') }}</label>
                                                <input type="text" name="detail[phone]" value="{{ old('detail.phone', $user->detail->phone ?? '') }}"
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                            </div>
                                            <div class="md:col-span-2">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.full_address') }}</label>
                                                <textarea name="detail[address]" rows="3"
                                                          class="w-full px-3 py-2 border border-gray-300 rounded-md">{{ old('detail.address', $user->detail->address ?? '') }}</textarea>
                                                <p class="text-xs text-gray-500 mt-1">{{ __('messages.example') }}: Jl. Sudirman No. 123, Jakarta Selatan</p>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.date_birth') }}</label>
                                                <input type="date" name="detail[date_birth]" value="{{ old('detail.date_birth', $user->detail->date_birth) }}"
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.gender') }}</label>
                                                <select name="detail[gender]" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                                    <option value="">-</option>
                                                    <option value="male" {{ ($user->detail->gender ?? '') === 'male' ? 'selected' : '' }}>{{ __('messages.male') }}</option>
                                                    <option value="female" {{ ($user->detail->gender ?? '') === 'female' ? 'selected' : '' }}>{{ __('messages.female') }}</option>
                                                </select>
                                            </div>

                                            @if(in_array($user->role, ['traveler', 'customer']))
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.bank_account') }}</label>
                                                    <input type="text" name="detail[bank_name]" value="{{ old('detail.bank_name', $user->detail->bank_name ?? '') }}"
                                                           class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.bank_account_number') }}</label>
                                                    <input type="text" name="detail[bank_number]" value="{{ old('detail.bank_number', $user->detail->bank_number ?? '') }}"
                                                           class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('main-content').classList.remove('initial-hidden');
            document.getElementById('navbar-header')?.classList.remove('initial-hidden');
        });
    </script>
</x-app-layout>