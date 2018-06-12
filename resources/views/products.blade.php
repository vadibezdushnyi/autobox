@extends('layouts.app')
@section('content')

<main class="page-content">
  <!-- Section Prices -->
  <section class="section section--content section-product-search-top animate">
      <div class="page-wrapper">
          <div class="page-container">
              <h2 class="page-title">{{ $_page->text_1 }}</h2>

              @if(!SIGNEDIN)
              <div class="btn-container-general">
                  <a href="" class="btn btn-red btn-red-regular js_modal-open" data-modal-type="authorization" data-modal-part="1">{{ $_page->text_21 }}</a>
                  <a href="" class="btn btn-red btn-red-regular js_modal-open" data-modal-type="authorization" data-modal-part="2">{{ $_page->text_22 }}</a>
              </div>
              @endif

          </div>
      </div>
  </section>

  <!-- Section part code -->
  <section class="section section-find-part-code">
      <div class="page-wrapper">
          <div class="page-container">

              <div class="code-field__container">
                  <form name="search-form" id="search-form" method="get">
                      <div class="code-field__input">
                          <label>
                              <input type="text" placeholder="{{ $_page->text_2 }}" value="{{ $query ? $query : '' }}">
                              <span class="code-field__message">{{ $_page->text_23 }}</span>
                          </label>
                      </div>
                      <button type="submit" class="btn btn-red code-field__btn icon icon-search">{{ $_page->text_3 }}</button>
                  </form>
              </div>

          </div>
      </div>
  </section>

  <!-- Section product search -->
  <section class="section section-product-search">
      <div class="page-wrapper">
          <div class="page-container">
              <div class="search-results table-view" id="search-results" style="position:relative;">
                <div class="content">
                  <p style="padding:100px 40px; margin:0; text-align:center; font-size:40px; font-weight:700;">{{ $_page->text_4 }}</p>
                </div>
              </div>

          </div>
      </div>
  </section>
</main>
@endsection
