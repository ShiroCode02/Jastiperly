<!-- Footer Tabel -->
<div class="flex justify-between items-center bg-white/50 p-3 shadow-md">
    <span class="text-gray-700 font-semibold">{{ __('messages.total') }} {{ $paginator->total() }}</span>
    <div class="flex gap-2 items-center">
        <button
            onclick="window.location.href='{{ $paginator->appends(request()->query())->previousPageUrl() }}'"
            class="px-2 py-1 rounded-lg hover:bg-gray-300 {{ $paginator->onFirstPage() ? 'hover:opacity-50 cursor-not-allowed' : '' }}"
            {{ $paginator->onFirstPage() ? 'disabled' : '' }}>
            &lt;
        </button>

        @php
            $current = $paginator->currentPage();
            $last = $paginator->lastPage();
            $start = max(1, $current - 1);
            $end = min($last, $current + 1);
            if ($current == 1) $end = min($last, 2);
            if ($current == $last) $start = max(1, $last - 1);
        @endphp

        @for($i = $start; $i <= $end; $i++)
            <span
                onclick="window.location.href='{{ $paginator->appends(request()->query())->url($i) }}'"
                class="inline-block text-black font-semibold hover:bg-[#577BC1]/50 hover:text-white rounded-full px-2 transition cursor-pointer {{ $i == $current ? 'bg-[#577BC1]/70 text-white' : '' }}">
                {{ $i }}
            </span>
        @endfor

        <button
            onclick="window.location.href='{{ $paginator->appends(request()->query())->nextPageUrl() }}'"
            class="px-2 py-1 rounded-lg hover:bg-gray-300 {{ !$paginator->hasMorePages() ? 'hover:opacity-50 cursor-not-allowed' : '' }}"
            {{ !$paginator->hasMorePages() ? 'disabled' : '' }}>
            &gt;
        </button>
    </div>
</div>