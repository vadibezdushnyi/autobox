@extends('layouts.app')
@section('content')
<main class="page-content">


<!-- Section Company Profile -->
<section class="section section--content animate">
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title">{{ $_page->text_1 }}</h2>
            <div class="section-text animatable-simple">
                <h3>{{ $_page->text_2 }}</h3>
                <div class="company-specialization">
                    <h3 class="title">{{ $_page->text_3 }}</h3>
                    <div class="infographic-block">
                        <div class="lines animate-reverse">
                            <div class="line"><div class="line-content" style="min-width: 94%"><span>{{ $_page->text_4 }}</span><div class="line-bg"></div></div></div>
                            <div class="line"><div class="line-content" style="min-width: 91%"><span>{{ $_page->text_5 }}</span><div class="line-bg"></div></div></div>
                            <div class="line"><div class="line-content" style="min-width: 84%"><span>{{ $_page->text_6 }}</span><div class="line-bg"></div></div></div>
                            <div class="line"><div class="line-content" style="min-width: 78%"><span>{{ $_page->text_7 }}</span><div class="line-bg"></div></div></div>
                            <div class="line"><div class="line-content" style="min-width: 59%"><span>{{ $_page->text_8 }}</span><div class="line-bg"></div></div></div>
                            <div class="line"><div class="line-content" style="min-width: 78%"><span>{{ $_page->text_9 }}</span><div class="line-bg"></div></div></div>
                            <div class="line"><div class="line-content" style="min-width: 69%"><span>{{ $_page->text_10 }}</span><div class="line-bg"></div></div></div>
                            <div class="line"><div class="line-content" style="min-width: 78%"><span>{{ $_page->text_11 }}</span><div class="line-bg"></div></div></div>
                            <div class="line"><div class="line-content" style="min-width: 88%"><span>{{ $_page->text_12 }}</span><div class="line-bg"></div></div></div>
                        </div>
                        <img src="{{ url('/public/img/content/bike.png') }}" alt="" class="image-bike animate">
                    </div>
                </div>
                <div>
                  {!! $_page->text_13 !!}
                </div>
                <div class="company-specialization company-specialization--mobile">
                    <h3 class="title">{{ $_page->text_3 }}</h3>
                    <div class="infographic-block">
                        <div class="lines animate-reverse">
                          <div class="line"><div class="line-content" style="min-width: 94%"><span>{{ $_page->text_4 }}</span><div class="line-bg"></div></div></div>
                          <div class="line"><div class="line-content" style="min-width: 91%"><span>{{ $_page->text_5 }}</span><div class="line-bg"></div></div></div>
                          <div class="line"><div class="line-content" style="min-width: 84%"><span>{{ $_page->text_6 }}</span><div class="line-bg"></div></div></div>
                          <div class="line"><div class="line-content" style="min-width: 78%"><span>{{ $_page->text_7 }}</span><div class="line-bg"></div></div></div>
                          <div class="line"><div class="line-content" style="min-width: 59%"><span>{{ $_page->text_8 }}</span><div class="line-bg"></div></div></div>
                          <div class="line"><div class="line-content" style="min-width: 78%"><span>{{ $_page->text_9 }}</span><div class="line-bg"></div></div></div>
                          <div class="line"><div class="line-content" style="min-width: 69%"><span>{{ $_page->text_10 }}</span><div class="line-bg"></div></div></div>
                          <div class="line"><div class="line-content" style="min-width: 78%"><span>{{ $_page->text_11 }}</span><div class="line-bg"></div></div></div>
                          <div class="line"><div class="line-content" style="min-width: 88%"><span>{{ $_page->text_12 }}</span><div class="line-bg"></div></div></div>
                        </div>
                        <img src="{{ url('/public/img/content/bike.png') }}" alt="" class="image-bike animate">
                    </div>
                </div>
                <div>
                  {!! $_page->text_14 !!}
                </div>
                <div class="excerpts-container animate">
                  @foreach($_page->list as $item)
                    <div class="image-excerpt animate">
                        <div class="image-container">
                            <div class="image" style="background-image: url('{{ url('/public/img/content/company-profile/', $item->cover) }}')">
                                <img src="{{ url('/public/img/content/company-profile/', $item->cover) }}" alt="{{ $item->name }}">
                            </div>
                        </div>
                        <div class="text">
                            <h5 class="title">{{ $item->name }}</h5>
                        </div>
                    </div>
                  @endforeach
                </div>
                <div>
                  {!! $_page->text_15 !!}
                </div>
            </div>

        </div>
    </div>
</section>


</main>
@endsection
