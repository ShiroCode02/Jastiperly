<div id="history-table">
    <div class="overflow-x-auto">
        <table class="w-full text-sm border-collapse">
            <thead>
                <tr class="border-b border-black">
                    <th class="py-3 pl-4 text-left font-semibold text-[#344CB7] w-[20%]">Hari, Tanggal</th>
                    <th class="py-3 pl-4 text-left font-semibold text-[#344CB7] w-[20%]">Field</th>
                    <th class="py-3 pl-4 text-left font-semibold text-[#344CB7] w-[60%]">Perubahan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($user->detailHistories as $log)
                    <tr class="border-b border-gray-300">
                        <td class="py-3 pl-4 text-gray-600 font-medium">{{ $log->tanggal }}</td>
                        <td class="py-3 pl-4 text-gray-600 font-medium">{{ $log->field }}</td>
                        <td class="py-3 pl-4 text-gray-600 font-medium">
                            {{ $log->old_value }} → {{ $log->new_value }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-8 text-gray-500 italic">
                            Belum ada perubahan data.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION HTMX -->
    <div class="mt-6">
        @include('_superadmin.components.pagination', ['paginator' => $user->detailHistories])
    </div>
</div>