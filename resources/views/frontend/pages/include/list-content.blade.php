@foreach ($posts as $post)
    <div class="box-content">
        <a href="{{ route('content', $post->slug) }}">
            <div class="c-image">
                <img src="{{ showImage($post->image) }}" alt="{{ $post->title }}">
            </div>
            <div class="c-title">
                <h3>{{ $post->title }}</h3>
            </div>
            <div class="c-created_at">
                <i class="fa fa-calendar"></i>
                {{ \Carbon\Carbon::parse($post->published_at ?? $post->created_at)->format('d/m/Y') . ' (' . \Carbon\Carbon::parse($post->published_at ?? $post->created_at)->diffForHumans() . ')' }}
            </div>

            <div class="c-excerpt">
                <p>{{ \Str::words($post->excerpt, 15, '...') }}</p>
            </div>
        </a>
    </div>
@endforeach

{{ $posts->appends(request()->query())->links() }}
