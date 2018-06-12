@extends('layouts.app')
@section('content')
<main class="page-content">


<!-- Section Contact Us -->
<section class="section section--content section-news animate">
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title">{{ $_page->text_1 }}</h2>
            <h3 class="section-title-small section-title-small--red animatable">{{ $_page->text_2 }}</h3>
            <div class="section-text animatable">
                {{ $_page->text_3 }}
            </div>

            <div class="filter-feed-container js_filter-scope animate">

                <div class="filter-nav filter-nav--small">
                    <ul>
                      @foreach($tags as $tag)
                        <li>
                            <a href="" class="js_filter-trigger {{ in_array($tag->alias, ['*','all']) ? 'active' : '' }}" {{ !in_array($tag->alias, ['*','all']) ? 'data-filter='.$tag->alias.'' : '' }}>{{ $tag->name }}</a>
                        </li>
                      @endforeach
                    </ul>
                </div>

                <div class="filter-feed post-excerpts-container js_filter-feed">
                  @foreach($posts as $post)
                    <div class="post-excerpt js_filter-item animate" data-filter="{{ implode(',', $post->tagaliases) }}">
                        <a href="{{ url('/news/'.$post->alias) }}" class="post-excerpt__image">
                            <span class="image-wrapper">
                                <span class="image-container" style="background-image: url('{{ url('/public/img/content/'.$post->filename) }}')">
                                  <img src="{{ url('/public/img/content/'.$post->filename) }}" alt="{{ $post->img_alt }}" title="{{ $post->img_title }}">
                                </span>
                            </span>
                        </a>
                        <div class="post-excerpt__info">
                            <div class="post-excerpt__meta">
                                <span class="post-excerpt__label">{{ $post->category }}</span>
                                <span class="post-excerpt__date">{{ date('d', strtotime($post->created)) }}<span> / </span>{{ date('M', strtotime($post->created)) }}<span> / </span>{{ date('Y', strtotime($post->created)) }}</span>
                            </div>
                            <a href="{{ url('/news/'.$post->alias) }}" class="post-excerpt__title">
                                {{ $post->name }}
                            </a>
                            <div class="post-excerpt__description">
                                {{ substr(strip_tags($post->content), 0, 150).'...' }}
                            </div>
                            <div class="post-excerpt__tags">
                              @foreach($post->tagnames as $tag)
                                <span class="tag">{{ $tag }}</span>
                              @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>

        </div>
    </div>
</section>


</main>

@endsection
