@if ($paginator->hasPages())
    <nav>
        <ul class="news-pagination-list pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="Предыдущая">
                    <a class="page-link" href="#">Предыдущая</a>
                </li>
            @else
                <li class="page-item">
                    <a href="{{ $paginator->previousPageUrl() }}" class="page-link" rel="prev" aria-label="Предыдущая">Предыдущая</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        {{ $element }}
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><a href="#" class="page-link">{{ $page }}</a></li>
                        @else
                            <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item next">
                    <a href="{{ $paginator->nextPageUrl() }}" class="page-link" rel="next" aria-label="Следующая">
                        Следующая
                    </a>
                </li>
            @else
                <li class="page-item next disabled" aria-disabled="true" aria-label="Следующая">
                    <a class="page-link" href="#">Следующая</a>
                </li>
            @endif
        </ul>
    </nav>
@endif
