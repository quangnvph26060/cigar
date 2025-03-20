@extends('backend.layouts.master')


@section('content')
    @include('backend.layouts.partials.breadcrumb', [
        'page' => isset($product) ? 'Sửa sản phẩm' : 'Thêm mới sản phẩm',
        'href' => route('admin.products.index'),
    ])

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active fw-bold" id="info-tab" data-bs-toggle="tab" href="#info" role="tab"
                aria-controls="info" aria-selected="true">Thông Tin Sản Phẩm</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link fw-bold" id="seo-tab" data-bs-toggle="tab" href="#seo" role="tab"
                aria-controls="seo" aria-selected="false">Cấu Hình Seo</a>
        </li>
    </ul>

    @php
        $action = isset($product) ? route('admin.products.update', $product) : route('admin.products.store');
    @endphp

    <form action="{{ $action }}" method="post" enctype="multipart/form-data" id="myForm">

        @isset($product)
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
                                        <label for="name" class="form-label">Tên sản phẩm<span
                                                class="text-danger">*</span></label>
                                        <input value="{{ $product->name ?? '' }}" oninput="convertSlug('#name', '#slug')"
                                            id="name" name="name" class="form-control" type="text"
                                            placeholder="Tên thương hiệu">
                                    </div>

                                    <div class="form-group mb-3 col-lg-6">
                                        <label for="slug" class="form-label">Đường dẫn thân thiện</label>
                                        <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Không nhập sẽ lấy theo tên"></i>
                                        <input id="slug" value="{{ $product->slug ?? '' }}" name="slug"
                                            class="form-control" type="text" placeholder="Đường dẫn thân thiện">
                                    </div>

                                    <div class="form-group mb-3 col-lg-3">
                                        <label for="price" class="form-label">Giá bán</label>
                                        <input type="text" value="{{ $product->price ?? '' }}" name="price"
                                            id="price" class="form-control">
                                    </div>
                                    <div class="form-group mb-3 col-lg-3">
                                        <label for="discount_value" class="form-label">Giá khuyến mãi</label>
                                        <input type="text" value="{{ $product->discount_value ?? '' }}"
                                            name="discount_value" id="discount_value" class="form-control">
                                    </div>

                                    <div class="form-group mb-3 col-lg-3">
                                        <label for="discount_start" class="form-label">Ngày bắt đầu</label>
                                        <input type="date"
                                            value="{{ optional($product)->discount_start ? $product->discount_start->format('Y-m-d') : '' }}"
                                            name="discount_start" id="discount_start" class="form-control">
                                    </div>
                                    <div class="form-group mb-3 col-lg-3">
                                        <label for="discount_end" class="form-label">Ngày kết thúc</label>
                                        <input type="date"
                                            value="{{ optional($product)->discount_end ? $product->discount_end->format('Y-m-d') : '' }}"
                                            name="discount_end" id="discount_end" class="form-control">
                                    </div>

                                    <div class="form-group mb-3 col-lg-12">
                                        <label for="slug" class="form-label">Mô tả chi tiết</label>
                                        <textarea name="description" class="form-control" id="description" placeholder="Mô tả seo">{!! $products->description ?? '' !!}</textarea>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="tags" class="form-label">Tags</label>
                                        <input id="tags" class="form-control" value="{{ $product->tags ?? '' }}"
                                            name="tags">
                                    </div>

                                    <div class="form-group mb-3">
                                        <div class="mb-3">
                                            <label for="videos" class="form-label fw-bold">Chọn file MP3:</label>
                                            <input class="form-control filepond" type="file" name="videos[]" multiple
                                                accept="video/mp4">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                                <div class="form-group mb-3">
                                    <label for="seo_title" class="form-label">Tiêu đề seo</label>
                                    <input type="text" value="{{ $product->seo_title ?? '' }}"
                                        placeholder="Tiêu đề seo" id="seo_title" name="seo_title" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="seo_description" class="form-label">Mô tả seo</label>
                                    <textarea name="seo_description" id="seo_description" cols="30" rows="4" class="form-control"
                                        placeholder="Mô tả seo">{{ $product->seo_description ?? '' }}</textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="seo_keywords" class="form-label">Từ khóa seo</label>
                                    <input id="seo_keywords" value="{{ $product->seo_keywords ?? '' }}"
                                        name="seo_keywords">
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">

                @isset($product)
                    <div class="card">
                        <div class="card-body m-auto">
                            <label for="qr-code"></label>
                            <a id="downloadQrCode" href="{{ showImage($product->qr_code) }}"
                                download="qr_code_{{ $product->id }}.png">
                                <img width="150" height="150" src="{{ showImage($product->qr_code) }}" alt="QR Code">
                            </a>
                        </div>
                    </div>
                @endisset

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Danh mục</h5>
                    </div>

                    <div class="card-body">
                        <select id="category_id" class="form-select select2" name="category_id">
                            <option value="">Chọn danh mục</option>
                            @foreach ($categorys as $item)
                                <option value="{{ $item->id }}"
                                    {{ isset($product) && $product->category_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Thương hiệu</h5>
                    </div>

                    <div class="card-body">
                        <select id="brand_id" class="form-select select2" name="brand_id">
                            <option value="">Chọn sản phẩm</option>
                            @foreach ($brands as $item)
                                <option value="{{ $item->id }}"
                                    {{ isset($product) && $product->brand_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Trạng thái</h5>
                    </div>

                    <div class="card-body">
                        <select name="status" id="status" class="form-select">
                            <option value="1" @selected(($product->status ?? 1) == 1)>Xuất bản</option>
                            <option value="2" @selected(($product->status ?? '') == 2)>Chưa xuất bản</option>
                        </select>
                    </div>
                </div>



                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Ảnh đại điện</h5>
                    </div>

                    <div class="card-body">

                        <img class="img-fluid img-thumbnail w-100" id="show_image" style="cursor: pointer"
                            src="{{ showImage($product->image ?? '') }}" alt=""
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
    {{-- <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css"> --}}
    <link rel="stylesheet" href="{{ asset('backend/assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/tagify.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/image-uploader.min.css') }}">

    <style>
        .col-lg-9 .card {
            border-top-left-radius: 0 !important;
            border-top-right-radius: 0 !important;
            border: 1px solid #eee;
        }

        .video-container {
            display: none;
            margin-top: 15px;
            border-radius: 10px;
            overflow: hidden;
        }

        video,
        iframe {
            width: 100%;
            border-radius: 10px;
            height: 350px;
            border: 2px solid #ccc;
        }

        .upload-text span {
            display: none !important;
        }

        .image-uploader .uploaded .uploaded-image {
            width: calc(50% - 1rem);
            padding-bottom: calc(50% - 1rem);
        }
    </style>
@endpush

@push('scripts')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js">
    </script> --}}
    <script src="{{ asset('backend/assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/tagify.min.js') }}"></script>
    <script src="{{ asset('backend/ckeditor/ckeditor.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-fileinput/js/fileinput.min.js"></script>
    <script src="{{ asset('backend/assets/js/image-uploader.min.js') }}"></script>
    <script>
        $(document).ready(function() {


            var input = document.querySelector('#seo_keywords');
            var tagify = new Tagify(input, {
                maxTags: 10,
                placeholder: "Nhập từ khóa...",
            });

            var input_tags = document.querySelector('#tags');
            var tagify_tags = new Tagify(input_tags, {
                maxTags: 10,
                placeholder: "Nhập tags...",
            });

            $('#brand_id').select2({
                placeholder: 'Chọn một sản phẩm',
                allowClear: true
            })

            $('#category_id').select2({
                placeholder: 'Chọn một danh mục',
                allowClear: true
            })

            submitForm('#myForm', function(response) {
                window.location.href = "{{ route('admin.products.index') }}"
            });

            ckeditor('description')

            // formatDataInput('price');

            const preloaded = [];

            $('.input-images').imageUploader({
                preloaded: preloaded, // Ảnh đã có sẵn
                imagesInputName: 'images', // Tên input khi upload ảnh mới
                preloadedInputName: 'old', // Tên input chứa ảnh cũ
                maxSize: 2 * 1024 * 1024, // Giới hạn ảnh 2MB
                maxFiles: 15, // Tối đa 15 ảnh
            });

            // $('#discount_start').datetimepicker({
            //     format: 'd-m-Y H:i',
            //     lang: 'vi',
            // });

            // $('#discount_end').datetimepicker({
            //     format: 'd-m-Y H:i',
            //     lang: 'vi',
            // });
        });
    </script>
@endpush
