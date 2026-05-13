@if ($paginator->hasPages())
<nav>
    
    <ul class="pagination pagination-sm mb-0">

        {{-- Previous --}}
        <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}">
                &laquo;
            </a>
        </li>

        @php
            $current = $paginator->currentPage();
            $last = $paginator->lastPage();
            $start = max(1, $current - 2);
            $end = min($last, $current + 2);
        @endphp

        {{-- First page --}}
        @if ($start > 1)
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
            </li>
            @if ($start > 2)
                <li class="page-item disabled">
                    <span class="page-link">…</span>
                </li>
            @endif
        @endif

        {{-- Page range --}}
        @for ($page = $start; $page <= $end; $page++)
            <li class="page-item {{ $page == $current ? 'active' : '' }}">
                <a class="page-link" href="{{ $paginator->url($page) }}">
                    {{ $page }}
                </a>
            </li>
        @endfor

        {{-- Last page --}}
        @if ($end < $last)
            @if ($end < $last - 1)
                <li class="page-item">
                    <span class="page-link">…</span>
                </li>
            @endif
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url($last) }}">
                    {{ $last }}
                </a>
            </li>
        @endif

        {{-- Next --}}
        <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
            <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                &raquo;
            </a>
        </li>

    </ul>
</nav>
@endif
