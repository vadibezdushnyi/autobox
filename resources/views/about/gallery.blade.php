@extends('layouts.app')
@section('content')
<main class="page-content">


<!-- Section Gallery -->
<section class="section section--content  section-gallery animate">
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title">{{ $_page->text_1 }}</h2>
            <h3 class="section-title-small section-title-small--red animatable">{{ $_page->text_2 }}</h3>
            <div class="section-text animatable">
                {!! $_page->text_3 !!}
            </div>

            <div class="tripple-container animate">

              @foreach($gallery as $item)
                <div class="excerpt gallery-excerpt animate">
                  <a class="gallery-excerpt__body js_gallery-slider-btn"
                    href="{{ sizeof($item->images) > 1 ? url($item->images[0]['file']) : ''}}"
                    data-gallery-images="{{ implode('||', array_column($item->images, 'file')) }}"
                    data-gallery-captions="{{ implode('||', array_column($item->images, 'title')) }}">
                    <div class="gallery-excerpt__image" style="background-image: url('{{ url($item->images[0]['file']) }}');"></div>
                    <div class="gallery-excerpt__overlay">
                      <span class="gallery-excerpt__overlay__text">{{ $_page->text_4 }}</span>
                    </div>
                    @if(sizeof($item->images) > 1)
                    <div class="gallery-excerpt__body__container">
                      <span class="gallery-excerpt__body__text">{{ $_page->text_5 }}</span>
                      <span class="gallery-excerpt__body__count"><span>+ {{ sizeof($item->images) - 1 }}</span></span>
                    </div>
                    @endif
                  </a>
                  <div class="gallery-excerpt__footer">
                    <h3 class="gallery-excerpt__title">{{ $item->name }}</h3>
                    <span class="gallery-excerpt__subtitle">{{ $item->title }}</span>
                  </div>
                </div>
              @endforeach

            </div>

        </div>
    </div>
</section>


</main>
@include('elements.gallerymodal')
@endsection
