@extends('frontend.layouts.master')


@section('content')
    <div class="ws-container">
        <div class="ws-g ws-c bigspots">
            <div class="ws-u-1 ws-u-lg-1-2 bigspots-left">
                <div class="inner">
                    <div id="home-carousel" class="carousel slide" data-interval="6000" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach ($sliders as $slider)
                                <li data-target="#home-carousel" data-slide-to="{{ $loop->index }}"
                                    @if ($loop->first) class="active" @endif></li>
                            @endforeach
                        </ol>

                        <div class="carousel-inner">
                            @foreach ($sliders as $slider)
                                <a @if ($slider['url']) target="_blank" @endif
                                    href="{{ $slider['url'] ?? 'javascript:void(0)' }}"
                                    class="item  @if ($loop->first) active @endif">
                                    <img src="{{ showImage($slider['image']) }}"
                                        data-src="{{ showImage($slider['image']) }}" alt="{{ $slider['alt'] }}" />
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
                    <div class="ws-u-1-2 spot-4">
                        <div class="inner">
                            <a href="/content/kubanische-zigarillos?ref=spot">
                                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                    data-src="/img/cuba-cigarillo-spot-128.jpg" alt="Kubanische Zigarillos" />
                                <div class="title">
                                    <span class="nobr">Kubanische Zigarillos</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="ws-u-1-2 spot-5">
                        <div class="inner">
                            <a href="/flor-de-copan?ref=spot">
                                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                    data-src="/img/banner/spot/dfd653a4b8d9d4f136d154d4be78c1c4.jpg" alt="flor de copan" />
                            </a>
                        </div>
                    </div>

                    <div class="ws-u-1-2 spot-2">
                        <div class="inner">
                            <a href="https://www.rauchr.de/content/worldofvegafina?ref=spot?ref=spot">
                                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                    data-src="/img/banner/spot/b3c50f671336312af08438b91db099d8.jpg"
                                    alt="Vega Fina Zigarren" />
                            </a>
                        </div>
                    </div>

                    <div class="ws-u-1-2 spot-3">
                        <div class="inner">
                            <a href="https://www.rauchr.de/domaine-de-lavalette?ref=spot">
                                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                    data-src="/img/banner/spot/b4204c57f8ebe95ff734566e8f216810.jpeg"
                                    alt="domaine-de-lavalette" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ws-g">
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
        </div>


        <div class="ws-g ws-c topbrands">

            @foreach ($brands as $brand)
                <div class="ws-u-1-4 ws-u-lg-1-8 brand">
                    <a href="/#" title="{{ $brand->name }}" class="inner">
                        <img class="logo" src="{{ showImage($brand->image) }}"
                            data-src="{{ showImage($brand->image) }}" alt="{{ $brand->name }}" />
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


                    @foreach ($sliderSmall as $slider)
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

                    <div class="ws-u-1-2 spot" style="vertical-align: middle">
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
                    </div>
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
                                <a class="ws-u-1 item" href="/zigarren/cuba/regulares/trinidad-01021">
                                    <div class="ws-g tab-pane-item">
                                        <div class="ws-u-4-24 image">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                                data-src="/bilder/detail/small/21_28905_34396.jpg" alt="Trinidad " />
                                        </div>
                                        <div class="ws-u-15-24 ws-u-md-11-24 content">
                                            <span class="title nobr">Trinidad </span>
                                            <span class="subtitle nobr">Vigia</span>
                                        </div>
                                        <div
                                            class="mobileItemOffset ws-u-14-24 ws-u-sm-14-24 ws-u-md-14-24 ws-u-lg-9-24 ws-u-xl-9-24 price nobr">
                                            <span><span data-eurval="53.00">53.00 €</span></span>
                                        </div>
                                    </div>
                                </a>
                                <a class="ws-u-1 item"
                                    href="/zigarren/dominikanische-republik/arturo-fuente-hemingway-01101020">
                                    <div class="ws-g tab-pane-item">
                                        <div class="ws-u-4-24 image">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                                data-src="/bilder/detail/small/1552_38417_56640.jpg"
                                                alt="Arturo Fuente Hemingway" />
                                        </div>
                                        <div class="ws-u-15-24 ws-u-md-11-24 content">
                                            <span class="title nobr">Arturo Fuente Hemingway</span>
                                            <span class="subtitle nobr">Between the Lines</span>
                                        </div>
                                        <div
                                            class="mobileItemOffset ws-u-14-24 ws-u-sm-14-24 ws-u-md-14-24 ws-u-lg-9-24 ws-u-xl-9-24 price nobr">
                                            <span><span data-eurval="44.60">44.60 €</span></span>
                                        </div>
                                    </div>
                                </a>

                                <a class="ws-u-1 more" href="/shop/restbestand">Weitere Restbestände
                                    anzeigen</a>
                            </div>
                        </div>

                        <div id="tab-pane-discontinued" class="ws-u-1 tab-pane discontinued fade in">
                            <div class="ws-g inner">
                                <a class="ws-u-1 item" href="/zigarren/dominikanische-republik/ashton-classic-01102">
                                    <div class="ws-g tab-pane-item item-row">
                                        <div class="ws-u-4-24 image">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                                data-src="/bilder/detail/small/25_181_90085.jpg" alt="Ashton Classic" />
                                        </div>
                                        <div class="ws-u-20-24 ws-u-md-11-24 content">
                                            <span class="title nobr">Ashton Classic</span>
                                            <span class="subtitle nobr">Cordial</span>
                                        </div>
                                        <div
                                            class="mobileItemOffset ws-u-14-24 ws-u-sm-14-24 ws-u-md-14-24 ws-u-lg-9-24 ws-u-xl-9-24 price nobr">
                                            <span><span data-eurval="7.60">7.60 €</span></span>
                                        </div>
                                    </div>
                                </a>
                                <a class="ws-u-1 item"
                                    href="/zigarren/dominikanische-republik/ashton-cabinet-no-3-01104_3371">
                                    <div class="ws-g tab-pane-item item-row">
                                        <div class="ws-u-4-24 image">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                                data-src="/bilder/detail/small/1318_3371_21665.jpg"
                                                alt="Ashton Cabinet" />
                                        </div>
                                        <div class="ws-u-20-24 ws-u-md-11-24 content">
                                            <span class="title nobr">Ashton Cabinet</span>
                                            <span class="subtitle nobr">No. 3</span>
                                        </div>
                                        <div
                                            class="mobileItemOffset ws-u-14-24 ws-u-sm-14-24 ws-u-md-14-24 ws-u-lg-9-24 ws-u-xl-9-24 price nobr">
                                            <span><span data-eurval="13.60">13.60 €</span></span>
                                        </div>
                                    </div>
                                </a>
                                <a class="ws-u-1 item" href="/zigarren/dominikanische-republik/don-diego-classic-01105">
                                    <div class="ws-g tab-pane-item item-row">
                                        <div class="ws-u-4-24 image">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                                data-src="/bilder/detail/small/27_204_21727.jpg"
                                                alt="Don Diego Classic" />
                                        </div>
                                        <div class="ws-u-20-24 ws-u-md-11-24 content">
                                            <span class="title nobr">Don Diego Classic</span>
                                            <span class="subtitle nobr">Coronas Major AT</span>
                                        </div>
                                        <div
                                            class="mobileItemOffset ws-u-14-24 ws-u-sm-14-24 ws-u-md-14-24 ws-u-lg-9-24 ws-u-xl-9-24 price nobr">
                                            <span><span data-eurval="7.60">7.60 €</span></span>
                                        </div>
                                    </div>
                                </a>

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
                                <a class="ws-u-1 item" href="/zigarrenzubehoer/cutter/villiger-cutter-90017090">
                                    <div class="ws-g tab-pane-item">
                                        <div class="ws-u-4-24 image">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                                data-src="/bilder/detail/small/16444_59782_164826.jpg"
                                                alt="Villiger Cutter" />
                                        </div>
                                        <div class="ws-u-15-24 ws-u-md-11-24 content">
                                            <span class="title nobr">Villiger Cutter</span>
                                            <span class="subtitle nobr">schwarz, V-Cut mit Logo</span>
                                        </div>
                                        <div
                                            class="mobileItemOffset ws-u-14-24 ws-u-sm-14-24 ws-u-md-14-24 ws-u-lg-9-24 ws-u-xl-9-24 price nobr">
                                            <del class="altpreis"><span data-eurval="8.95">8.95 €</span></del>
                                            <span><span data-eurval="6.95">6.95 €</span></span>
                                        </div>
                                    </div>
                                </a>
                                <a class="ws-u-1 item" href="/zigarrenzubehoer/humidor/passatore-reisehumidor-02001002">
                                    <div class="ws-g tab-pane-item">
                                        <div class="ws-u-4-24 image">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                                data-src="/bilder/detail/small/1573_59781_164810.jpg"
                                                alt="Passatore Reisehumidor" />
                                        </div>
                                        <div class="ws-u-15-24 ws-u-md-11-24 content">
                                            <span class="title nobr">Passatore Reisehumidor</span>
                                            <span class="subtitle nobr">Cigar Case Acryl schwarz für 4 Zigarren
                                                (560808)</span>
                                        </div>
                                        <div
                                            class="mobileItemOffset ws-u-14-24 ws-u-sm-14-24 ws-u-md-14-24 ws-u-lg-9-24 ws-u-xl-9-24 price nobr">
                                            <del class="altpreis"><span data-eurval="22.00">22.00 €</span></del>
                                            <span><span data-eurval="20.90">20.90 €</span></span>
                                        </div>
                                    </div>
                                </a>
                                <a class="ws-u-1 item" href="/zigarren/honduras/rocky-patel-seed-to-smoke-shade-90017075">
                                    <div class="ws-g tab-pane-item">
                                        <div class="ws-u-4-24 image">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                                data-src="/bilder/detail/small/16427_59780_164790.jpg"
                                                alt="Rocky Patel Seed to Smoke Shade" />
                                        </div>
                                        <div class="ws-u-15-24 ws-u-md-11-24 content">
                                            <span class="title nobr">Rocky Patel Seed to Smoke Shade</span>
                                            <span class="subtitle nobr">Toro (Shortfiller)</span>
                                        </div>
                                        <div
                                            class="mobileItemOffset ws-u-14-24 ws-u-sm-14-24 ws-u-md-14-24 ws-u-lg-9-24 ws-u-xl-9-24 price nobr">
                                            <span><span data-eurval="3.40">3.40 €</span></span>
                                        </div>
                                    </div>
                                </a>
                                <a class="ws-u-1 item" href="/zigarrenzubehoer/cutter/adorini-cutter-90010963">
                                    <div class="ws-g tab-pane-item">
                                        <div class="ws-u-4-24 image">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                                data-src="/bilder/detail/small/10461_59779_164803.jpg"
                                                alt="Adorini Cutter" />
                                        </div>
                                        <div class="ws-u-15-24 ws-u-md-11-24 content">
                                            <span class="title nobr">Adorini Cutter</span>
                                            <span class="subtitle nobr">Special Edition Carbon golden
                                                (16328)</span>
                                        </div>
                                        <div
                                            class="mobileItemOffset ws-u-14-24 ws-u-sm-14-24 ws-u-md-14-24 ws-u-lg-9-24 ws-u-xl-9-24 price nobr">
                                            <span><span data-eurval="45.00">45.00 €</span></span>
                                        </div>
                                    </div>
                                </a>
                                <a class="ws-u-1 item" href="/zigarrenzubehoer/cutter/adorini-cutter-90010963">
                                    <div class="ws-g tab-pane-item">
                                        <div class="ws-u-4-24 image">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                                data-src="/bilder/detail/small/10461_59778_164798.jpg"
                                                alt="Adorini Cutter" />
                                        </div>
                                        <div class="ws-u-15-24 ws-u-md-11-24 content">
                                            <span class="title nobr">Adorini Cutter</span>
                                            <span class="subtitle nobr">Special Edition Carbon gunmetal
                                                (16327)</span>
                                        </div>
                                        <div
                                            class="mobileItemOffset ws-u-14-24 ws-u-sm-14-24 ws-u-md-14-24 ws-u-lg-9-24 ws-u-xl-9-24 price nobr">
                                            <span><span data-eurval="45.00">45.00 €</span></span>
                                        </div>
                                    </div>
                                </a>
                                <a class="ws-u-1 item" href="/zigarrenzubehoer/bohrer/st-dupont-double-puncher-90017087">
                                    <div class="ws-g tab-pane-item">
                                        <div class="ws-u-4-24 image">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                                data-src="/bilder/detail/small/16440_59777_164729.jpg"
                                                alt="S.T. Dupont Double Puncher" />
                                        </div>
                                        <div class="ws-u-15-24 ws-u-md-11-24 content">
                                            <span class="title nobr">S.T. Dupont Double Puncher</span>
                                            <span class="subtitle nobr">schwarz/golden (003282P)</span>
                                        </div>
                                        <div
                                            class="mobileItemOffset ws-u-14-24 ws-u-sm-14-24 ws-u-md-14-24 ws-u-lg-9-24 ws-u-xl-9-24 price nobr">
                                            <span><span data-eurval="230.00">230.00 €</span></span>
                                        </div>
                                    </div>
                                </a>
                                <a class="ws-u-1 item" href="/zigarrenzubehoer/bohrer/st-dupont-double-puncher-90017087">
                                    <div class="ws-g tab-pane-item">
                                        <div class="ws-u-4-24 image">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                                data-src="/bilder/detail/small/16440_59776_164726.jpg"
                                                alt="S.T. Dupont Double Puncher" />
                                        </div>
                                        <div class="ws-u-15-24 ws-u-md-11-24 content">
                                            <span class="title nobr">S.T. Dupont Double Puncher</span>
                                            <span class="subtitle nobr">schwarz (003281P)</span>
                                        </div>
                                        <div
                                            class="mobileItemOffset ws-u-14-24 ws-u-sm-14-24 ws-u-md-14-24 ws-u-lg-9-24 ws-u-xl-9-24 price nobr">
                                            <span><span data-eurval="230.00">230.00 €</span></span>
                                        </div>
                                    </div>
                                </a>

                                <a class="ws-u-1 more" href="/shop/neu/zigarren">Alle neuen Produkte
                                    anzeigen</a>
                            </div>
                        </div>

                        <div id="tab-pane-reduced" class="ws-u-1 tab-pane reduced fade in">
                            <div class="ws-g inner">
                                <a class="ws-u-1 item" href="/zigarren/nicaragua/blanco-cigars-nine-90008812">
                                    <div class="ws-g tab-pane-item item-row">
                                        <div class="ws-u-4-24 image">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                                data-src="/bilder/detail/small/8653_40981_69342.jpg"
                                                alt="Blanco Cigars Nine" />
                                        </div>
                                        <div class="ws-u-20-24 ws-u-md-11-24 content">
                                            <span class="title nobr">Blanco Cigars Nine</span>
                                            <span class="subtitle nobr">Lancero</span>
                                        </div>
                                        <div
                                            class="mobileItemOffset ws-u-14-24 ws-u-sm-14-24 ws-u-md-14-24 ws-u-lg-9-24 ws-u-xl-9-24 price nobr">
                                            <del class="altpreis"><span data-eurval="7.90">7.90 €</span></del>
                                            <span><span data-eurval="6.50">6.50 €</span></span>
                                        </div>
                                    </div>
                                </a>
                                <a class="ws-u-1 item"
                                    href="/zigarren/dominikanische-republik/kristoff-gc-signature-series-90013403">
                                    <div class="ws-g tab-pane-item item-row">
                                        <div class="ws-u-4-24 image">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                                data-src="/bilder/detail/small/12627_27763_58275.jpg"
                                                alt="Kristoff GC Signature Series" />
                                        </div>
                                        <div class="ws-u-20-24 ws-u-md-11-24 content">
                                            <span class="title nobr">Kristoff GC Signature Series</span>
                                            <span class="subtitle nobr">GC Robusto</span>
                                        </div>
                                        <div
                                            class="mobileItemOffset ws-u-14-24 ws-u-sm-14-24 ws-u-md-14-24 ws-u-lg-9-24 ws-u-xl-9-24 price nobr">
                                            <del class="altpreis"><span data-eurval="9.50">9.50 €</span></del>
                                            <span><span data-eurval="8.50">8.50 €</span></span>
                                        </div>
                                    </div>
                                </a>
                                <a class="ws-u-1 item" href="/zigarren/nicaragua/horacio-classic-90015167">
                                    <div class="ws-g tab-pane-item item-row">
                                        <div class="ws-u-4-24 image">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                                data-src="/bilder/detail/small/14454_38206_55742.jpg"
                                                alt="Horacio Classic" />
                                        </div>
                                        <div class="ws-u-20-24 ws-u-md-11-24 content">
                                            <span class="title nobr">Horacio Classic</span>
                                            <span class="subtitle nobr">No. 5</span>
                                        </div>
                                        <div
                                            class="mobileItemOffset ws-u-14-24 ws-u-sm-14-24 ws-u-md-14-24 ws-u-lg-9-24 ws-u-xl-9-24 price nobr">
                                            <del class="altpreis"><span data-eurval="8.90">8.90 €</span></del>
                                            <span><span data-eurval="7.50">7.50 €</span></span>
                                        </div>
                                    </div>
                                </a>
                                <a class="ws-u-1 item" href="/zigarren/panama/colon-vintage-2001-90004606">
                                    <div class="ws-g tab-pane-item item-row">
                                        <div class="ws-u-4-24 image">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                                data-src="/bilder/detail/small/5282_13426_105848.jpg"
                                                alt="Colon Vintage 2001" />
                                        </div>
                                        <div class="ws-u-20-24 ws-u-md-11-24 content">
                                            <span class="title nobr">Colon Vintage 2001</span>
                                            <span class="subtitle nobr">Doble Perfecto</span>
                                        </div>
                                        <div
                                            class="mobileItemOffset ws-u-14-24 ws-u-sm-14-24 ws-u-md-14-24 ws-u-lg-9-24 ws-u-xl-9-24 price nobr">
                                            <del class="altpreis"><span data-eurval="42.20">42.20 €</span></del>
                                            <span><span data-eurval="28.00">28.00 €</span></span>
                                        </div>
                                    </div>
                                </a>
                                <a class="ws-u-1 item" href="/zigarren/dominikanische-republik/baron-ullmann-90006477">
                                    <div class="ws-g tab-pane-item item-row">
                                        <div class="ws-u-4-24 image">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                                data-src="/bilder/detail/small/15887.jpg" alt="Baron Ullmann " />
                                        </div>
                                        <div class="ws-u-20-24 ws-u-md-11-24 content">
                                            <span class="title nobr">Baron Ullmann </span>
                                            <span class="subtitle nobr">Lanceros</span>
                                        </div>
                                        <div
                                            class="mobileItemOffset ws-u-14-24 ws-u-sm-14-24 ws-u-md-14-24 ws-u-lg-9-24 ws-u-xl-9-24 price nobr">
                                            <del class="altpreis"><span data-eurval="16.00">16.00 €</span></del>
                                            <span><span data-eurval="6.90">6.90 €</span></span>
                                        </div>
                                    </div>
                                </a>
                                <a class="ws-u-1 item" href="/zigarren/nicaragua/fratello-classico-90014862">
                                    <div class="ws-g tab-pane-item item-row">
                                        <div class="ws-u-4-24 image">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                                data-src="/bilder/detail/small/14127_35964_47405.jpg"
                                                alt="Fratello Classico" />
                                        </div>
                                        <div class="ws-u-20-24 ws-u-md-11-24 content">
                                            <span class="title nobr">Fratello Classico</span>
                                            <span class="subtitle nobr">Corona 5.5x46</span>
                                        </div>
                                        <div
                                            class="mobileItemOffset ws-u-14-24 ws-u-sm-14-24 ws-u-md-14-24 ws-u-lg-9-24 ws-u-xl-9-24 price nobr">
                                            <del class="altpreis"><span data-eurval="7.90">7.90 €</span></del>
                                            <span><span data-eurval="6.50">6.50 €</span></span>
                                        </div>
                                    </div>
                                </a>
                                <a class="ws-u-1 item"
                                    href="/zigarren/dominikanische-republik/smoking-jacket-by-hendrik-kelner-jr-90014856">
                                    <div class="ws-g tab-pane-item item-row">
                                        <div class="ws-u-4-24 image">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                                data-src="/bilder/detail/small/14121_35931_47285.jpg"
                                                alt="Smoking Jacket by Hendrik Kelner Jr." />
                                        </div>
                                        <div class="ws-u-20-24 ws-u-md-11-24 content">
                                            <span class="title nobr">Smoking Jacket by Hendrik Kelner Jr.</span>
                                            <span class="subtitle nobr">Red Label Favoritos</span>
                                        </div>
                                        <div
                                            class="mobileItemOffset ws-u-14-24 ws-u-sm-14-24 ws-u-md-14-24 ws-u-lg-9-24 ws-u-xl-9-24 price nobr">
                                            <del class="altpreis"><span data-eurval="10.50">10.50 €</span></del>
                                            <span><span data-eurval="8.50">8.50 €</span></span>
                                        </div>
                                    </div>
                                </a>

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

                {!! $config->introduction  !!}
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
