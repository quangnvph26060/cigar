@extends('backend.layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title">Thông tin đặt hàng <code>({{ $order->code }})</code></h3>
                    <p id="status-order-top">{!! statusColor($order->order_status) !!}</p>
                </div>

                <div class="card-body">
                    <table class="table table-hover table-striped">
                        <tbody>
                            @foreach ($order->orderDetails as $item)
                                <tr>
                                    <td width="50">
                                        <img src="{{ showImage($item->p_image) }}" style="width:100%"
                                            alt="{{ $item->p_name }}">
                                    </td>
                                    <td>
                                        <a
                                            href="{{ route('admin.variations.product.edit', [$item->product_id, $item->variation_id]) }}">
                                            {{ $item->p_name }}</a> <small>x {{ $item->p_qty }}</small>
                                    </td>
                                    <td>
                                        {{ getFormattedSubTotal($item->p_price) }} $ / {{ $item->p_unit }}
                                    </td>
                                    <td>

                                    </td>
                                    <td>
                                        {{ getFormattedSubTotal($item->p_price * $item->p_qty) }} $
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Tổng tiền:</strong></td>
                                <td><strong class="ms-2">{{ getFormattedSubTotal($order->total_amount) }} $</strong></td>
                            </tr>
                        </tfoot>

                    </table>
                </div>

                <div class="card-footer d-flex justify-content-between align-items-center">
                    <h5>Trạng thái thanh toán</h5>
                    @if ($order->payment_status == 0)
                        <button class="btn btn-primary btn-sm" id="confirm-payment">Xác nhận thanh toán</button>
                    @else
                        <span class="badge bg-success">Đã thanh toán</span>
                    @endif
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <h5></h5>
                    <div class="card-btn">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-dark btn-sm"> <i
                                class="fas fa-undo-alt me-1"></i> Quay lại</a>

                        @if ($order->order_status != 'cancelled')
                            <button class="btn btn-outline-secondary btn-sm" id="downloadInvoiceBtn"
                                data-id="{{ $order->id }}"><i class="fas fa-file-export me-1"></i>Xuất hóa
                                đơn</button>

                            <button data-bs-toggle="modal" data-bs-target="#exampleModal" type="button"
                                @disabled($order->order_status == 'completed' || $order->payment_status == '1') class="btn btn-outline-danger btn-sm"><i
                                    class="far fa-window-close me-1"></i>Hủy yêu cầu
                            </button>
                        @endif

                    </div>
                </div>
            </div>

            <div class="order-reason">
                @if ($order->status == 'cancelled')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title
                            text-danger">Lý do hủy đơn hàng</h3>
                        </div>
                        <div class="card-body">
                            <p>{{ $order->reason }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thông tin người đặt</h3>
                </div>
                <div class="card-body">
                    <!-- Customer Information -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-1">{{ $order->fullname }}</p>
                                <p class="mb-1"><a href="mailto:{{ $order->email }}">{{ $order->email }}</a>
                                </p>
                                <p class="mb-1"><a href="tel:{{ $order->phone }}">{{ $order->phone }}</a></p>
                                <p class="mb-1">{{ $order->address }}</p>
                                <p class="mb-1">
                                    @if ($order->payment_method == 'cod')
                                        Thanh toán khi nhận hàng (COD)
                                    @endif
                                </p>

                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="mb-4">
                        <div class="d-flex align-items-center">
                            <div>
                                <strong>Ghi chú</strong>
                                <p class="mb-1">
                                    <textarea disabled class="form-control" name="" id="" cols="30" rows="4">{{ $order->notes }}</textarea>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($order->order_status != 'cancelled')
                    <div class="card-footer" id="status-order">
                        @if ($order->order_status == 'completed')
                            <span class="badge bg-success">Đơn hàng đã hoàn thành</span>
                        @else
                            <button type="button" class="btn btn-primary btn-sm w-100" id="btn-confirm">
                                @if ($order->order_status == 'pending')
                                    Xác nhận đơn hàng
                                @elseif($order->order_status == 'confirmed')
                                    Hoàn thành đơn hàng
                                @endif
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Lý do hủy đơn hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <textarea class="form-control" required name="reason" id="reason" cols="30" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary btn-sm" id="btn-cancel">Xác nhận hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.15.3/sweetalert2.min.js"></script>

    <script>
        $('#btn-confirm').on('click', function() {
            $.ajax({
                url: "{{ route('admin.orders.change-order-status') }}",
                method: "POST",
                data: {
                    orderId: "{{ $order->id }}"
                },
                success: (response) => {

                    if (response.value == 'confirmed') {

                        $('#status-order-top').html(
                            '<span class="badge bg-primary">Đã xác nhận</span>');

                        $(this).html('Hoàn thành đơn hàng');
                    } else {

                        $('button[data-bs-toggle="modal"]').prop('disabled', true);

                        $('#status-order-top').html(
                            '<span class="badge bg-success">Đơn hàng đã hoàn thành</span>');

                        $('#status-order').html(
                            '<span class="badge bg-success">Đơn hàng đã hoàn thành</span>');
                    }

                    Toast.fire({
                        icon: "success",
                        title: "Thay đổi trạng thái thành công.",
                        customClass: {
                            popup: 'custom-popup-width' // Đặt lớp CSS tùy chỉnh
                        }
                    });
                },
                error: (xhr) => {
                    if (xhr.status != 500) {
                        Toast.fire({
                            icon: "error",
                            title: xhr.responseJSON.message,
                            customClass: {
                                popup: 'custom-popup-width' // Đặt lớp CSS tùy chỉnh
                            }
                        });

                        return false
                    }

                    alert('Đã có lỗi xảy ra. Vui lòng thử lại sau!')
                }
            })
        })

        $('#downloadInvoiceBtn').on('click', function() {
            const orderId = $(this).data('id');

            $.ajax({
                url: '{{ route('admin.orders.exportPDF') }}',
                type: 'POST',
                data: {
                    order_id: orderId,
                },
                xhrFields: {
                    responseType: 'blob' // Để xử lý file PDF
                },
                success: function(data) {
                    const blob = new Blob([data], {
                        type: 'application/pdf'
                    });
                    const link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = `invoice-${orderId}.pdf`;
                    link.click();
                },
                error: function(xhr, err) {

                    Toast.fire({
                        icon: "error",
                        title: "Đơn hàng chưa được xác nhận, không thể in hóa đơn!"
                    });
                }
            });
        });

        $('#btn-cancel').on('click', (e) => {
            e.preventDefault();

            $.ajax({
                url: "{{ route('admin.orders.cancel-order', ':id') }}".replace(':id',
                    '{{ $order->id }}'),
                method: 'POST',
                data: {
                    reason: $('#reason').val()
                },
                success: (response) => {

                    $('#status-order').html('<span class="badge bg-danger">Đơn hàng đã bị hủy</span>');

                    $('#status-order-top').html(
                        '<span class="badge bg-danger">Đã hủy</span>');

                    $('button[data-bs-toggle="modal"]').remove();
                    $('#downloadInvoiceBtn').remove();

                    $('.modal').modal('hide');

                    let _html =
                        `
                     <div class="card">
                        <div class="card-header">
                            <h3 class="card-title
                                text-danger">Lý do hủy đơn hàng</h3>
                        </div>
                        <div class="card-body">
                            <p>${response.reason}</p>
                        </div>
                    </div>
                    `

                    $('.order-reason').html(_html);

                    Toast.fire({
                        icon: "success",
                        title: response.message
                    });
                },
                error: (xhr) => {
                    alert('Đã có lỗi xảy ra. Vui lòng thử lại sau!')
                }
            })

        })

        $('#confirm-payment').on('click', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('admin.orders.confirm-payment', $order->id) }}",
                method: 'GET',
                success: (response) => {

                    $('#confirm-payment').replaceWith(`
                        <span class="text-success">Đã xác nhận thanh toán</span>
                    `);

                    Toast.fire({
                        icon: "success",
                        title: response.message
                    });
                },
                error: (xhr) => {
                    Toast.fire({
                        icon: "error",
                        title: xhr.responseJSON.message
                    });
                }
            })
        });
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.15.3/sweetalert2.min.css">
    <style>
        body.swal2-toast-shown .swal2-container {
            /* max-width: 600px !important; */
            width: auto !important;
        }

        .table>tbody>tr>td,
        .table>tbody>tr>th {
            padding: 5px !important;
        }

        .table>tfoot>tr>td,
        .table>tfoot>tr>th {
            padding: 15px 0 0 0 !important;
        }
    </style>
@endpush
