<link rel="icon" href="{{ asset('backend/assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />

<!-- Fonts and icons -->
<script src="{{ asset('backend/assets/js/plugin/webfont/webfont.min.js') }}"></script>
<script>
    WebFont.load({
        google: {
            families: ["Public Sans:300,400,500,600,700"]
        },
        custom: {
            families: [
                "Font Awesome 5 Solid",
                "Font Awesome 5 Regular",
                "Font Awesome 5 Brands",
                "simple-line-icons",
            ],
            urls: ["{{ asset('backend/assets/css/fonts.min.css') }}"],
        },
        active: function() {
            sessionStorage.fonts = true;
        },
    });
</script>

<!-- CSS Files -->
<link rel="stylesheet" href="{{ asset('backend/assets/css/bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{ asset('backend/assets/css/plugins.min.css') }}" />
<link rel="stylesheet" href="{{ asset('backend/assets/css/kaiadmin.min.css') }}" />


<!-- CSS Just for demo purpose, don't include it in your project -->
<link rel="stylesheet" href="{{ asset('backend/assets/css/demo.css') }}" />

<style>
    form label {
        font-weight: bold;
    }

    table thead tr th,
    table thead tr td,
    table tbody tr th,
    table tbody tr td {
        font-size: 0.9em;
    }

    .nav.nav-tabs {
        border: none
    }

    .breadcrumb {
        background: #ffffff;
        border-radius: 8px;
        padding: 10px 15px;

        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        /* Đảm bảo không bị vỡ layout trên màn hình nhỏ */
    }

    .breadcrumb .breadcrumb-item {
        display: flex;
        align-items: center;
    }

    .breadcrumb-item a {
        text-decoration: none;
        color: #007bff;
        font-weight: 500;
    }

    .breadcrumb-item a:hover {
        text-decoration: underline;
        color: #0056b3;
    }

    .breadcrumb-item.active {
        color: #6c757d;
        font-weight: 600;
    }

    .breadcrumb li:last-child {
        margin-left: auto;
        /* Đẩy phần tử cuối về bên phải */
    }
</style>

@stack('styles')
