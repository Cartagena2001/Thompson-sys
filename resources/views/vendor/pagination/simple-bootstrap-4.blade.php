@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled px-2" aria-disabled="true">
                    <span class="page-link">Anterior</span>
                </li>
            @else
                <li class="page-item px-2">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">Anterior</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item px-2">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Siguiente</a>
                </li>
            @else
                <li class="page-item disabled px-2" aria-disabled="true">
                    <span class="page-link">Siguiente</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
