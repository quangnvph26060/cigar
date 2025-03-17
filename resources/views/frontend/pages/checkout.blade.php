@extends('frontend.layouts.master')


@section('content')
    <form action="" method="post">
        @csrf
        <div class="ws-container">
            <div id="content" class="default normal">

                @php
                    $data = [];
                    $data['Warenkorb'] = route('cartList');

                    $data['zahlen'] = null;
                @endphp

                @include('frontend.pages.include.breadcrumb', [
                    'data' => $data,
                ])


                @if ($errors->any())
                    <div class="ws-g ws-c notice">
                        <div class="ws-u-1 notice-error"><i class="notice-icon fa fa-exclamation-triangle"></i><span
                                class="notice-text">{{ $errors->first() }}</span></div>
                    </div>
                @endif


                <div class="container-custom">
                    <!-- Biểu mẫu thanh toán -->
                    <div class="payment-details">
                        <h2>
                            Zahlungsdetails
                        </h2>
                        <div class="form-group">
                            <label for="username">
                                Vollständiger Name <span>*</span></label>
                            <input type="text" id="username" name="username" value="{{ old('username') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">
                                Telefonnummer <span>*</span></label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Standort <span>*</span></label>
                            <input type="text" id="address" name="address" value="{{ old('address') }}" required
                                placeholder="Geben Sie Ihren Standort ein...">
                        </div>
                        <div class="form-group">
                            <label for="email">Email <span>*</span></label>
                            <input type="email" id="email" name="email"
                                value="{{ old('email', 'dnguyentien145@gmail.com') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="notes">Weitere Informationen</label>
                            <textarea id="notes" name="notes" placeholder="Bestellhinweise (optional)">{{ old('notes') }}</textarea>
                        </div>
                    </div>


                    <!-- Đơn hàng của bạn -->
                    <div class="order-summary">
                        <h2>
                            Ihre Bestellung</h2>
                        <div class="order-item">
                            <span>Produkt</span>
                            <span>Gesamt</span>
                        </div>
                        @foreach ($carts as $cart)
                            <div class="order-product">
                                <span>{{ $cart->name }} × {{ $cart->qty }}</span>
                                <span>{{ getFormattedSubTotal($cart->price) }} $</span>
                            </div>
                        @endforeach

                        <div class="order-total">
                            <span>Gesamt</span>
                            @php
                                $subTotal = Cart::instance('shopping')->subTotal();
                                $formattedTotal = getFormattedSubTotal(str_replace(',', '', $subTotal));
                            @endphp
                            <span>{{ $formattedTotal }} $</span>

                        </div>

                        <div class="payment-method">
                            <h2>
                                Zahlungsart</h2>
                            @foreach ($paymentMethods as $pm)
                                <label>
                                    <input type="radio" name="payment_method" value="{{ $pm->type }}"
                                        {{ $loop->first ? 'checked' : '' }}>
                                    {{ $pm->name }}
                                </label>
                            @endforeach

                        </div>

                        <button class="submit-btn">Befehl</button>
                    </div>
                </div>

                <div class="ws-container">
                    <div class="modal fade modal-regional-settings" id="modal_regional_settings" tabindex="-1"
                        role="dialog" aria-labelledby="modal_regional_settings_label">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-body">loading...</div>
                            </div>
                        </div>
                    </div>
                </div>
    </form>
@endsection

@push('styles')
    <style>
        .order-product {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .container-custom {
            display: flex;
            gap: 20px;
            width: 100%;
            align-items: flex-start;
        }

        .payment-details,
        .order-summary {
            background-color: white;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            flex: 1;
        }

        .payment-details {
            flex: 65;
            min-width: 0;
        }

        .order-summary {
            flex: 35;
            border: 2px solid #801f1f;
            min-height: 0;
        }

        h2 {
            font-size: 18px;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .form-group label span {
            color: rgb(119, 30, 30);
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .order-item,
        .order-total {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .order-total {
            font-weight: bold;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .payment-method {
            margin: 20px 0;
        }

        .payment-method label {
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .submit-btn {
            background-color: #2a4d69;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            text-transform: uppercase;
        }

        .submit-btn:hover {
            background-color: #1e3a5f;
        }

        /* Responsive Design */
        @media (max-width: 768px) {

            /* Tablet */
            .container-custom {
                flex-direction: row;
                /* Vẫn giữ 2 cột */
                gap: 15px;
                /* Giảm khoảng cách */
            }

            .payment-details,
            .order-summary {
                padding: 15px;
                /* Giảm padding */
            }

            h2 {
                font-size: 16px;
                /* Giảm kích thước tiêu đề */
            }

            .form-group input,
            .form-group select,
            .form-group textarea {
                font-size: 13px;
                /* Giảm kích thước chữ */
            }

            .submit-btn {
                font-size: 14px;
                /* Giảm kích thước chữ nút */
                padding: 8px 15px;
            }
        }

        @media (max-width: 480px) {

            /* Mobile */
            .container-custom {
                flex-direction: column;
                /* Chuyển sang 1 cột */
                gap: 10px;
                /* Giảm khoảng cách */
            }

            .payment-details,
            .order-summary {
                width: 100%;
                /* Chiếm toàn bộ chiều rộng */
                padding: 10px;
                /* Giảm padding */
            }

            h2 {
                font-size: 14px;
                /* Giảm kích thước tiêu đề */
            }

            .form-group input,
            .form-group select,
            .form-group textarea {
                font-size: 12px;
                /* Giảm kích thước chữ */
            }

            .order-product,
            .order-item,
            .order-total {
                font-size: 12px;
                /* Giảm kích thước chữ */
            }

            .submit-btn {
                font-size: 13px;
                /* Giảm kích thước chữ nút */
                padding: 8px 10px;
            }

            .payment-method label {
                font-size: 12px;
                /* Giảm kích thước chữ */
            }
        }
    </style>
@endpush
