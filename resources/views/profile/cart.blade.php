@extends('layouts.app')
@section('content')

<main class="page-content">

<div class="page-header-bg animate page-header-bg--profile">
    <div class="page-header-bg__image" style="background-image: url({{ url('/public/img/content/bg2.jpg')  }})"></div>
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title">{{ $_page->text_19 }}</h2>
            <div class="ext-balance">
                    <div class="ext-balance__item">
                        <h5 class="ext-balance__title"><span class="t-desktop">Debt</span><span class="t-mobile">Debt</span></h5>
                        <span class="ext-balance__val {{ $_user->debt > 0 ? 'red' : '' }}">{{ $_user->debt }}<span class="currency">&nbsp;€</span></span>
                    </div>
                    <div class="ext-balance__item">
                        <h5 class="ext-balance__title"><span class="t-desktop">Balance</span><span class="t-mobile">Balance</span></h5>
                        <span class="ext-balance__val {{ $_user->balance == 0 ? 'red' : ( $_user->balance < 5000 ? 'yellow' : 'green') }}">{{ $_user->balance }}<span class="currency">&nbsp;€</span></span>
                    </div>
                    <div class="ext-balance__item">
                        <h5 class="ext-balance__title"><span class="t-desktop">Deposit Available</span><span class="t-mobile">Deposit Available</span></h5>
                        <span class="ext-balance__val {{ $_user->deposit_available == 0 ? 'red' : '' }}">{{ $_user->deposit_available }}<span class="currency">&nbsp;€</span></span>
                    </div>
            </div>
        </div>
    </div> 
</div>

