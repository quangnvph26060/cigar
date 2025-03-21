@extends('frontend.layouts.master')

@section('content')
    {{-- paramOne, paramTwo, attribute_name --}}
    <div class="ws-container">

        @php
            $data = [];

            if ($paramOne) {
                $data[$category->name ?? $brand->name] = $category ? route('products', $category->slug) : null;
            }

            if ($paramOne && $paramTwo) {
                $data[$attribute->value] = null;
            }

        @endphp

        @include('frontend.pages.include.breadcrumb', [
            'data' => $data,
        ])

        @isset($category)
            <div class="ws-g ws-cx mb-2 mb-lg-4 mt-2 mt-lg-0 contentpage contentpage--teaser">
                <div class="ws-u-1">
                    <h1 class="h2 mb-2">{{ $category->name }}</h1>
                </div>
            </div>
        @else
            <div class="ws-g ws-cx wgrbanner mb-2 mb-lg-4 mt-2 mt-lg-0">
                <div class="ws-u-1 wgrbanner__inner">

                    <h1 class="h2 mb-2">{{ $brand->title }}</h1>

                    <p class="mb-0 contentpage contentpage--teaser">
                        {!! $brand->excerpt !!}
                    </p>
                    <style>
                        .wgrbanner__inner img {
                            display: block !important;
                        }

                        .wgrbanner__inner p {
                            line-height: 26px;
                        }

                        @media only screen and (max-width: 768px) {
                            .wgrbanner__inner p {
                                font-size: 14px;
                                line-height: 1.4em;
                                text-align: justify;
                                margin-bottom: 0;
                            }
                        }
                    </style>

                </div>
            </div>
        @endisset

        <div class="search-filter mb-2 mb-lg-3">
            <div class="ws-g ws-cx">
                <div class="ws-u-1">
                    <form class="ws-g ws-form" action="" method="get">
                        <a class="ws-u-1 showfilter" href="#filter-dropnav"> <span class="show"> <i
                                    class="fa fa-sliders"></i> &nbsp; Filter &nbsp; <i class="fa fa-caret-down"></i> </span>
                            <span class="hide"> <i class="fa fa-sliders"></i> &nbsp; Filter ausblenden &nbsp; <i
                                    class="fa fa-caret-up"></i> </span> </a>

                        <span class="filter-nav left hidden d-none" style="height: 64px;"><i
                                class="fa fa-angle-left"></i></span>

                        <span class="filter-nav right d-none" style="height: 64px;"><i class="fa fa-angle-right"></i></span>

                        <a class="filter-nav h-100" href="javascript:void(0);" onclick="scrollFilters('right')"
                            style="right: 0">
                            <span><i class="fa fa-angle-right"></i></span>
                        </a>
                        <a class="filter-nav h-100" href="javascript:void(0);" onclick="scrollFilters('left')"
                            style="left: 0">
                            <span><i class="fa fa-angle-left"></i></span>
                        </a>

                        <ul class="ws-u-1 filter-dropnav filter-container" id="#filter-dropnav">
                            <!-- -->


                            @if (count($brands ?? []) > 0)
                                <li class="filter-item">
                                    <a href="#filter-brand">
                                        <span>Warenzeichen
                                            <i class="fa fa-angle-down caret-indicator"></i>
                                        </span>
                                    </a>
                                    <div class="filter-dropdown ws-g hersteller enable-scroll" id="filter-brand">
                                        <div class="ws-u-1">
                                            <ul class="ws-g inner">
                                                @foreach ($brands as $iBrand)
                                                    <li class="ws-u-1 nobr">
                                                        <label class="filter-item-wrapper" for="{{ $iBrand['id'] }}">
                                                            <input type="checkbox" name="brands[]" id="{{ $iBrand['id'] }}"
                                                                value="{{ $iBrand['brand_name'] }}"
                                                                onchange="submitFormWithDelay(true)"
                                                                @if (in_array($iBrand['brand_name'], request()->has('brands') ? explode(',', request()->input('brands')[0]) : [])) checked @endif>
                                                            <span class="label-text">{{ $iBrand['brand_name'] }}</span>
                                                            <span class="count">({{ $iBrand['product_count'] }})</span>
                                                        </label>
                                                    </li>
                                                @endforeach
                                            </ul>


                                        </div>
                                    </div>
                                </li>
                            @endif

                            @foreach ($attributesArray as $key => $attr)
                                <li class="filter-item">
                                    <a href="#filter-{{ $key }}">
                                        <span>{{ $key }}
                                            <i class="fa fa-angle-down caret-indicator"></i>
                                        </span>
                                    </a>
                                    <div class="filter-dropdown ws-g hersteller enable-scroll"
                                        id="filter-{{ $key }}">
                                        <div class="ws-u-1">
                                            <ul class="ws-g inner">
                                                @foreach ($attr as $aKey => $count)
                                                    <li class="ws-u-1 nobr">
                                                        <label class="filter-item-wrapper" for="{{ $aKey }}">
                                                            <input type="checkbox" name="attrs[]" id="{{ $aKey }}"
                                                                value="{{ $aKey }}"
                                                                onchange="submitFormWithDelay(true)"
                                                                @if (in_array($aKey, request()->has('attrs') ? explode(',', request()->input('attrs')[0]) : [])) checked @endif>
                                                            <span class="label-text">{{ $aKey }}</span>
                                                            <span class="count">({{ $count }})</span>
                                                        </label>
                                                    </li>
                                                @endforeach
                                            </ul>


                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </form>
                </div>
            </div>
        </div>
        <style>

        </style>
        <div class="ws-g ws-cx mb-2 search-row-info">
            <form action="" method="get" class="ws-form">

                <div class="ws-u-1 ws-u-lg-12-24 mb-2 mb-lg-0">
                    {{ $products->total() }} Artikel gefunden
                </div>
                <div class="ws-u-1 ws-u-lg-12-24 text-lg-end">
                    <div class="d-block d-lg-inline-block text-end text-lg-start">
                        <div class="d-inline-block ml-lg-3 ms-lg-3">
                            <label for="shoporder_select" class="d-block d-lg-inline-block text-start mt-0">Sortieren
                                nach:</label>
                            <select id="shoporder_select" name="sortOrder" class="d-inline-block"
                                onchange="submitFormWithDelay()">
                                <option value="relevanz" {{ request('sortOrder') == 'relevanz' ? 'selected' : '' }}>
                                    Relevanz</option>
                                <option value="preis_desc" {{ request('sortOrder') == 'preis_desc' ? 'selected' : '' }}>Giá
                                    giảm dần</option>
                                <option value="preis_asc" {{ request('sortOrder') == 'preis_asc' ? 'selected' : '' }}>Giá
                                    tăng dần</option>
                                <option value="neueste" {{ request('sortOrder') == 'neueste' ? 'selected' : '' }}>Mới nhất
                                </option>
                            </select>
                        </div>

                    </div>
                </div>
            </form>
        </div>
        <div class="ws-g search-result">
            @foreach ($products as $item)
                {{-- @dd($item) --}}
                <div class="ws-u-1-2 ws-u-md-1-3 ws-u-xl-1-5 search-result-item"> <a class="search-result-item-inner"
                        href="{{ route('products', [$item->category->slug, $item->brand->slug, $item->slug . '-' . $item->id]) }}"
                        title="{{ $item->name ?? $item->brand->name }}">
                        <div class="product-badge-wrapper">
                            @if (isDiscounted($item))
                                <span
                                    class="product-badge product-badge--discount">{{ calculateDiscountPercentage($item->price, $item->discount_value) }}%</span>
                            @endif
                        </div>
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
                                                            €</span></span></div>
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

        {{ $products->links('vendor.pagination.default') }}

        @isset($brand)
            <div id="text-cohiba---zigarren--zigarillos-und-zigarrenzubehoer"
                class="ws-g ws-c mt-4 contentpage contentpage--twocol">
                <div class="ws-u-1 contentpage__title"><span class="h1">{{ $brand->title }}</span></div>
                <div class="ws-u-1 contentpage__content">
                    {!! $brand->description !!}
                </div>
            </div>
        @endisset


    </div>


@endsection

@push('scripts')
    {{-- <script>
        function submitFormWithParams() {
            const form = document.querySelector('.search-row-info .ws-form');
            const page = new URLSearchParams(window.location.search).get('page');
            if (page) {
                // Add the current page to the form before submitting
                const pageInput = document.createElement('input');
                pageInput.type = 'hidden';
                pageInput.name = 'page';
                pageInput.value = page;
                form.appendChild(pageInput);
            }
            form.submit();
        }
    </script> --}}
@endpush

@push('styles')
@endpush
