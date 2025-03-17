@extends('frontend.layouts.master')

@section('content')
    <div class="ws-container">
        <div class="ws-g ws-c breadcrumbs">
            <div class="ws-u-1">
                <span class="breadcrumb-title">Sie befinden sich hier: </span><span class="breadcrumb-item"><a href="/"
                        class="breadcrumb-link"><span>Startseite</span></a></span><i
                    class="fa fa-angle-right breadcrumb-icon"></i><span class="breadcrumb-item"><a href="/shop/index"
                        class="breadcrumb-link"><span>Shop</span></a></span><i
                    class="fa fa-angle-right breadcrumb-icon"></i><span class="breadcrumb-item"><a href="/zigarren"
                        class="breadcrumb-link"><span>Zigarren</span></a></span><i
                    class="fa fa-angle-right breadcrumb-icon"></i><span class="breadcrumb-item"><a
                        href="/zigarren/dominikanische-republik" class="breadcrumb-link"><span>Dominikanische
                            Republik</span></a></span><i class="fa fa-angle-right breadcrumb-icon"></i><span
                    class="breadcrumb-item"><a href="/arturo-fuente" class="breadcrumb-link"><span>Arturo
                            Fuente</span></a></span><i class="fa fa-angle-right breadcrumb-icon"></i><span
                    class="breadcrumb-item"><a href="/zigarren/dominikanische-republik/arturo-fuente-hemingway-01101020"
                        class="breadcrumb-link"><span>Hemingway</span></a></span>
            </div>
        </div>

        <div class="ws-g">
            <div class="ws-u-1 ws-u-lg-16-24">
                <div class="ws-g ws-c DetailInfo">
                    <div class="ws-u-1 ws-u-lg-0 DetailInfo-more mb-2">
                        <a href="/arturo-fuente"><i class="fa fa-angle-left"></i>   Marke anzeigen</a>
                    </div>

                    <div class="ws-u-1 h-alt DetailInfo-title">
                        <img src="{{ showImage($product->brand->image) }}"
                            alt="{{ $product->brand->name . $product->name }}">
                        <h1>{{ $product->brand->name . ' ' . $product->name }}</h1>
                    </div>

                    <div class="ws-u-1 ws-u-lg-1-3 DetailInfo-logo">
                        <div class="ws-g DetailInfo-logoInner">
                            <div class="ws-u-1">
                                <div class="ws-g ws-c DetailInfo-logoImage">
                                    <div class="ws-u-1 DetailInfo-logoImageInner">
                                        <img src="{{ showImage($product->image) }}" alt="{{ $product->name }}" />
                                    </div>
                                </div>

                                <div class="ws-g ws-c DetailInfo-logoText">
                                    <div class="ws-u-1">{{ $product->variations_count }} verschiedene Varianten</div>
                                    <div class="ws-u-1">
                                        Diese Serie wurde am {{ \Carbon\Carbon::parse($product->create)->format('d.m.Y') }}
                                        angelegt
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ws-u-1 ws-u-lg-2-3 DetailInfo-description contentpage contentpage--detail">
                        <div class="ws-g DetailInfo-descriptionText contentpage__content">
                            <div class="ws-u-1"></div>
                        </div>

                        <div class="ws-g DetailInfo-descriptionExpand">
                            <i class="fa fa-chevron-down DetailInfo-descriptionExpandIcon"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ws-u-1 ws-u-lg-8-24">
                <div class="ws-g ws-c DetailRelated">
                    <div class="ws-u-1 h-alt">
                        <h2>Weitere {{ $product->brand->name }} Artikel</h2>
                    </div>

                    <div class="ws-u-1">
                        <ul class="ws-g rdsgn-List">

                            @foreach ($relatedProducts as $rp)
                                <li class="ws-u-1 rdsgn-List-item">
                                    <a href="{{ route('products', [$rp->category->slug, $rp->brand->slug, $rp->slug . '-' . $rp->id]) }}"
                                        class="ws-g rdsgn-List-link">
                                        <div class="ws-u-1-5 rdsgn-List-col1">
                                            <img src="{{ showImage($rp->image) }}" class="rdsgn-List-image" />
                                        </div>

                                        <div class="ws-u-4-5 rdsgn-List-col2">
                                            <div class="ws-g">
                                                <div class="ws-u-2-3 DetailRelated-name nobr">
                                                    <span class="rdsgn-List-text">{{ $rp->brand->name . $rp->name }}</span>
                                                    <span
                                                        class="rdsgn-List-text DetailRelated-variants">{{ $rp->variations_count }}
                                                        Varianten</span>
                                                </div>
                                                <div class="ws-u-1-3 DetailRelated-price">
                                                    <span class="rdsgn-List-text"><span
                                                            data-eurval="{{ isDiscounted($rp) ? $rp->discount_value : $rp->price }}">{{ isDiscounted($rp) ? $rp->discount_value : $rp->price }} €</span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                            <li class="ws-u-1 rdsgn-List-foot">
                                <a class="rdsgn-List-footLink" href="{{ route('products', $product->brand->slug) }}">Marke
                                    anzeigen</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="ws-g ws-c DetailVariant-tabnav">
            <ul class="ws-u-1 ws-u-lg-2-3 tab-nav">
                <li class="active"><a href="#tab-pane-variants" data-toggle="tab">Varianten</a></li>

                @if ($unpublishedVariations->isNotEmpty())
                    <li class="dot"></li>
                    <li><a href="#tab-pane-soldout" data-toggle="tab">Ausverkauft</a></li>
                @endif

                @if ($product->videos)
                    <li class="dot"></li>
                    <li><a href="#tab-pane-videos" data-toggle="tab">Produktvideos</a></li>
                @endif
            </ul>

            {{-- <form class="ws-u-1 ws-u-lg-1-3 DetailVariant-orderby" method="post" action="">
                <label for="orderby">Sortieren nach: </label>
                <select name="orderby" id="orderby">
                    <option value="">Standard</option>
                    <option value="name">Name</option>
                    <option value="rating">Preis/Leistung</option>
                    <option value="quality">Qualität</option>
                    <option value="taste">Stärke</option>
                    <option value="diameter">Durchmesser</option>
                    <option value="length">Länge</option>
                    <option value="price">Preis</option>
                </select>
            </form> --}}
            {{-- <script>
                (function() {
                    var form = document.body.querySelector(".DetailVariant-orderby");
                    var select = form.querySelector("select");
                    select.addEventListener("change", function() {
                        form.submit();
                    });
                })();
            </script> --}}
        </div>
        <div class="ws-g ws-c tab-content DetailVariant-tabcontent">
            <div id="tab-pane-variants" class="ws-u-1 tab-pane active fade in sortable">
                <ul class="DetailVariant-list">
                    @foreach ($product->variations as $pv)
                        <li class="ws-g DetailVariant" data-addtocart="loader">
                            <div class="ws-u-1 DetailVariant-variantName">
                                {{ $pv->name }}
                            </div>

                            <div class="product-badge-wrapper"></div>

                            <a class="ws-u-1 ws-u-lg-4-24 DetailVariant-col DetailVariant-image"
                                href="{{ route('products', [$product->category->slug, $product->brand->slug, $product->slug . '-' . $pv->slug . '-' . $product->id . '_' . $pv->id]) }}"
                                title="Arturo Fuente {{ $pv->name }}">
                                <img src="{{ showImage($pv->image) }}"
                                    alt="{{ implode(' ', [$product->category->name, $product->brand->name, $product->name, $pv->name]) }} " />
                            </a>

                            <a class="ws-u-1 ws-u-lg-11-24 ws-u-xl-13-24 DetailVariant-col DetailVariant-data"
                                href="{{ route('products', [$product->category->slug, $product->brand->slug, $product->slug . '-' . $pv->slug . '-' . $product->id . '_' . $pv->id]) }}"
                                title="Arturo Fuente {{ $pv->name }}">
                                <div class="ws-g">
                                    <div class="ws-u-1 DetailVariant-dataName">
                                        <span> {{ $pv->name }}</span>
                                    </div>
                                    <div class="ws-u-1">
                                        <div class="ws-g">
                                            <div class="ws-u-1 ws-u-lg-12-24 ws-u-xl-6-24 DetailVariant-dataContent">
                                                <span class="DetailVariant-dataValue nobr">
                                                    <div class="rating">
                                                        @for ($i = 0; $i < 8; $i++)
                                                            <span
                                                                class="fa fa-star {{ $i + 1 > $pv->rating ? 'inactive' : '' }}"></span>
                                                        @endfor
                                                    </div>
                                                </span>
                                                <span class="hidden">5 Bewertungen</span>
                                                <span class="DetailVariant-dataTitle">25 Bewertungen</span>
                                            </div>

                                            <div class="ws-u-1 ws-u-lg-12-24 ws-u-xl-6-24 DetailVariant-dataContent">
                                                <span class="DetailVariant-dataValue nobr">
                                                    <div class="rating">
                                                        @for ($i = 0; $i < 8; $i++)
                                                            <span
                                                                class="fa fa-star {{ $i + 1 > $pv->quality ? 'inactive' : '' }}"></span>
                                                        @endfor
                                                    </div>
                                                </span>
                                                <span class="hidden">6 Bewertungen</span>
                                                <span class="DetailVariant-dataTitle">Qualität</span>
                                            </div>

                                            <div class="ws-u-1 ws-u-lg-12-24 ws-u-xl-6-24 DetailVariant-dataContent">
                                                <span class="DetailVariant-dataValue nobr">
                                                    <div class="rating">
                                                        @for ($i = 0; $i < 8; $i++)
                                                            <span
                                                                class="fa fa-star {{ $i + 1 > $pv->strength ? 'inactive' : '' }}"></span>
                                                        @endfor
                                                    </div>
                                                </span>
                                                <span class="hidden">5 Bewertungen</span>
                                                <span class="DetailVariant-dataTitle">
                                                    Stärke
                                                </span>
                                            </div>

                                            <div
                                                class="ws-u-1 ws-u-lg-6-24 ws-u-xl-3-24 DetailVariant-dataContent DetailVariant-dataDiameter">
                                                <span class="DetailVariant-dataValue">{{ $pv->radius }}</span>
                                                <span class="DetailVariant-dataTitle">Ø</span>
                                            </div>

                                            <div
                                                class="ws-u-1 ws-u-lg-6-24 ws-u-xl-3-24 DetailVariant-dataContent DetailVariant-dataLength">
                                                <span class="DetailVariant-dataValue">{{ $pv->length }}</span>
                                                <span class="DetailVariant-dataTitle">Länge</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <div class="ws-u-1 ws-u-lg-9-24 ws-u-xl-7-24 DetailVariant-col">
                                {{-- <form class="ws-g DetailVariant-form" method="post" action=""> --}}
                                <div class="ws-u-1 DetailVariant-formRow">
                                    <div class="ws-g">
                                        <div class="ws-u-1-3 ws-u-lg-1-4 DetailVariant-formPriceTitle">
                                            Preis
                                        </div>
                                        <div class="ws-u-1-3 ws-u-lg-1-4 DetailVariant-formQuantityTitle">
                                            Menge
                                        </div>
                                        <div class="ws-u-1-3 ws-u-lg-1-2 DetailVariant-formUnitTitle">
                                            Einheit
                                        </div>
                                    </div>
                                </div>

                                <form action="" method="post" class="form-add-to-cart">
                                    @foreach ($pv->priceVariants as $pirceV)
                                        <div class="ws-u-1 DetailVariant-formRow">
                                            <div class="ws-g">
                                                <div class="ws-u-1-3 ws-u-lg-1-4 DetailVariant-formPrice">
                                                    <input type="hidden"
                                                        value="{{ $product->id . '-' . $pv->id . '-' . $pirceV->id }}"
                                                        id="group_id" name="options[{{ $pirceV->id }}][group_id]" />
                                                    <span class="preis">
                                                        <span
                                                            data-eurval="{{ isDiscounted($pirceV) ? $pirceV->discount_value : $pirceV->price }}">
                                                            {{ isDiscounted($pirceV) ? $pirceV->discount_value : $pirceV->price }}
                                                            €
                                                        </span>
                                                    </span>

                                                    <!-- Chỉ hiển thị phần tử del khi có giảm giá -->
                                                    @if (isDiscounted($pirceV))
                                                        <del class="altpreis">
                                                            statt <span data-eurval="{{ $pirceV->price }}"
                                                                data-curiso="USD">{{ $pirceV->price }} $</span>
                                                        </del>
                                                    @endif

                                                    <nobr><span class="grundbetrag"></span></nobr>
                                                </div>


                                                <div class="ws-u-1-3 ws-u-lg-1-4 DetailVariant-formQuantity">
                                                    <input type="number" style="width: 40px"
                                                        name="options[{{ $pirceV->id }}][qty]" value="0">
                                                </div>

                                                <div class="ws-u-1-3 ws-u-lg-1-2 DetailVariant-formUnit">
                                                    <label for="wk_anzahl_auswahl_2">
                                                        <span class="einheitlabel avail_1"
                                                            title="">{{ $pirceV->unit }}
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="ws-u-1 DetailVariant-formRow">
                                        <div class="ws-g">
                                            <div class="ws-u-1-1 ws-u-lg-1-4 DetailVariant-space"></div>
                                            <div class="ws-u-1-1 ws-u-lg-1-4 DetailVariant-space"></div>
                                            <div class="ws-u-1-1 ws-u-lg-1-2 DetailVariant-formAddtocart">
                                                <button
                                                    class="ws-button ws-button-md ws-button-checkout DetailVariant-formAddtocartButton"
                                                    type="submit" data-addtocart="submit" data-toggle="tooltip"
                                                    data-trigger="manual" data-title="Menge nicht ausgewählt">
                                                    In den Warenkorb
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                    @endforeach

                </ul>
            </div>

            @if ($unpublishedVariations->isNotEmpty())
                <div id="tab-pane-soldout" class="ws-u-1 fade tab-pane sortable in">
                    <ul class="DetailVariant-list">
                        @foreach ($unpublishedVariations as $uv)
                            {{-- @dd($pv) --}}
                            <li class="ws-g DetailVariant" data-addtocart="loader">
                                <div class="ws-u-1 DetailVariant-variantName">
                                    {{ $uv->name }}
                                </div>

                                <div class="product-badge-wrapper"></div>

                                <a class="ws-u-1 ws-u-lg-4-24 DetailVariant-col DetailVariant-image"
                                    href="{{ route('products', [$product->category->slug, $product->brand->slug, $product->slug . '-' . $uv->slug . '-' . $product->id . '_' . $uv->id]) }}"
                                    title="Arturo Fuente {{ $uv->name }}">
                                    <img src="{{ showImage($uv->image) }}" style="width: 57%; height: auto"
                                        alt="{{ implode(' ', [$product->category->name, $product->brand->name, $product->name, $uv->name]) }} " />
                                </a>

                                <a class="ws-u-1 ws-u-lg-11-24 ws-u-xl-13-24 DetailVariant-col DetailVariant-data"
                                    href="/zigarren/dominikanische-republik/arturo-fuente-hemingway-best-seller-perfecto-01101020_19532"
                                    title="Arturo Fuente {{ $uv->name }}">
                                    <div class="ws-g">
                                        <div class="ws-u-1 DetailVariant-dataName">
                                            <span> {{ $uv->name }}</span>
                                        </div>
                                        <div class="ws-u-1">
                                            <div class="ws-g">
                                                <div class="ws-u-1 ws-u-lg-12-24 ws-u-xl-6-24 DetailVariant-dataContent">
                                                    <span class="DetailVariant-dataValue nobr">
                                                        <div class="rating">
                                                            @for ($i = 0; $i < 8; $i++)
                                                                <span
                                                                    class="fa fa-star {{ $i + 1 > $uv->rating ? 'inactive' : '' }}"></span>
                                                            @endfor
                                                        </div>
                                                    </span>
                                                    <span class="hidden">5 Bewertungen</span>
                                                    <span class="DetailVariant-dataTitle">25 Bewertungen</span>
                                                </div>

                                                <div class="ws-u-1 ws-u-lg-12-24 ws-u-xl-6-24 DetailVariant-dataContent">
                                                    <span class="DetailVariant-dataValue nobr">
                                                        <div class="rating">
                                                            @for ($i = 0; $i < 8; $i++)
                                                                <span
                                                                    class="fa fa-star {{ $i + 1 > $uv->quality ? 'inactive' : '' }}"></span>
                                                            @endfor
                                                        </div>
                                                    </span>
                                                    <span class="hidden">6 Bewertungen</span>
                                                    <span class="DetailVariant-dataTitle">Qualität</span>
                                                </div>

                                                <div class="ws-u-1 ws-u-lg-12-24 ws-u-xl-6-24 DetailVariant-dataContent">
                                                    <span class="DetailVariant-dataValue nobr">
                                                        <div class="rating">
                                                            @for ($i = 0; $i < 8; $i++)
                                                                <span
                                                                    class="fa fa-star {{ $i + 1 > $uv->strength ? 'inactive' : '' }}"></span>
                                                            @endfor
                                                        </div>
                                                    </span>
                                                    <span class="hidden">5 Bewertungen</span>
                                                    <span class="DetailVariant-dataTitle">
                                                        Stärke
                                                    </span>
                                                </div>

                                                <div
                                                    class="ws-u-1 ws-u-lg-6-24 ws-u-xl-3-24 DetailVariant-dataContent DetailVariant-dataDiameter">
                                                    <span class="DetailVariant-dataValue">{{ $uv->radius }}</span>
                                                    <span class="DetailVariant-dataTitle">Ø</span>
                                                </div>

                                                <div
                                                    class="ws-u-1 ws-u-lg-6-24 ws-u-xl-3-24 DetailVariant-dataContent DetailVariant-dataLength">
                                                    <span class="DetailVariant-dataValue">{{ $uv->length }}</span>
                                                    <span class="DetailVariant-dataTitle">Länge</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <div class="ws-u-1 ws-u-lg-9-24 ws-u-xl-7-24 DetailVariant-col">
                                    <form class="ws-g DetailVariant-form" method="post" action="/warenkorb/show"
                                        data-ajaction="/ajax/warenkorb/show" data-addtocart="form">
                                        <div class="ws-u-1 DetailVariant-formRow">
                                            <div class="ws-g">
                                                <div class="ws-u-1-3 ws-u-lg-1-4 DetailVariant-formPriceTitle">
                                                    Preis
                                                </div>
                                                <div class="ws-u-1-3 ws-u-lg-1-4 DetailVariant-formQuantityTitle">
                                                    Menge
                                                </div>
                                                <div class="ws-u-1-3 ws-u-lg-1-2 DetailVariant-formUnitTitle">
                                                    Einheit
                                                </div>
                                            </div>
                                        </div>

                                        <div class="ws-u-1 DetailVariant-formRow">
                                            <div class="ws-g">
                                                <div class="ws-u-1-3 ws-u-lg-1-4 DetailVariant-formPrice">
                                                    <input type="hidden" name="wk_artikelid[1]" value="19532" />
                                                    <span class="preis"><span data-eurval="17.00">17.00 €</span></span>
                                                    <nobr><span class="grundbetrag"></span></nobr>
                                                </div>

                                                <div class="ws-u-1-3 ws-u-lg-1-4 DetailVariant-formQuantity">

                                                </div>

                                                <div class="ws-u-1-3 ws-u-lg-1-2 DetailVariant-formUnit">
                                                    <label for="wk_anzahl_auswahl_1">
                                                        <input type="hidden" name="wk_einheit[1]" value="11328" /><span
                                                            class="einheitlabel avail_1" title="">1er</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ws-u-1 DetailVariant-formRow">
                                            <div class="ws-g">
                                                <div class="ws-u-1-3 ws-u-lg-1-4 DetailVariant-formPrice">
                                                    <input type="hidden" name="wk_artikelid[2]" value="19532" />
                                                    <span class="preis"><span data-eurval="412.25">412.25 €</span></span>
                                                    <nobr><span class="grundbetrag"></span></nobr>
                                                </div>

                                                <div class="ws-u-1-3 ws-u-lg-1-4 DetailVariant-formQuantity">
                                                </div>

                                                <div class="ws-u-1-3 ws-u-lg-1-2 DetailVariant-formUnit">
                                                    <label for="wk_anzahl_auswahl_2">
                                                        <input type="hidden" name="wk_einheit[2]" value="11329" /><span
                                                            class="einheitlabel avail_1" title="">25er Kiste</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
            @endif


            @if ($product->videos)
                <div id="tab-pane-videos" class="ws-u-1 tab-pane fade DetailVariant-videos">
                    <ul class="ws-g DetailVariant-list">
                        <li class="ws-u-1 ws-u-lg-1-3 DetailVideo">
                            <div class="ws-g ws-c">
                                <div class="ws-u-1 DetailVideo-title nobr"
                                    title="Tasting: Bolivar Coronas Extra Cabinet &amp; Romeo y Julieta Wide Churchill">
                                    Tasting: Bolivar Coronas Extra Cabinet &amp; Romeo y Julieta Wide Churchill</div>
                                <div class="ws-u-1 DetailVideo-player"> <iframe
                                        src="https://www.youtube-nocookie.com/embed/rWMLRRBdRPs?rel=0" frameborder="0"
                                        allowfullscreen=""></iframe></div>
                                <div class="ws-u-1 DetailVideo-description">Marc Benden und Mitarbeiter Niko Alexandridis
                                    verkosten diesmal zwei Habanas.
                                    Zum einen testet Marc die Bolivar Corona Extra aus der Cabinet-Kiste. Eine kräftige
                                    Pfeffrige Zigarre.
                                    Niko raucht diesmal eine etwas mildere Habana, die Romeo &amp; Julieta Wide Churchill.
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            @endif

        </div>

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

    {{-- @dd(Cart::instance('shopping')->content()) --}}
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
