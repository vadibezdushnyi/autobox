@extends('layouts.app')
@section('content')
<main class="page-content">


<!-- Section Contact Us -->
<section class="section section--content  section-parts-archive animate">
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title">{{ $_page->text_1 }}</h2>
            <h3 class="section-title-small section-title-small--red animatable">{{ $_page->text_2 }}</h3>
            <div class="section-text animatable">
                {{ $_page->text_3 }}
            </div>

            <div class="tripple-container animate">
              @foreach($categories as $category)
              <div class="excerpt parts-excerpt animate">
                  <div class="parts-excerpt__header">
                      <div class="parts-excerpt__image" style="background-image: url('{{ url('/public/img/content/parts/'.$category->logo) }}')"></div>
                      <div class="parts-excerpt__overlay"></div>
                      <div class="parts-excerpt__header__container">
                          <h3 class="parts-excerpt__title">{{ $category->name }}</h3>
                      </div>
                  </div>
                  <div class="parts-excerpt__body">
                      <div class="parts-excerpt__list scrollbar-dark">
                        @if($category->producers)
                          @foreach($category->producers as $producer)
                          <div class="parts-excerpt__list__link"><a href="{{ url('/parts/'.$producer->id) }}">{{ $producer->name }}</a></div>
                          @endforeach
                        @endif
                      </div>
                      <a href="javascript:void(0)" class="btn btn-red">{{ $_page->text_4 }}</a>
                  </div>
              </div>
              @endforeach
            </div>

        </div>
    </div>
</section>


</main>
@endsection
