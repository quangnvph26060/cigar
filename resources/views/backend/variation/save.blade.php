@extends('backend.layouts.master')


@section('content')
    @include('backend.layouts.partials.breadcrumb', [
        'page' => isset($variation) ? 'Sửa biến thể' : 'Thêm mới biến thể',
        'href' => route('admin.variations.index'),
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
        {{-- @csrf --}}
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

                                        {{-- @dd($attributes_variation->attributes) --}}
                                        <div id="additional-selects" class="mt-3 row">

                                            @if (isset($variation))
                                                @foreach ($attributes_variation_values as $item)
                                                    <div class="col-lg-4 mb-3 form-grou"
                                                        id="select-wrapper-{{ $item->attribute->id }}">
                                                        <label
                                                            for="select-${selectedId}">{{ $item->attribute->name }}</label>
                                                        {{-- @dd($item->attribute->attributeValues); --}}
                                                        <select name="attribute_value_id[{{ $item->attribute->id }}][attribute_value_id]"
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
                                        <div id="additional-detail" class="form-group">

                                        </div>
                                    </div>

                                    <div class="form-group mb-3 col-lg-12">
                                        <label for="slug" class="form-label">Mô tả chi tiết</label>
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

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Sản phẩm</h5>
                    </div>

                    <div class="card-body">
                        <select id="product_id" class="form-select select2" name="product_id">
                            <option value="">Chọn sản phẩm</option>
                            @foreach ($products as $item)
                                <option value="{{ $item->id }}"
                                    {{ isset($variation) && $variation->product_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }} - {{ $item->code }}
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

            var input_tags = document.querySelector('#tags');
            var tagify_tags = new Tagify(input_tags, {
                maxTags: 10,
                placeholder: "Nhập tags...",
            });

            submitForm('#myForm', function(response) {
                window.location.href = "{{ route('admin.variations.index') }}"
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
            ckeditor('seo_description')

            // formatDataInput('price');
        });
    </script>

    <script>
        $(document).ready(function() {
            var container = $("#additional-detail");

            // Kiểm tra nếu $variation tồn tại thì lấy dữ liệu, ngược lại dùng mảng rỗng
            var pricesData = {
                prices: @json(isset($variation) ? json_decode($variation->prices, true) : []),
                quantity: @json(isset($variation) ? json_decode($variation->quantity, true) : []),
                unit: @json(isset($variation) ? json_decode($variation->unit, true) : []),
            };

            function createForm(price = "", quantity = "", unit = "") {
                return `
                    <div class="row form-group-item">
                        <div class="form-group  col-lg-4">
                            <label class="form-label">Price</label>
                            <input name="prices[]" class="form-control" type="text" placeholder="Giá" value="${price}">
                        </div>

                        <div class="form-group  col-lg-2">
                            <label class="form-label">Số lượng</label>
                            <input name="quantity[]" class="form-control" type="text" placeholder="number" value="${quantity}">
                        </div>

                        <div class="form-group  col-lg-4">
                            <label class="form-label">Đơn vị</label>
                            <input name="unit[]" class="form-control" type="text" placeholder="Đơn vị" value="${unit}">
                        </div>

                        <div class="form-group  col-lg-2 d-flex align-items-end">
                            <div class="d-flex gap-1">
                                <button type="button" class="btn btn-success btn-sm p-2 add-form">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm p-2 remove-form d-none">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                `;
            }

            function updateRemoveButtons() {
                var totalForms = $(".form-group-item").length;
                $(".form-group-item").each(function() {
                    if (totalForms === 1) {
                        $(this).find(".remove-form").addClass("d-none");
                    } else {
                        $(this).find(".remove-form").removeClass("d-none");
                    }
                });
            }

            // Xóa form cũ trước khi thêm mới từ JSON
            container.empty();

            // Kiểm tra nếu có dữ liệu từ JSON thì load, ngược lại hiển thị form trống
            if (pricesData.prices.length > 0) {
                for (var i = 0; i < pricesData.prices.length; i++) {
                    container.append(createForm(
                        pricesData.prices[i] ?? "",
                        pricesData.quantity[i] ?? "",
                        pricesData.unit[i] ?? ""
                    ));
                }
            } else {
                container.append(createForm());
            }

            updateRemoveButtons();

            // Sự kiện thêm form
            container.on("click", ".add-form", function() {
                $(this).closest(".form-group-item").after(createForm());
                updateRemoveButtons();
            });

            // Sự kiện xóa form
            container.on("click", ".remove-form", function() {
                if ($(".form-group-item").length > 1) {
                    $(this).closest(".form-group-item").remove();
                    updateRemoveButtons();
                }
            });
        });
    </script>
@endpush
