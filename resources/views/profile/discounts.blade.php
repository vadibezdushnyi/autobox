@extends('layouts.app')
@section('content')
<main class="page-content">


<div class="page-header-bg animate page-header-bg--profile">
    <div class="page-header-bg__image" style="background-image: url({{ url('/public/img/content/bg2.jpg')  }})"></div>
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title">{{ $_page->text_10 }}</h2>
            <div class="ext-balance">
                <div class="ext-balance__item">
                    <h5 class="ext-balance__title"><span class="t-desktop">Debt</span><span class="t-mobile">Debt</span></h5>
                    <span class="ext-balance__val {{ $_user->balance > 0 ? 'red' : '' }}">{{ $_user->debt }}<span class="currency">&nbsp;€</span></span>
                </div>
                <div class="ext-balance__item">
                    <h5 class="ext-balance__title"><span class="t-desktop">Balance</span><span class="t-mobile">Balance</span></h5>
                    <span class="ext-balance__val {{ $_user->balance > 0 ? 'green' : '' }}">{{ $_user->balance }}<span class="currency">&nbsp;€</span></span>
                </div>
                <div class="ext-balance__item">
                    <h5 class="ext-balance__title"><span class="t-desktop">Deposit Available</span><span class="t-mobile">Deposit Available</span></h5>
                    <span class="ext-balance__val {{ $_user->deposit_available > 0 ? 'green' : '' }}">{{ $_user->deposit_available }}<span class="currency">&nbsp;€</span></span>
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
                <div class="cart-header-sorting-form">
                    <form id="table-sorting-form" class="form-style form-style--dark-small">
                        <div class="fields-container">
                            <div class="fields-row-container fields-row-container--sorting">

                                <div class="fields-row fields-row--sorting-brand">
                                    <label class="col field-block">
                                        <span class="field-block__title">{{ $_page->text_3 }}</span>
                                        <span class="field-block__input-container">
                                            <input type="text" id="discounts-brand" name="brand">
                                            <span class="appearance"><span></span></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="fields-row fields-row--sorting-discount">
                                    <label class="col field-block">
                                        <span class="field-block__title">{{ $_page->text_4 }}</span>
                                        <span class="field-block__input-container">
                                            <input type="text" id="discounts-group" name="discount-group">
                                            <span class="appearance"><span></span></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="fields-row fields-row--2 fields-row--sorting-btns">
                                    <div class="col field-block col--btn-sorting-filter">
                                        <span class="field-block__title"></span>
                                        <span class="field-block__input-container">
                                            <button type="button" class="btn btn-sorting-filter icon icon-filter" onclick="__.filterDiscounts();"></button>
                                        </span>
                                    </div>
                                    <div class="col field-block col--btn-sorting-reset">
                                        <span class="field-block__title"></span>
                                        <span class="field-block__input-container">
                                            <button type="button" class="btn btn-sorting-reset icon icon-cross3" onclick="__.resetForm();__.filterDiscounts();"></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="cart-main">

                    <!-- Cart table -->
                    <table id="discounts-table" class="table-style-black table-discounts table-underline table-zebra js_table-tooltips js_dataTable">
                        <thead>
                            <tr>
                                <td class="cell-number">№</td>
                                <td class="cell-discounts-logo">{{ $_page->text_5 }}</td>
                                <td class="cell-discounts-group">{{ $_page->text_6 }}</td>
                                <td class="cell-products-group">{{ $_page->text_7 }}</td>
                                <td class="cell-personal-discount">{{ $_page->text_8 }}</td>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($discounts as $idx => $discount)
                            <tr data-brand="{{ $discount->producer_name }}" data-group="{{ $discount->Name }}">
                                <td class="cell-number" data-sort="{{ $idx }}">
                                    <div class="title-mobile"><span class="text">№</span></div>
                                    <div class="cell-value"><b>{{ $idx+1 }}</b></div>
                                </td>
                                <td class="cell-discounts-logo" data-sort="{{ $discount->producer_name }}">
                                    <div class="title-mobile"><span class="text">{{ $_page->text_5 }}</span></div>
                                    <div class="cell-value"><div class="logo-image"><img alt="{{ $discount->producer_name }}" src="{{ url('/public/img/icons-general/car-logos', $discount->producer_logo) }}"></div></div>
                                </td>
                                <td class="cell-discount-group" data-sort="{{ $discount->Name }}">
                                    <div class="title-mobile"><span class="text">{{ $_page->text_6 }}</span></div>
                                    <div class="cell-value"><b>{{ $discount->Name }}</b></div>
                                </td>
                                <td class="cell-products-group" data-sort="{{ $discount->products_amount }}">
                                    <div class="title-mobile"><span class="text">{{ $_page->text_7 }}</span></div>
                                    <div class="cell-value"><span class="nowrap">{{ $discount->products_amount }}</span></div>
                                </td>
                                <td class="cell-personal-discount" data-sort="{{ 100 - (100 * $discount->Factor) }}">
                                    <div class="title-mobile"><span class="text">{{ $_page->text_8 }}</span></div>
                                    <div class="cell-value"><span class="nowrap"><b>{{ 100 - (100 * $discount->Factor) }}%</b></span></div>
                                </td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>

                    <div class="form-style form-style--dark discounts-footer">
                        <div class="form-footer">
                            <div class="action-buttons active">
                                <a href="{{ url('/cart') }}" class="btn btn-red-small">{{ $_page->text_9 }}</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<script>
  window.onload = function() {
    var discountsTable = $('#discounts-table'),
        discountsDataTable;

    if (discountsTable.length) {
        initDiscountsTable(discountsTable);
    };

    function initDiscountsTable(table) {
        discountsDataTable = table.DataTable({
            "autoWidth": false,
            "searching": false,
            "paging": false,
            "info": false,
            "columns": [
                null,
                null,
                null,
                null,
                null
            ],
            "order": []
        });

        table.on( 'init', function () {
            cs.checkEditableHeight();
        });
    }
  }
</script>

</main>
@endsection
