<div class="ws-g ws-cx search-pagination-bottom mt-3">
    <form action="{{ url()->current() }}" method="get" class="ws-u-1 ws-form pagination-select" data-cssloader="true"
        onchange="submitFormWithDelay()">
        <!-- Previous Button -->
        @if ($paginator->onFirstPage())
            <span class="ws-button ws-button-disabled"><i class="fa fa-chevron-left"></i></span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="ws-button"><i class="fa fa-chevron-left"></i></a>
        @endif

        <!-- Pagination Select -->
        <select class="search-pagination" name="page" onchange="submitFormWithDelay()">
            @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                <option value="{{ $page }}" @if ($page == $paginator->currentPage()) selected @endif>
                    {{ $page }}</option>
            @endforeach
        </select>

        <span>von {{ $paginator->total() }}</span>

        <!-- Next Button -->
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="ws-button"><i class="fa fa-chevron-right"></i></a>
        @else
            <span class="ws-button ws-button-disabled"><i class="fa fa-chevron-right"></i></span>
        @endif

        <noscript><button type="submit" class="ws-button">OK</button></noscript>
    </form>
</div>
