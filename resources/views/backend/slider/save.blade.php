@extends('backend.layouts.master')


@section('content')
    @include('backend.layouts.partials.breadcrumb', [
        'page' => 'Thêm mới slider',
        'href' => route('admin.sliders.index'),
    ])

    @php
        $action = $slider ? route('admin.sliders.update', $slider) : route('admin.sliders.store');
    @endphp

    <form id="myForm" action="{{ $action }}" method="post" enctype="multipart/form-data">
        @if ($slider)
            @method('PUT')
        @endif
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Cấu Hình Slider</h4>

                <div class="card-tool">
                    <button id="add-slider" type="button" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Thêm
                        Slider</button>
                </div>

            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="type" class="form-label">Tên</label>
                    <input type="text" placeholder="Tên" name="name" id="name" class="form-control">
                    {{-- <select name="type" id="type" class="form-select">
                        <option value="big" @selected(optional($slider)->type == 'big')>Slider Lớn</option>
                        <option value="small" @selected(optional($slider)->type == 'small')>Slider Nhỏ</option>
                    </select> --}}
                </div>
                <div class="sliders">
                    {{-- @dd($slider->items) --}}
                    @foreach ($slider->items ?? [] as $key => $item)
                        <div class="slider-container mb-3" data-id="{{ $key + 1 }}">
                            <div class="slider-item">
                                <div class="slider-left">
                                    <span class="handle"><i class="fas fa-list"></i></span>
                                    <img class="img-fluid img-thumbnail preview-img" id="show_image_{{ $key }}"
                                        src="{{ showImage($item['image'], 'banner_defaut.jpg') }}" alt=""
                                        onclick="document.getElementById('image_{{ $key }}').click();">
                                    <input type="file" name="items[{{ $key + 1 }}][image]"
                                        id="image_{{ $key }}" class="image-input d-none" accept="image/*"
                                        onchange="previewImage(event, 'show_image_{{ $key }}')">
                                </div>

                                <div class="slider-right">
                                    <input type="text" class="form-control title-input" value="{{ $item['title'] }}"
                                        placeholder="Tiêu đề" name="items[{{ $key + 1 }}][title]">
                                    <input type="text" class="form-control alt-input" placeholder="Alt Text"
                                        name="items[{{ $key + 1 }}][alt]" value="{{ $item['alt'] }}">
                                    <input type="text" class="form-control url-input" placeholder="URL"
                                        name="items[{{ $key + 1 }}][url]" value="{{ $item['url'] }}">
                                    <input type="hidden" class="position-input"
                                        name="items[{{ $key + 1 }}][position]" value="{{ $key + 1 }}">
                                </div>
                                <button type="button" class="btn-remove"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <button id="submitBtn" class="btn btn-primary btn-sm d-flex align-items-center gap-2" type="submit">
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <i class="fas fa-save me-1"></i> Lưu
                </button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            @php
                $maxPosition = !empty($slider->items) ? collect($slider->items)->max('position') + 1 : 1;
            @endphp

            let sliderIndex = {{ $maxPosition }};

            function createSliderItem(id) {
                return `
                    <div class="slider-container mb-3" data-id="${id}">
                        <div class="slider-item">
                            <div class="slider-left">
                                <span class="handle"><i class="fas fa-list"></i></span>
                                <img class="img-fluid img-thumbnail preview-img" id="show_image_${id}"
                                    src="{{ showImage('', 'banner_defaut.jpg') }}" alt=""
                                    onclick="document.getElementById('image_${id}').click();">
                                <input type="file" name="items[${id}][image]" id="image_${id}" class="image-input d-none"
                                    accept="image/*" onchange="previewImage(event, 'show_image_${id}')">
                            </div>
                            <div class="slider-right">
                                <input type="text" class="form-control title-input" placeholder="Tiêu đề" name="items[${id}][title]">
                                <input type="text" class="form-control alt-input" placeholder="Alt Text" name="items[${id}][alt]">
                                <input type="text" class="form-control url-input" placeholder="URL" name="items[${id}][url]">
                                <input type="hidden" class="position-input" name="items[${id}][position]" value="${id}">
                            </div>
                            <button type="button" class="btn-remove"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                `;
            }

            // Thêm slider mặc định khi trang load
            @if (empty($slider->items))
                $(".card-body .sliders").append(createSliderItem(sliderIndex++));
            @endif

            // Thêm slider mới
            $("#add-slider").click(function() {
                $(".card-body .sliders").append(createSliderItem(sliderIndex++));
            });

            // Xóa slider (chỉ xóa nếu có nhiều hơn 1 slider)
            $(document).on("click", ".btn-remove", function() {
                // Kiểm tra nếu có nhiều hơn 1 slider thì mới cho phép xóa
                if ($(".slider-container").length > 1) {
                    // Xóa slider và cập nhật lại vị trí của các slider còn lại
                    $(this).closest(".slider-container").fadeOut(300, function() {
                        // Sau khi xóa, gọi hàm cập nhật lại vị trí
                        $(this).remove();
                        updateSliderOrder();
                    });
                }
            });

            // Kéo thả để thay đổi vị trí
            $(".card-body .sliders").sortable({
                handle: ".handle",
                placeholder: "ui-state-highlight",
                update: function(event, ui) {
                    updateSliderOrder(); // Cập nhật lại vị trí sau khi kéo thả
                }
            });

            // Hàm cập nhật lại vị trí
            function updateSliderOrder() {
                $(".slider-container").each(function(index) {
                    // Cập nhật giá trị position cho các slider
                    $(this).find(".position-input").val(index + 1); // Thứ tự bắt đầu từ 1
                });
            }

            submitForm('#myForm', function(response) {
                window.location.href = "{{ route('admin.sliders.index') }}"
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .slider-container {
            margin: auto;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .slider-item {
            display: flex;
            align-items: center;
            background: #ffffff;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 10px;
            gap: 10px;
            width: 100%;
            min-height: 150px;
        }

        .slider-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .slider-left img {
            width: 200px;
            /* Giữ nguyên kích thước ảnh */
            height: 135px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .slider-right {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            gap: 5px;
            min-width: 0;
        }


        .slider-right input {
            width: 100%;
        }

        .handle {
            cursor: grab;
            font-size: 20px;
            color: #6c757d;
        }

        .btn-remove {
            position: absolute;
            right: 0px;
            top: 0px;
            background: #dc3545;
            border: none;
            color: white;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-remove:hover {
            background: #c82333;
        }
    </style>
@endpush