<!-- Section Cart -->
<section class="section section--content-inner section-cart animate">
    <div class="page-wrapper">
        <div class="page-container">

            @include('elements.profilemenu')

            <h3 class="section-title-small">{{ $_page->text_1 }}</h3>
            <div class="section-text">
                {{ $_page->text_2 }}
            </div>

            <div class="cart-container">
                <div class="cart-header-actions">
                    <button class="btn btn-icon btn-black btn-cart-refresh" onclick="__.refreshCart()"><span class="icon icon-refresh"></span>{{ $_page->text_3 }}</button>
                    <button class="btn btn-icon btn-black btn-add-products js_modal-open" data-modal-type="add-products"><span class="icon"><span class="plus"></span></span>{{ $_page->text_4 }}</button>
                </div>
                <div class="cart-main" style="display:{{ empty($cart->products) ? 'none' : 'block' }};">
                    <!-- Cart table -->
                    <div class="cart-table-container">
                        <table id="cart-table" class="table-style-black table-wide js_dataTable" style="position: relative;">
                          <div id="remove_overlay" style="display:none;">
                            <div style="display:table-cell;vertical-align:middle;">
                              <div style="font-size:16px;color:#fff;margin-bottom:5px;">{{ $_page->text_21 }}</div>
                              <button type="button" class="btn btn-red confirm" style="margin-right:5px;">{{ $_page->text_22 }}</button>
                              <button type="button" class="btn btn-red decline" style="margin-left:5px;">{{ $_page->text_23 }}</button>
                            </div>
                          </div>
                            <thead>
                                <tr>
                                    <td class="cell-number">№</td>
                                    <td class="cell-logo">{{ $_page->text_5 }}</td>
                                    <td class="cell-partcode">{{ $_page->text_6 }}</td>
                                    <td class="cell-title">{{ $_page->text_7 }}</td>
                                    <td class="cell-discount">{{ $_page->text_8 }}</td>
                                    <?php /* ?>
                                    <td class="cell-price"><span class="price">{{ $_page->text_9 }}</span></td>
                                    <?php */ ?>
                                    <?php /* ?>
                                    <td class="cell-factor">{{ $_page->text_10 }}</td>
                                    <?php */ ?>
                                    <td class="cell-factor-price"><span class="price">{{ $_page->text_11 }}</span></td>
                                    <td class="cell-quantity">{{ $_page->text_12 }}</td>
                                    <td class="cell-total"><span class="price">{{ $_page->text_13 }}</span></td>
                                    <td class="cell-comment">{{ $_page->text_14 }}</td>
                                    <td class="cell-vin">{{ $_page->text_15 }}</td>
                                    <td><img src="{{ url('/public/img/icons/alt-icon-20.png') }}" alt="alternative" title="Product replacenment"></td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                              @if($cart->products)
                                @foreach($cart->products as $on => $p)
                                  <tr data-product="{{ $p->id }}">
                                      <td class="cell-number" data-sort="{{ $on+1 }}">
                                          <div class="title-mobile"><span class="text">№</span></div>
                                          <div class="cell-value">{{ $on+1 }}</div>
                                      </td>
                                      <td class="cell-logo" data-sort="{{ $p->producer_name }}">
                                          <div class="title-mobile"><span class="text">{{ $_page->text_5 }}</span></div>
                                          <div class="cell-value">
                                            <div class="logo-image">
												@if(!$p->not_found)
                                              	<img alt="{{ $p->producer_name }}" title="{{ $p->producer_name }}" src="{{ url('/public/img/icons-general/car-logos/'.$p->producer_logo) }}">
                                              	@endif
                                            </div>
                                          </div>
                                      </td>
                                      <td class="cell-partcode" data-sort="{{ $p->Code }}">
                                          <div class="title-mobile"><span class="text">{{ $_page->text_6 }}</span></div>
                                          <div class="cell-value"><span class="nowrap">{{ $p->Code }}</span></div>
                                      </td>
                                      <td class="cell-title" data-sort="{{ $p->Details }}">
                                          <div class="title-mobile"><span class="text">{{ $_page->text_7 }}</span></div>
                                          <div class="cell-value"><b>{{ $p->Details }}</b></div>
                                      </td>
                                      <td class="cell-discount" data-sort="{{ $p->FactorGroup }}">
                                          <div class="title-mobile"><span class="text">{{ $_page->text_8 }}</span></div>
                                          {{ $p->FactorGroup }}<div class="cell-value"><span class="nowrap">{{ $p->FactorGroup }}</span></div>
                                      </td>
                                      <?php /* ?>
                                      <td class="cell-price" data-sort="{{ number_format($p->OriginPrice,2,',','') }}">
                                          <div class="title-mobile"><span class="text"><span class="price">{{ $_page->text_9 }}</span></span></div>
                                          <div class="cell-value"><span class="nowrap">{{ number_format($p->OriginPrice,2,',','') }}</span></div>
                                      </td>
                                      <?php */ ?>
                                      <?php /* ?>
                                      <td class="cell-factor" data-sort="{{ $p->discount }}">
                                          <div class="title-mobile"><span class="text">{{ $_page->text_10 }}</span></div>
                                          <div class="cell-value"><span class="nowrap">{{ $p->discount }}</span></div>
                                      </td>
                                      <?php */ ?>
                                      <td class="cell-factor-price" data-sort="{{ number_format($p->Price,2,',',' ') }}">
                                          <div class="title-mobile"><span class="text"><span class="price">{{ $_page->text_11 }}</span></span></div>
                                          <div class="cell-value"><span class="nowrap">{{ number_format($p->Price,2,',',' ') }}</span></div>
                                      </td>
                                      <td class="cell-quantity" data-sort="{{ $p->qty }}"><div class="title-mobile"><span class="text">{{ $_page->text_12 }}</span></div>
                                          <div class="cell-value"><input type="text" class="input-quantity" value="{{ $p->qty }}" onchange="__.updateQty({{ $p->id }}, event)"></div>
                                      </td>
                                      <td class="cell-total" data-sort="{{ number_format($p->Price * $p->qty,2,',',' ') }}">
                                          <div class="title-mobile"><span class="text"><span class="price">{{ $_page->text_13 }}</span></span></div>
                                          {{ number_format($p->Price * $p->qty,2,',',' ') }}<div class="cell-value"><span class="nowrap"><b>{{ number_format($p->Price * $p->qty,2,',',' ') }}</b></span></div>
                                      </td>
                                      <td class="cell-comment js_editable-cell" data-cell="cell-comment">
                                          <div class="title-mobile"><span class="text">{{ $_page->text_14 }}</span></div>
                                          <div class="editable-block js_editable">
                                              <div class="editable-block__value js_editable-value-container"><span class="js_editable-value">{{ $p->comment }}</span></div>
                                              <div class="editable-block__textarea js_editable-input"><textarea class="comment-textarea js_editable-textarea" onchange="__.updateComment({{ $p->id }}, event)"></textarea></div>
                                          </div>
                                      </td>
                                      <td class="cell-vin js_editable-cell" data-cell="cell-vin">
                                          <div class="title-mobile"><span class="text">{{ $_page->text_15 }}</span></div>
                                          <div class="editable-block js_editable">
                                              <div class="editable-block__value js_editable-value-container"><span class="js_editable-value">{{ $p->vin }}</span></div>
                                              <div class="editable-block__textarea js_editable-input"><textarea class="comment-textarea js_editable-textarea" onchange="__.updateVin({{ $p->id }}, event)"></textarea></div>
                                          </div>
                                      </td>
                                      <td class="cell-delete">
                                        @if(strlen(trim($p->AltCode)) && !$p->not_found)
                                          <div class="title-mobile"><span class="text"></span></div>
                                          <div class="cell-value"><button type="button" class="btn btn-delete icon icon-refresh" data-idx="{{ $p->product_id }}" onclick="__.cartReplacementPopup(event)"></button></div>
                                        @endif
                                      </td>
                                      <td class="cell-delete">
                                          <div class="title-mobile"><span class="text"></span></div>
                                          <div class="cell-value"><button type="button" class="btn btn-delete icon icon-trash" data-idx="{{ $p->id }}" onclick="__.removeFromCartPopup(event)"></button></div>
                                      </td>
                                  </tr>
                                @endforeach
                              @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <?php /* ?>
                                    <td></td>
                                    <td></td>
                                    <?php */ ?>
                                    <td></td>
                                    <td></td>
                                    <td class="cell-quantity"><span class="nowrap total_qty">{{ $cart->qty }}</span></td>
                                    <td class="cell-total"><span class="nowrap total_amount"><b>{{ $cart->total }}</b></span></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Negative balance -->
                    <div class="cart-empty-container notification" style="display: {{ $cart->can_order ? 'none' : 'block' }};">
                        <div class="form-style form-style--dark strong-m">
                            <div class="form-footer">
                                <div class="form-message icon icon-attention message-error active">
                                    {!! $_page->text_24 !!} <br> {!! $_page->text_25 !!}: <strong class="price" id="claimed_to_refill">{{ number_format(($cart->ftotal - $_user->limit),2,',',' ') }} €</strong>
                                </div>
                                <?php if(false): ?>
                                <div class="action-buttons active">
                                    <a href="javascript:void(0)" class="btn btn-red-small">{{ $_page->text_26 }}</a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>                     

                    <!-- Cart table actions -->
                    <div class="cart-footer-actions cart-footer-actions--ext">
                        <div class="total-amount">
                            <table>
                                <tbody><tr>
                                    <td><span class="text">{{ $_page->text_27 }}</span></td>
                                    <td><span class="value total_amount">{{ $cart->total }} €</span></td>
                                </tr>
                                <tr>
                                    <td><span class="text">{{ $_page->text_28 }}</span></td>
                                    <td><span class="value total_vat"><?= $_settings->order_vat * 100 ?>%</span></td>
                                </tr>
                                <tr>
                                    <td><span class="text">{{ $_page->text_29 }}</span></td>
                                    <td><span class="value total_vat_amount">{{ $cart->vtotal }} €</span></td>
                                </tr>
                                <tr>
                                    <td><span class="text">{{ $_page->text_30 }}</span></td>
                                    <td>
                                        <div class="field-block">
                                            <div class="field-block__input-container">
                                                <textarea placeholder="{{ $_page->text_31 }}" id="order_comment"></textarea>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                          </table>
                        </div>                        
                        <div class="action-buttons">
                            <button type="button" class="btn btn-grey-small" onclick="__.clearCartPopup();">{{ $_page->text_17 }}</button>
                            <button type="button" id="order_create_btn" class="btn btn-red-small {{ !$cart->can_order ? 'disabled' : '' }}" onclick="{{ $cart->can_order ? '__.createOrder(event)' : '' }}">
                              {{ $_page->text_18 }}
                            </button>
                        </div>
                    </div>

                </div>
                <div class="cart-empty-container emptiness" style="display:{{ empty($cart->products) ? 'block' : 'none' }};">
                  <h3 style="text-align:center;font-size: 28px;">{{ $_page->text_20 }}</h3>
                </div>
            </div>
        </div>
    </div>
