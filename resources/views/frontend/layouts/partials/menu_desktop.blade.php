<div class="ws-container container">
    <div class="row g-0">

        @foreach ($categories as $category)
            <div class="col">
                <a class="dnav-item" href="/zigarren"
                    data-dropnav="{{ $category->slug }}"><span>{{ $category->name }}</span></a>
            </div>
        @endforeach
        <div class="col-4 col-xl-5">
            <div class="dnav-search d-flex h-100 align-items-center">
                <form id="cw-search" action="/shop/suche" method="get" class="w-100 ps-2 ps-xl-5 position-relative">
                    <input id="cw-searchterm" class="form-control rounded-0" autocomplete="off"
                        placeholder="Suchbegriff eingeben..." value="" name="suchterms" type="text" />
                    <i class="fa fa-search"></i>
                    <div id="cw-suggestions" class="cw-suggestions"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="dropnav">
    @foreach ($categories as $category)
        <div class="container dropnav-{{ $category->slug }}">
            <div class="row g-0 justify-content-start">
                @php
                    $categoryList = $category->children->isEmpty() ? [$category] : $category->children;
                @endphp

                @foreach ($categoryList as $cat)
                    <div class="col-auto">
                        <a href="{{ route('products', $cat->slug) }}"
                            class="h4 text-uppercase dropnav-h-1">{{ $cat->name }}</a>
                        <div class="row g-0 justify-content-start">
                            @foreach ($category->attributes as $attribute)
                                <div class="col-auto">
                                    <span class="h5 dropnav-h-2">{{ $attribute->name }}</span>
                                    <ul>
                                        @foreach ($attribute->values as $av)
                                            <li>
                                                <a href="{{ route('products', [$cat->slug, $av['slug']]) }}"
                                                    title="{{ $av['name'] }}">
                                                    <span>{{ $av['name'] }}</span> <!-- Hiển thị name -->
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach


                            <!-- Hiển thị các thương hiệu trong cùng row với thuộc tính -->
                            <div class="col-auto">
                                <span class="h5 dropnav-h-2">Thương hiệu</span>
                                <ul>
                                    @foreach ($cat->brands as $brand)
                                        <li>
                                            <a href="/zigarren/brand/{{ $brand->slug }}" title="{{ $brand->name }}">
                                                <span>{{ $brand->name }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-auto dropnav-divider-col">
                        <div class="dropnav-divider"></div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach


</div>
