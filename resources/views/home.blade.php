@extends('layouts.app')
@section('content')

<main class="page-content">
<!-- Main top slider section -->
<section class="homeslider-section" id="homeslider">
  @foreach($banners as $index => $banner)
    <div>
        <div class="sizer"></div>
        <div class="image" style="background-image: url('{{ url('/public/img/content/'.$banner->file) }}')"></div>
        <div class="image-mobile" style="background-image: url('{{ url('/public/img/content/'.$banner->file) }}')"></div>
        <div class="content">
            <div class="text">
                <div class="text-container">
                    <div class="counters-container">
                      <span class="number js_slider-count-current">{{ $index + 1 }}</span>
                      <span class="dash">/</span>
                      <span class="number number--small js_slider-count-overall">{{ sizeof($banners) }}</span>
                    </div>
                    <h2 class="title">{{ $banner->data }}</h2>
                    <hr>
                </div>
            </div>
        </div>
    </div>
  @endforeach
</section>

<!-- Section part code -->
<section class="section section-find-part-code">
    <div class="page-wrapper">
        <div class="page-container">

            <div class="code-field__container">
                <form action="{{ url('/products/') }}" method="get">
                    <div class="code-field__input">
                        <label>
                            <input type="text" placeholder="{{ $_page->text_1 }}" name="q">
                        </label>
                    </div>
                    <button type="submit" class="btn btn-red code-field__btn icon icon-search">{{ $_page->text_2 }}</button>
                </form>
            </div>

        </div>
    </div>
</section>

<!-- Section home why -->
<section class="section section-home-why">
    <div class="page-wrapper">
        <div class="page-container">

            <div class="cta-register-block animate">
                <div class="strings-container">
                    <div class="block1">
                        <div class="string">{{ $_page->text_4 }}</div>
                    </div>
                    <div class="block2">
                        <div class="string">{{ $_page->text_3 }}</div>
                    </div>
                </div>
                @if(!SIGNEDIN)
                <div class="btn-container-general">
                    <a href="{{ url('/about/profile') }}" class="btn btn-regular">{{ $_page->text_31 }}</a>
                </div>
                @endif
            </div>

            <div class="info-block-two-cols animate">
                <div class="col-title">
                    <h3 class="section-title section-title--red">{{ $_page->text_5 }}</h3>
                </div>
                <div class="col-text">
                    <div class="section-text">{!! $_page->text_6 !!}</div>
                </div>
            </div>

            <div class="excerpts-container">
              @foreach($_page->whyus as $item)
                <div class="image-excerpt animate">
                    <div class="image-container">
                        <div class="image" style="background-image: url('{{ url('/public/img/content/', $item->cover) }}')">
                            <img src="{{ url('/public/img/content/', $item->cover) }}" alt="{{ $item->name }}">
                        </div>
                    </div>
                    <div class="text">
                        <h5 class="title">{{ $item->name }}</h5>
                    </div>
                </div>
              @endforeach
            </div>

            <div class="btn-container-general">
                <a href="{{ url('/about/whyus') }}" class="btn btn-regular">{{ $_page->text_7 }}</a>
            </div>

        </div>
    </div>
</section>


<!-- Section home why -->
<section class="section section-home-support">
    <div class="page-wrapper">
        <div class="page-container">

            <div class="two-cols animate">
                <div class="col-left">
                    <h3 class="section-title">{{ $_page->text_8 }}</h3>
                    <div class="section-text">
                        {{ $_page->text_9 }}
                    </div>
                    <div class="btn-container-general">
                        <a href="{{ url('/about/benefits') }}" class="btn btn-regular btn-regular--red">{{ $_page->text_10 }}</a>
                    </div>
                </div>
                <div class="col-right">
                    <div class="support-info-item support-info-item--1">
                        <div class="image">
                            <img src="{{ url('/public/img/icons-general/icon1.svg') }}" alt="{{ $_page->text_11 }}">
                        </div>
                        <h5 class="title">{{ $_page->text_11 }}</h5>
                    </div>
                    <div class="support-info-item support-info-item--2">
                        <div class="image">
                            <img src="{{ url('/public/img/icons-general/icon2.svg') }}" alt="{{ $_page->text_12 }}">
                        </div>
                        <h5 class="title">{{ $_page->text_12 }}</h5>
                    </div>
                    <div class="support-info-item support-info-item--3">
                        <div class="image">
                            <img src="{{ url('/public/img/icons-general/icon3.svg') }}" alt="{{ $_page->text_13 }}">
                        </div>
                        <h5 class="title">{{ $_page->text_13 }}</h5>
                    </div>
                    <div class="support-info-item support-info-item--4">
                        <div class="image">
                            <img src="{{ url('/public/img/icons-general/icon4.svg') }}" alt="{{ $_page->text_14 }}">
                        </div>
                        <h5 class="title">{{ $_page->text_14 }}</h5>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="section-bg"></div>
    <img src="{{ url('/public/img/content/image7.jpg') }}" alt="" class="image-bg">
</section>


