<style>
    .pagination .page-link {
        border: 0;
        color: white;
        background-color: transparent;
        border-radius: 0;
        font-size: 16px;
        font-weight: 700;
        padding: 15px;
        opacity: .4;
        margin: 10px;
        transition: all 0.3s;
    }

    .pagination .page-item:first-child .page-link 
    {
        background: transparent;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
    .pagination .page-item:first-child .page-link 
    {
        background: transparent;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
 
    .pagination .page-item:last-child .page-link {
        background: transparent;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .pagination .page-link:focus {
        box-shadow: none;
        outline: none;
    }

    .pagination .page-item.active .page-link {
        background-color: transparent;
        position: relative;
        color: white; 
    }

    .pagination .page-item.active .page-link::after {
        content: ''; 
        position: absolute;
        bottom: 10px;
        left: 0;
        width: 100%; 
        height: 1px; 
        background-color: white; 
        display: block; 
    }
</style>

@if ($paginator->hasPages())
    <div>
        <ul class="pagination pagination-sm">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true"><i class="ti ti-chevron-left"></i></span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                        aria-label="@lang('pagination.previous')"><i class="ti ti-chevron-left"></i></a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array of links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"
                        aria-label="@lang('pagination.next')"><i class="ti ti-chevron-right"></i></a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true"><i class="ti ti-chevron-right"></i></span>
                </li>
            @endif
        </ul>
    </div>
@endif
