@extends('layouts.app')
@section('content')
<main class="page-content">


<!-- Section Join Us -->
<section class="section section--content animate">
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title">{{ $_page->text_1 }}</h2>
            <div class="section-text animatable-simple">
                <h3>{{ $_page->text_2 }}</h3>
                <img src="{{ url('/public/img/content', $_page->file) }}" alt="{{ $_page->alt }}" class="align-right">
                <h4>{{ $_page->text_3 }}</h4>
                <p>{{ $_page->text_4 }}</p>
                <h4>{{ $_page->text_5 }}</h4>
                <p>{{ $_page->text_6 }}</p>
                <p>{{ $_page->text_7 }}</p>
                <h4>{{ $_page->text_8 }}</h4>
                <p>{{ $_page->text_9 }}</p>
                <div>
                  {!! $_page->text_10 !!}
                </div>
            </div>

        </div>
    </div>
</section>


</main>
@endsection
