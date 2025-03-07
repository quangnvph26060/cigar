<div class="ws-g ws-c breadcrumbs">
    <div class="ws-u-1">
        <span class="breadcrumb-title">Sie befinden sich hier: </span>

        <span class="breadcrumb-item">
            <a href="/" class="breadcrumb-link"><span>Startseite</span></a>
        </span>
        <i class="fa fa-angle-right breadcrumb-icon"></i>
        @foreach ($data as $label => $url)
            <span class="breadcrumb-item">
                @if ($url)
                    <a href="{{ $url }}" class="breadcrumb-link">
                        <span>{{ $label }}</span>
                    </a>
                @else
                    <span>{{ $label }}</span>
                @endif
            </span>

            @if (!$loop->last)
                <i class="fa fa-angle-right breadcrumb-icon"></i>
            @endif
        @endforeach
    </div>
</div>
