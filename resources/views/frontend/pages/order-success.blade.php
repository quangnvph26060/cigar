@extends('frontend.layouts.master')

@section('content')
    <div class="ws-container">
        @include('frontend.pages.include.breadcrumb', [
            'data' => ['Information' => route('myInfo'), 'Bestelldetails' => null],
        ])

        <div class="container-custom ">
            <!-- Section 1: Thông báo đặt hàng thành công -->
            <div class="section-1">
                <h1>Đặt Hàng Thành Công!</h1>
                <p class="success-message">Cảm ơn quý khách đã mua sắm tại cửa hàng chúng tôi.</p>
                <p>Mã đơn hàng: #{{ $order->code }}</p>
            </div>

            <!-- Section 2: Thông tin người đặt và đơn hàng -->
            <div class="section-2">
                <div class="box">
                    <h2>Thông Tin Người Đặt</h2>
                    <p><strong>Họ tên:</strong> {{ $order->username }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                    <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
                    <p><strong>Email:</strong> {{ $order->email }}</p>
                </div>
                <div class="box">
                    <h2>Thông Tin Đơn Hàng</h2>
                    <p><strong>Mã đơn hàng:</strong> #{{ $order->code }}</p>
                    <p><strong>Ngày đặt:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</p>
                    <p><strong>Phương thức thanh toán:</strong>
                        {{ $order->payment_method == 'cod' ? 'Thanh toán khi nhận hàng' : 'Thanh toán chuyển khoản' }} </p>
                    <p><strong>Trạng thái: </strong>
                        @switch($order->order_status)
                            @case('pending')
                                Đang xử lý...
                            @break

                            @case('confirmed')
                                Đã xác nhận
                            @break

                            @case('completed')
                                Đã hoàn thành
                            @break

                            @case('cancelled')
                                Đã hủy
                            @break

                            @default
                                Không xác định
                        @endswitch
                    </p>

                </div>
            </div>

            <!-- Section 3: Thông tin sản phẩm và tổng tiền -->
            <div class="section-3">
                <h2>Sản Phẩm Đã Mua</h2>
                <div class="order-items">

                    @foreach ($order->orderDetails as $item)
                        <div class="order-item">
                            <div class="left">
                                <span>{{ $item->p_name }} <small>x{{ $item->p_qty }}</small></span>
                            </div>

                            <div class="right">
                                <span>
                                    @php
                                        $total = getFormattedSubTotal($item->p_price);
                                    @endphp
                                    {{ $total }} $/{{ $item->p_unit }}</span>
                            </div>

                        </div>
                    @endforeach
                </div>
                <div class="total">
                    <p>Tổng số tiền: @php
                        $subTotal = getFormattedSubTotal($order->total_amount);
                    @endphp {{ $subTotal }} $</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .container-custom {
            font-family: 'Times New Roman', serif;
            background-color: #f5e8d3;
            color: #4a2c0f;
            max-width: 900px;
            margin: 0 auto;
            padding: 15px;
            /* Giảm padding cho màn hình nhỏ */
            border: 2px solid #8b5a2b;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1,
        h2 {
            font-family: 'Georgia', serif;
            color: #8b5a2b;
            text-align: center;
            border-bottom: 1px dashed #8b5a2b;
            padding-bottom: 10px;
        }

        /* Section 1 */
        .section-1 {
            text-align: center;
            padding: 15px 0;
            /* Giảm padding cho màn hình nhỏ */
        }

        .success-message {
            font-size: 20px;
            /* Giảm font-size cho màn hình nhỏ */
            font-weight: bold;
        }

        /* Section 2 */
        .section-2 {
            display: flex;
            flex-wrap: wrap;
            /* Cho phép các box xuống dòng khi màn hình nhỏ */
            justify-content: space-between;
            margin: 15px 0;
            /* Giảm margin */
            gap: 10px;
            /* Khoảng cách giữa các box */
        }

        .box {
            width: 100%;
            /* Mặc định full width cho màn hình nhỏ */
            background-color: #fdf6e8;
            padding: 10px;
            /* Giảm padding */
            border: 1px solid #d4a373;
        }

        .box h2 {
            font-size: 16px;
            /* Giảm font-size */
            margin-top: 0;
        }

        /* Section 3 */
        .section-3 {
            margin-top: 15px;
            /* Giảm margin */
        }

        .order-items {
            border: 1px solid #d4a373;
            padding: 10px;
            /* Giảm padding */
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            /* Giảm padding */
            border-bottom: 1px dashed #d4a373;
            flex-wrap: wrap;
            /* Cho phép nội dung xuống dòng nếu cần */
        }

        .total {
            text-align: right;
            font-weight: bold;
            font-size: 16px;
            /* Giảm font-size */
            margin-top: 10px;
        }

        .success-message {
            line-height: 30px
        }

        /* Media Queries cho màn hình lớn hơn */
        @media (min-width: 768px) {
            .container-custom {
                padding: 30px;
                /* Khôi phục padding cho màn hình lớn */
            }

            .section-1 {
                padding: 20px 0;
            }

            .success-message {
                font-size: 24px;
                /* Khôi phục font-size */
            }

            .section-2 {
                flex-wrap: nowrap;
                /* Không xuống dòng trên màn hình lớn */
                margin: 20px 0;
            }

            .box {
                width: 48%;
                /* Trở lại 48% cho màn hình lớn */
                padding: 15px;
            }

            .box h2 {
                font-size: 18px;
                /* Khôi phục font-size */
            }

            .section-3 {
                margin-top: 20px;
            }

            .order-items {
                padding: 15px;
            }

            .order-item {
                padding: 10px 0;
                flex-wrap: nowrap;
                /* Không xuống dòng trên màn hình lớn */
            }

            .total {
                font-size: 18px;
                /* Khôi phục font-size */
            }
        }
    </style>
@endpush
