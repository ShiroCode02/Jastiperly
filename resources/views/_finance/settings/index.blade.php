<x-app-layout>
    <div class="flex">
        @include('layouts.sidebar-finance')

        {{-- Wrapper Kanan --}}
        <div class="flex-1 ml-[312px] flex flex-col bg-[#DBEDFF] min-h-screen">

            {{-- Header Fixed --}}
            <div class="fixed top-0 left-[312px] right-0 z-20 bg-[#DBEDFF] px-6 pt-4 pb-4 shadow">
                @include('layouts.navigation-finance', ['title' => $title])
            </div>

            {{-- CONTENT --}}
            <div class="flex-1 px-6 pt-32 pb-10">

                {{-- Banner Biru --}}
                <div class="w-full h-[200px] rounded-xl bg-gradient-to-r from-[#1A3FA6] to-[#5578D9] relative overflow-hidden">
                </div>

                {{-- Foto Profil --}}
                <div class="relative w-full flex justify-start pl-5">
                    <img src="https://i.pravatar.cc/200"
                        class="w-40 h-40 rounded-full border-4 border-white shadow-lg -mt-20 object-cover" />
                </div>

                {{-- Tabs Profil / Password --}}
                <div class="mt-6 flex justify-center gap-10 border-b border-gray-300 pb-2">
                    <button class="text-blue-900 font-semibold border-b-4 border-blue-900 pb-1">
                        Profil
                    </button>

                    <button class="text-gray-400 font-semibold">
                        Password
                    </button>
                </div>

                {{-- Judul Profil --}}
                <h2 class="text-3xl font-bold text-blue-900 mt-6 mb-8">Profil</h2>

                {{-- FORM PROFIL --}}
                <div class="flex flex-col gap-y-6 text-blue-900 max-w-[900px]">

                    {{-- Username --}}
                    <div class="flex items-center gap-8">
                        <label class="font-semibold w-[140px]">Username</label>
                        <input type="text"
                            class="flex-1 max-w-[520px] rounded-lg border border-gray-400 px-4 py-2" />
                    </div>

                    {{-- Nama Lengkap --}}
                    <div class="flex items-center gap-8">
                        <label class="font-semibold w-[140px]">Nama Lengkap</label>
                        <input type="text"
                            class="flex-1 max-w-[520px] rounded-lg border border-gray-400 px-4 py-2" />
                    </div>

                    {{-- Email & Jenis Kelamin --}}
                    <div class="flex items-center justify-between">
                       
                        {{-- Email (kiri) --}}
                        <div class="flex items-center gap-8">
                            <label class="font-semibold w-[140px]">Email</label>
                            <input type="text"
                                class="w-[260px] rounded-lg border border-gray-400 px-4 py-2" />
                        </div>

                        {{-- Jenis Kelamin (kanan) --}}
                        <div class="flex items-center gap-9">
                            <label class="font-semibold w-[120px] text-right">Jenis Kelamin</label>
                            <input type="text"
                                class="w-[180px] rounded-lg border border-gray-400 px-4 py-2" />
                        </div>
                    </div>

                    {{-- Telepon & Bahasa --}}
                    <div class="flex items-center justify-between">
                        {{-- Telepon (kiri) --}}
                        <div class="flex items-center gap-8">
                            <label class="font-semibold w-[140px]">Telepon</label>
                            <input type="text"
                                class="w-[260px] rounded-lg border border-gray-400 px-4 py-2" />
                        </div>

                        {{-- Bahasa (kanan) --}}
                        <div class="flex items-center gap-9">
                            <label class="font-semibold w-[120px] text-right">Bahasa</label>
                            <input type="text"
                                class="w-[180px] rounded-lg border border-gray-400 px-4 py-2" />
                        </div>
                    </div>


                    {{-- Tanggal Lahir --}}
                    <div class="flex items-center gap-8">
                        <label class="font-semibold w-[140px]">Tanggal Lahir</label>
                        <input type="date"
                            class="flex-1 max-w-[680px] rounded-lg border border-gray-400 px-4 py-2" />
                    </div>

                    {{-- Alamat --}}
                    <div class="flex items-center gap-8">
                        <label class="font-semibold w-[140px]">Alamat</label>
                        <input type="text"
                            class="flex-1 max-w-[680px] rounded-lg border border-gray-400 px-4 py-2" />
                    </div>
                </div>

                {{-- Tombol Edit --}}
                <div class="flex justify-end mt-12 max-w-[900px]">
                    <button
                        class="bg-[#FF6A2A] text-white font-semibold px-10 py-3 rounded-lg text-lg shadow hover:brightness-110 transition">
                        Edit
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
