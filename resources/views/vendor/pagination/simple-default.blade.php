@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true"><span class="page-link" style="font-size:13px;padding:6px 10px;min-width:36px;height:36px;display:inline-flex;align-items:center;justify-content:center;">@lang('pagination.previous')</span></li>
            @else
                <li><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" style="font-size:13px;padding:6px 10px;min-width:36px;height:36px;display:inline-flex;align-items:center;justify-content:center;">@lang('pagination.previous')</a></li>
            @endif

            @if ($paginator->hasMorePages())
                <li><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" style="font-size:13px;padding:6px 10px;min-width:36px;height:36px;display:inline-flex;align-items:center;justify-content:center;">@lang('pagination.next')</a></li>
            @else
                <li class="disabled" aria-disabled="true"><span class="page-link" style="font-size:13px;padding:6px 10px;min-width:36px;height:36px;display:inline-flex;align-items:center;justify-content:center;">@lang('pagination.next')</span></li>
            @endif
        </ul>
    </nav>
@endif
