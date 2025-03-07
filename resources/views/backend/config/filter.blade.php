@extends('backend.layouts.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-content-center">
            <h4 class="card-title">Cấu hình lọc</h4>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Thêm lọc
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable" class="display" style="width:100%">

                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="" id="handleSubmit">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm bộ lọc</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Chọn kiểu lọc -->
                        <div class="form-group">
                            <label for="filter_type">Chọn kiểu lọc</label>
                            <select id="filter_type" name="filter_type" class="form-control">
                                <option value="brand">Thương hiệu</option>
                                <option value="attribute">Thuộc tính</option>
                                <option value="price">Giá</option>
                            </select>
                        </div>

                        <!-- Tiêu đề -->
                        <div class="form-group">
                            <label for="title">Tiêu đề</label>
                            <input type="text" id="title" name="title" class="form-control">
                        </div>

                        <!-- Chọn kiểu lọc theo checkbox hoặc radio -->
                        <div id="filter-method-section" class="form-group" style="display: none;">
                            <label>Chọn kiểu lọc</label>
                            <div>
                                <input type="radio" id="filter-radio" name="selection_type" value="radio">
                                <label for="filter-radio">Radio</label>

                                <input type="radio" id="filter-checkbox" name="selection_type" value="checkbox">
                                <label for="filter-checkbox">Checkbox</label>
                            </div>
                        </div>

                        <!-- Chọn thuộc tính muốn lọc -->
                        <div id="attribute-section" class="filter-options" style="display: none;">
                            <div class="form-group">
                                <label for="attribute_id">Chọn thuộc tính muốn lọc</label>
                                <select id="attribute_id" name="attribute_id" class="form-control">
                                    <option value="">Chọn thuộc tính</option>
                                    @foreach ($attributes as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Chọn giá muốn lọc -->
                        <div id="price-section" style="display: none;">
                            <div class="form-group">
                                <label for="option_price" class="form-label">Chọn giá muốn lọc</label>
                                <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Ví dụ: 10-20, 30-50, ..."></i>
                                <input type="text" class="form-control" name="option_price">
                            </div>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary btn-sm">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script src="{{ asset('backend/assets/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/columns/filter.js') }}"></script>
    <script src="{{ asset('backend/assets/js/connectDataTable.js') }}"></script>

    <script>
        $(document).ready(function() {

            const api = "{{ route('admin.configs.filter') }}"

            dataTables(api, columns, 'ConfigFilter', true)

            function updateFilterSections() {
                var selectedType = $('#filter_type').val();

                // Ẩn tất cả các phần trước khi hiển thị cái cần thiết
                $('#attribute-section, #price-section, #filter-method-section').hide();

                if (selectedType === 'attribute' || selectedType === 'brand') {
                    $('#filter-method-section').show(); // Hiển thị chọn lọc theo checkbox/radio
                }

                if (selectedType === 'attribute') {
                    $('#attribute-section').show();
                } else if (selectedType === 'price') {
                    $('#price-section').show();
                }
            }

            // Gọi khi người dùng thay đổi select
            $('#filter_type').on('change', updateFilterSections);

            // Kiểm tra giá trị ban đầu khi load trang
            updateFilterSections();

            $('#handleSubmit').on('submit', function(e) {
                e.preventDefault();

                var form = $(this);
                var url = form.attr('action');
                var data = form.serialize();

                $.post(url, data, function(response) {
                    $('#exampleModal').modal('hide');
                    $('#myTable').DataTable().ajax.reload();
                }).fail(function(xhr) {
                    alert('Có lỗi xảy ra!');
                });
            });

            $('button[data-bs-toggle="modal"]').on('click', function() {
                $('#exampleModalLabel').html('Thêm bộ lọc')
                $('#handleSubmit').trigger('reset');
                $('#filter_type').trigger('change');
                $('#handleSubmit').attr('action', '')
                $('.modal').modal('show');
            });

            $(document).on('click', '.btn-edit', function() {
                const resource = $(this).data('resource');

                $.each(resource, function(key, value) {
                    $(`input[name=${key}]`).val(value);

                    if (key === 'filter_type') {
                        $(`select[name=${key}]`).val(value).trigger('change');
                    }

                    if (key === 'attribute_id') {
                        $('#attribute_id').val(value);
                    }

                    if (key === 'selection_type') {
                        $(`#filter-${value}`).prop('checked', true);
                    }
                });

                $('#exampleModalLabel').html('Cập nhật bộ lọc');

                $('#handleSubmit').attr('action',
                    '{{ route('admin.configs.handleSubmitChangeFilter', ':id') }}'.replace(':id',
                        resource.id)
                );

                $('.modal').modal('show');
            });

        });
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/dataTables.min.css') }}">
@endpush
