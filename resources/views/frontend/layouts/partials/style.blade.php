<link rel="icon" href="{{ showImage($config->icon) }}" sizes="32x32" type="image/png" />
<link rel="icon" href="{{ showImage($config->icon) }}" sizes="16x16" type="image/png" />
<link rel="apple-touch-icon" href="{{ showImage($config->icon) }}" sizes="180x180" />
<link rel="shortcut icon" href="{{ showImage($config->icon) }}" type="image/x-icon" />
<link rel="preload" href="{{ asset('frontend/assets/fonts/fontawesome-webfont.woff2?v=4.5.0') }}" as="font"
    type="font/woff2" crossorigin="" />

<link type="text/css" href="{{ asset('frontend/assets/css/9a9418fd8ec8665080e9bda6e1d8f292_44896467456.css') }}"
    rel="stylesheet" />


<link rel="preload" href="//app.usercentrics.eu/browser-ui/latest/loader.js" />


<link href="{{ asset('frontend/assets/css/wsconnex-search.css') }}" type="text/css" rel="stylesheet" />

<link type="text/css" href="{{ asset('frontend/assets/css/fbeb9c80f3389159630a63f52a261ebe_10014165865.css') }}"
    rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css') }}">

<style>
    .cart-notification {
        position: fixed;
        bottom: -100px;
        right: 20px;
        width: auto;
        background: #3c3c3c;
        /* Màu xám trầm */
        color: #ddd;
        padding: 8px;
        border: 2px solid #666;
        border-radius: 3px;
        box-shadow: inset -2px -2px 0px #555, inset 2px 2px 0px #222;
        font-family: "Tahoma", sans-serif;
        font-size: 13px;
        opacity: 0;
        transition: all 0.5s ease-in-out;
    }

    /* Khi hiển thị */
    .cart-notification.show {
        bottom: 20px !important;
        opacity: 1 !important;
    }

    /* Tiêu đề */
    .cart-notification h4 {
        margin: 0;
        font-size: 13px;
        font-weight: bold;
        text-align: center;
        background: #222;
        color: #ddd;
        padding: 5px;
        border-bottom: 2px solid #444;
    }

    /* Nội dung trên 1 dòng */
    .cart-notification .product-info {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 13px;
        margin: 5px 0;

        gap: 15px
    }

    /* Nút đóng (X) */
    .close-btn {
        position: absolute;
        top: 3px;
        right: 10px;
        font-size: 14px;
        font-weight: bold;
        border: none;
        background: none;
        cursor: pointer;
        color: #bbb;
    }

    /* Nút xem giỏ hàng */
    .view-cart {
        display: block;
        width: 100%;
        background: #444;
        color: #ddd;
        text-align: center;
        padding: 5px;
        border: none;
        font-size: 13px;
        font-weight: bold;
        text-decoration: none;
        margin-top: 8px;
        cursor: pointer;
    }

    .view-cart:hover {
        background: #222;
    }
</style>

@stack('styles')
