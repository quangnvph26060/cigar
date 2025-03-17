@extends('frontend.layouts.master')

@section('content')
    <div class="ws-container">

        @php
            $data = [];
            $data['Warenkorb'] = null;
        @endphp

        @include('frontend.pages.include.breadcrumb', [
            'data' => $data,
        ])



        <div class="ws-g ws-c">
            <div class="ws-u-1">
                <div class="article" id="warenkorbpage">
                    <div class="wrapper">
                        <article>
                            <h1>Ihr Warenkorb</h1>
                            @if (Cart::instance('shopping')->count() > 0)
                                <div class="tencol">
                                    <div class="wrapper ">
                                        <p style="text-align: right;" class="shoppingcart__buttons">
                                            <a href="{{ route('checkout') }}"
                                                class="ws-button ws-button-checkout ws-button-md shoppingcart__button-proceed">
                                                Zur Kasse &nbsp; <i class="fa fa-angle-right"></i></a>
                                        </p>
                                    </div>
                                </div>
                                <div class="section tencol" id="warenkorblist" style="margin-bottom:0;">
                                    <div class="wrapper ">
                                        <section>
                                            <ul class="sort-by nomobile">
                                                <li class="sort fivecol asc" data-sort="wkartikel">Artikel</li>
                                                <li class="sort onecol" data-sort="wksortanzahl">Anzahl</li>
                                                <li class="onecol"></li>
                                                <li class="sort onecol" data-sort="wkeinzelpreis">Einzelpreis</li>
                                                <li class="sort twocol" data-sort="wkgesamtpreis">Gesamtpreis</li>
                                                <div class="clear">
                                                    <hr>
                                                </div>
                                            </ul>


                                            <ul class="list" id="warenkorblist">
                                                @foreach ($carts as $cart)
                                                    <li class="tencol">
                                                        <div class="wrapper">
                                                            <a href="{{ $cart->options->slug }}"
                                                                class="twocol produktbildlink" style="text-align: center;">
                                                                <img src="{{ showImage($cart->options->image) }}"
                                                                    class="produktbild" alt="Churchill">
                                                            </a>

                                                            <div class="wkitemdescription threecol">
                                                                <a href="{{ $cart->options->slug }}"
                                                                    class="wkartikel">{{ $cart->name }}</a>
                                                                <br>{{ $cart->options->unit }}<br>
                                                            </div>
                                                            <div class="fivecol anzahlpreisbox">
                                                                <div class="wrapper">
                                                                    <div class="onecol anzahlbox">
                                                                        <span class="hidden wksortanzahl">1</span>
                                                                        <p>
                                                                            <label
                                                                                for="wk_update_38ed74e9ab43c7132c4914f21792ab57a277f04f"
                                                                                class="mobile">Anzahl</label>
                                                                            <input type="hidden" name="rowId"
                                                                                value="{{ $cart->rowId }}">
                                                                            <input type="number" name="qty"
                                                                                id="wk_update_38ed74e9ab43c7132c4914f21792ab57a277f04f"
                                                                                value="{{ $cart->qty }}"
                                                                                class="wkanzahl">
                                                                        </p>
                                                                        <p>
                                                                            <button type="button" class="wkrefreshbutton"
                                                                                title="Warenkorb aktualisieren"><span>Warenkorb
                                                                                    aktualisieren</span></button>
                                                                            <a href="?wk_remove={{ $cart->rowId }}"
                                                                                class="wkdeletebutton"
                                                                                title="{{ $cart->name }}"><span>{{ $cart->name }}</span></a>
                                                                        </p>
                                                                    </div>

                                                                    <div class="onecol spezialicon">
                                                                    </div>

                                                                    <div class="onecol wkeinzelpreis">

                                                                        <span class="mobile">Einzelpreis:</span>
                                                                        <span class="preis"><span data-eurval="2.90"
                                                                                data-curiso="USD">{{ $cart->price }}
                                                                                $</span></span>
                                                                        <br class="mobile">

                                                                    </div>

                                                                    <div class="twocol wkgesamtpreis">

                                                                        <span class="mobile onecol">Gesamtpreis:</span>
                                                                        <span class="onecol">
                                                                            <span data-eurval="2.90"
                                                                                data-curiso="USD">{{ $cart->price * $cart->qty }}
                                                                                $</span>
                                                                        </span>

                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class="clear">
                                                                <hr>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>




                                            <div class="clear">
                                                <hr>
                                            </div>
                                        </section>
                                    </div>
                                </div>

                                <div class="section tencol explanation js-calc-total" id="wksummenbox">
                                    <div class="wrapper ">
                                        <section>
                                            <div class="fourcol">

                                            </div>

                                            <div class="twocol hint-coupon">

                                            </div>

                                            <div class="fourcol">
                                                <div class="wrapper ">


                                                    <div class="twocol wksummen wksummenfett nomobile"
                                                        style="text-align: right;">
                                                        <div> Gesamtwert:
                                                        </div>
                                                    </div>
                                                    <div class="twocol wkout">
                                                        <div class="wrapper ">
                                                            <div class="onecol mobile">
                                                                <div> Gesamtwert:
                                                                </div>
                                                            </div>
                                                            <div class="onecol wksummen wksummenfett">
                                                                <div> <span
                                                                        data-eurval="{{ Cart::instance('shopping')->subTotal() }}"
                                                                        data-curiso="USD">{{ Cart::instance('shopping')->subTotal() }}
                                                                        $</span> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clear">
                                                        <hr>
                                                    </div>
                                                </div>
                                            </div>

                                            <style>
                                                .js-is-loading {
                                                    opacity: 0.25;
                                                    pointer-events: none;
                                                }

                                                .calc-shipping {
                                                    padding-left: 10px;
                                                    margin-left: 10px;
                                                    padding: 15px;
                                                    background: #f2f2f2;
                                                }

                                                .calc-shipping-title {
                                                    display: block;
                                                    font-weight: bold;
                                                    margin-bottom: 0.5em;
                                                }

                                                .calc-shipping-row {
                                                    margin-bottom: 0.5em;
                                                }

                                                .calc-shipping-row:last-child {
                                                    margin-bottom: 0;
                                                }

                                                .calc-shipping-row label {
                                                    font-weight: bold;
                                                }

                                                .calc-shipping-row select {
                                                    width: 100%;
                                                }

                                                .calc-shipping-row input[type="radio"]+span {
                                                    vertical-align: middle;
                                                }

                                                .calc-shipping-row input[type="radio"] {
                                                    vertical-align: middle;
                                                    margin-top: -1px;
                                                }

                                                .calc-shipping-row ul {
                                                    margin: 0;
                                                }
                                            </style>

                                            <div class="clear">
                                                <hr>
                                            </div>
                                        </section>
                                    </div>
                                </div>

                                <div class="tencol">
                                    <div class="wrapper ">
                                        <p class="shoppingcart__buttons">
                                            <a href="?clear" class="ws-button ws-button-md shoppingcart__button-clear"
                                                style="float:left;">
                                                <i class="fa fa-trash-o"></i> &nbsp; Warenkorb leeren </a>
                                            <a href="{{ route('checkout') }}"
                                                class="ws-button ws-button-checkout ws-button-md shoppingcart__button-proceed"
                                                style="float:right;"> Zur Kasse &nbsp; <i
                                                    class="fa fa-angle-right"></i></a>
                                        </p>
                                    </div>
                                </div>

                                <div class="clear">
                                    <hr>
                                </div>
                            @else
                                <p class="warning tencol">Ihr Warenkorb ist leer!</p>
                            @endif

                            {{-- <p>
                                <a href="/shop/index" class="StandardButton">Kaufen Sie bald weiter</a>
                            </p> --}}
                        </article>
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
            $(document).on('click', '.wkrefreshbutton', function() {
                // Lấy thẻ <li> bao quanh nút vừa bấm
                var li = $(this).closest('li');

                // Lấy giá trị của ô input có name="rowId" và "qty"
                var rowId = li.find('input[name="rowId"]').val();
                var qty = li.find('input[name="qty"]').val();

                // Gửi dữ liệu qua AJAX để cập nhật giỏ hàng
                $.ajax({
                    url: '/update-cart', // Địa chỉ API của bạn
                    type: 'POST',
                    data: {
                        rowId: rowId,
                        qty: qty
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.reload();
                        } else {
                            alert('Lỗi trong quá trình cập nhật giỏ hàng');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Lỗi AJAX:', error);
                        alert('Có lỗi xảy ra khi cập nhật giỏ hàng');
                    }
                });
            });
        });
    </script>
@endpush
