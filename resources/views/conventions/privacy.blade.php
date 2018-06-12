@extends('layouts.app')
@section('content')
<main class="page-content">

  <!-- Section Join Us -->
  <section class="section section--content animate">
      <div class="page-wrapper">
          <div class="page-container">
              <h2 class="page-title">{{ $_page->text_1 }}</h2>
              <div class="section-text animatable-simple">
                {!! $_page->text_2 !!}
                <div class="clear"></div>
              </div>
          </div>
      </div>
  </section>

</main>
@endsection
