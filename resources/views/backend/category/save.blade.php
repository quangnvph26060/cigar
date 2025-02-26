@extends('backend.layouts.master')


@section('content')
    @include('backend.layouts.partials.breadcrumb', [
        'page' => 'Thêm mới danh mục',
        'href' => route('admin.categories.index'),
    ])

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="info-tab" data-bs-toggle="tab" href="#info" role="tab" aria-controls="info"
                aria-selected="true">Thông Tin Danh Mục</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="seo-tab" data-bs-toggle="tab" href="#seo" role="tab" aria-controls="seo"
                aria-selected="false">Cấu Hình Seo</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="attribute-tab" data-bs-toggle="tab" href="#attribute" role="tab"
                aria-controls="attribute" aria-selected="false">Thuộc tính</a>
        </li>
    </ul>

    @php
        $action = isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store');
    @endphp

    <form action="{{ $action }}" method="post" enctype="multipart/form-data" id="myForm">

        @isset($category)
            @method('PUT')
        @endisset

        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="info" role="tabpanel"
                                aria-labelledby="info-tab">
                                <div class="row">
                                    <div class="form-group mb-3 col-lg-6">
                                        <label for="name" class="form-label">Tên danh mục <span
                                                class="text-danger">*</span></label>
                                        <input value="{{ $category->name ?? '' }}" oninput="convertSlug('#name', '#slug')"
                                            id="name" name="name" class="form-control" type="text"
                                            placeholder="Tên danh mục">
                                    </div>

                                    <div class="form-group mb-3 col-lg-6">
                                        <label for="slug" class="form-label">Đường dẫn thân thiện</label>
                                        <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Không nhập sẽ lấy theo tên"></i>
                                        <input id="slug" value="{{ $category->slug ?? '' }}" name="slug"
                                            class="form-control" type="text" placeholder="Đường dẫn thân thiện">
                                    </div>

                                    <div class="form-group mb-3 col-lg-12">
                                        <label for="slug" class="form-label">Mô tả chi tiết</label>
                                        <textarea name="description" class="form-control" id="description" placeholder="Mô tả seo">{!! $category->description ?? '' !!}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                                <div class="form-group mb-3">
                                    <label for="seo_title" class="form-label">Tiêu đề seo</label>
                                    <input type="text" value="{{ $category->seo_title ?? '' }}" placeholder="Tiêu đề seo"
                                        id="seo_title" name="seo_title" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="seo_description" class="form-label">Mô tả seo</label>
                                    <textarea name="seo_description" id="seo_description" cols="30" rows="4" class="form-control"
                                        placeholder="Mô tả seo">{{ $category->seo_description ?? '' }}</textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="seo_keywords" class="form-label">Từ khóa seo</label>
                                    <input id="seo_keywords" value="{{ $category->seo_keywords ?? '' }}"
                                        name="seo_keywords">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="attribute" role="tabpanel" aria-labelledby="attribute-tab">
                                <div class="form-group">
                                    <label for="attribute_id">Chọn thuộc tính:</label>
                                    <select id="attribute_id" class="form-control select2" name="attribute_id[]" multiple
                                        style="width:100%">
                                        @foreach ($attributes as $id => $name)
                                            <option value="{{ $id }}" @selected(in_array($id, isset($category) ? $category->attributes->pluck('id')->toArray() : []))>
                                                {{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="attribute-values-container">

                                    @isset($category)
                                        @foreach ($category->attributes ?? [] as $attr)
                                            <div class="form-group">
                                                <label for="attribute_values_{{ $attr->id }}">{{ $attr->name }}:</label>
                                                <select id="attribute_values_{{ $attr->id }}"
                                                    data-attribute-id="{{ $attr->id }}"
                                                    name="attribute_values[{{ $attr->id }}][]"
                                                    class="form-control select2 attribute-value-select" multiple
                                                    style="width:100%">
                                                    @foreach ($attributeValues[$attr->id] as $value)
                                                        <option value="{{ $value['id'] }}"
                                                            @if (in_array(
                                                                    $value['id'],
                                                                    json_decode($category->attributes->where('id', $attr->id)->first()->pivot->attribute_value_ids) ?? [])) selected @endif>
                                                            {{ $value['text'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endforeach
                                    @endisset

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Trạng thái</h5>
                    </div>

                    <div class="card-body">
                        <select name="status" id="status" class="form-select">
                            <option value="1" @selected(($category->status ?? 1) == 1)>Xuất bản</option>
                            <option value="2" @selected(($category->status ?? '') == 2)>Chưa xuất bản</option>
                        </select>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Danh mục cha</h5>
                    </div>

                    <div class="card-body">
                        <select name="parent_id" id="parent_id" class="form-select">
                            <option value="">Danh mục cha</option>
                            @foreach ($categories as $key => $c)
                                <option @disabled(($category->id ?? '') == $key) @selected(($category->parent_id ?? '') == $key)
                                    value="{{ $key }}">{{ $c }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Ảnh đại điện</h5>
                    </div>

                    <div class="card-body">
                        <img class="img-fluid img-thumbnail w-100" id="show_image" style="cursor: pointer"
                            src="{{ showImage($category->image ?? '') }}" alt=""
                            onclick="document.getElementById('image').click();">
                        <input type="file" name="image" id="image" class="form-control d-none"
                            accept="image/*" onchange="previewImage(event, 'show_image')">
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button id="submitBtn" class="btn btn-primary btn-sm d-flex align-items-center gap-2" type="submit">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <i class="fas fa-save me-1"></i> Lưu
                    </button>
                </div>

            </div>
        </div>
    </form>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/tagify.css') }}">
    <style>
        .col-lg-9 .card {
            border-top-left-radius: 0 !important;
            border-top-right-radius: 0 !important;
            border: 1px solid #eee;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('backend/assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/tagify.min.js') }}"></script>
    <script src="{{ asset('backend/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(document).ready(function() {

            const attributeValues = @json($attributeValues)

            $('#attribute_id').select2({
                placeholder: "Chọn thuộc tính",
                allowClear: true,
                width: '100%', // Đảm bảo chiều rộng được thiết lập chính xác
                dropdownAutoWidth: true, // Tự động điều chỉnh chiều rộng khi có nhiều lựa chọn
            })

            $('#attribute-values-container .select2').select2({
                placeholder: 'Chọn giá trị',
                allowClear: true,
                width: '100%', // Đảm bảo chiều rộng được thiết lập chính xác
                dropdownAutoWidth: true, // Tự động điều chỉnh chiều rộng khi có nhiều lựa chọn
            });

            $("#attribute_id").on("change", function() {
                let selectedAttributes = $(this).val() || [];

                let container = $("#attribute-values-container");

                // Xóa các select không còn cần thiết (thuộc tính bị bỏ chọn)
                container.find(".attribute-value-select").each(function() {
                    console.log(selectedAttributes);
                    let attrId = $(this).data("attribute-id");

                    // Nếu thuộc tính không còn trong danh sách được chọn, xóa select
                    if (!selectedAttributes.includes(attrId.toString())) {
                        $(this).parent().remove(); // Xóa cả div form-group chứa select
                    }
                });

                // Thêm select mới cho các thuộc tính vừa được chọn
                selectedAttributes.forEach(function(attributeId) {
                    if (!container.find(`[data-attribute-id='${attributeId}']`).length) {
                        let selectId = `attribute_values_${attributeId}`;
                        let newSelect = `
                        <div class="form-group">
                            <label for="${selectId}">${$("#attribute_id option[value='" + attributeId + "']").text()}:</label>
                            <select id="${selectId}" class="form-control select2 attribute-value-select"
                                multiple data-attribute-id="${attributeId}" name="attribute_values[${attributeId}][]"
                                style="width:100%"></select>
                        </div>`;

                        container.append(newSelect);

                        // Khởi tạo Select2 với dữ liệu
                        let selectElement = $(`#${selectId}`);
                        selectElement.select2({
                            data: attributeValues[attributeId] || [],
                            placeholder: "Chọn giá trị",
                            allowClear: true
                        });
                    }
                });
            });


            var input = document.querySelector('#seo_keywords');
            var tagify = new Tagify(input, {
                maxTags: 10,
                placeholder: "Nhập từ khóa...",
            });

            submitForm('#myForm', function(response) {
                window.location.href = "{{ route('admin.categories.index') }}"
            });

            CKEDITOR.replace('description', {
                filebrowserUploadMethod: 'form',
                height: "315px"
            });
        });
    </script>
@endpush
