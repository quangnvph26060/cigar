<nav id="mmenu" class="d-none">
    <ul>

        <li><a href="/" class="mmenu-selected">Startseite</a></li>

        @foreach ($categories as $category)
            <li>
                <span>{{ $category->name }}</span>
                <ul>
                    <li><a href="{{ $category->slug }}">Alles anzeigen</a></li>

                    @php
                        $categoryList = $category->children->isEmpty() ? [$category] : $category->children;
                    @endphp

                    @foreach ($categoryList as $cat)
                        <li>
                            <span>{{ $cat->name }}</span>
                            <ul>
                                <li><a href="{{ route('products', $cat->slug) }}">Alles anzeigen</a></li>


                                @foreach ($category->attributes as $attribute)
                                    <li>
                                        <span>{{ $attribute->name }}</span>
                                        <ul>

                                            @foreach ($attribute->values as $av)
                                                <li>
                                                    <a
                                                        href="{{ route('products', [$cat->slug, $av['slug']]) }}">{{ $av['name'] }}</a>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </li>
                                @endforeach


                                <li>
                                    <span>Top-Marken</span>
                                    <ul>
                                        @foreach ($cat->brands as $brand)
                                            <li><a href="{{ route('products', $brand->slug) }}">{{ $brand->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>


                            </ul>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</nav>
