<div class="ws-container">
    <div class="ws-g ws-c">
        <div class="ws-u-8-24 ws-u-xl-4-24 logo">
            <a href="/">
                <img src="{{ showImage($config->logo) }}" width="492" height="104" alt="Rauchr logo" />
            </a>
        </div>
        <div class="ws-u-0 ws-u-xl-10-24"> </div>
        <div class="ws-u-16-24 ws-u-xl-10-24 content">
            <div class="ws-g">
                <div class="ws-u-14-24 ws-u-xl-13-24 lang-contact">
                    <div class="ws-g">
                        <div class="ws-u-1"> </div>

                        <div class="ws-u-1 contact">
                            <span class="title">Tel.:</span>
                            <a href="tel:{{ preg_replace('/\D/', '', $config->hotline) }}q"
                                class="tel">{{ $config->hotline }}</a>
                        </div>
                    </div>
                </div>

                <div class="ws-u-5-24 ws-u-xl-5-24 login">
                    <a href="{{ auth()->check() ? '#' : route('login') }}" class="Login {{ auth()->check() ? 'is-logger' : '' }}">
                        <i class="fa fa-user"></i>
                        <span class="text nobr">{{ auth()->check() ? auth()->user()->name : 'Anmelden' }}</span>
                    </a>
                </div>

                {{-- <div class="popover MyaccountPopover bottom in" role="tooltip" id="popover142377">
                        <div class="arrow" style="left: 50%;"></div>
                        <h3 class="popover-title" style="display: none;"></h3>
                        <div class="popover-content">
                            <div class="ws-g myaccount-popover">
                                <a class="ws-u-1 item" href="/meinkonto">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">Tài khoản của tôi</font>
                                    </font>
                                </a>
                                <a class="ws-u-1 item" href="/meinkonto/bestellungen">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">đơn đặt hàng</font>
                                    </font>
                                </a>
                                <a class="ws-u-1 item" href="/meinkonto/einstellungen">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">dữ liệu người dùng</font>
                                    </font>
                                </a>
                                <a class="ws-u-1 item" href="/meinkonto/merkliste">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">danh sách theo dõi</font>
                                    </font>
                                </a>
                                <a class="ws-u-1 item item-logout" href="/meinkonto/logout">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">Đăng xuất</font>
                                    </font>
                                </a>
                            </div>
                        </div>
                    </div> --}}
                <div class="ws-u-5-24 ws-u-xl-6-24 cart">
                    <a href="/warenkorb/show">
                        <i class="fa fa-shopping-bag"></i>
                        <span class="text nobr">Warenkorb ({{ Cart::instance('shopping')->count() }})</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
