@extends('frontend.layouts.master')

@section('content')
    <div class="ws-container">

        @php
            $data = [];
            $data['Content'] = $post ? route('content') : null;

            if (isset($post)) {
                $data[$post->title] = null;
            }
        @endphp

        @include('frontend.pages.include.breadcrumb', [
            'data' => $data,
        ])

        <div class="microsite">
            <div class="ws-container group-content">
                <div class="box-left">

                    @if ($post)
                        {!! $post->content !!}
                    @else
                        <div class="container-content">
                            @include('frontend.pages.include.list-content', ['posts' => $posts])
                        </div>
                    @endif


                </div>

                <div class="box-right">
                    <div class="new-content">
                        <div class="n-heading">
                            <h3>Neuer Artikel</h3>
                        </div>
                        @foreach ($posts->take(8) as $item)
                            <div class="box-new-content">
                                <div class="n-image">
                                    <img src="{{ showImage($item->image) }}" alt="{{ $item->title }}">
                                </div>
                                <div class="n-title">
                                    <h3>{{ \Str::words($item->excerpt, 15, '...') }}</h3>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>


            </div>
        </div>

        <style>
            .n-title h3 {
                font-size: .8em;
            }

            .group-content {
                display: flex;
                justify-content: space-between;
                padding: 0 10px
            }

            .group-content .box-left {
                width: 80%;
            }

            .group-content .box-right {
                width: 18%;
            }

            .c-created_at {
                margin-bottom: 5px;
            }

            .box-content:hover,
            .box-new-content:hover .n-title {
                cursor: pointer;
                color: #be7a73;
                /* Đổi màu chữ khi hover */
                transition: color 0.3s ease;
            }


            .container-content {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                /* 3 cột đều nhau */
                gap: 20px;
                /* Khoảng cách giữa các bài viết */
                grid-auto-rows: auto;
                /* Chiều cao tự động cho các hàng */
            }

            /* Đảm bảo ảnh trong các bài viết không bị méo */
            .c-image img {
                width: 100%;
                height: auto;
                border-radius: 8px;
            }

            .c-title {
                margin-top: 10px;
            }

            .c-title h3 {
                font-weight: bold;
                font-size: 1.2em;
            }

            /* Điều chỉnh cho các bài viết mới */
            .new-content .box-new-content {
                display: flex;
                gap: 10px;
                padding-bottom: 5px;
                margin-bottom: 5px;
                border-bottom: 1px solid #eaeaea;
            }

            .new-content .n-image {
                width: 40px;
                height: 40px;
                background-color: #ccc;
                border-radius: 8px;
            }

            .new-content .n-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .new-content .n-title {
                flex: 1;
                font-size: 16px;
                color: #333;
                font-weight: bold;
            }

            /* Responsiveness cho màn hình nhỏ */
            @media (max-width: 1024px) {
                .container-content {
                    grid-template-columns: repeat(2, 1fr);
                    /* 2 cột trên màn hình vừa */
                }
            }

            @media (max-width: 768px) {
                .container-content {
                    grid-template-columns: 1fr;
                    /* 1 cột trên màn hình nhỏ */
                }

                .group-content .box-left {
                    width: 100%;
                }

                .group-content .box-right {
                    width: 100%;
                }

                .group-content {
                    display: block;
                }

                .new-content .n-image {
                    width: 50px;
                    height: 50px;
                }

                .new-content {
                    margin-top: 40px;
                }
            }

            body.a-content.v-index .breadcrumbs {
                display: block;
            }
        </style>
    </div>
@endsection
