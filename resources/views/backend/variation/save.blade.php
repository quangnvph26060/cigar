@extends('backend.layouts.master')


@section('content')
    @include('backend.layouts.partials.breadcrumb', [
        'page' => isset($variation)
            ? 'Sửa biến thể của sản phẩm : ' . $product->name
            : 'Thêm mới biến thể của sản phẩm: ' . $product->name,

        'href' => route('admin.variations.product.index', ['id' => $product->id]),
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
        $action = isset($variation) ? route('admin.variations.update', $variation) : route('admin.variations.store');
    @endphp

    <form action="{{ $action }}" method="post" enctype="multipart/form-data" id="myForm">

        @isset($variation)
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
                                        <label for="name" class="form-label">Tên biến thể<span
                                                class="text-danger">*</span></label>
                                        <input value="{{ $variation->name ?? '' }}" oninput="convertSlug('#name', '#slug')"
                                            id="name" name="name" class="form-control" type="text"
                                            placeholder="Tên thương hiệu">
                                    </div>

                                    <div class="form-group mb-3 col-lg-6">
                                        <label for="slug" class="form-label">Đường dẫn thân thiện</label>
                                        <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Không nhập sẽ lấy theo tên"></i>
                                        <input id="slug" value="{{ $variation->slug ?? '' }}" name="slug"
                                            class="form-control" type="text" placeholder="Đường dẫn thân thiện">
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <label class="form-label" for="">Thuộc tính</label>
                                        <select id="mySelect" multiple="multiple" class="form-select"
                                            name="attribute_id[]">
                                            @php
                                                $attributeIds = isset($variation)
                                                    ? $variation->attributes->pluck('id')->toArray()
                                                    : [];
                                            @endphp

                                            @foreach ($attributes as $item)
                                                <option @selected(in_array($item->id, $attributeIds)) value="{{ $item->id }}">
                                                    {{ $item->name }}</option>
                                            @endforeach

                                        </select>
                                        <div id="additional-selects" class="mt-3 row">

                                            @if (isset($variation))
                                                @foreach ($attributes_variation_values as $item)
                                                    <div class="col-lg-4 mb-3 form-grou"
                                                        id="select-wrapper-{{ $item->attribute->id }}">
                                                        <label
                                                            for="select-${selectedId}">{{ $item->attribute->name }}</label>
                                                        <select
                                                            name="attribute_value_id[{{ $item->attribute->id }}][attribute_value_id]"
                                                            id="select-{{ $item->attribute->id }}" class="form-select"
                                                            style="width: 100%;">
                                                            @foreach ($item->attribute->attributeValues as $value)
                                                                <option @selected($item->attribute_value_id == $value->id)
                                                                    value="{{ $value->id }}">{{ $value->value }}
                                                                </option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                @endforeach
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-lg-12 form-group">
                                        <div id="additional-detail">
                                            @foreach ($variation->priceVariants as $index => $pv)
                                                <div class="row mb-3">
                                                    <div class="col-lg-2">
                                                        <label for="price" class="form-label">Giá</label>
                                                        <input class="form-control" type="text"
                                                            name="options[{{ $index }}][price]"
                                                            value="{{ $pv->price }}">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="discount_value" class="form-label">Giá Khuyến
                                                            mãi</label>
                                                        <input class="form-control" type="text"
                                                            name="options[{{ $index }}][discount_value]"
                                                            value="{{ $pv->discount_value }}">
                                                    </div>
                                                    <div class="col-lg-3-5">
                                                        <label for="discount_start" class="form-label">Ngày bắt đầu</label>
                                                        <input class="form-control" type="date"
                                                            name="options[{{ $index }}][discount_start]"
                                                            value="{{ $pv->discount_start ? $pv->discount_end->format('Y-m-d') : '' }}">
                                                    </div>
                                                    <div class="col-lg-3-5">
                                                        <label for="discount_end" class="form-label">Ngày kết thúc</label>
                                                        <input class="form-control" type="date"
                                                            name="options[{{ $index }}][discount_end]"
                                                            value="{{ $pv->discount_end ? $pv->discount_end->format('Y-m-d') : '' }}">

                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="unit" class="form-label">Đơn vị</label>
                                                        <input class="form-control" type="text"
                                                            name="options[{{ $index }}][unit]"
                                                            value="{{ $pv->unit }}">
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <button type="button"
                                                            class="btn {{ $loop->first ? 'btn-primary add-detail' : 'btn-danger remove-detail' }}"
                                                            style="margin-top: 2rem !important;">
                                                            <i
                                                                class="fa-solid {{ $loop->first ? 'fa-plus' : 'fa-minus' }}"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>

                                    <div class="form-group mb-3 col-lg-12">
                                        <label for="short_description" class="form-label">Mô tả ngắn</label>
                                        <textarea name="short_description" class="form-control" id="short_description" rows="3" placeholder="Mô tả ngắn">{{ $variation->short_description ?? '' }}</textarea>
                                    </div>

                                    <div class="form-group mb-3 col-lg-12">
                                        <label for="description" class="form-label">Mô tả chi tiết</label>
                                        <textarea name="description" class="form-control" id="description" placeholder="Mô tả seo">{!! $variation->description ?? '' !!}</textarea>
                                    </div>

                                    <div class="row form-group-item">
                                        <div class="form-group mb-3 col-lg-3">
                                            <label class="form-label">Đánh giá</label>
                                            <input name="rating" class="form-control" type="number"
                                                placeholder="Dánh giá">
                                        </div>

                                        <div class="form-group mb-3 col-lg-3">
                                            <label class="form-label">Chất lượng</label>
                                            <input name="quality" class="form-control" type="number"
                                                placeholder="Chất lượng">
                                        </div>

                                        <div class="form-group mb-3 col-lg-3">
                                            <label class="form-label">Bán kính</label>
                                            <input name="radius" id='radius' class="form-control" type="text"
                                                placeholder="Bán kính">
                                        </div>

                                        <div class="form-group mb-3 col-lg-3 ">
                                            <label class="form-label">Chiều dài</label>
                                            <input name="length" id='length' class="form-control" type="text"
                                                placeholder="Chiều dài">
                                        </div>
                                    </div>


                                    <div class="form-group mb-3">
                                        <label for="tags" class="form-label">Tags</label>
                                        <input id="tags" class="form-control" value="{{ $variation->tags ?? '' }}"
                                            name="tags">
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                                <div class="form-group mb-3">
                                    <label for="seo_title" class="form-label">Tiêu đề seo</label>
                                    <input type="text" value="{{ $variation->seo_title ?? '' }}"
                                        placeholder="Tiêu đề seo" id="seo_title" name="seo_title" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="seo_description" class="form-label">Mô tả seo</label>
                                    <textarea name="seo_description" id="seo_description" cols="30" rows="4" class="form-control"
                                        placeholder="Mô tả seo">{{ $variation->seo_description ?? '' }}</textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="seo_keywords" class="form-label">Từ khóa seo</label>
                                    <input id="seo_keywords" value="{{ $variation->seo_keywords ?? '' }}"
                                        name="seo_keywords">
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">

                <input type="hidden" name="product_id" value="{{ $id }}">

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Trạng thái</h5>
                    </div>

                    <div class="card-body">
                        <select name="status" id="status" class="form-select">
                            <option value="1" @selected(($variation->status ?? 1) == 1)>Xuất bản</option>
                            <option value="2" @selected(($variation->status ?? '') == 2)>Chưa xuất bản</option>
                        </select>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Ảnh đại điện</h5>
                    </div>

                    <div class="card-body">

                        <img class="img-fluid img-thumbnail w-100" id="show_image" style="cursor: pointer"
                            src="{{ showImage($variation->image ?? '') }}" alt=""
                            onclick="document.getElementById('image').click();">
                        <input type="file" name="image" id="image" class="form-control d-none"
                            accept="image/*" onchange="previewImage(event, 'show_image')">
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Albums</h5>
                    </div>

                    <div class="card-body">

                        <div class="input-images"></div>

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
    <link rel="stylesheet" href="{{ asset('backend/assets/css/image-uploader.min.css') }}">
    <style>
        @media (min-width: 992px) {
            .col-lg-3-5 {
                flex: 0 0 auto;
                width: 20%;
            }
        }

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
    <script src="{{ asset('backend/assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/tagify.min.js') }}"></script>
    <script src="{{ asset('backend/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('backend/assets/js/image-uploader.min.js') }}"></script>
    @php
        $preloaded =
            isset($images) && $images->isNotEmpty()
                ? $images->map(function ($image) {
                    return [
                        'src' => asset('storage/' . $image->image_path), // Đường dẫn ảnh
                        'id' => $image->id, // ID của ảnh
                    ];
                })
                : [];
    @endphp
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
            let id = "{{ $id }}";

            submitForm('#myForm', function(response) {
                window.location.href = "{{ route('admin.variations.product.index', ['id' => '__ID__']) }}"
                    .replace('__ID__', id);
            });

            $('#product_id').select2({
                placeholder: 'Chọn một sản phẩm',
                allowClear: true
            })

            $('#mySelect').select2({
                placeholder: 'Chọn một tùy chọn',
                allowClear: true
            }).on("select2:select", function(evt) {
                let element = evt.params.data.element;
                let $element = $(element);
                $element.detach();
                $(this).append($element).trigger("change");

                const selectedId = evt.params.data.id;
                const selectedText = evt.params.data.text;

                $.ajax({
                    url: "{{ route('admin.variations.attributes-values') }}",
                    method: "POST",
                    data: {
                        selectedId
                    },
                    success: function(response) {
                        console.log(response.data);
                        let optionsHtml = '<option value="">Chọn giá trị</option>';
                        $.each(response.data, function(_, item) {
                            optionsHtml +=
                                `<option value="${item.id}">${item.value}</option>`;
                        });

                        const newSelectHtml = `
                         <div class="col-lg-4 mb-3" id="select-wrapper-${selectedId}">
                            <label for="select-${selectedId}">${selectedText}</label>
                            <select name="attribute_value_id[${selectedId}][attribute_value_id]" id="select-${selectedId}" class="form-select" style="width: 100%;">
                                ${optionsHtml}
                            </select>
                        </div>
                    `;

                        $('#additional-selects').append(newSelectHtml);
                    }
                })
            });


            $('#mySelect').on('select2:unselect', function(e) {
                const unselectedId = e.params.data.id;

                $(`#select-wrapper-${unselectedId}`).remove();
            });

            ckeditor('description')

            const preloaded = @json($preloaded);;

            $('.input-images').imageUploader({
                preloaded: preloaded, // Ảnh đã có sẵn
                imagesInputName: 'images', // Tên input khi upload ảnh mới
                preloadedInputName: 'old', // Tên input chứa ảnh cũ
                maxSize: 2 * 1024 * 1024, // Giới hạn ảnh 2MB
                maxFiles: 15, // Tối đa 15 ảnh
            });

            var container = $("#additional-detail")

        });
    </script>

    <script>
        $(document).ready(function() {

            let counter =
                {{ isset($variation->priceVariants) ? $variation->priceVariants->count() : 0 }}; // Biến đếm để thay đổi chỉ số trong tên trường

            let _html = (index, isFirst = false) => `
                <div class="row mb-3">
                    <div class="col-lg-2">
                        <label for="price" class="form-label">Giá</label>
                        <input class="form-control" type="text" name="options[${index}][price]">
                    </div>
                    <div class="col-lg-2">
                        <label for="discount_value" class="form-label">Giá Khuyến mãi</label>
                        <input class="form-control" type="text" name="options[${index}][discount_value]">
                    </div>
                    <div class="col-lg-3-5">
                        <label for="discount_start" class="form-label">Ngày bắt đầu</label>
                        <input class="form-control" type="date" name="options[${index}][discount_start]">
                    </div>
                    <div class="col-lg-3-5">
                        <label for="discount_end" class="form-label">Ngày kết thúc</label>
                        <input class="form-control" type="date" name="options[${index}][discount_end]">
                    </div>
                    <div class="col-lg-2">
                        <label for="unit" class="form-label">Đơn vị</label>
                        <input class="form-control" type="text" name="options[${index}][unit]">
                    </div>
                    <div class="col-lg-1">
                        <button type="button" class="btn ${isFirst ? 'btn-primary add-detail' : 'btn-danger remove-detail'}" style="margin-top: 2rem !important;">
                            <i class="fa-solid ${isFirst ? 'fa-plus' : 'fa-minus'}"></i>
                        </button>
                    </div>
                </div>
            `;

            var hasPriceVariants = @json($variation->priceVariants->count() > 0);

            if (!hasPriceVariants) {
                $('#additional-detail').append(_html(counter, true));
                counter++;
            }


            $('.add-detail').on('click', function() {
                $('#additional-detail').append(_html(counter));
                counter++;
            });

            $(document).on('click', '.remove-detail', function() {
                $(this).closest('.row').remove();
            });

            updateCharCount('#seo_description', 150)

        });
    </script>
@endpush
