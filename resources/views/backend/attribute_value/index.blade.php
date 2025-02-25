@extends('backend.layouts.master')

@section('content')
    @include('backend.layouts.partials.breadcrumb', [
        'page' => 'DANH SÁCH GIÁ TRỊ',
        'href' => route('admin.attributes.index'),
    ])

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="info-tab" data-bs-toggle="tab" href="#info" role="tab" aria-controls="info"
                aria-selected="true">Thông Tin Giá Trị</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="seo-tab" data-bs-toggle="tab" href="#seo" role="tab" aria-controls="seo"
                aria-selected="false">Cấu Hình Seo</a>
        </li>
    </ul>


    <form action="{{ route('admin.attributes-values.store', request('id')) }}" id="myForm" method="post">
        <input type="hidden" name="id" id="id">
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-content-center">
                        <h3 class="card-title form-title">THÊM GIÁ TRỊ</h3>
                        <div class="card-tool">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <i class="fas fa-list me-1"></i>Hiển thị danh sách
                            </button>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="info" role="tabpanel"
                                aria-labelledby="info-tab">
                                <div class="row">
                                    <div class="form-group mb-3 col-lg-6">
                                        <label for="value" class="form-label">Tên giá trị</label>
                                        <input type="text" oninput="convertSlug('#value', '#slug')"
                                            placeholder="Tên giá trị" name="value" id="value" class="form-control">
                                    </div>

                                    <div class="form-group mb-3 col-lg-6">
                                        <label for="slug" class="form-label">Đường dẫn</label>
                                        <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Không nhập sẽ lấy theo tên"></i>
                                        <input type="text" placeholder="Đường dẫn" name="slug" id="slug"
                                            class="form-control">
                                    </div>

                                    <div class="form-group mb-3 col-lg-12">
                                        <label for="slug" class="form-label">Mô tả chi tiết</label>
                                        <textarea name="description" class="form-control ckeditor" id="description" placeholder="Mô tả seo">{!! $category->description ?? '' !!}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                                <div class="form-group mb-3">
                                    <label for="seo_title" class="form-label">Tiêu đề seo</label>
                                    <input type="text" value="" placeholder="Tiêu đề seo" id="seo_title"
                                        name="seo_title" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="seo_description" class="form-label">Mô tả seo</label>
                                    <textarea name="seo_description" id="seo_description" cols="30" rows="4" class="form-control"
                                        placeholder="Mô tả seo"></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="seo_keywords" class="form-label">Từ khóa seo</label>
                                    <input id="seo_keywords" value="" name="seo_keywords">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-3">

                <div class="card">
                    <div class="card-body">
                        <label for="status" class="form-label">Trạng thái</label>
                        <select name="status" id="status" class="form-select">
                            <option value="1">Xuất bản</option>
                            <option value="2">Chưa xuất bản</option>
                        </select>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label for="image" class="form-label">Ảnh đại điện</label>
                        <img class="img-fluid img-thumbnail w-100" id="show_image" style="cursor: pointer"
                            src="{{ showImage('') }}" alt="" onclick="document.getElementById('image').click();">
                        <input type="file" name="image" id="image" class="form-control d-none"
                            accept="image/*" onchange="previewImage(event, 'show_image')">
                    </div>

                    <div class=" card-footer d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-danger btn-sm me-3"><i
                                class="fas fa-undo me-1"></i>Hủy</button>
                        <button id="submitBtn" class="btn btn-primary btn-sm d-flex align-items-center gap-2"
                            type="submit">
                            <span class="spinner-border spinner-border-sm d-none" role="status"
                                aria-hidden="true"></span>
                            <i class="fas fa-save me-1"></i> Lưu
                        </button>
                    </div>
                </div>


            </div>
        </div>
    </form>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="text-transform: uppercase" id="exampleModalLabel">GIÁ TRỊ THUỘC TÍNH
                        ({{ $attribute->name }})</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="myTable" class="display" style="width:100%">
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('backend/assets/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/columns/attribute_value.js') }}"></script>
    <script src="{{ asset('backend/assets/js/connectDataTable.js') }}"></script>
    <script src="{{ asset('backend/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('backend/assets/js/tagify.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            CKEDITOR.replace('description', {
                filebrowserUploadMethod: 'form',
            });

            var url = window.location.href;
            var id = url.substring(url.lastIndexOf('/') + 1);
            const api = "{{ route('admin.attributes-values.index', '__id__') }}".replace('__id__', id)
            dataTables(api, columns, 'AttributeValue')

            function reset() {
                $('#myForm').attr('action', '{{ route('admin.attributes-values.store', '__id__') }}'.replace(
                    '__id__', id))
                $('#myForm').removeAttr('data-type')
                $("#myForm").trigger("reset");
                $('.form-title').html('Thêm mới giá trị')
                $('#show_image').attr('src', "{{ showImage('') }}");
                CKEDITOR.instances.description.setData('');
                tagify.removeAllTags();
                $('#id').val('');
            }

            submitForm('#myForm', function(response) {
                $("#myTable").DataTable().ajax.reload();

                Toast.fire({
                    icon: "success",
                    title: response.message
                });

                reset()
            });

            $('.btn-outline-danger').on('click', function() {
                reset()
            })

            $('table tbody').on('click', 'a', function(e) {
                e.preventDefault();

                let resource = $(this).data('resource')

                $.each(resource, function(key, value) {
                    // Gán giá trị vào các input khác, không áp dụng cho input[type="file"]
                    if (key !== 'image') {
                        $(`#${key}`).val(value);
                    }

                    // Nếu là description, gán giá trị vào CKEditor
                    if (key == 'description') {
                        CKEDITOR.instances.description.setData(value);
                    }

                    // Nếu là seo_keywords, xử lý mảng và thêm vào Tagify
                    if (key == 'seo_keywords') {
                        // Kiểm tra nếu giá trị là chuỗi JSON, và chuyển nó thành mảng
                        let parsedValue = Array.isArray(value) ? value : JSON.parse(value);

                        if (Array.isArray(parsedValue)) {
                            let tags = parsedValue.map(item => item.value);
                            tagify.addTags(tags);
                        }
                    }

                    // Nếu là image, hiển thị ảnh
                    if (key == 'image') {
                        const pathImage = "{{ env('APP_URL') }}/storage/"
                        // Gán URL ảnh vào thẻ img
                        let src = pathImage + value

                        if (!value) {
                            src = "{{ showImage('') }}"
                        }
                        $('#show_image').attr('src', src);
                    }
                });

                $('#myForm').attr('data-type', 'PUT')

                $('#myForm').attr('action', '{{ route('admin.attributes-values.update', '__id__') }}'
                    .replace(
                        '__id__', "{{ request('id') }}"))

                $('.form-title').html('Cập nhật giá trị')

            })

            var input = document.querySelector('#seo_keywords');
            var tagify = new Tagify(input, {
                maxTags: 10,
                placeholder: "Nhập từ khóa...",
            });
        })
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/tagify.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/dataTables.min.css') }}">

    <style>
        .col-lg-9 .card {
            border-top-left-radius: 0 !important;
            border-top-right-radius: 0 !important;
            border: 1px solid #eee;
        }
    </style>
@endpush
