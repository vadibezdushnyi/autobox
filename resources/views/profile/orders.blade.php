@extends('layouts.app')
@section('content')

<main class="page-content">


<div class="page-header-bg animate page-header-bg--profile">
    <div class="page-header-bg__image" style="background-image: url({{ url('/public/img/content/bg2.jpg')  }})"></div>
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title">{{ $_page->text_1 }}</h2>
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

            <h3 class="section-title-small">{{ $_page->text_2 }}</h3>
            <div class="section-text">{{ $_page->text_3 }}</div>

            <div class="cart-container">
                <div class="cart-header-sorting-form">
                    <form id="table-sorting-form" class="form-style form-style--dark-small">
                        <div class="fields-container">
                            <div class="fields-row-container fields-row-container--sorting">

                                <div class="fields-row fields-row--2 fields-row--sorting-date">
                                    <label class="col field-block field-block--date">
                                        <span class="field-block__title">{{ $_page->text_4 }}</span>
                                        <span class="field-block__input-container">
                                            <input type="text" id="order-date-start" name="order-date-start" class="js_datepicker start-date" data-default="{{ date('d.m.y', strtotime($ordersStartDate)) }}" value="{{ date('d.m.y', strtotime($ordersStartDate)) }}">
                                            <span class="appearance"><span></span></span>
                                        </span>
                                    </label>
                                    <label class="col field-block field-block--date">
                                        <span class="field-block__title"></span>
                                        <span class="field-block__input-container">
                                            <input type="text" id="order-date-end" name="order-date-end" class="js_datepicker end-date" data-default="{{ date('d.m.y', strtotime($ordersEndDate)) }}" value="{{ date('d.m.y', strtotime($ordersEndDate)) }}">
                                            <span class="appearance"><span></span></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="fields-row fields-row--2 fields-row--sorting-text">
                                    <label class="col field-block">
                                        <span class="field-block__title">{{ $_page->text_5 }}</span>
                                        <span class="field-block__input-container">
                                            <input type="text" id="order-partcode" name="order-partcode" data-default="">
                                            <span class="appearance"><span></span></span>
                                        </span>
                                    </label>
                                    <label class="col field-block">
                                        <span class="field-block__title">{{ $_page->text_6 }}</span>
                                        <span class="field-block__input-container">
                                            <input type="text" id="order-keyword" name="order-keyword" data-default="">
                                            <span class="appearance"><span></span></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="fields-row fields-row--2 fields-row--sorting-btns">
                                    <div class="col field-block col--btn-sorting-filter">
                                        <span class="field-block__title"></span>
                                        <span class="field-block__input-container">
                                            <button type="button" class="btn btn-sorting-filter icon icon-filter" onclick="__.filterOrders(); "></button>
                                        </span>
                                    </div>
                                    <div class="col field-block col--btn-sorting-reset">
                                        <span class="field-block__title"></span>
                                        <span class="field-block__input-container">
                                            <button type="button" class="btn btn-sorting-reset icon icon-cross3" onclick="__.resetForm(); __.filterOrders();"></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="cart-main">

                    <!-- Cart table -->
                    <div class="cart-table-container">
                        <table id="orders-table" class="table-style-black table-orders table-wide table-underline table-zebra js_table-tooltips js_dataTable">
                            <thead>
                                <tr>
                                    <td class="cell-number">№</td>
                                    <?php /* <td class="cell-client-code">{{ $_page->text_7 }}</td> */ ?>
                                    <td class="cell-order">{{ $_page->text_8 }}</td>
                                    <td class="cell-status">Status</td>
                                    <td class="cell-products">{{ $_page->text_9 }}</td>
                                    <td class="cell-date">{{ $_page->text_11 }}</td>
                                    <?php /* <td class="cell-netto-price"><span class="price">{{ $_page->text_12 }}</span></td> */ ?>
                                    <td class="cell-brutto-price"><span class="price">{{ $_page->text_13 }}</span></td>
                                    <td class="cell-vat">{{ $_page->text_14 }}</td>
                                    <td class="cell-sum"><span class="price">{{ $_page->text_15 }}</span></td>
                                    <td class="cell-in-stock">{{ $_page->text_16 }}</td>
                                    <td class="cell-sent">{{ $_page->text_17 }}</td>
                                    <td class="cell-watch"><span class="icon icon-info"></span></td>
                                </tr>
                            </thead>
                            @if(!empty($orders))
                            <tbody>
                              @foreach($orders as $np => $order)
                                <tr>
                                    <td class="cell-number" data-sort="{{ $np + 1 }}">
                                        <div class="title-mobile"><span class="text">№</span></div>
                                        <div class="cell-value"><b>{{ $np + 1 }}</b></div>
                                    </td>
                                   <?php /*  <td class="cell-client-code" data-sort="{{ $order->KundenCode }}">
                                        <div class="title-mobile"><span class="text">{{ $_page->text_7 }}</span></div>
                                        <div class="cell-value">{{ $order->KundenCode }}</div>
                                    </td> */ ?>
                                    <td class="cell-order" data-sort="{{ $order->wb_id }}">
                                        <div class="title-mobile"><span class="text">{{ $_page->text_8 }}</span></div>
                                        <div class="cell-value"><a href="{{ url('/profile/orders/'.$order->id) }}" class="order-link link-blue"><b>{{ strlen($order->wb_id) ? $order->wb_id : '-' }}</b></a></div>
                                    </td>
                                    <td class="cell-status" data-sort="<?= $order->status ?>">
                                        <div class="title-mobile"><span class="text">Status</span></div>
                                        <div class="cell-value">{{ $order->status_name }}</div>
                                    </td>
                                    <td class="cell-products" data-sort="{{ $order->products }}">
                                        <div class="title-mobile"><span class="text">{{ $_page->text_9 }}</span></div>
                                        <div class="cell-value"><span class="nowrap">{{ $order->products }}</span></div>
                                    </td>
                                    <td class="cell-date" data-sort="{{ strtotime($order->created) }}">
                                        <div class="title-mobile"><span class="text">{{ $_page->text_11 }}</span></div>
                                        <div class="cell-value"><span class="nowrap">{{ date('d.m.Y H:i', strtotime($order->created)) }}</span></div>
                                    </td>
                                    <?php /* <td class="cell-netto-price" data-sort="{{ sprintf('%.2f', $order->netto) }}">
                                        <div class="title-mobile"><span class="text"><span class="price">{{ $_page->text_12 }}</span></span></div>
                                        <div class="cell-value"><span class="nowrap">{{ sprintf("%.2f", $order->netto) }}</span></div>
                                    </td> */ ?>
                                    <td class="cell-brutto-price" data-sort="{{ sprintf('%.2f', $order->brutto) }}">
                                        <div class="title-mobile"><span class="text"><span class="price">{{ $_page->text_13 }}</span></span></div>
                                        <div class="cell-value"><span class="nowrap">{{ sprintf("%.2f", $order->brutto) }}</span></div>
                                    </td>
                                    <td class="cell-vat" data-sort="{{ sprintf('%.2f', $order->vat) }}">
                                        <div class="title-mobile"><span class="text">{{ $_page->text_14 }}</span></div>
                                        <div class="cell-value"><span class="nowrap">{{ sprintf("%.2f", $order->vat) }}%</span></div>
                                    </td>
                                    <td class="cell-sum" data-sort="{{ sprintf('%.2f', $order->brutto) }}">
                                        <div class="title-mobile"><span class="text"><span class="price">{{ $_page->text_15 }}</span></span></div>
                                        <div class="cell-value"><span class="nowrap"><b>{{ sprintf("%.2f", ( $order->brutto + ($order->brutto/100*$order->vat) ) ) }}</b></span></div>
                                    </td>
                                    <td class="cell-in-stock <?= !$order->instock ? 'status-waiting' : ( $order->instock < $order->products ? 'status-in-progress' : 'status-complete' ) ?>" data-sort="{{ $order->instock }}">
                                        <div class="title-mobile"><span class="text">{{ $_page->text_16 }}</span></div>
                                        <div class="cell-value"><span class="nowrap">{{ $order->instock }}</span></div>
                                    </td>
                                    <td class="cell-sent <?= !$order->sent ? 'status-waiting' : ( $order->sent < $order->products ? 'status-in-progress' : 'status-complete' ) ?>" data-sort="{{ $order->sent }}">
                                        <div class="title-mobile"><span class="text">{{ $_page->text_17 }}</span></div>
                                        <div class="cell-value"><span class="nowrap">{{ $order->sent }}</span></div>
                                    </td>
                                    <td class="cell-watch">
                                        <div class="title-mobile"><span class="text"></span></div>
                                        <div class="cell-value"><a href="{{ url('/profile/orders/'.$order->id) }}" class="btn btn-watch icon icon-eye"></a></div>
                                    </td>
                                </tr>
                              @endforeach
                            </tbody>
                            @endif
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

</main>

<script>
window.onload = function() {

    var ordersTable = $('#orders-table'),
        ordersDataTable;

    if (ordersTable.length) {
        initOrdersTable(ordersTable);
    };

    function initOrdersTable(table) {
        ordersDataTable = table.DataTable({
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
                null,
                { "orderable": false }
            ],
            "order": []
        });

        table.on( 'init', function () {
            cs.checkEditableHeight();
        } );
    };

    var dateFormat = "dd.mm.y",

    startDatepicker = $('.js_datepicker.start-date').datepicker({dateFormat: dateFormat}).on( "change", function() {
      endDatepicker.datepicker("option", "minDate", getDate(this));
    }),

    endDatepicker = $('.js_datepicker.end-date').datepicker({dateFormat: dateFormat}).on( "change", function() {
      startDatepicker.datepicker("option", "maxDate", getDate(this));
    });

    startDatepicker.datepicker("setDate", new Date("{{ $ordersStartDate }}"));
    endDatepicker.datepicker("setDate", new Date("{{ $ordersEndDate }}"));

    function getDate(element) {
      var date;
      try {
        date = $.datepicker.parseDate(dateFormat, element.value);
      } catch( error ) {
        date = null;
      }
      return date;
    }
};

</script>

@endsection
