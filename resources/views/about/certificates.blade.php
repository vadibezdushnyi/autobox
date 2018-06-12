@extends('layouts.app')
@section('content')
<main class="page-content">


<!-- Section News post -->
<section class="section section--content  section-certificates animate">
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title">{{ $_page->text_1 }}</h2>
            <div>
              @foreach($certificates as $certificate)
              <div class="certificates-container animate">
                <div class="certificates-container__gallery">
                  <a class="gallery-excerpt__body js_gallery-slider-btn"
                  href="{{ sizeof($certificate->images) > 1 ? url($certificate->images[0]['file']) : ''}}"
                  data-gallery-images="{{ implode('||', array_column($certificate->images, 'file')) }}"
                  data-gallery-captions="{{ implode('||', array_column($certificate->images, 'title')) }}"
                  data-gallery-type="nocaption">
                    <div class="gallery-excerpt__image" style="background-image: url('{{ url($certificate->images[0]['file']) }}');"></div>
                    <div class="gallery-excerpt__overlay">
                      <span class="gallery-excerpt__overlay__text">{{ $_page->text_2 }}</span>
                    </div>
                    @if(sizeof($certificate->images) > 1)
                    <div class="gallery-excerpt__body__container">
                      <span class="gallery-excerpt__body__text">{{ $_page->text_3 }}</span>
                      <span class="gallery-excerpt__body__count"><span>+ {{ sizeof($certificate->images) - 1 }}</span></span>
                    </div>
                    @endif
                  </a>
                </div>
                <div class="certificates-container__info">
                  <h3 class="section-title-small">{{ $certificate->name }}</h3>
                  <div class="section-text">
                    {!! $certificate->content !!}
                  </div>
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