<!-- Section home parts -->
<section class="section section-home-parts">
    <div class="page-wrapper">
        <div class="page-container">

            <h3 class="section-title">{{ $_page->text_15 }}</h3>
            <div class="excerpts-small-container">
                <div class="image-excerpt animate">
                    <div class="image-container">
                        <div class="image" style="background-image: url('{{ url('/public/img/content/All-GP_Engine&Transmission.jpg') }}')">
                            <img src="{{ url('/public/img/content/All-GP_Engine&Transmission.jpg') }}" alt="">
                        </div>
                    </div>
                    <div class="text">
                        <h5 class="title">{{ $_page->text_16 }}</h5>
                    </div>
                </div>
                <div class="image-excerpt animate">
                    <div class="image-container">
                        <div class="image" style="background-image: url('{{ url('/public/img/content/All-GP_BodyWork&Lighting.jpg') }}')">
                            <img src="{{ url('/public/img/content/All-GP_BodyWork&Lighting.jpg') }}" alt="">
                        </div>
                    </div>
                    <div class="text">
                        <h5 class="title">{{ $_page->text_17 }}</h5>
                    </div>
                </div>
                <div class="image-excerpt animate">
                    <div class="image-container">
                        <div class="image" style="background-image: url('{{ url('/public/img/content/All-GP_BrakeComponents.jpg') }}')">
                            <img src="{{ url('/public/img/content/All-GP_BrakeComponents.jpg') }}" alt="">
                        </div>
                    </div>
                    <div class="text">
                        <h5 class="title">{{ $_page->text_18 }}</h5>
                    </div>
                </div>
                <div class="image-excerpt animate">
                    <div class="image-container">
                        <div class="image" style="background-image: url('{{ url('/public/img/content/All-GP_Suspension&Steering.jpg') }}')">
                            <img src="{{ url('/public/img/content/All-GP_Suspension&Steering.jpg') }}" alt="">
                        </div>
                    </div>
                    <div class="text">
                        <h5 class="title">{{ $_page->text_19 }}</h5>
                    </div>
                </div>
                <div class="image-excerpt animate">
                    <div class="image-container">
                        <div class="image" style="background-image: url('{{ url('/public/img/content/All-GP_Wheels&Tires') }}.jpg')">
                            <img src="{{ url('/public/img/content/All-GP_Wheels&Tires') }}.jpg" alt="">
                        </div>
                    </div>
                    <div class="text">
                        <h5 class="title">{{ $_page->text_20 }}</h5>
                    </div>
                </div>
                <div class="image-excerpt animate">
                    <div class="image-container">
                        <div class="image" style="background-image: url('{{ url('/public/img/content/All-GP_Electrics&Electronics.jpg') }}')">
                            <img src="{{ url('/public/img/content/All-GP_Electrics&Electronics.jpg') }}" alt="">
                        </div>
                    </div>
                    <div class="text">
                        <h5 class="title">{{ $_page->text_21 }}</h5>
                    </div>
                </div>
                <div class="image-excerpt animate">
                    <div class="image-container">
                        <div class="image" style="background-image: url('{{ url('/public/img/content/All-GP_Accessories.jpg') }}')">
                            <img src="{{ url('/public/img/content/All-GP_Accessories.jpg') }}" alt="">
                        </div>
                    </div>
                    <div class="text">
                        <h5 class="title">{{ $_page->text_22 }}</h5>
                    </div>
                </div>
                <div class="image-excerpt animate">
                    <div class="image-container">
                        <div class="image" style="background-image: url('{{ url('/public/img/content/All-GP_Interior.jpg') }}')">
                            <img src="{{ url('/public/img/content/All-GP_Interior.jpg') }}" alt="">
                        </div>
                    </div>
                    <div class="text">
                        <h5 class="title">{{ $_page->text_23 }}</h5>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- Section home welcome -->
<section class="section section-home-welcome">
    <div class="page-wrapper">
        <div class="page-container">

        <div class="two-cols animate">
            <div class="col-left">
                <h3 class="section-title section-title--red">{{ $_page->text_24 }}</h3>
                <div class="section-text">
                     {!! $_page->text_25 !!}
                </div>
            </div>
            <div class="col-right">
                <h3 class="section-title">{{ $_page->text_26 }}</h3>
                <div class="section-text">
                  {!! $_page->text_27 !!}
                </div>
            </div>
        </div>

        </div>
    </div>
</section>


<!-- Section home automodels -->
<section class="section section-home-clients">
    <div class="page-wrapper">
        <div class="page-container">
            <h3 class="section-title section-title--red">{{ $_page->text_28 }}</h3>
            <div class="text">
                {{ $_page->text_29 }}
            </div>

            <div class="clients-slider carousel animate">
              @foreach($producers as $chunk)
                <div class="slide">
                  @foreach($chunk as $producer)
                    <a href="{{ url('/parts', $producer->Id) }}" class="client-logo bmw"><div class="image"><img src="{{ url('/public/img/icons-general/car-logos/', $producer->Logo) }}" alt=""></div><div class="text"><h5 class="title">{{ $producer->Name }}</h5></div></a>
                  @endforeach
                </div>
              @endforeach
            </div>

        </div>
    </div>
</section>


<!-- Section Latest news -->
@if(!empty($posts))
<section class="section section-latest-news">
    <div class="bg-image-container bg-image-container--1 animate">
        <img src="{{ url('/public/img/content/image6.jpg') }}" class="bg-image bg-image--1">
    </div>
    <div class="bg-image-container bg-image-container--2 animate">
        <img src="{{ url('/public/img/content/image7.jpg') }}" class="bg-image bg-image--1">
    </div>
    <div class="page-wrapper">
        <div class="page-container">
            <h3 class="section-title section-title">{{ $_page->text_30 }}</h3>

            <div class="excerpts-carousel carousel js_excerpts-carousel js_slider-height-equalize animate">
              @foreach($posts as $post)
                <div class="slide">
                    <div class="slide-container">
                        <div class="post-excerpt js_excerpt">
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
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</section>
@endif
</main>

@endsection
