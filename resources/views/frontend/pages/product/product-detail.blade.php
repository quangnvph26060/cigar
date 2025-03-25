@extends('frontend.layouts.master')

@section('content')
    <div class="ws-container">

        @php
            $data = [];
            $data[$product->category->name] = route('products', $product->category->slug);
            $data[$product->brand->name] = route('products', $product->brand->slug);
            $data[$product->name == $variant->name ? $product->name : $product->name . ' ' . $variant->name] = null;
        @endphp

        @include('frontend.pages.include.breadcrumb', [
            'data' => $data,
        ])

        <div class="ws-g">
            <div class="ws-u-1 ws-u-xl-6-24 SeriesProducts">
                <div class="ws-u-g ws-c">

                    <div class="ws-u-1 SeriesProducts-more">
                        <a
                            href="{{ route('products', [$product->category->slug, $product->brand->slug, $product->slug . '-' . $product->id]) }}"><i
                                class="fa fa-angle-left"></i>   Serie anzeigen</a>
                    </div>

                    <ul class="ws-u-1 SeriesProducts-list">

                        @if ($hasMatchingVariation)
                            <li class="SeriesProducts-item active">
                                <a href="" title="{{ $variant->name }}" class="nobr">{{ $variant->name }}
                                </a>
                            </li>
                        @else
                            @foreach ($product->variations as $item)
                                <li class="SeriesProducts-item {{ $item->id == $variant->id ? 'active' : '' }}">
                                    <a href="{{ route('products', [$product->category->slug, $product->brand->slug, $product->slug . '-' . $item->slug . '-' . $product->id . '_' . $item->id]) }}"
                                        title="{{ $item->name }}" class="nobr">{{ $item->name }}</a>
                                </li>
                            @endforeach
                        @endif
                    </ul>

                    @if (!$hasMatchingVariation)
                        <div class="ws-u-1 SeriesProducts-more SeriesProducts-moreBottom">
                            <a
                                href="{{ route('products', [$product->category->slug, $product->brand->slug, $product->slug . '-' . $product->id]) }}"><i
                                    class="fa fa-angle-left"></i>   Serie anzeigen</a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="ws-u-1 ws-u-xl-18-24">
                <div class="ws-g ws-c VariantTitle">
                    <div class="ws-u-1">
                        <h1 class="h-alt">
                            {{ $variant->name }}
                        </h1>
                    </div>
                </div>

                @php
                    $images = array_merge([$variant->image], $variant->albums->pluck('image_path')->toArray() ?? []);

                @endphp
                <div class="ws-g VariantContent">
                    <div class="ws-u-1 ws-u-lg-3-5 variant__gallery">
                        <div class="variant__gallery-inner">
                            <div class="variant__gallery-full">
                                <div class="product-badge-wrapper"></div>

                                <i class="d-none d-lg-block fa fa-search DetailImageBig-icon"
                                    data-detailimagemodal="#detailimage-modal"></i>
                                <div class="variant__gallery-full-wrapper">
                                    <div class="swiper variant_gallery-swiper__full" style="display: none">
                                        <div class="swiper-wrapper">

                                            @foreach ($images as $thumbnail)
                                                <div class="swiper-slide">
                                                    <div class="swiper-zoom-container">
                                                        <img src="{{ showImage($thumbnail) }}" loading="lazy"
                                                            alt="{{ $product->category->name . ' ' . $product->brand->name . ' ' . ($product->name == $variant->name ? $product->name : $product->name . ' ' . $variant->name) }}"
                                                            data-magnify="{{ showImage($thumbnail) }}" />
                                                        <div class="swiper-lazy-preloader"></div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if (count($images) > 1)
                                <div class="variant__gallery-thumbs">
                                    <div class="swiper variant_gallery-swiper__thumbs" style="display: none">
                                        <div class="swiper-wrapper">

                                            @foreach ($images as $album)
                                                <div class="swiper-slide">
                                                    <img src="{{ showImage($album) }}"
                                                        alt="{{ $product->category->name . ' ' . $product->brand->name . ' ' . ($product->name == $variant->name ? $product->name : $product->name . ' ' . $variant->name) }}"
                                                        width="60" height="60" />
                                                </div>
                                            @endforeach



                                        </div>
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                    <div class="ws-u-1 ws-u-lg-2-5 variant__orderbox">
                        <div class="ws-g ws-c VariantColTitle">
                            <div class="ws-u-1">Kaufen</div>
                        </div>

                        <div class="ws-g ws-c DetailOrderbox" data-addtocart="loader">
                            <div class="ws-u-1">
                                <h4 class="h-alt h-alt-nm d-none d-lg-block nobr">
                                    {{ $variant->name }}
                                </h4>

                                <div class="ws-g DetailOrderbox-row DetailOrderbox--titlerow mt-2 mt-lg-3">

                                    <div class="ws-u-7-24 DetailOrderbox-col DetailOrderbox-price DetailOrderbox--title">
                                        Preis
                                    </div>
                                    <div class="ws-u-5-24 DetailOrderbox-col DetailOrderbox-quantity DetailOrderbox--title">
                                        Menge
                                    </div>
                                    <div class="ws-u-8-24 DetailOrderbox-col DetailOrderbox-unit DetailOrderbox--title">
                                        Einheit
                                    </div>
                                </div>


                                <form action="" method="post" class="form-add-to-cart">

                                    @foreach ($variant->priceVariants as $vp)
                                        <div class="ws-g DetailOrderbox-row">

                                            <div class="ws-u-7-24 DetailOrderbox-col DetailOrderbox-price">

                                                <input type="hidden"
                                                    value="{{ $product->id . '-' . $variant->id . '-' . $vp->id }}"
                                                    id="group_id" name="options[{{ $vp->id }}][group_id]" />
                                                <span class="preis">
                                                    <span
                                                        data-eurval="{{ isDiscounted($vp) ? $vp->discount_value : $vp->price }}">
                                                        {{ isDiscounted($vp) ? $vp->discount_value : $vp->price }}
                                                        €
                                                    </span>
                                                </span>

                                                <!-- Chỉ hiển thị phần tử del khi có giảm giá -->
                                                @if (isDiscounted($vp))
                                                    <del class="altpreis">
                                                        statt <span data-eurval="{{ $vp->price }}"
                                                            data-curiso="USD">{{ $vp->price }} $</span>
                                                    </del>
                                                @endif

                                                <nobr><span class="grundbetrag"></span></nobr>
                                            </div>
                                            <div class="ws-u-5-24 DetailOrderbox-col DetailOrderbox-quantity">
                                                <input type="number" style="width: 40px"
                                                    name="options[{{ $vp->id }}][qty]" value="0" min="0">

                                            </div>
                                            <div class="ws-u-8-24 DetailOrderbox-col DetailOrderbox-unit">
                                                <label for="wk_anzahl_auswahl_1" title="Auf Lager">
                                                    <span class="einheitlabel avail_1" title="">{{ $vp->unit }}
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="ws-g DetailOrderbox-buttons mt-3">
                                        <div class="ws-u-1 ws-u-md-1-2 DetailOrderbox-addtocart" style="width: 55%">
                                            <button type="submit"
                                                class="btn btn-bs btn-success DetailOrderbox-buttonAddtocart"
                                                data-addtocart="submit" data-toggle="tooltip" data-trigger="manual"
                                                data-title="Menge nicht ausgewählt">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-cart2" viewBox="0 0 16 16">
                                                    <path
                                                        d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z">
                                                    </path>
                                                </svg>
                                                In den Warenkorb
                                            </button>
                                        </div>

                                        <div class="ws-u-0 ws-u-md-1-2 mt-2 mt-lg-0 DetailOrderbox-addtowatchlist"
                                            style="width: 45%">

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ws-g VariantTab">
                    <div class="ws-u-1">
                        <div class="ws-g ws-c VariantTab-nav">
                            <ul class="ws-u-1 tab-nav tab-nav-amp">
                                @if ($variant->description)
                                    <li class="active">
                                        <a href="#tab-pane-description" data-toggle="tab">Beschreibung</a>
                                    </li>
                                @endif

                                <li class="{{ !$variant->description ? 'active' : '' }}">
                                    <a href="#tab-pane-data" data-toggle="tab">Infos und Fakten</a>
                                </li>
                            </ul>
                        </div>

                        <div class="ws-g tab-content VariantTab-content contentpage contentpage--variante">
                            <ul id="tab-pane-description" class="ws-u-1 tab-pane active fade in">
                                <div class="ws-g ws-c">
                                    <div class="ws-u-1">
                                        <div class="contentpage__content">
                                            {!! $variant->description !!}
                                        </div>
                                    </div>
                                </div>
                            </ul>

                            <div id="tab-pane-data"
                                class="ws-u-1 tab-pane fade in {{ !$variant->description ? 'active' : '' }}">
                                <div class="ws-g VariantInfo">
                                    <div class="ws-u-1 ws-u-sm-1-2 ws-u-md-1-3 ws-u-lg-1-3 ws-u-xl-1-5 VariantInfo-item">
                                        <div class="ws-g ws-c">
                                            <div class="ws-u-1 VariantInfo-itemName">
                                                Im Sortiment seit
                                            </div>
                                            <div class="ws-u-1 VariantInfo-itemValue">
                                                {{ $variant->created_at->format('d.m.Y') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ws-u-1 ws-u-sm-1-2 ws-u-md-1-3 ws-u-lg-1-3 ws-u-xl-1-5 VariantInfo-item">
                                        <div class="ws-g ws-c">
                                            <div class="ws-u-1 VariantInfo-itemName">Marke</div>
                                            <div class="ws-u-1 VariantInfo-itemValue">
                                                <a
                                                    href="{{ route('products', $product->brand->slug) }}"><u>{{ $product->brand->name }}</u></a>
                                            </div>
                                        </div>
                                    </div>

                                    @foreach ($attributes as $attribute)
                                        <div
                                            class="ws-u-1 ws-u-sm-1-2 ws-u-md-1-3 ws-u-lg-1-3 ws-u-xl-1-5 VariantInfo-item">
                                            <div class="ws-g ws-c">
                                                <div class="ws-u-1 VariantInfo-itemName">
                                                    {{ $attribute['attribute_name'] }}</div>
                                                <div class="ws-u-1 VariantInfo-itemValue">
                                                    {{ $attribute['attribute_value'] }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="ws-g">
                    <div class="ws-u-1">
                        <div class="ws-g ws-c">
                            <div class="ws-u-1">
                                <h2 class="h-alt h-alt-nm">
                                    Kunden, die sich dieses Produkt anschauten, kauften danach
                                </h2>
                            </div>
                        </div>
                        <div class="ws-g ws-c">
                            <div class="ws-u-1">
                                <div class="swiper-products">
                                    <div id="swiper-671234f91702578f" class="swiper" style="display: block">
                                        <div class="swiper-wrapper" style="display: flex">



                                            @foreach ($fakeProductPayed as $fPP)
                                                <div class="swiper-slide"
                                                    style="
                                                flex-shrink: 0;
                                                width: 360.8px;
                                                margin-right: 20px;
                                            ">
                                                    <div class="ws-u-1 search-result-item">
                                                        <a class="search-result-item-inner"
                                                            href="{{ route('products', [$fPP->category->slug, $fPP->brand->slug, $fPP->slug . '-' . $fPP->id]) }}"
                                                            title="{{ $fPP->name }}">
                                                            <div class="product-badge-wrapper"></div>
                                                            <div class="ws-g search-result-item-content">
                                                                <div class="ws-u-1 image">
                                                                    <img src="images/ajax-loader.gif"
                                                                        alt="{{ $fPP->name }}"
                                                                        data-src="{{ showImage($fPP->image) }}" />
                                                                </div>
                                                                <div class="ws-u-1 bottom">
                                                                    <div class="ws-g bottom-content">
                                                                        <div class="ws-u-1 mb-2 bottom-row bottom-row--1">
                                                                            <div class="brand">{{ $fPP->brand->name }}
                                                                            </div>
                                                                            <div class="name">
                                                                                {{ $fPP->name }}
                                                                            </div>
                                                                            <div class="remark"> </div>
                                                                        </div>
                                                                        <div
                                                                            class="ws-u-1 mb-2 bottom-row bottom-row--values">
                                                                            <span>Ø 1.98 cm</span>
                                                                            <span>L 10.16 cm</span>
                                                                        </div>

                                                                        <div class="ws-u-1 bottom-row bottom-row--2">
                                                                            <div class="ws-g">
                                                                                <div
                                                                                    class="ws-u-1 ws-u-lg-2-5 itembadges d-none d-lg-inline-block">
                                                                                    <i class="fa fa-star itembadge toprating"
                                                                                        title="Top Bewertungen"></i>
                                                                                </div>
                                                                                <div class="ws-u-1 ws-u-lg-3-5 price">
                                                                                    <div class="price-wrapper"><span
                                                                                            class="price-remark"></span>
                                                                                        <span class="price-value">
                                                                                            <span
                                                                                                data-eurval="{{ isDiscounted($fPP) ? $fPP->discount_value : $fPP->price }}"
                                                                                                data-curiso="USD">{{ isDiscounted($fPP) ? $fPP->discount_value : $fPP->price }}
                                                                                                €
                                                                                            </span>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="swiper-button-prev"></div>
                                        <div class="swiper-button-next"></div>
                                    </div>

                                    <script>
                                        (function(undefined) {
                                            var settings = JSON.parse(
                                                '{"direction":"horizontal","slidesPerView":2,"spaceBetween":5,"loop":false,"speed":300,"pagination":false,"navigation":{"nextEl":".swiper-button-next","prevEl":".swiper-button-prev"},"scrollbar":false,"autoplay":false,"breakpointsBase":"container","breakpoints":{"568":{"slidesPerView":2},"768":{"slidesPerView":3,"spaceBetween":20},"1024":{"slidesPerView":4,"spaceBetween":20},"1440":{"slidesPerView":5,"spaceBetween":20}}}'
                                            );
                                            var swiperSelector = "#swiper-671234f91702578f";
                                            var swiperElement =
                                                document.querySelector(swiperSelector);
                                            var swiperWrapper =
                                                swiperElement.querySelector(".swiper-wrapper");
                                            var swiperSlides =
                                                swiperElement.querySelectorAll(".swiper-slide");

                                            swiperWrapper.style.display = "flex";
                                            swiperSlides.forEach(function(tmp) {
                                                tmp.style.flexShrink = 0;
                                            });

                                            document.querySelector(swiperSelector).style.display =
                                                "block";
                                            var slideContainerWidth =
                                                swiperElement.getBoundingClientRect().width;

                                            if (slideContainerWidth > 0) {
                                                document.querySelector(
                                                    swiperSelector
                                                ).style.display = "none";
                                                var slidesPerView = settings.slidesPerView;
                                                var spaceBetween = settings.spaceBetween;

                                                if (settings.breakpoints !== undefined) {
                                                    Object.entries(settings.breakpoints).forEach(
                                                        ([key, values]) => {
                                                            if (
                                                                window.matchMedia(
                                                                    "(min-width: " + key + "px)"
                                                                ).matches
                                                            ) {
                                                                slidesPerView =
                                                                    values.slidesPerView !== undefined ?
                                                                    values.slidesPerView :
                                                                    slidesPerView;
                                                                spaceBetween =
                                                                    values.spaceBetween !== undefined ?
                                                                    values.spaceBetween :
                                                                    spaceBetween;
                                                            }
                                                        }
                                                    );
                                                }

                                                var swiperSlideElements =
                                                    swiperElement.querySelectorAll(".swiper-slide");
                                                swiperSlideElements.forEach((el) => {
                                                    el.style.width =
                                                        slideContainerWidth / slidesPerView -
                                                        ((slidesPerView - 1) * spaceBetween) /
                                                        slidesPerView +
                                                        "px";
                                                    el.style.marginRight = spaceBetween + "px";
                                                });

                                                document.querySelector(
                                                    swiperSelector
                                                ).style.display = "block";
                                            }

                                            window.addEventListener(
                                                "DOMContentLoaded",
                                                (event) => {
                                                    const swiper = new Swiper(
                                                        swiperSelector,
                                                        settings
                                                    );
                                                }
                                            );
                                        })();
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="addToCart-modal" class="modal fade DetailVariant-modalCart" tabindex="-1" role="dialog"
            data-addtocart="modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <i class="fa fa-close close" data-dismiss="modal"></i>
                        <h4 class="modal-title">Warenkorb</h4>
                    </div>
                    <div class="modal-body" data-addtocart="body">
                        <div class="ws-g ws-c notice">
                            <div class="ws-u-1 notice-error">
                                <i class="notice-icon fa fa-exclamation-triangle"></i><span class="notice-text">Anzahl
                                    nicht ausgewählt</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="ws-button DetailVariant-modalButtonClose" data-dismiss="modal">
                            <i class="fa fa-chevron-left"></i> Weiter einkaufen
                        </button>
                        <a href="/warenkorb/show" type="button"
                            class="ws-button ws-button-primary DetailVariant-modalButtonCart"><i
                                class="fa fa-shopping-cart"></i> Warenkorb ansehen</a>
                        <a href="/bestellung/index" type="button"
                            class="ws-button ws-button-checkout DetailVariant-modalButtonCheckout">Zur Kasse <i
                                class="fa fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            (function(undefined) {
                var modal = $('[data-addtocart="modal"]');
                var modal_body = $('[data-addtocart="body"]', modal);

                $('[data-addtocart="form"]').on("submit", function(e) {
                    e.preventDefault();
                    var form = $(this);
                    var container = form.closest('[data-addtocart="loader"]');
                    var submit = form.find('[data-addtocart="submit"]');

                    var has_selected_value = false;
                    form.find("select").each(function() {
                        if ($(this).prop("selectedIndex") != 0) {
                            has_selected_value = true;
                        }
                    });

                    if (!has_selected_value) {
                        if (submit.attr("aria-describedby") == undefined) {
                            submit.tooltip("show");
                            setTimeout(function() {
                                submit.tooltip("hide");
                            }, 1500);
                        }
                        return false;
                    }

                    container.cssloader("show");

                    $.post(
                        form.attr("data-ajaction"),
                        form.serialize() + "&rdsgn=1",
                        function(data) {
                            var content = $(data);
                            if (content.find("div").length > 1) {
                                //if($.trim(data) != '') {
                                var wkanz = content.find(".wkanzahl");
                                wkanz.each(function() {
                                    var alt = $(this);
                                    var neu = $("<span>", {
                                        class: "wkanzahl",
                                        text: "x " + alt.val(),
                                    });
                                    alt.replaceWith(neu);
                                });
                                modal_body.empty().append(content);
                            }
                            form.find("select").prop("selectedIndex", 0).val(0);
                            modal.modal();
                        }
                    );
                });

                modal.on("show.bs.modal", function() {
                    var container = $('[data-addtocart="loader"]');
                    container.cssloader("hide");
                });
            })();
        </script>

        <div id="reminder-modal" class="modal fade Reminder-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <i class="fa fa-close close" data-dismiss="modal"></i>
                        <h4 class="modal-title">Erinnerung</h4>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" class="ws-button Reminder-close" data-dismiss="modal">
                            Abbrechen
                        </button>
                        <a href="/meinkonto/reminder" class="ws-button ws-button-primary Reminder-manage"><i
                                class="fa fa-list-ul"></i> Erinnerungen verwalten</a>
                        <button type="button" class="ws-button ws-button-primary Reminder-fakesubmit">
                            <i class="fa fa-check"></i> Erinnerung speichern
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="detailimage-modal" class="modal fade DetailImageModal" tabindex="-1" role="dialog"
            data-modal="detailimagemodal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <i class="fa fa-close DetailImageModalClose" data-dismiss="modal"></i>

                    <div class="modal-body ws-g" data-detailimagecontainer="">

                        <div class="ws-u-1 DetailImageModalBig">
                            <img src="{{ $variant->image }}" alt="{{ $variant->name }}" data-detailimage="" />
                        </div>

                        <div class="ws-u-1 DetailImageModalSmall">

                            @foreach ($images as $popupImg)
                                <div class="DetailImageModalSmall-inner">
                                    <a href="{{ showImage($popupImg) }}" title="{{ $variant->name }}"
                                        data-detailimagesrc="{{ showImage($popupImg) }}"
                                        data-detailimagealt="{{ $variant->name }}">
                                        <img src="{{ showImage($popupImg) }}" alt="{{ $variant->name }}" />
                                    </a>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ws-container">
        <div class="modal fade modal-regional-settings" id="modal_regional_settings" tabindex="-1" role="dialog"
            aria-labelledby="modal_regional_settings_label">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body">loading...</div>
                </div>
            </div>
        </div>


    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('submit', '.form-add-to-cart', function(e) {
                e.preventDefault();

                let form = $(this); // Lưu form hiện tại
                let formData = form.serialize(); // Lấy dữ liệu từ form

                $.ajax({
                    url: "{{ route('addToCart') }}",
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        // Cập nhật số lượng sản phẩm trong giỏ hàng
                        $('.ws-u-5-24.ws-u-xl-6-24.cart span.text.nobr').html(
                            `Warenkorb (${response.count})`);

                        // Reset giá trị ô input qty về 0
                        form.find('input[type="number"]').val(0);

                        setTimeout(() => {
                            showNotification(response.addedItems);
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        alert('Lỗi kết nối, vui lòng thử lại!');
                    }
                });
            });
        });
    </script>
@endpush
