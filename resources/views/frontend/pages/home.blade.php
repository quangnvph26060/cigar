@extends('frontend.layouts.master')


@section('content')
    @php
        $firstSlider = $sliders->first();
    @endphp
    <div class="ws-container">
        <div class="ws-g ws-c bigspots">
            <div class="ws-u-1 ws-u-lg-1-2 bigspots-left">
                <div class="inner">
                    <div id="home-carousel" class="carousel slide" data-interval="6000" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach ($firstSlider->items as $slider)
                                <li data-target="#home-carousel" data-slide-to="{{ $loop->index }}"
                                    @if ($loop->first) class="active" @endif></li>
                            @endforeach
                        </ol>

                        <div class="carousel-inner">
                            @foreach ($firstSlider->items as $item)
                                <a @if ($item['url']) target="_blank" @endif
                                    href="{{ $item['url'] ?? 'javascript:void(0)' }}"
                                    class="item  @if ($loop->first) active @endif">
                                    <img src="{{ showImage($item['image']) }}" data-src="{{ showImage($item['image']) }}"
                                        alt="{{ $item['alt'] }}" />
                                </a>
                            @endforeach


                        </div>

                        <a class="left carousel-control" href="#home-carousel" data-slide="prev">
                            <span class="fa fa-chevron-left"></span>
                        </a>
                        <a class="right carousel-control" href="#home-carousel" data-slide="next">
                            <span class="fa fa-chevron-right"></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="ws-u-1 ws-u-lg-1-2 bigspots-right">
                <div class="ws-g">
                    {{-- <div class="ws-u-1-2 spot-4">
                        <div class="inner">
                            <a href="/content/kubanische-zigarillos?ref=spot">
                                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                    data-src="/img/cuba-cigarillo-spot-128.jpg" alt="Kubanische Zigarillos" />
                                <div class="title">
                                    <span class="nobr">Kubanische Zigarillos</span>
                                </div>
                            </a>
                        </div>
                    </div> --}}


                    @foreach ($posts as $post)
                        <div class="ws-u-1-2 spot-4">
                            <div class="inner">
                                <a href="{{ route('content', $post->slug) }}">
                                    <img src="{{ showImage($post->image) }}" alt="{{ $post->title }}" />
                                    <div class="overlay"></div> <!-- Lớp phủ mờ -->
                                    <div class="excerpt">
                                        <p style="margin-bottom: 0">{{ $post->excerpt }}</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach






                </div>
            </div>
        </div>

        {{-- <div class="ws-g">
            <div class="ws-u-1-2 ws-u-lg-1-4" style="vertical-align: middle">
                <div class="ws-c">
                    <a href="https://www.rauchr.de/casa-de-alegria?ref=spot" style="display: block; position: relative"
                        class="spot-sm">
                        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                            data-src="/img/banner/spot/bb4ee8eafb6dd67b4dcadd1a011597de.jpeg" alt="Casa de Alegria"
                            style="width: 100%" />
                    </a>
                </div>
            </div>

            <div class="ws-u-1-2 ws-u-lg-1-4" style="vertical-align: middle">
                <div class="ws-c">
                    <a href="/el-septimo?ref=spot" style="display: block; position: relative" class="spot-sm">
                        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                            data-src="/img/banner/spot/81ff842a55ffbd342b15f52c09b9bffc.jpeg" alt="El Septimo"
                            style="width: 100%" />
                    </a>
                </div>
            </div>

            <div class="ws-u-1-2 ws-u-lg-1-4" style="vertical-align: middle">
                <div class="ws-c">
                    <a href="https://www.rauchr.de/bugatti?ref=spot" style="display: block; position: relative"
                        class="spot-sm">
                        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                            data-src="/img/banner/spot/04f37fa45705375a4aa7d9fc963bb0f6.jpeg" alt="Bugatti"
                            style="width: 100%" />
                    </a>
                </div>
            </div>

            <div class="ws-u-1-2 ws-u-lg-1-4" style="vertical-align: middle">
                <div class="ws-c">
                    <a href="/plasencia?ref=spot-plasencia" style="display: block; position: relative" class="spot-sm">
                        <img src="images/spot-plasencia.jpg" alt="Plasencia" style="width: 100%" />
                        <div class="title" style="z-index: 1">
                            <span class="nobr" style="font-size: 18.4px; letter-spacing: -0.015em">Plasencia</span>
                        </div>
                    </a>
                </div>
            </div>
        </div> --}}


        <div class="ws-g ws-c topbrands">

            @foreach ($brands as $brand)
                <div class="ws-u-1-4 ws-u-lg-1-8 brand">
                    <a href="/#" title="{{ $brand->name }}" class="inner">
                        <img class="logo" src="{{ showImage($brand->image) }}" data-src="{{ showImage($brand->image) }}"
                            alt="{{ $brand->name }}" />
                        <div class="name">
                            <div class="ws-g">
                                <span class="ws-u-1">{{ $brand->name }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="ws-g ws-c colcontent">
            <div class="ws-u-1 ws-u-lg-1-2 leftcol">
                <div class="ws-g">
                    @foreach ($sliders->skip(1) as $slider)
                        <div class="ws-u-1-2 spot" style="vertical-align: middle">
                            <div class="ws-c">
                                <div id="carousel-{{ $slider->id }}" class="carousel slide accessorieTeaserSpot"
                                    data-interval="6000" data-ride="carousel">
                                    <div class="carousel-inner">
                                        @php
                                            $items = $slider->items; // Giải mã JSON
                                        @endphp

                                        @foreach ($items as $index => $item)
                                            <div class="item {{ $loop->first ? 'active' : '' }}">
                                                <a @if ($item['url']) target="_blank" @endif
                                                    href="{{ $item['url'] ?? '#' }}" title="{{ $item['title'] ?? '' }}">
                                                    <img src="{{ showImage($item['image'], 'banner_default.jpg') }}"
                                                        data-src="{{ showImage($item['image'], 'banner_default.jpg') }}"
                                                        alt="{{ $item['alt'] ?? '' }}" />
                                                    <span>{{ $item['title'] ?? '' }}</span>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>

                                    <a class="left carousel-control" href="#carousel-{{ $slider->id }}"
                                        data-slide="prev">
                                        <span class="fa fa-chevron-left"></span>
                                    </a>
                                    <a class="right carousel-control" href="#carousel-{{ $slider->id }}"
                                        data-slide="next">
                                        <span class="fa fa-chevron-right"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach


                    {{-- <div class="ws-u-1-2 spot" style="vertical-align: middle">
                        <div class="ws-c">
                            <div id="c67acb8247e4c6" class="carousel slide accessorieTeaserSpot" data-interval="6000"
                                data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="item active">
                                        <a href="/zigarrenzubehoer/feuerzeug?ref=spot" title="Feuerzeuge">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                                data-src="/img/accessories/RBA-Feuerzeuge.jpg" alt="Feuerzeuge" />
                                            <span>Feuerzeuge</span>
                                        </a>
                                    </div>
                                    <div class="item">
                                        <a href="/zigarrenzubehoer/etui?ref=spot" title="Etuis">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                                data-src="/img/accessories/RBA-Etui.jpg" alt="Etuis" />
                                            <span>Etuis</span>
                                        </a>
                                    </div>
                                </div>

                                <a class="left carousel-control" href="#c67acb8247e4c6" data-slide="prev">
                                    <span class="fa fa-chevron-left"></span>
                                </a>
                                <a class="right carousel-control" href="#c67acb8247e4c6" data-slide="next">
                                    <span class="fa fa-chevron-right"></span>
                                </a>
                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class="ws-u-1-2 spot" style="vertical-align: middle">
                        <div class="ws-c">
                            <div class="accessorieTeaserSpot">
                                <div class="item">
                                    <a href="/shop/empfehlung-der-woche/zigarre" title=""
                                        style="
                                            background-image: url('images/15861_53556_129705.jpg');
                                            background-repeat: no-repeat;
                                            background-size: 95% auto;
                                            background-position: center 40%;
                                        ">
                                        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                            data-src="/img/edw-spot.jpg" alt="" style="opacity: 0" />
                                        <span>Empfehlung der Woche</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ws-u-1-2" style="vertical-align: middle">
                        <div class="ws-c">
                            <div class="accessorieTeaserSpot">
                                <div class="item">
                                    <a href="/shop/bestseller/Zigarren">
                                        <img src="images/bestseller-stars-spot.jpg" alt="Bestseller" />
                                        <span>Bestseller</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>

                <div class="ws-g ws-c tabs-left" style="margin-top: 25px">
                    <ul class="ws-u-1 tab-nav tab-nav-amp tab-nav-amp-no-arrow">
                        <li class="active">
                            <a href="#tab-pane-remainder" data-toggle="tab">Restbestände</a>
                        </li>
                        <li>
                            <a href="#tab-pane-discontinued" data-toggle="tab">Auslaufartikel</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div id="tab-pane-remainder" class="ws-u-1 tab-pane remainder active fade in">
                            <div class="ws-g inner">
                                <a class="ws-u-1 item" href="/zigarren/cuba/regulares/cohiba-01002">
                                    <div class="ws-g tab-pane-item">
                                        <div class="ws-u-4-24 image">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                                data-src="/bilder/detail/small/2_13_163115.jpg" alt="Cohiba " />
                                        </div>
                                        <div class="ws-u-15-24 ws-u-md-11-24 content">
                                            <span class="title nobr">Cohiba </span>
                                            <span class="subtitle nobr">Robustos</span>
                                        </div>
                                        <div
                                            class="mobileItemOffset ws-u-14-24 ws-u-sm-14-24 ws-u-md-14-24 ws-u-lg-9-24 ws-u-xl-9-24 price nobr">
                                            <span><span data-eurval="75.50">75.50 €</span></span>
                                        </div>
                                    </div>
                                </a>

                                <a class="ws-u-1 more" href="/shop/restbestand">Weitere Restbestände
                                    anzeigen</a>
                            </div>
                        </div>

                        <div id="tab-pane-discontinued" class="ws-u-1 tab-pane discontinued fade in">
                            <div class="ws-g inner">

                                @foreach ($statusTwoProducts as $sTP)
                                    <a class="ws-u-1 item"
                                        href="{{ route('products', [$sTP->category->slug, $sTP->brand->slug, $sTP->slug . '-' . $sTP->id]) }}">
                                        <div class="ws-g tab-pane-item item-row">
                                            <div class="ws-u-4-24 image">
                                                <img src="{{ showImage($sTP->image) }}"
                                                    data-src="{{ showImage($sTP->image) }}" alt="{{ $sTP->name }}" />
                                            </div>
                                            <div class="ws-u-20-24 ws-u-md-11-24 content">
                                                <span class="title nobr">{{ $sTP->name }}</span>
                                                <span class="subtitle nobr">{{ $sTP->short_description }}</span>
                                            </div>
                                            <div
                                                class="mobileItemOffset ws-u-14-24 ws-u-sm-14-24 ws-u-md-14-24 ws-u-lg-9-24 ws-u-xl-9-24 price nobr">
                                                <span><span
                                                        data-eurval="{{ isDiscounted($sTP) ? $sTP->discount_value : $sTP->price }}">{{ isDiscounted($sTP) ? $sTP->discount_value : $sTP->price }} €</span></span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach

                                <a class="ws-u-1 more" href="/shop/discontinued">zu den Auslaufartikeln</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ws-u-1 ws-u-lg-1-2 rightcol">
                <div class="ws-g ws-c tabs-right">
                    <ul class="ws-u-1 tab-nav tab-nav-amp tab-nav-amp-no-arrow">
                        <li class="active">
                            <a href="#tab-pane-new" data-toggle="tab">Neu</a>
                        </li>
                        <li>
                            <a href="#tab-pane-reduced" data-toggle="tab">Reduziert</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div id="tab-pane-new" class="ws-u-1 tab-pane new active fade in">
                            <div class="ws-g inner">

                                @foreach ($newVariants as $nv)
                                    @php
                                        // Lấy bản ghi priceVariant đầu tiên cho biến thể này
                                        $firstPriceVariant = $nv->priceVariants->first();
                                    @endphp

                                    <a class="ws-u-1 item" href="#">
                                        <div class="ws-g tab-pane-item">
                                            <div class="ws-u-4-24 image">
                                                <img src="{{ showImage($nv->image) }}"
                                                    data-src="{{ showImage($nv->image) }}" alt="{{ $nv->name }}" />
                                            </div>
                                            <div class="ws-u-15-24 ws-u-md-11-24 content">
                                                <span class="title nobr">{{ $nv->name }}</span>
                                                <span class="subtitle nobr">{{ $nv->short_description }}</span>
                                            </div>
                                            <div
                                                class="mobileItemOffset ws-u-14-24 ws-u-sm-14-24 ws-u-md-14-24 ws-u-lg-9-24 ws-u-xl-9-24 price nobr">
                                                @if ($firstPriceVariant && isDiscounted($firstPriceVariant))
                                                    <del class="altpreis"><span data-eurval="12.00"
                                                            data-curiso="USD">{{ $firstPriceVariant->price }}
                                                            €</span></del>
                                                    <span>
                                                        <span data-eurval="{{ $firstPriceVariant->discount_value }}">
                                                            {{ $firstPriceVariant->discount_value }}
                                                            €
                                                        </span>
                                                    </span>
                                                @else
                                                    <!-- Nếu không có giảm giá, hiển thị giá gốc -->
                                                    <span
                                                        data-eurval="{{ $firstPriceVariant->price }}">{{ $firstPriceVariant->price }}
                                                        €</span>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                @endforeach



                                <a class="ws-u-1 more" href="/shop/neu/zigarren">Alle neuen Produkte
                                    anzeigen</a>
                            </div>
                        </div>

                        <div id="tab-pane-reduced" class="ws-u-1 tab-pane reduced fade in">
                            <div class="ws-g inner">
                                @foreach ($discountVariants as $dv)
                                    @php
                                        $discountFirstPrice = $dv->priceVariants->first();
                                    @endphp
                                    <a class="ws-u-1 item"
                                        href="/zigarren/nicaragua/blanco-cigars-nine-{{ $dv->id }}">
                                        <div class="ws-g tab-pane-item item-row">
                                            <div class="ws-u-4-24 image">
                                                <img src="{{ showImage($dv->image) }}"
                                                    data-src="{{ showImage($dv->image) }}" alt="{{ $dv->name }}" />
                                            </div>
                                            <div class="ws-u-20-24 ws-u-md-11-24 content">
                                                <span class="title nobr">{{ $dv->name }}</span>
                                                <span class="subtitle nobr">{{ $dv->short_description }}</span>
                                            </div>
                                            <div
                                                class="mobileItemOffset ws-u-14-24 ws-u-sm-14-24 ws-u-md-14-24 ws-u-lg-9-24 ws-u-xl-9-24 price nobr">

                                                <!-- Nếu có giảm giá, hiển thị giá sau giảm -->
                                                <del class="altpreis"><span
                                                        data-eurval="{{ $discountFirstPrice->price }}"
                                                        data-curiso="USD">{{ $discountFirstPrice->price }}
                                                        €</span></del>
                                                <span>
                                                    <span data-eurval="{{ $discountFirstPrice->discount_value }}">
                                                        {{ $discountFirstPrice->discount_value }}
                                                        €
                                                    </span>
                                                </span>

                                            </div>
                                        </div>
                                    </a>
                                @endforeach



                                <a class="ws-u-1 more" href="/shop/reduzierte-sonderposten/zigarren">Alle
                                    reduzierten Artikel anzeigen</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ws-g ws-c mt-4 contentpage contentpage--twocol contentpage--index">
            <div class="ws-u-1 contentpage__title">
                <h1>
                    {{ $config->intro_title }}
                </h1>
            </div>
            <div class="ws-u-1 contentpage__content">
                {{-- <div class="tableofcontents">
                    <span class="content-nav-title"><i class="fa fa-list-ol"></i> Inhalt:</span>
                    <ul>
                        <li>
                            <a href="#zigarren-bei-rauchr-guenstig-kaufen">Zigarren bei RAUCHR günstig kaufen</a>
                        </li>
                        <li>
                            <a href="#aromatisierte-zigarillos-und-deutsche-klassiker">Aromatisierte Zigarillos
                                und deutsche Klassiker</a>
                        </li>
                        <li>
                            <a href="#pfeifen-und-pfeifentabak-bei-rauchr">Pfeifen und Pfeifentabak bei RAUCHR</a>
                        </li>
                        <li>
                            <a href="#raucherzubehoer-und-service">Raucherzubehör und Service</a>
                        </li>
                    </ul>
                </div> --}}
                <div class="clear">
                    <hr />
                </div>

                {!! $config->introduction !!}
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script>
        document.querySelectorAll(".inner").forEach((item) => {
            const excerpt = item.querySelector(".excerpt");
            const overlay = item.querySelector(".overlay");

            item.addEventListener("mouseenter", () => {
                gsap.to(overlay, {
                    opacity: 1,
                    duration: 0.3,
                    ease: "power2.out"
                });
                gsap.to(excerpt, {
                    y: 0,
                    duration: 0.5,
                    ease: "power2.out"
                });
            });

            item.addEventListener("mouseleave", () => {
                gsap.to(overlay, {
                    opacity: 0,
                    duration: 0.3,
                    ease: "power2.in"
                });
                gsap.to(excerpt, {
                    y: "100%",
                    duration: 0.5,
                    ease: "power2.in"
                });
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .inner {
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .inner img {
            width: 100%;
            height: auto;
            display: block;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Màu đen mờ */
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .excerpt {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            /* Màu nền sáng với độ trong */
            padding: 20px;
            box-sizing: border-box;
            transform: translateY(100%);
            transition: transform 0.5s ease-out;
            max-height: 100%;
            /* Chiều cao không giới hạn */
            overflow-y: auto;
            /* Cho phép cuộn dọc khi nội dung dài */
        }

        .inner:hover .overlay {
            opacity: 1;
        }

        .inner:hover .excerpt {
            transform: translateY(0);
            /* Nội dung xuất hiện từ từ */
        }

        .excerpt::-webkit-scrollbar {
            width: 0px;
            /* Ẩn thanh cuộn */
            background: transparent;
            /* Không có màu nền */
        }

        .excerpt::-webkit-scrollbar-thumb {
            background: transparent;
            /* Không hiển thị thanh cuộn */
        }
    </style>
@endpush
