<!DOCTYPE html>
<html lang="de">

<head>
    @include('frontend.layouts.partials.meta')

    <title>Zigarillos, Zigarren & Pfeifen günstig kaufen | Rauchr.de</title>

    @include('frontend.layouts.partials.style')
</head>

<body class="f-default a-content v-index shadow-1">
    <div class="mhead d-block d-lg-none">
        <div class="ws-container">
            <div class="ws-g mhead-row mhead-row--a px-2 px-sm-3 py-0 py-md-1">
                <div class="ws-u-9-24 ws-u-sm-8-24 ws-u-md-6-24 mhead__col mhead__col--logo">
                    <a href="/" class="mhead__link d-block py-1" title="Startseite">
                        <img src="{{ showImage($config->logo) }}" alt="Rauchr logo" class="mhead__logo" />
                    </a>
                </div>

                <div class="ws-u-15-24 ws-u-sm-16-24 ws-u-md-18-24 mhead__col mhead__col--links text-right">
                    <a href="/service/regional_settings"
                        class="mhead__link mhead__link--regional js-modal-regional-settings"
                        title="Regionale Einstellungen">
                        <span class="mhead__regional-text"> DE · € </span>
                        <span class="mhead__regional-flag mhead__regional-flag--de"
                            style="background-image: url(images/de.png)"> </span>
                    </a>
                    <a href="/meinkonto" class="mhead__link" title="Mein Konto">
                        <i class="fa fa fa-user fa-fw mhead__icon"></i>
                        <span class="mhead__badge mhead__badge--login-status" data-login-status="0"></span>
                    </a>
                    <a href="/warenkorb/show" class="mhead__link" title="Warenkorb">
                        <i class="fa fa-shopping-bag fa-fw mhead__icon"></i>
                        <span class="mhead__badge" data-badge-count="0">0</span>
                    </a>
                </div>
            </div>

            <div class="ws-g mhead-row mhead-row--b px-2 pb-2 pt-1 py-sm-3 pb-md-3 pt-md-2">
                <div class="ws-u-0 ws-u-md-7-24 mhead__col mhead__col--links">
                    <a href="/Pfeifenshop" class="mhead__text" title="Pfeifenshop">Pfeifenshop</a>
                </div>
                <div class="ws-u-21-24 ws-u-md-10-24 mhead__col">
                    <div class="mhead__search">
                        <div class="mhead__search-box">
                            <form id="cw-search-m" class="mhead__search-form" method="get" action="/shop/suche">
                                <span class="mhead__search-icon"><i class="fa fa-search"></i></span>
                                <input id="cw-searchterm-m" type="text" class="mhead__search-input" name="suchterms"
                                    placeholder="Suche" value="" autocomplete="off" />
                            </form>
                        </div>
                    </div>
                </div>
                <div class="ws-u-3-24 ws-u-md-7-24 mhead__col mhead__col--links text-right">
                    <a href="#mmenu" class="mhead__link" title="Kategorien">
                        <span class="mhead__text d-none d-md-inline-block">Kategorien</span>
                        <i class="fa fa-bars fa-fw mhead__icon"></i>
                    </a>
                </div>
            </div>
        </div>
        <div id="cw-suggestions-m" class="cw-suggestions"></div>
    </div>

    <div class="mnav">
        @include('frontend.layouts.partials.menu_mobile')
    </div>

    <header class="dhead full-header d-none d-lg-block">
        @include('frontend.layouts.partials.header')
    </header>

    <nav class="dnav full-nav">
        @include('frontend.layouts.partials.menu_desktop')
    </nav>

    <main class="main">
        @yield('content')
    </main>

    <footer class="footer">
        @include('frontend.layouts.partials.footer')
    </footer>

    <div class="cart-notification" id="cartNotification">
        <button class="close-btn" onclick="hideNotification()">×</button>
        <h4>Giỏ hàng</h4>
        <div class="product-info">
            <span><strong>Áo Sơ Mi</strong></span>
            <span>150.000đ x 1</span>
        </div>
        <a href="/cart" class="view-cart">Xem giỏ hàng</a>
    </div>


    {{-- <script type="application/ld+json">
			[
				{
					"@context": "http://schema.org",
					"@type": "WebSite",
					"url": "https://www.rauchr.de",
					"potentialAction": {
						"@type": "SearchAction",
						"target": "https://www.rauchr.de/shop/suche?suchterms={search_term}",
						"query-input": "required name=search_term"
					}
				}
			]
		</script> --}}


    @include('frontend.layouts.partials.script')

</body>

</html>
