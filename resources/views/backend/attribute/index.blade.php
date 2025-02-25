@extends('backend.layouts.master')

@section('content')
    @include('backend.layouts.partials.breadcrumb', ['page' => 'DANH SÁCH THUỘC TÍNH'])

    <div class="row">

        <div class="col-lg-4">
            <form action="{{ route('admin.attributes.store') }}" id="myForm" method="post">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title form-title">Thêm thuộc tính</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Tên thuộc tính</label>
                            <input type="text" placeholder="Tên thuộc tính" name="name" id="name"
                                class="form-control">
                        </div>

                        <div class="form-group mb-3">
                            <label for="slug" class="form-label">Đường dẫn</label>
                            <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Không nhập sẽ lấy theo tên"></i>
                            <input type="text" placeholder="Đường dẫn" name="slug" id="slug"
                                class="form-control">
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-danger btn-sm me-3"><i
                                class="fas fa-undo me-1"></i>Hủy</button>
                        <button id="submitBtn" class="btn btn-primary btn-sm d-flex align-items-center gap-2"
                            type="submit">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            <i class="fas fa-save me-1"></i> Lưu
                        </button>
                    </div>

                </div>
            </form>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-content-center">
                    <h3 class="card-title">DANH SÁCH THUỘC TÍNH</h3>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="display" style="width:100%">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('backend/assets/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/columns/attribute.js') }}"></script>
    <script src="{{ asset('backend/assets/js/connectDataTable.js') }}"></script>
    <script>
        $(document).ready(function() {
            const api = "{{ route('admin.attributes.index') }}"
            dataTables(api, columns, 'Attribute')

            function reset() {

                $('#myForm').attr('action', '{{ route('admin.attributes.store') }}')
                $('#myForm').removeAttr('data-type')
                $("#myForm").trigger("reset");
                $('.form-title').html('Thêm mới thuộc tính')
            }

            $('.btn-outline-danger').on('click', function() {
                reset()
            })

            submitForm('#myForm', function(response) {

                $("#myTable").DataTable().ajax.reload();

                Toast.fire({
                    icon: "success",
                    title: response.message
                });

                reset()
            });

            $('table tbody').on('click', 'a.d-block.fw-bold', function(e) {
                e.preventDefault();

                $('#myForm').attr('data-type', 'PUT')

                $('#myForm').attr('action', '{{ route('admin.attributes.update', '__id__') }}'.replace(
                    '__id__', $(this).data('id')))

                $('.form-title').html('Cập nhật thuộc tính')

                $('#name').val($(this).data('name'))

                $('#slug').val($(this).data('slug'))
            })


        })
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/dataTables.min.css') }}">
@endpush
