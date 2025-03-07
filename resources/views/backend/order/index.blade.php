@extends('backend.layouts.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Danh sách đơn hàng</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable" class="display" style="width:100%">
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('backend/assets/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/columns/order.js') }}"></script>
    <script src="{{ asset('backend/assets/js/connectDataTable.js') }}"></script>

    <script>
        $(document).ready(function() {

            const api = "{{ route('admin.orders.index') }}"
            dataTables(api, columns, 'Order')
        })

    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        table tr td p {
            margin: 0;
        }
    </style>
@endpush
