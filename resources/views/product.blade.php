@extends('layouts.app')
@section('content')
<main class="page-content">

  <!-- Section Products Code -->
  <section class="section section--content section-products-code animate">
      <div class="page-wrapper">
          <div class="page-container">
              <h2 class="page-title">{{ ucwords($product->producer_name) }}</h2>
              <div class="brand-info-container">
                  <div class="logo-image"><img alt="" src="{{ url('/public/img/icons-general/car-logos/', $product->producer_logo) }}"></div>
                  <form class="product-overview">
                      <h3 class="partcode-title"><small>{{ $_page->text_1 }}</small>{{ $product->Code }}</h3>
                      <table class="product-short-info">
                          <tbody>
                              <tr>
                                  <td>{{ $_page->text_2 }}:</td>
                                  <td><b>{{ $product->Details }}</b></td>
                              </tr>
                              <tr>
                                  <td>{{ $_page->text_3 }}:</td>
                                  <td><b>{{ ucwords($product->producer_name) }}</b></td>
                              </tr>
                              @if($product->factor_group)
                              <tr>
                                  <td>{{ $_page->text_4 }}:</td>
                                  <td><b>{{ $product->factor_group }}</b></td>
                              </tr>
                              @endif
                              <tr>
                                  <td>{{ $_page->text_5 }}:</td>
                                  <td><b>{{ $product->Weight }}</b></td>
                              </tr>
                              <tr>
                                  <td>{{ $_page->text_6 }}:</td>
                                  <td><b>{{ $product->Note }}</b></td>
                              </tr>
                              <tr>
                                  <td>{{ $_page->text_7 }}:</td>
                                  <td><b>{{ $product->Sizes }}</b></td>
                              </tr>
                          </tbody>
                      </table>
                      <div class="cart-footer-actions">
                          <div class="total-amount">
                              <span class="text">{{ $_page->text_10 }}</span><span class="value">{{ number_format($product->user_price, 2, ',', '') }}</span>
                          </div>
                          <div class="total-amount">
                            <span class="text">{{ $product->factor_comment }}</span>
                          </div>
                          <div class="action-buttons">
                              <div class="btn counter-input js_counter-input">
                                  <button type="button" class="counter-input__btn minus js_counter-input-btn"><span></span></button>
                                  <input type="text" name="product-counter" value="1" class="input-quantity">
                                  <button type="button" class="counter-input__btn plus js_counter-input-btn"><span></span></button>
                              </div>
                              <button type="button" class="btn btn-red-small" onclick="__.toCart({{$product->Id}}, parseInt($(this).siblings().find('.input-quantity').val()))">{{ $_page->text_11 }}</button>
                          </div>
                      </div>
                  </form>
              </div>

          </div>
      </div>
  </section>

  @if(isset($product->substitutes) && $product->substitutes)
  <section class="section section-product-analogs animate">
      <div class="page-wrapper">
          <div class="page-container">
              <h3 class="section-title-small">{{ $_page->text_12 }}</h3>
              <div class="analogs-container animate">
                @foreach($product->substitutes as $sub)
                  <div class="analog-excerpt animate">
                      <h5 class="code">{{ $sub->Code }}</h5>
                      <h6 class="title">{{ $sub->producer_name }}</h6>
                      <a href="{{ url('products', $sub->Id) }}" class="link-more">{{ $_page->text_13 }}</a>
                  </div>
                @endforeach
              </div>
          </div>
      </div>
  </section>
  @endif
</main>
@endsection
