@extends('backend.layouts.master')

@section('content')
    @include('backend.layouts.partials.breadcrumb', [
        'page' => 'Danh sách thương hiệu',
    ])

    <div class="card">
        <div class="card-header d-flex justify-content-between align-content-center">
            <h3 class="card-title">DANH SÁCH THƯƠNG HIỆU</h3>
            <div class="card-tool">
                <a href="{{ route('admin.brands.create') }}" class="btn btn-primary btn-sm"><i
                        class="fas fa-plus-circle me-1"></i> Thêm mới</a>
            </div>
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
    <script src="{{ asset('backend/assets/js/columns/brand.js') }}"></script>
    <script src="{{ asset('backend/assets/js/connectDataTable.js') }}"></script>
    <script>
        $(document).ready(function() {
            const api = "{{ route('admin.brands.index') }}"
            dataTables(api, columns, 'Brand')
        })
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/dataTables.min.css') }}">
@endpush
