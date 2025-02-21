<div class="sidebar-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark">
        <a href="index.html" class="logo">
            <img src="{{ asset('backend/assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand" class="navbar-brand"
                height="20" />
        </a>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
            </button>
        </div>
        <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
        </button>
    </div>
    <!-- End Logo Header -->
</div>
@php
    $menu = json_decode(file_get_contents(resource_path('views/backend/layouts/partials/menu.json')), true);
    $currentRoute = request()->route()->getName(); // Lấy route hiện tại
@endphp

<div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
        <ul class="nav nav-secondary">
            @foreach ($menu ?? [] as $item)
                @php
                    $isActive = request()->routeIs($item['route'] ?? '') ? 'active' : '';
                    $hasChildren = isset($item['children']);
                    $href = $hasChildren ? '#' . $item['id'] : (isset($item['route']) ? route($item['route']) : '#');
                    $isOpen =
                        $hasChildren && collect($item['children'])->contains(fn($child) => request()->is($child['url']))
                            ? 'show'
                            : '';
                @endphp

                <li class="nav-item {{ $isActive }}">
                    <a href="{{ $href }}" class="{{ $hasChildren ? 'collapsed' : '' }}"
                        @if ($hasChildren) data-bs-toggle="collapse" @endif>
                        <i class="{{ $item['icon'] }}"></i>
                        <p>{{ $item['title'] }}</p>
                        @if ($hasChildren)
                            <span class="caret"></span>
                        @endif
                    </a>

                    @if ($hasChildren)
                        <div class="collapse {{ $isOpen }}" id="{{ $item['id'] }}">
                            <ul class="nav nav-collapse">
                                @foreach ($item['children'] as $child)
                                    @php
                                        $isChildActive = request()->is($child['url']) ? 'active' : '';
                                    @endphp
                                    <li class="{{ $isChildActive }}">
                                        <a href="{{ url($child['url']) }}">
                                            <span class="sub-item">{{ $child['title'] }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </li>
            @endforeach
        </ul>
    </div>
</div>
