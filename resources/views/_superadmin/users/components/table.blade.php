<div class="rounded-t-lg overflow-hidden shadow-md bg-white/50">
    <table class="w-full text-sm border-collapse">
        <thead class="bg-[#577BC1]/40 text-blue-900">
            <tr>
                <th class="p-3 text-center font-semibold">ID</th>
                <th class="p-3 text-center font-semibold">Foto</th>
                <th class="p-3 text-center font-semibold">Nama</th>
                <th class="p-3 text-center font-semibold">Email</th>
                <th class="p-3 text-center font-semibold">Status</th>
                <th class="p-3 text-center font-semibold">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $index => $user)
                <tr class="border-b hover:bg-blue-100 transition">
                    <td class="p-3 text-center">{{ $user->id }}</td>
                    <td class="p-3 justify-center flex">
                        <img src="{{ $user->profile_image_url }}"
                             class="w-[50px] h-[50px] rounded-full object-cover">
                    </td>
                    <td class="p-3 text-center">{{ $user->detail->name }}</td>
                    <td class="p-3 text-center">{{ $user->email }}</td>
                    <td class="p-3 text-center">
                        @php
                            $statusColors = [
                                'Online'    => 'text-green-600',
                                'Aktif'     => 'text-blue-600',
                                'Offline'   => 'text-gray-500',
                                'Nonaktif'  => 'text-red-600',
                            ];
                        @endphp
                        <span class="{{ $statusColors[$user->display_status] ?? 'text-gray-500' }}">
                            {{ $user->display_status }}
                        </span>
                    </td>
                    <td class="p-3 flex justify-center gap-2">
                        <!-- Edit -->
                        <a href="{{ route('superadmin.users.edit', $user) }}"
                            class="p-2 rounded-md transition hover:scale-110"
                            style="background-color: #FAB00580;">
                                <x-icons.icon name="pencil" class="w-4 h-4" />
                        </a>
                        <!-- View -->
                        <a href="{{ route('superadmin.users.show', $user) }}"
                            class="p-2 rounded-md transition hover:scale-110"
                            style="background-color: #0095DA80;">
                                <x-icons.icon name="eye" class="w-4 h-4 text-white" />
                        </a>
                        <!-- Delete -->
                        <button class="p-2 rounded-md transition hover:scale-110"
                                style="background-color: #FA525280;"
                                onclick="confirmDeleteUser({{ $user->id }})">
                            <x-icons.icon name="trash" class="w-4 h-4 text-white" />
                        </button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-gray-500 py-4">Tidak ada pengguna</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-4">
    @include('_superadmin.components.pagination-simple', ['paginator' => $users])
</div>