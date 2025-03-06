<script type="text/javascript" src="{{ asset('frontend/assets/js/d22fe7711ff92d80f2f762880f07a130_6247782101.js') }}">
</script>

<script id="usercentrics-cmp" data-settings-id="723havn0HOgc0G" data-language="de"
    src="{{ asset('frontend/assets/js/loader.js') }}"></script>

<script charset="UTF-8" src="{{ asset('frontend/assets/js/XB329D0FECA1C20BC34639A428C44B4FC.js') }}"></script>



<script type="text/javascript" src="{{ asset('frontend/assets/js/54c5eefa0c4476ebac1af24c57f5ab32_16770458357.js') }}">
</script>


<script src="https://www.ws-connex.de/jsloader/509222017/search:2.2"></script>

<script src="{{ asset('frontend/assets/js/custom.js') }}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function showNotification(data) {
        let notification = document.getElementById("cartNotification");

        let productList = "";
        $.each(data, function(index, item) {
            productList += `
                <div class="product-info">
                    <span><strong>${item.name}</strong></span>
                    <span>${item.price} €<small>/${item.unit}</small> x ${item.qty}</span>
                </div>
        `;
        });

        notification.innerHTML = `
            <button class="close-btn" onclick="hideNotification()">×</button>
            <h4>Giỏ hàng</h4>
            ${productList}
            <a href="{{ route('cartList') }}" class="view-cart">Xem giỏ hàng</a>
    `;

        notification.classList.add("show");

        // Tự động ẩn sau 3 giây
        setTimeout(() => {
            hideNotification();
        }, 3000);
    }

    function hideNotification() {
        let notification = document.getElementById("cartNotification");
        notification.style.bottom = "-100px";
        notification.style.opacity = "0";
        notification.classList.remove("show");
    }

    function submitFormWithDelay() {
        const params = new URLSearchParams(window.location.search); // Lấy tất cả tham số hiện tại
        const formInputs = document.querySelectorAll('.ws-form input, .ws-form select');

        // Cập nhật params từ form
        formInputs.forEach(input => {
            if ((input.type === 'checkbox' || input.type === 'radio') && !input.checked) return;
            params.set(input.name, input.value);
        });

        // console.log(params.toString());


        // Điều hướng đến URL mới
        window.location.href = window.location.pathname + '?' + params.toString();
    }
</script>
@stack('scripts')
