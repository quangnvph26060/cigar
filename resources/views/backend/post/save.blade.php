@extends('backend.layouts.master')


@section('content')
    @include('backend.layouts.partials.breadcrumb', [
        'page' => 'Thêm mới bài viết',
        'href' => route('admin.posts.index'),
    ])

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active fw-bold" id="info-tab" data-bs-toggle="tab" href="#info" role="tab"
                aria-controls="info" aria-selected="true">Thông Tin Bài Viết</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link fw-bold" id="seo-tab" data-bs-toggle="tab" href="#seo" role="tab"
                aria-controls="seo" aria-selected="false">Cấu Hình Seo</a>
        </li>
    </ul>

    @php
        $action = isset($post) ? route('admin.posts.update', $post) : route('admin.posts.store');
    @endphp

    <form action="{{ $action }}" method="post" enctype="multipart/form-data" id="myForm">

        @isset($post)
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
                                        <label for="title" class="form-label">Tiêu Đề Bài Viết<span
                                                class="text-danger">*</span></label>
                                        <input value="{{ $post->title ?? '' }}" oninput="convertSlug('#title', '#slug')"
                                            id="title" name="title" class="form-control" type="text"
                                            placeholder="Tiêu đề bài viết">
                                    </div>

                                    <div class="form-group mb-3 col-lg-6">
                                        <label for="slug" class="form-label">Đường Dẫn Thân Thiện</label>
                                        <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Không nhập sẽ lấy theo tên"></i>
                                        <input id="slug" value="{{ $post->slug ?? '' }}" name="slug"
                                            class="form-control" type="text" placeholder="Đường dẫn thân thiện">
                                    </div>

                                    <div class="form-group mb-3 col-lg-12">
                                        <label for="excerpt" class="form-label">Mô Tả Ngắn Bài Viết</label>
                                        <textarea name="excerpt" class="form-control" id="excerpt" rows="5" placeholder="Mô Tả Ngắn Bài Viết">{!! $post->excerpt ?? '' !!}</textarea>
                                    </div>

                                    <div class="form-group mb-3 col-lg-12">
                                        <label for="content" class="form-label">Nội Dung Bài Viết</label>
                                        <textarea name="content" class="form-control ckeditor" id="content" placeholder="Nội dung bài viết">{!! $post->content ?? '' !!}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                                <div class="form-group mb-3">
                                    <label for="seo_title" class="form-label">Tiêu Đề Seo</label>
                                    <input type="text" value="{{ $post->seo_title ?? '' }}" placeholder="Tiêu đề seo"
                                        id="seo_title" name="seo_title" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="seo_description" class="form-label">Mô Tả Seo</label>
                                    <textarea name="seo_description" id="seo_description" cols="30" rows="4" class="form-control"
                                        placeholder="Mô tả seo">{{ $post->seo_description ?? '' }}</textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="seo_keywords" class="form-label">Từ Khóa Seo</label>
                                    <input id="seo_keywords" value="{{ $post->seo_keywords ?? '' }}" name="seo_keywords">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="seo_tags" class="form-label">Tags</label>
                                    <input id="seo_tags" value="{{ $post->seo_tags ?? '' }}" name="seo_tags">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <label for="status" class="form-label">Trạng Thái</label>
                        <select name="status" id="status" class="form-select">
                            <option value="1" @selected(($post->status ?? 1) == 1)>Xuất bản</option>
                            <option value="2" @selected(($post->status ?? '') == 2)>Chưa xuất bản</option>
                        </select>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body d-flex align-items-center gap-3">
                        <label for="featured" class="form-label  mb-0">Bài Viết Nổi Bật</label>
                        <label class="switch">
                            <input name="featured" @checked(optional($post)->featured) type="checkbox" />
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label for="published_at" class="form-label">Ngày Đăng</label>
                        <input id="published_at"
                            value="{{ optional($post)->published_at ? $post->published_at->format('d-m-Y H:i') : '' }}"
                            name="published_at" type="text" class="form-control">
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label for="removed_at" class="form-label">Ngày Gỡ</label>
                        <input id="removed_at"
                            value="{{ optional($post)->removed_at ? $post->removed_at->format('d-m-Y H:i') : '' }}"
                            name="removed_at" type="text" class="form-control" placeholder="Ngày gỡ">
                    </div>
                </div>

                <div class="card">

                    <div class="card-body">
                        <label for="image" class="form-label">Ảnh Đại Diện</label>
                        <img class="img-fluid img-thumbnail w-100" id="show_image" style="cursor: pointer"
                            src="{{ showImage($post->image ?? '') }}" alt=""
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
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js">
    </script>
    <script>
        $(document).ready(function() {

            updateCharCount('#excerpt', '500')
            updateCharCount('#title', '250')

            $('#published_at').datetimepicker({
                format: 'd-m-Y H:i', // Định dạng ngày/tháng/năm
                lang: 'vi', // Ngôn ngữ Tiếng Việt
            });

            $('#removed_at').datetimepicker({
                format: 'd-m-Y H:i', // Định dạng ngày/tháng/năm
                lang: 'vi', // Ngôn ngữ Tiếng Việt
            });

            var input = document.querySelector('#seo_keywords');
            var tagify = new Tagify(input, {
                maxTags: 10,
                placeholder: "Nhập từ khóa...",
            });

            var input = document.querySelector('#seo_tags');
            var tagify = new Tagify(input, {
                maxTags: 10,
                placeholder: "Nhập tags...",
            });

            submitForm('#myForm', function(response) {
                console.log(response);

                window.location.href = "{{ route('admin.posts.index') }}"
            });

            ckeditor('content')
        });
    </script>
@endpush
