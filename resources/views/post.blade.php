@extends('layouts.app')
@section('content')
<main class="page-content">


<!-- Section News post -->
<section class="section section--content  section-news-post animate">
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title">{{ $_page->text_1 }}</h2>

            <a href="{{ url('/news') }}" class="link-back">{{ $_page->text_2 }}</a>

            <div class="news-post-container animate">
                <div class="post-excerpt post-excerpt--news-post animate">
                    <div class="post-excerpt__gallery">
                        <a class="gallery-excerpt__body js_gallery-slider-btn" href="{{ url($post->cover) }}"
                          data-gallery-images="{{ implode('||', array_column($post->gallery, 'file')) }}"
                          data-gallery-captions="{{ implode('||', array_column($post->gallery, 'title')) }}">
                            <div class="gallery-excerpt__image" style="background-image: url('{{ url($post->cover) }}')"></div>
                            <div class="gallery-excerpt__overlay">
                                <span class="gallery-excerpt__overlay__text">{{ $_page->text_3 }}</span>
                            </div>
                            <div class="gallery-excerpt__body__container">
                                <span class="gallery-excerpt__body__text">{{ $_page->text_4 }}</span>
                                <span class="gallery-excerpt__body__count"><span>+ {{ sizeof($post->gallery) }}</span></span>
                            </div>
                        </a>
                    </div>
                    <div class="post-excerpt__info">
                        <div class="post-excerpt__meta">
                            <span class="post-excerpt__label">{{ $post->category }}</span>
                            <span class="post-excerpt__date">{{ date('d', strtotime($post->created)) }}<span> / </span>{{ date('M', strtotime($post->created)) }}<span> / </span>{{ date('Y', strtotime($post->created)) }}</span>
                        </div>
                        <h2 class="post-excerpt__title">
                            {{ $post->name }}
                        </h2>
                        <div class="post-excerpt__description">
                          {!! $post->content !!}
                        </div>
                    </div>
                </div>

            </div>

            <div class="news-post-footer">
                <div class="post-excerpt__tags">
                  @foreach($post->tagnames as $tag)
                    <span class="tag">{{ $tag }}</span>
                  @endforeach
                </div>
                <div class="social-links-simple">
                    <a href="javascript:void(0)" class="social-link link-facebook">
                        <span class="icon icon-facebook"></span>
                    </a>
                    <a href="javascript:void(0)" class="social-link link-twitter">
                        <span class="icon icon-twitter"></span>
                    </a>
                    <a href="javascript:void(0)" class="social-link link-instagram">
                        <span class="icon icon-instagram"></span>
                    </a>
                    <a href="javascript:void(0)" class="social-link link-google-plus">
                        <span class="icon icon-google-plus"></span>
                    </a>
                    <a href="javascript:void(0)" class="social-link link-linkedin">
                        <span class="icon icon-linkedin"></span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>


</main>
@include('elements.gallerymodal')
@endsection
