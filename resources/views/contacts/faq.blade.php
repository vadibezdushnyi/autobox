@extends('layouts.app')
@section('content')
<main class="page-content">
  <!-- Section Contact Us -->
  <section class="page-section section-faq animate">
      <div class="page-wrapper">
          <div class="page-container">
              <h2 class="page-title">FAQ</h2>

              <div class="filter-feed-container js_filter-scope animate">

                  <div class="filter-nav">
                      <ul>
                        @foreach($tags as $tag)
                          <li>
                              <a href="" class="js_filter-trigger {{ in_array($tag->alias, ['*','all']) ? 'active' : '' }}" {{ !in_array($tag->alias, ['*','all']) ? 'data-filter='.$tag->alias.'' : '' }}>{{ $tag->name }}</a>
                          </li>
                        @endforeach
                      </ul>
                  </div>

                  <div class="filter-feed togglers-container js_filter-feed">
                    @foreach($faqs as $faq)
                      <div class="toggler js_filter-item js_toggler" data-filter="{{ implode(',', $faq->tagaliases) }}">
                          <a href="" class="toggler__trigger js_toggler-trigger"><span class="btn-icon-plus"></span>{{ $faq->question }}</a>
                          <div class="toggler__body js_toggler-body">
                              <div class="toggler__body__container js_toggler-body-container">
                                  <div class="section-text">
                                      <p>{!! $faq->answer !!}</p>
                                  </div>
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
