@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true" style="font-size:13px;padding:6px 10px;min-width:36px;height:36px;display:inline-flex;align-items:center;justify-content:center;">&lsaquo;</span>
                </li>
            @else
                <li>
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')" style="font-size:13px;padding:6px 10px;min-width:36px;height:36px;display:inline-flex;align-items:center;justify-content:center;">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span class="page-link" style="font-size:13px;padding:6px 10px;min-width:36px;height:36px;display:inline-flex;align-items:center;justify-content:center;">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active" aria-current="page"><span class="page-link" style="font-size:13px;padding:6px 10px;min-width:36px;height:36px;display:inline-flex;align-items:center;justify-content:center;">{{ $page }}</span></li>
                        @else
                            <li><a class="page-link" href="{{ $url }}" style="font-size:13px;padding:6px 10px;min-width:36px;height:36px;display:inline-flex;align-items:center;justify-content:center;">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')" style="font-size:13px;padding:6px 10px;min-width:36px;height:36px;display:inline-flex;align-items:center;justify-content:center;">&rsaquo;</a>
                </li>
            @else
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true" style="font-size:13px;padding:6px 10px;min-width:36px;height:36px;display:inline-flex;align-items:center;justify-content:center;">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
