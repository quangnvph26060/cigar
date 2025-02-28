@extends('backend.layouts.master')


@section('content')
    @include('backend.layouts.partials.breadcrumb', [
        'page' => 'Cấu hình chung',
    ])

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active fw-bold" id="info-tab" data-bs-toggle="tab" href="#info" role="tab"
                aria-controls="info" aria-selected="true">Cấu Hình Thông Tin</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link fw-bold" id="seo-tab" data-bs-toggle="tab" href="#seo" role="tab"
                aria-controls="seo" aria-selected="false">Cấu Hình Seo</a>
        </li>
    </ul>

    <form action="{{ route('admin.configs.post_config') }}" method="post" id="myForm">
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="info" role="tabpanel"
                                aria-labelledby="info-tab">
                                <div class="row">
                                    <div class="form-group mb-3 col-lg-12">
                                        <label for="title" class="form-label">Tiêu Đề Trang Chủ</label>
                                        <input type="text" value="{{ $config->title }}" name="title" id="title" placeholder="Tiêu Đề Trang Web"
                                            class="form-control">
                                    </div>

                                    <div class="form-group mb-3 col-lg-6">
                                        <label for="website_name" class="form-label">Tên Trang Web</label>
                                        <input value="{{ $config->website_name }}" type="text" name="website_name" id="website_name"
                                            placeholder="Tên Trang Web" class="form-control">
                                    </div>

                                    <div class="form-group mb-3 col-lg-6">
                                        <label for="email" class="form-label">Địa Chỉ Email</label>
                                        <input value="{{ $config->email }}" type="text" name="email" id="email" placeholder="Địa Chỉ Email"
                                            class="form-control">
                                    </div>

                                    <div class="form-group mb-3 col-lg-6">
                                        <label for="hotline" class="form-label">Số Điện Thoại Kinh Doanh</label>
                                        <input value="{{ $config->hotline }}" type="text" name="hotline" id="hotline"
                                            placeholder="Số Điện Thoại Kinh Doanh" class="form-control">
                                    </div>

                                    <div class="form-group mb-3 col-lg-6">
                                        <label for="phone_number" class="form-label">Số Điện Thoại Liên Hệ</label>
                                        <input value="{{ $config->phone_number }}" type="text" name="phone_number" id="phone_number"
                                            placeholder="Số Điện Thoại Liên Hệ" class="form-control">
                                    </div>

                                    <div class="form-group mb-3 col-lg-12">
                                        <label for="address" class="form-label">Địa Chỉ</label>
                                        <input value="{{ $config->address }}" type="text" name="address" id="address" placeholder="Địa Chỉ"
                                            class="form-control">
                                    </div>

                                    <div class="form-group mb-3 col-lg-12">
                                        <label for="copyright" class="form-label">Chân Trang</label>
                                        <input value="{{ $config->copyright }}" type="text" name="copyright" id="copyright" placeholder="Chân Trang"
                                            class="form-control">
                                    </div>

                                    <div class="form-group mb-3 col-lg-12">
                                        <label for="introduction" class="form-label">Giới Thiệu Trang Web</label>
                                        <textarea name="introduction" class="form-control ckeditor" id="introduction" placeholder="Giới Thiệu Trang Web">{!! $config->introduction !!}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                                <div class="form-group mb-3">
                                    <label for="seo_title" class="form-label">Tiêu đề seo</label>
                                    <input  type="text" value="{{ $config->seo_title }}" placeholder="Tiêu đề seo" id="seo_title"
                                        name="seo_title" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="seo_description" class="form-label">Mô tả seo</label>
                                    <textarea name="seo_description" id="seo_description" cols="30" rows="4" class="form-control"
                                        placeholder="Mô tả seo">{{ $config->seo_description }}</textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="seo_keywords" class="form-label">Từ khóa seo</label>
                                    <input id="seo_keywords" value="{{ $config->seo_keywords }}" name="seo_keywords">
                                </div>
                                <hr>
                                <div class="form-group mb-3">
                                    <label for="restriction_message" class="form-label">Cảnh Báo Pháp Lý</label>
                                    <input  type="text" value="{{ $config->restriction_message }}" placeholder="Cảnh Báo Pháp Lý"
                                        id="restriction_message" name="restriction_message" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="adult_only_policy" class="form-label">Chính sách giới hạn độ tuổi</label>
                                    <input type="text" value="{{ $config->adult_only_policy }}" placeholder="Chính sách giới hạn độ tuổi"
                                        id="adult_only_policy" name="adult_only_policy" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <label for="logo" class="form-label">Logo</label>
                        <img class="img-fluid img-thumbnail w-100" id="show_logo" style="cursor: pointer"
                            src="{{ showImage($config->logo) }}" alt="" onclick="document.getElementById('logo').click();">
                        <input type="file" name="logo" id="logo" class="form-control d-none"
                            accept="image/*" onchange="previewImage(event, 'show_logo')">
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label for="icon" class="form-label">Icon</label>
                        <img class="img-fluid img-thumbnail w-100" id="show_icon" style="cursor: pointer"
                            src="{{ showImage($config->icon) }}" alt="" onclick="document.getElementById('icon').click();">
                        <input type="file" name="icon" id="icon" class="form-control d-none"
                            accept="image/*" onchange="previewImage(event, 'show_icon')">
                    </div>

                    <div class=" card-footer d-flex justify-content-end">
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
@endsection


@push('scripts')
    <script src="{{ asset('backend/assets/js/tagify.min.js') }}"></script>
    <script src="{{ asset('backend/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(document).ready(function() {
            ckeditor('introduction');

            var input = document.querySelector('#seo_keywords');
            var tagify = new Tagify(input, {
                maxTags: 10,
                placeholder: "Nhập từ khóa...",
            });

            submitForm('#myForm', function(response) {
                Toast.fire({
                    icon: "success",
                    title: response.message
                });
            });
        })
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/tagify.css') }}">
@endpush
