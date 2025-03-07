<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Hóa đơn</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 20px;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .info-table,
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 5px;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .total {
            text-align: right;
            font-weight: bold;
        }

        .qr-code {
            float: right;
            margin-left: 20px;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <div class="header">
            <h1>HÓA ĐƠN BÁN HÀNG</h1>
            <p>Số: {{ $order->code }}</p>
        </div>

        <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code" class="qr-code" style="width: 100px;">

        <table class="info-table">
            <tr>
                <td><strong>Ngày:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td><strong>Khách hàng:</strong> {{ $order->username }}</td>
            </tr>
            <tr>
                <td><strong>Địa chỉ:</strong> {{ $order->address }}</td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderDetails as $item)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $item->p_name }} <small>x {{ $item->p_qty }}</small></td>
                        <td>{{ getFormattedSubTotal($item->p_price) }} $ / {{ $item->p_unit }}</td>
                        <td>{{ getFormattedSubTotal($item->p_price * $item->p_qty) }} $</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            <p>Tổng cộng: {{ getFormattedSubTotal($order->total_amount) }} $</p>
        </div>
    </div>
</body>

</html>
