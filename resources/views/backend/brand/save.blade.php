@extends('backend.layouts.master')


@section('content')
    @include('backend.layouts.partials.breadcrumb', [
        'page' => 'Thêm mới danh mục',
        'href' => route('admin.brands.index'),
    ])

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active fw-bold" id="info-tab" data-bs-toggle="tab" href="#info" role="tab"
                aria-controls="info" aria-selected="true">Thông Tin Thương Hiệu</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link fw-bold" id="seo-tab" data-bs-toggle="tab" href="#seo" role="tab"
                aria-controls="seo" aria-selected="false">Cấu Hình Seo</a>
        </li>
    </ul>

    @php
        $action = isset($brand) ? route('admin.brands.update', $brand) : route('admin.brands.store');
    @endphp

    <form action="{{ $action }}" method="post" enctype="multipart/form-data" id="myForm">

        @isset($brand)
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
                                        <label for="name" class="form-label">Tên thương hiệu<span
                                                class="text-danger">*</span></label>
                                        <input value="{{ $brand->name ?? '' }}" oninput="convertSlug('#name', '#slug')"
                                            id="name" name="name" class="form-control" type="text"
                                            placeholder="Tên thương hiệu">
                                    </div>

                                    <div class="form-group mb-3 col-lg-6">
                                        <label for="slug" class="form-label">Đường dẫn thân thiện</label>
                                        <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Không nhập sẽ lấy theo tên"></i>
                                        <input id="slug" value="{{ $brand->slug ?? '' }}" name="slug"
                                            class="form-control" type="text" placeholder="Đường dẫn thân thiện">
                                    </div>

                                    <div class="form-group mb-3 col-lg-12">
                                        <label for="excerpt" class="form-label">Mô tả ngắn</label>
                                        <textarea name="excerpt" class="form-control ckeditor" id="excerpt" placeholder="Mô tả seo">{!! $brand->excerpt ?? '' !!}</textarea>
                                    </div>

                                    <div class="form-group mb-3 col-lg-12">
                                        <label for="slug" class="form-label">Mô tả chi tiết</label>
                                        <textarea name="description" class="form-control ckeditor" id="description" placeholder="Mô tả seo">{!! $brand->description ?? '' !!}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">Tiêu đề</label>
                                    <input type="text" value="{{ $brand->title ?? '' }}" placeholder="Tiêu đề"
                                        id="title" name="title" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="seo_title" class="form-label">Tiêu đề seo</label>
                                    <input type="text" value="{{ $brand->seo_title ?? '' }}" placeholder="Tiêu đề seo"
                                        id="seo_title" name="seo_title" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="seo_description" class="form-label">Mô tả seo</label>
                                    <textarea name="seo_description" id="seo_description" cols="30" rows="4" class="form-control"
                                        placeholder="Mô tả seo">{{ $brand->seo_description ?? '' }}</textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="seo_keywords" class="form-label">Từ khóa seo</label>
                                    <input id="seo_keywords" value="{{ $brand->seo_keywords ?? '' }}"
                                        name="seo_keywords">
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
                            <option value="1" @selected(($brand->status ?? 1) == 1)>Xuất bản</option>
                            <option value="2" @selected(($brand->status ?? '') == 2)>Chưa xuất bản</option>
                        </select>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Hiển thị trang chủ</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check form-check-inline p-0">
                            <input @checked(($brand->is_show_home ?? 0) == 1) class="form-check-input" type="radio"
                                name="is_show_home" id="yes" value="yes">
                            <label class="form-check-label" for="yes">Có</label>
                        </div>
                        <div class="form-check form-check-inline p-0">
                            <input @checked(($brand->is_show_home ?? 0) == 0) class="form-check-input" type="radio"
                                name="is_show_home" id="no" value="no">
                            <label class="form-check-label" for="no">Không</label>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Thương hiệu hàng đầu</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check form-check-inline p-0">
                            <input @checked(($brand->is_top ?? 0) == 1) class="form-check-input" type="radio"
                                name="is_top" id="yes" value="yes">
                            <label class="form-check-label" for="yes">Có</label>
                        </div>
                        <div class="form-check form-check-inline p-0">
                            <input @checked(($brand->is_top ?? 0) == 0) class="form-check-input" type="radio"
                                name="is_top" id="no" value="no">
                            <label class="form-check-label" for="no">Không</label>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Ảnh đại điện</h5>
                    </div>

                    <div class="card-body">
                        <img class="img-fluid img-thumbnail w-100" id="show_image" style="cursor: pointer"
                            src="{{ showImage($brand->image ?? '') }}" alt=""
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

            var input = document.querySelector('#seo_keywords');
            var tagify = new Tagify(input, {
                maxTags: 10,
                placeholder: "Nhập từ khóa...",
            });

            submitForm('#myForm', function(response) {
                window.location.href = "{{ route('admin.brands.index') }}"
            });

            ckeditor('description')
            ckeditor('excerpt', 150)
        });
    </script>
@endpush
