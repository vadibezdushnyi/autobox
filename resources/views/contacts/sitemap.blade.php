@extends('layouts.app')
@section('content')
<main class="page-content">
<!-- Section About Us -->
<section class="section section--content section-sitemap animate">
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title">{{ $_page->text_1 }}</h2>
            <h3 class="section-title-small animatable">{{ $_page->text_2 }}</h3>
            <div class="section-text animatable">
                {{ $_page->text_3 }}
            </div>

            <div class="sitemap-blocks animate">

              @foreach($sitemap as $category)
                <div class="sitemap-block">
                    <a class="link-main">{{ $category->name }}</a>
                    @foreach($category->nestings as $nesting)
                      <a href="{{ url($nesting->alias) }}" target="_blank" class="link">{{ $nesting->name }}</a>
                    @endforeach
                </div>
              @endforeach

            </div>

            <!-- <a href="" target="_blank" class="link js_modal-open" data-modal-type="authorization" data-modal-part="1">Registration</a> -->
            <!-- <a href="" target="_blank" class="link js_modal-open" data-modal-type="authorization" data-modal-part="2">Login</a> -->
            <!-- <a href="" target="_blank" class="link js_modal-open" data-modal-type="authorization" data-modal-part="3">Forgot password</a> -->
            <!-- <a href="" target="_blank" class="link js_modal-open" data-modal-type="email-feedback" data-modal-part="1">Feedback</a> -->

        </div>
    </div>
</section>
</main>
@endsection