</section>


</main>

<script>
function destroyCartTable(table) {
  cartDataTable = table.DataTable();
  if(cartDataTable.hasOwnProperty('destroy')) cartDataTable.destroy();
}
function initCartTable(table) {
  cartDataTable = table.DataTable({
    "autoWidth": false,
    "searching": false,
    "paging": false,
    "info": false,
    "columns": [
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      { "orderable": false },
      { "orderable": false },
      { "orderable": false }
    ],
    "order": []
  });

  table.on( 'init', function () {
    cs.checkEditableHeight();
  } );
}

window.onload = function() {

    var cartTable = $('#cart-table'),
    importResultTable = $('#import-result-table'),
    cartDataTable,
    importDataTable;

    if (cartTable.length) {
      initCartTable(cartTable);
    };
    if (importResultTable.length) {
      initImportTable(importResultTable);
    };

    function initImportTable(table) {
      importDataTable = table.DataTable({
        "autoWidth": false,
        "searching": false,
        "paging": false,
        "info": false,
        "columns": [
          null,
          null,
          { "orderable": false },
          null
          ],
          "order": []
        });

        table.on( 'init', function () {
          cs.checkEditableHeight();
        } );
      }
      $(document).on('keypress', '.input-quantity', function(e) {
        return isNumberKey(e);

        function isNumberKey(evt){
          var charCode = (evt.which) ? evt.which : event.keyCode
          if (charCode > 31 && (charCode < 48 || charCode > 57)) return false;

          return true;
        }

      });
      $(document).on('change', '.input-quantity', function(e) {
        var $this = $(e.target);
        value = $this.val().trim(),
        cell = $this.closest('td');

        cell.attr('data-sort', value);
        if ($(this).closest('#cart-table').length) {
          cartDataTable.row(cell.closest('tr')).invalidate().draw();
        } else if ($(this).closest('#import-result-table').length) {
          importDataTable.row(cell.closest('tr')).invalidate().draw();
        }

      });
};
</script>

@include('elements.cartmodals')
@endsection
