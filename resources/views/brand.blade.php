@extends('layouts.app')
@section('content')
<main class="page-content">


<div class="page-header-bg animate">
    <div class="page-header-bg__image" style="background-image: url('{{ url('/public/img/content/'.$brand->cover) }}')"></div>
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title">{{ $brand->Name }}</h2>
        </div>
    </div>
</div>

<!-- Section Brand -->
<section class="section section--content section-brand animate">
    <div class="page-wrapper">
        <div class="page-container">
            <div class="brand-info-container">
                <div class="aside">
                    <div class="logo-image"><img alt="" src="{{ url('/public/img/icons-general/car-logos/'.$brand->Logo) }}"></div>
                    <div class="parts-excerpt parts-excerpt--narrow animate">
                        <div class="parts-excerpt__header">
                            <div class="parts-excerpt__image" style="background-image: url('{{ url('/public/img/content/parts/why-us-parts-bg.jpg') }}')"></div>
                            <div class="parts-excerpt__overlay"></div>
                            <div class="parts-excerpt__header__container">
                                <h3 class="parts-excerpt__title">{{ $_page->text_2 }}</h3>
                            </div>
                        </div>
                        @if($brand->directions)
                        <div class="parts-excerpt__body">
                            <div class="parts-excerpt__list no-scrollbar">
                              @foreach($brand->directions as $dir)
                                <div class="parts-excerpt__list__link"><a href="javascript:void(0)">{{ $dir->name }}</a></div>
                              @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="more-than" style="background-image: url('{{ url('/public/img/content/more-bg.jpg') }}')">
                        {{ $_page->text_3 }}<span class="number"><span id="counter1" class="js_number-animate animate" data-counter-start="0" data-counter-end="{{ $brand->products_amount }}">0</span></span>{{ $_page->text_4 }}
                    </div>
                </div>
                <div class="main">
                    <ul class="breadcrumbs">
                        <li><a href="{{ url('/parts') }}">{{ $_page->text_1 }}</a></li>
                        <li class="active"><span>{{ $brand->Name }}</span></li>
                    </ul>

                    <div class="logo-image"><img alt="" src="{{ url('/public/img/icons-general/car-logos/'.$brand->Logo) }}"></div>

                    <div class="section-text">
                        <h3>{{ $brand->Name }}</h3>
                        <div>
                          {!! $brand->description !!}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
</main>
@endsection
