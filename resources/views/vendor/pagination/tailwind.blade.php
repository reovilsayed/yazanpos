@if ($paginator->hasPages())
    <nav class="pagination_panel">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    {{-- <span aria-hidden="true">&lsaquo;</span> --}}
                    <a>
                        <svg width="5" height="9" viewBox="0 0 5 9" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 1L1 4.5L4 8" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        Previous
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                        <svg width="5" height="9" viewBox="0 0 5 9" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 1L1 4.5L4 8" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        Previous
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active" aria-current="page"><span>{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        Next
                        <svg width="5" height="9" viewBox="0 0 5 9" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 8L4 4.5L1 1" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </a>
                </li>
            @else
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <a>
                        Next
                        <svg width="5" height="9" viewBox="0 0 5 9" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 8L4 4.5L1 1" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
@endif
