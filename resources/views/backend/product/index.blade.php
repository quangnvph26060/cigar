@extends('backend.layouts.master')

@section('content')
    @include('backend.layouts.partials.breadcrumb', [
        'page' => 'Danh sách sản phẩm',
    ])

    <div class="card">
        <div class="card-header d-flex justify-content-between align-content-center">
            <h3 class="card-title">DANH SÁCH SẢN PHẨM</h3>
            <div class="card-tool">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm"><i
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
    <script src="{{ asset('backend/assets/js/columns/product.js') }}"></script>
    <script src="{{ asset('backend/assets/js/connectDataTable.js') }}"></script>
    <script>
        function format(d) {

            let image = "{{ env('APP_URL') }}" + '/storage/' + d.image
            return `
                <form id="myForm" enctype="multipart/form-data">
                    <div class="row">

                        <div class="mb-3 col-2">
                            <label for="image" class="form-label">Ảnh sản phẩm</label>
                            <img class="img-fluid img-thumbnail w-100" id="show_image-${d.id}" style="cursor: pointer"
                            src="${image}" alt="${d.name}"
                            onclick="document.getElementById('image-${d.id}').click();">
                            <input type="file" name="image" id="image-${d.id}" class="form-control d-none"
                                accept="image/*" onchange="previewImage(event, 'show_image-${d.id}')">
                        </div>

                        <div class="col-10">
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label for="name" class="form-label">Tên sản phẩm</label>
                                    <input type="text" name="name" class="form-control" id="name" value="${d.name}">
                                </div>
                                <div class="mb-3 col-3">
                                    <label for="price" class="form-label">Giá sản phẩm</label>
                                    <input type="text" name="price" class="form-control" id="price" value="${d.price}">
                                </div>
                                <div class="mb-3 col-3">
                                    <label for="discount_value" class="form-label">Giá khuyến mãi</label>
                                    <input type="text" name="discount_value" class="form-control" id="discount_value" value="${d.discount_value}">
                                </div>

                                <div class="mb-3 col-12 d-flex align-items-center gap-3">
                                    <label for="name" class="form-label mb-0">Trạng thái</label>
                                    <label class="switch">
                                        <input name="status"  type="checkbox" ${d.status == 1 ? 'checked' : ''}/>
                                        <span class="slider"></span>
                                    </label>
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary btn-sm">Cập nhật</button>
                                    <button type="button" class="btn btn-secondary btn-sm" id="cancelEditBtn">Hủy</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            `;
        }
        $(document).ready(function() {
            const api = "{{ route('admin.products.index') }}"
            dataTables(api, columns, 'Product')
        })
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/dataTables.min.css') }}">
@endpush
