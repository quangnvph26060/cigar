@extends('frontend.layouts.master')

@section('content')
    <div class="ws-container">
        @include('frontend.pages.include.breadcrumb', [
            'data' => ['Information' =>  null],
        ])

        <div class="container-custom">
            <div class="left-menu">
                <ul style="padding-left: 0;">
                    <li><a href="javascript:void(0)" onclick="loadPage('account')" class="active">Thông tin tài khoản</a>
                    </li>
                    <li><a href="javascript:void(0)" onclick="loadPage('orders')">Đơn hàng của tôi</a></li>
                </ul>
            </div>
            <div class="right-content" id="content">
                <h2>Thông Tin Tài Khoản</h2>
                <form id="accountForm" onsubmit="submitForm(event)">
                    <div class="form-group">
                        <label for="name">Họ tên:</label>
                        <input type="text" id="name" name="name" value="{{ auth()->user()->name }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="{{ auth()->user()->email }}">
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại:</label>
                        <input type="text" id="phone" name="phone" value="{{ auth()->user()->phone }}">
                    </div>
                    <button type="submit" class="submit-btn">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .container-custom {
            background: #e6d8ad;
            color: #333;
            display: flex;
            min-height: 100vh;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
            gap: 20px;
        }

        .left-menu {
            flex: 1;
            background: #f5f1e3;
            padding: 20px;
            border: 2px solid #8b4513;
            border-radius: 5px;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .left-menu ul {
            list-style: none;
        }

        .left-menu ul li {
            margin: 15px 0;
        }

        .left-menu ul li a {
            text-decoration: none;
            color: #8b4513;
            font-weight: bold;
            font-size: 18px;
            padding: 10px;
            display: block;
            border: 1px solid #8b4513;
            border-radius: 3px;
            background: #fffaf0;
            transition: all 0.3s ease;
        }

        .left-menu ul li a:hover,
        .left-menu ul li a.active {
            background: #8b4513;
            color: #fffaf0;
        }

        .right-content {
            flex: 3;
            background: #fffaf0;
            padding: 30px;
            border: 2px solid #8b4513;
            border-radius: 5px;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .right-content h2 {
            margin-bottom: 20px;
            color: #8b4513;
            font-size: 28px;
            border-bottom: 2px dotted #8b4513;
            padding-bottom: 10px;
        }

        /* Form styles */
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #8b4513;
            border-radius: 3px;
            background: #f5f1e3;
            font-size: 16px;
        }

        .submit-btn {
            background: #8b4513;
            color: #fffaf0;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease;
        }

        .submit-btn:hover {
            background: #6b3410;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #8b4513;
            padding: 10px;
            text-align: left;
        }

        table th {
            background: #f5f1e3;
            color: #8b4513;
            font-weight: bold;
        }

        table td {
            background: #fffaf0;
            color: #555;
        }

        table td p {
            margin-bottom: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                padding: 10px;
            }

            .left-menu,
            .right-content {
                width: 100%;
            }

            .left-menu ul li a {
                font-size: 16px;
                padding: 8px;
            }

            .form-group {
                flex-direction: column;
                gap: 0;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        var orders = @json($user->orders);

        function loadPage(page) {
            const content = document.getElementById('content');
            const links = document.querySelectorAll('.left-menu ul li a');

            // Xóa class 'active' khỏi tất cả link
            links.forEach(link => link.classList.remove('active'));

            // Thêm class 'active' cho link được nhấp
            event.target.classList.add('active');

            if (page === 'account') {
                content.innerHTML = `
            <h2>Thông Tin Tài Khoản</h2>
            <form id="accountForm" onsubmit="submitForm(event)">
                <div class="form-group">
                    <label for="name">Họ tên:</label>
                    <input type="text" id="name" name="name" value="{{ auth()->user()->name }}">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="{{ auth()->user()->email }}">
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại:</label>
                    <input type="text" id="phone" name="phone" value="{{ auth()->user()->phone }}">
                </div>
                <button type="submit" class="submit-btn">Cập nhật</button>
            </form>
        `;
            } else if (page === 'orders') {
                let orderRows = orders.map(order => `
            <tr>
                <td># <a href="/erfolg/${order.code}">${order.code}</a></td>
                <td>
                    <p>${order.email}</p>
                    <p>${order.username}</p>
                    <p>${order.phone}</p>
                </td>
                <td>${getFormattedSubTotal(order.total_amount)} $</td>
                <td>${order.order_status}</td>
                <td>${new Date(order.created_at).toLocaleDateString()}</td>
            </tr>
        `).join('');

                content.innerHTML = `
            <h2>Đơn Hàng Của Tôi</h2>
            <table>
                <thead>
                    <tr>
                        <th style="width: 15%">Mã đơn hàng</th>
                        <th>Thông tin</th>
                        <th style="width: 15%">Tổng tiền</th>
                        <th style="width: 15%">Trạng thái</th>
                        <th style="width: 15%">Ngày đặt</th>
                    </tr>
                </thead>
                <tbody>
                    ${orderRows}
                </tbody>
            </table>
        `;
            }
        }


        function submitForm(event) {
            event.preventDefault(); // Ngăn reload trang
            const form = document.getElementById('accountForm');
            const formData = new FormData(form);
            const data = {
                lastname: formData.get('lastname'),
                firstname: formData.get('firstname'),
                email: formData.get('email'),
                phone: formData.get('phone')
            };
            // Ở đây bạn có thể gửi dữ liệu lên server bằng fetch hoặc xử lý tiếp
            console.log('Dữ liệu đã submit:', data);
            alert('Thông tin đã được cập nhật!');
        }
    </script>
@endpush
