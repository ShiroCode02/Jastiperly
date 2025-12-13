@if ($paginator->hasPages())
    <div class="flex justify-center items-center mt-4 space-x-2 text-sm font-medium">
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2 text-gray-400 cursor-not-allowed">{{ __('messages.previous') }}</span>
        @else
            <button hx-get="{{ $paginator->previousPageUrl() }}"
                    hx-target="#latest-transactions-card"
                    hx-swap="outerHTML"
                    hx-indicator="#loading-spinner"
                    class="px-4 py-2 text-blue-900 hover:text-blue-600 transition">
                {{ __('messages.previous') }}
            </button>
        @endif

        @php
            $start = max(1, $paginator->currentPage() - 2);
            $end = min($paginator->lastPage(), $paginator->currentPage() + 2);
        @endphp

        @if ($start > 1)
            <button hx-get="{{ $paginator->url(1) }}"
                    hx-target="#latest-transactions-card"
                    hx-swap="outerHTML"
                    hx-indicator="#loading-spinner"
                    class="px-3 py-2 text-blue-900 hover:bg-blue-100 rounded-md transition">1</button>
            @if ($start > 2)<span class="px-2 text-gray-500">...</span>@endif
        @endif

        @for ($i = $start; $i <= $end; $i++)
            @if ($i == $paginator->currentPage())
                <span class="px-4 py-2 bg-blue-900 text-white font-semibold rounded-md">{{ $i }}</span>
            @else
                <button hx-get="{{ $paginator->url($i) }}"
                        hx-target="#latest-transactions-card"
                        hx-swap="outerHTML"
                        hx-indicator="#loading-spinner"
                        class="px-4 py-2 text-blue-900 hover:bg-blue-100 rounded-md transition">
                    {{ $i }}
                </button>
            @endif
        @endfor

        @if ($end < $paginator->lastPage())
            @if ($end < $paginator->lastPage() - 1)<span class="px-2 text-gray-500">...</span>@endif
            <button hx-get="{{ $paginator->url($paginator->lastPage()) }}"
                    hx-target="#latest-transactions-card"
                    hx-swap="outerHTML"
                    hx-indicator="#loading-spinner"
                    class="px-3 py-2 text-blue-900 hover:bg-blue-100 rounded-md transition">
                {{ $paginator->lastPage() }}
            </button>
        @endif

        @if ($paginator->hasMorePages())
            <button hx-get="{{ $paginator->nextPageUrl() }}"
                    hx-target="#latest-transactions-card"
                    hx-swap="outerHTML"
                    hx-indicator="#loading-spinner"
                    class="px-4 py-2 text-blue-900 hover:text-blue-600 transition">
                {{ __('messages.next') }}
            </button>
        @else
            <span class="px-4 py-2 text-gray-400 cursor-not-allowed">{{ __('messages.next') }}</span>
        @endif
    </div>
@endif