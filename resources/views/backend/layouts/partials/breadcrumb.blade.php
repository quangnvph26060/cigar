<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Trang chủ</a>
        </li>
        @isset ($page)
            <li class="breadcrumb-item active" aria-current="page">
                <i class="fas fa-file-alt"></i> Chi tiết sản phẩm
            </li>
        @endisset
    </ol>
</nav>
