@extends('frontend.layouts.master')

@section('content')
    <div class="ws-container">
        <div class="ws-g ws-c breadcrumbs">
            <div class="ws-u-1"><span class="breadcrumb-title">Sie befinden sich hier: </span><span class="breadcrumb-item"><a
                        href="/" class="breadcrumb-link"><span>Startseite</span></a></span><i
                    class="fa fa-angle-right breadcrumb-icon"></i><span class="breadcrumb-item"><a href="/shop/index"
                        class="breadcrumb-link"><span>Shop</span></a></span><i
                    class="fa fa-angle-right breadcrumb-icon"></i><span class="breadcrumb-item"><a href="/zigarren"
                        class="breadcrumb-link"><span>Zigarren</span></a></span><i
                    class="fa fa-angle-right breadcrumb-icon"></i><span class="breadcrumb-item"><a
                        href="/zigarren/brasilien" class="breadcrumb-link"><span>Brasilien</span></a></span></div>
        </div>

        <div class="ws-g ws-cx mb-2 mb-lg-4 mt-2 mt-lg-0 contentpage contentpage--teaser">
            <div class="ws-u-1">
                <h1 class="h2 mb-2">Brasilien</h1>
            </div>
        </div>

        <div class="search-filter mb-2 mb-lg-3">
            <div class="ws-g ws-cx">
                <div class="ws-u-1">
                    <form class="ws-g ws-form" action="/zigarren" method="get" data-cssloader="true">
                        <a class="ws-u-1 showfilter" href="#filter-dropnav">
                            <span class="show">
                                <i class="fa fa-sliders"></i>   Filter
                                <i class="fa fa-caret-down"></i>
                            </span>
                            <span class="hide">
                                <i class="fa fa-sliders"></i>   Filter ausblenden
                                <i class="fa fa-caret-up"></i>
                            </span>
                        </a>
                        <span class="filter-nav left hidden d-none"><i class="fa fa-angle-left"></i></span>
                        <span class="filter-nav right d-none"><i class="fa fa-angle-right"></i></span>
                        <a class="filter-nav h-100" href="#search-filter-detail" style="right: 0"><span><i
                                    class="fa fa-angle-right"></i></span></a>
                        <ul class="ws-u-1 filter-dropnav" id="#filter-dropnav">
                            <!-- -->
                            <li class="filter-item search-filter-detail-toggle">
                                <a href="#search-filter-detail"><span><i class="fa fa-fw fa-filter"></i></span></a>
                            </li>
                            <!-- -->
                            <li class="filter-item">
                                <a href="#filter-wgr"><span>Warengruppe<i
                                            class="fa fa-angle-down caret-indicator"></i></span></a>
                                <div class="filter-dropdown ws-g wgr" id="filter-wgr">
                                    <div class="ws-u-1">
                                        <ul class="ws-g inner">
                                            <li class="ws-u-1 nobr">
                                                <a class="filter-item-wrapper" href="/zigarren/brasilien"
                                                    data-cssloader="true">
                                                    Brasilien
                                                </a>
                                            </li>
                                            <li class="ws-u-1 nobr">
                                                <a class="filter-item-wrapper" href="/zigarren/costa-rica"
                                                    data-cssloader="true">
                                                    Costa Rica
                                                </a>
                                            </li>
                                            <li class="ws-u-1 nobr">
                                                <a class="filter-item-wrapper" href="/zigarren/cuba" data-cssloader="true">
                                                    Kuba
                                                </a>
                                            </li>
                                            <li class="ws-u-1 nobr">
                                                <a class="filter-item-wrapper" href="/zigarren/deutschland"
                                                    data-cssloader="true">
                                                    Deutschland
                                                </a>
                                            </li>
                                            <li class="ws-u-1 nobr">
                                                <a class="filter-item-wrapper" href="/zigarren/dominikanische-republik"
                                                    data-cssloader="true">
                                                    Dominikanische Republik
                                                </a>
                                            </li>
                                            <li class="ws-u-1 nobr">
                                                <a class="filter-item-wrapper" href="/Zigarren/E-Zigaretten"
                                                    data-cssloader="true">
                                                    E-Zigaretten
                                                </a>
                                            </li>
                                            <li class="ws-u-1 nobr">
                                                <a class="filter-item-wrapper" href="/zigarren/ecuador"
                                                    data-cssloader="true">
                                                    Ecuador
                                                </a>
                                            </li>
                                            <li class="ws-u-1 nobr">
                                                <a class="filter-item-wrapper" href="/zigarren/honduras"
                                                    data-cssloader="true">
                                                    Honduras
                                                </a>
                                            </li>
                                            <li class="ws-u-1 nobr">
                                                <a class="filter-item-wrapper" href="/zigarren/indonesien"
                                                    data-cssloader="true">
                                                    Indonesien
                                                </a>
                                            </li>
                                            <li class="ws-u-1 nobr">
                                                <a class="filter-item-wrapper" href="/Zigarren/Italien"
                                                    data-cssloader="true">
                                                    Italien
                                                </a>
                                            </li>
                                            <li class="ws-u-1 nobr">
                                                <a class="filter-item-wrapper" href="/Zigarren/Jamaika"
                                                    data-cssloader="true">
                                                    Jamaika
                                                </a>
                                            </li>
                                            <li class="ws-u-1 nobr">
                                                <a class="filter-item-wrapper" href="/zigarren/kanaren"
                                                    data-cssloader="true">
                                                    Kanarische Inseln
                                                </a>
                                            </li>
                                            <li class="ws-u-1 nobr">
                                                <a class="filter-item-wrapper" href="/Zigarren/Kolumbien"
                                                    data-cssloader="true">
                                                    Kolumbien
                                                </a>
                                            </li>
                                            <li class="ws-u-1 nobr">
                                                <a class="filter-item-wrapper" href="/zigarren/mexiko"
                                                    data-cssloader="true">
                                                    Mexiko
                                                </a>
                                            </li>
                                            <li class="ws-u-1 nobr">
                                                <a class="filter-item-wrapper" href="/Zigarren/Mosambik"
                                                    data-cssloader="true">
                                                    Mosambik
                                                </a>
                                            </li>
                                            <li class="ws-u-1 nobr">
                                                <a class="filter-item-wrapper" href="/zigarren/nicaragua"
                                                    data-cssloader="true">
                                                    Nicaragua
                                                </a>
                                            </li>
                                            <li class="ws-u-1 nobr">
                                                <a class="filter-item-wrapper" href="/zigarren/panama"
                                                    data-cssloader="true">
                                                    Panama
                                                </a>
                                            </li>
                                            <li class="ws-u-1 nobr">
                                                <a class="filter-item-wrapper" href="/Zigarren/Peru"
                                                    data-cssloader="true">
                                                    Peru
                                                </a>
                                            </li>
                                            <li class="ws-u-1 nobr">
                                                <a class="filter-item-wrapper" href="/zigarren/philippinen"
                                                    data-cssloader="true">
                                                    Philippinen
                                                </a>
                                            </li>
                                            <li class="ws-u-1 nobr">
                                                <a class="filter-item-wrapper" href="/zigarren/sampler"
                                                    data-cssloader="true">
                                                    Sampler
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <!-- -->

                            <!-- -->
                        </ul>
                        <input type="hidden" name="mySMKategorie" value="2" />
                    </form>
                </div>
            </div>
        </div>

        <div class="ws-g ws-cx mb-2 search-row-info">
            <form action="/zigarren" method="GET" class="ws-form">
                <div class="ws-u-1 ws-u-lg-12-24 mb-2 mb-lg-0">
                    {{ $products->total() }} Artikel gefunden
                </div>
                <div class="ws-u-1 ws-u-lg-12-24 text-lg-end">
                    <div class="d-block d-lg-inline-block text-end text-lg-start">
                        <div class="d-inline-block ml-lg-3 ms-lg-3">
                            <label for="shoporder_select" class="d-block d-lg-inline-block text-start mt-0">Sortieren
                                nach:</label>
                            <select id="shoporder_select" name="shoporder" class="d-inline-block">
                                <option value="Relevanz" selected="">Relevanz</option>
                                <option value="Artikelname">Artikelname</option>
                                <option value="Preis absteigend">Preis absteigend</option>
                                <option value="Preis aufsteigend">Preis aufsteigend</option>
                                <option value="Neuste zuerst">Neueste zuerst</option>
                            </select>
                        </div>
                        <div class="d-inline-block ml-lg-3 ms-lg-3">
                            <label for="pagination_select"
                                class="d-block d-lg-inline-block text-start mt-0">Seite:</label>
                            <select id="pagination_select" class="d-inline-block search-pagination" name="von">
                                <option value="0" selected="">1</option>
                                <option value="30">2</option>
                                <option value="60">3</option>
                                <option value="90">4</option>
                                <option value="120">5</option>
                                <option value="150">6</option>
                                <option value="180">7</option>
                                <option value="210">8</option>
                                <option value="240">9</option>
                            </select>
                            <span>von 44</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="ws-g search-result">

            @foreach ($products as $item)
                {{-- @dd($item) --}}
                <div class="ws-u-1-2 ws-u-md-1-3 ws-u-xl-1-5 search-result-item"> <a class="search-result-item-inner"
                        href="{{ route('products', [$category->slug, $item->brand->slug, $item->slug . '-' . $item->id]) }}"
                        title="{{ $item->name ?? $item->brand->name }}">
                        <div class="product-badge-wrapper"> </div>
                        <div class="ws-g search-result-item-content">
                            <div class="ws-u-1 image"> <img src="{{ showImage($item->image) }}"
                                    alt="{{ $item->name ?? $item->brand->name }} "
                                    data-src="{{ showImage($item->image) }}" class="unveiled"> </div>
                            <div class="ws-u-1 bottom">
                                <div class="ws-g bottom-content">
                                    <div class="ws-u-1 mb-2 mb-lg-0 bottom-row bottom-row--1">
                                        <div class="brand">{{ $item->brand->name }}</div>
                                        <div class="name">{{ $item->name }}</div>
                                        <div class="remark"></div>
                                    </div>
                                    <div class="ws-u-1 bottom-row bottom-row--2">
                                        <div class="ws-g">
                                            <div class="ws-u-1 ws-u-lg-2-5 itembadges">

                                                @if ($item->variations_count > 0)
                                                    <span class="d-none d-lg-block"
                                                        title="{{ $item->variations_count }} Varianten">
                                                        <span class="countvalue">{{ $item->variations_count }}</span> <i
                                                            class="fa fa-list itembadge count"></i></span> <span
                                                        class="d-block d-lg-none"> {{ $item->variations_count }} Varianten
                                                    </span>
                                                @endif

                                            </div>
                                            <div class="ws-u-1 ws-u-lg-3-5 price">
                                                <div class="price-wrapper"><span class="price-remark"></span> <span
                                                        class="price-value"><span
                                                            data-eurval="{{ isDiscounted($item) ? $item->discount_value : $item->price }}"
                                                            data-curiso="USD">{{ isDiscounted($item) ? $item->discount_value : $item->price }}
                                                            $</span></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        {!! $products->links('vendor.pagination.default') !!}

        {{-- <div class="ws-g ws-cx search-pagination-bottom mt-3">
            <form action="/zigarren/brasilien" method="get" class="ws-u-1 ws-form pagination-select"
                data-cssloader="true"><span class="ws-button ws-button-disabled"><i
                        class="fa fa-chevron-left"></i></span> <select class="search-pagination" name="von">
                    <option value="0" selected="">1</option>
                </select> <span>von 1</span> <span class="ws-button ws-button-disabled"><i
                        class="fa fa-chevron-right"></i></span> <noscript><button type="submit"
                        class="ws-button">OK</button></noscript></form>
        </div> --}}
    </div>
@endsection
