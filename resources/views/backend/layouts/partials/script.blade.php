    <!--   Core JS Files   -->
    <script src="{{ asset('backend/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('backend/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Chart JS -->
    <script src="{{ asset('backend/assets/js/plugin/chart.js/chart.min.js') }}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('backend/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Chart Circle -->
    <script src="{{ asset('backend/assets/js/plugin/chart-circle/circles.min.js') }}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ asset('backend/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Kaiadmin JS -->
    <script src="{{ asset('backend/assets/js/kaiadmin.min.js') }}"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="{{ asset('backend/assets/js/setting-demo.js') }}"></script>

    @include('backend.layouts.partials.alert')

    <script>
        const BASE_URL = "{{ url('/') }}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        const previewImage = function(event, imgId) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function() {
                const imgElement = document.getElementById(imgId);
                imgElement.src = reader.result;
            };
            if (file) {
                reader.readAsDataURL(file);
            }
        };

        const convertSlug = (sourceSelector, targetSelector) => {
            let text = $(sourceSelector).val();

            let slug = text
                .toLowerCase()
                .trim()
                .normalize("NFD")
                .replace(/[\u0300-\u036f]/g, "") // Loại bỏ dấu tiếng Việt
                .replace(/đ/g, "d")
                .replace(/Đ/g, "D") // Chuyển đ -> d
                .replace(/[^a-z0-9 -]/g, "") // Xóa ký tự đặc biệt
                .replace(/\s+/g, "-") // Thay khoảng trắng bằng dấu -
                .replace(/-+/g, "-"); // Xóa dấu - dư thừa

            $(targetSelector).val(slug);
        }

        function submitForm(formId, successCallback) {

            $(formId).on('submit', function(e) {
                e.preventDefault();

                let type = $(this).attr('data-type');

                var submitBtn = $("#submitBtn");
                var spinner = submitBtn.find(".spinner-border");

                // Disable nút và hiển thị hiệu ứng loading
                submitBtn.prop("disabled", true);
                spinner.removeClass("d-none");

                // Kiểm tra xem CKEditor đã được khởi tạo trên textarea chưa
                $('textarea.ckeditor').each(function() {
                    const editorId = this.id;

                    // Nếu CKEditor chưa được khởi tạo, khởi tạo nó
                    if (!CKEDITOR.instances[editorId]) {
                        CKEDITOR.replace(editorId, {
                            filebrowserUploadMethod: 'form'
                        });
                    } else {
                        // Nếu CKEditor đã được khởi tạo, cập nhật giá trị của nó
                        CKEDITOR.instances[editorId].updateElement();
                    }
                });


                var formData = new FormData(this);

                if (type && type !== undefined && type.toUpperCase() === 'PUT') {
                    formData.append('_method', 'PUT');
                }

                $.ajax({
                    url: $(formId).attr('action'),
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log('Dữ liệu đã được gửi thành công', response);
                        if (typeof successCallback === 'function') {
                            successCallback(response);
                        }
                    },
                    error: function(xhr, status, error) {

                        Toast.fire({
                            icon: "error",
                            title: xhr.responseJSON.message
                        });

                        console.log('Lỗi khi gửi dữ liệu: ', error);
                    },
                    complete: function() {
                        // Khôi phục trạng thái nút sau khi API hoàn tất (thành công hoặc lỗi)
                        submitBtn.prop("disabled", false);
                        spinner.addClass("d-none");
                    }
                });
            });

            // let isFormChanged = false;

            // // Khi có bất kỳ thay đổi nào trong form
            // $(formId).on('change input', function() {
            //     isFormChanged = true;
            // });

            // // Cảnh báo khi rời khỏi trang
            // $(window).on('beforeunload', function(e) {
            //     if (isFormChanged) {
            //         return "Bạn có chắc chắn muốn rời khỏi trang? Những thay đổi chưa được lưu sẽ mất.";
            //     }
            // });

            // // Xử lý khi bấm nút reload hoặc chuyển trang nội bộ
            // $('a').on('click', function(e) {
            //     if (isFormChanged) {
            //         let confirmLeave = confirm("Bạn có thay đổi chưa lưu. Bạn có chắc muốn rời đi?");
            //         if (!confirmLeave) {
            //             e.preventDefault(); // Hủy hành động nếu người dùng bấm "Hủy"
            //         }
            //     }
            // });
        }
    </script>


    @stack('scripts')
