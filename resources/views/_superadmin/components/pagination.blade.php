@if ($paginator->hasPages())
    <div class="flex justify-center items-center mt-6 space-x-2 text-sm font-medium">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2 text-gray-400 cursor-not-allowed">Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}&{{ http_build_query(request()->except('page')) }}"
               class="px-4 py-2 text-blue-900 hover:text-blue-600 transition">
                Previous
            </a>
        @endif

        {{-- Page Numbers --}}
        @php
            $start = max(1, $paginator->currentPage() - 2);
            $end = min($paginator->lastPage(), $paginator->currentPage() + 2);
        @endphp

        @if ($start > 1)
            <a href="{{ $paginator->url(1) }}&{{ http_build_query(request()->except('page')) }}"
               class="px-3 py-2 text-blue-900 hover:bg-blue-100 rounded-md transition">1</a>
            @if ($start > 2)
                <span class="px-2 text-gray-500">...</span>
            @endif
        @endif

        @for ($i = $start; $i <= $end; $i++)
            @if ($i == $paginator->currentPage())
                <span class="px-4 py-2 bg-blue-900 text-white font-semibold rounded-md">
                    {{ $i }}
                </span>
            @else
                <a href="{{ $paginator->url($i) }}&{{ http_build_query(request()->except('page')) }}"
                   class="px-4 py-2 text-blue-900 hover:bg-blue-100 rounded-md transition">
                    {{ $i }}
                </a>
            @endif
        @endfor

        @if ($end < $paginator->lastPage())
            @if ($end < $paginator->lastPage() - 1)
                <span class="px-2 text-gray-500">...</span>
            @endif
            <a href="{{ $paginator->url($paginator->lastPage()) }}&{{ http_build_query(request()->except('page')) }}"
               class="px-3 py-2 text-blue-900 hover:bg-blue-100 rounded-md transition">
                {{ $paginator->lastPage() }}
            </a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}&{{ http_build_query(request()->except('page')) }}"
               class="px-4 py-2 text-blue-900 hover:text-blue-600 transition">
                Next
            </a>
        @else
            <span class="px-4 py-2 text-gray-400 cursor-not-allowed">Next</span>
        @endif
    </div>
@endif