@extends('layouts.app')
@section('content')

<main class="page-content">

<!-- Section Cart -->
<section class="section section--content section-cart animate">
    <div class="page-wrapper">
        <div class="page-container">

            <h2 class="page-title">Balance</h2>

            @include('elements.profilemenu')

            <div class="cart-container js_tabs-scope" data-tabs="1">

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

                <div class="form-tabs-2">
                    <div class="form-tabs-2__nav">
                        <a class="btn btn-tab js_tabs-trigger active" data-tabs="1" data-tab="1">
                            <span class="btn-content">Invoices</span>
                        </a>
                        <a class="btn btn-tab js_tabs-trigger" data-tabs="1" data-tab="2">
                            <span class="btn-content">Payments</span>
                        </a>
                    </div>
                </div>

                <div class="cart-main">

                    <!-- Invoices table table -->
                    <div class="cart-table-container js_tabs-target active" data-tabs="1" data-tab="1">
                        <table id="table-balance-invoices" class="table-style-black table-balance table-wide table-underline js_table-tooltips js_dataTable">
                            <thead>
                                <tr>
                                    <td class="cell-b-date">Date</td>
                                    <td class="cell-b-invoice">Invoice number</td>
                                    <td class="cell-b-sum"><span class="price">Sum<span class="currency">€</span></span></td>
                                    <td class="cell-b-VAT">VAT</td>
                                    <td class="cell-b-total-sum"><span class="price">Total sum<span class="currency">€</span></span></td>
                                    <td class="cell-b-paid"><span class="price">Paid<span class="currency">€</span></span></td>
                                    <td class="cell-b-cond">Status</td>
                                    <td class="cell-b-comment">Comment</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices->list as $invoice)
                                <tr class="{{ $invoice->state_class }}">
                                    <td class="cell-b-date" data-sort="{{ strtotime($invoice->date) }}">
                                        <div class="title-mobile"><span class="text">Date</span></div>
                                        <div class="cell-value"><div class="b-date"><span>{{date('d.m.y', strtotime($invoice->date))}}</span><span>{{date('H:i:s', strtotime($invoice->date))}}</span></div></div>
                                    </td>
                                    <td class="cell-b-invoice" data-sort="{{ $invoice->invoice_id }}">
                                        <div class="title-mobile"><span class="text">Invoice №</span></div>
                                        <div class="cell-value"><b>{{ $invoice->invoice_num }}</b></div>
                                    </td>
                                    <td class="cell-b-sum" data-sort="{{ $invoice->amount }}">
                                        <div class="title-mobile"><span class="text"><span class="price">Sum<span class="currency">€</span></span></span></div>
                                        <div class="cell-value"><b>{{ number_format($invoice->amount,2,',',' ') }}</b></div>
                                    </td>
                                    <td class="cell-b-VAT" data-sort="0">
                                        <div class="title-mobile"><span class="text">VAT</span></div>
                                        <div class="cell-value">{{ $invoice->vat * 100 }}%</div>
                                    </td>
                                    <td class="cell-b-total-sum" data-sort="{{ $invoice->total }}">
                                        <div class="title-mobile"><span class="text"><span class="price">Total sum<span class="currency">€</span></span></span></div>
                                        <div class="cell-value">{{ number_format($invoice->total,2,',',' ') }}</div>
                                    </td>
                                    <td class="cell-b-paid" data-sort="{{ $invoice->paid }}">
                                        <div class="title-mobile"><span class="text"><span class="price">Paid<span class="currency">€</span></span></span></div>
                                        <div class="cell-value"><b>{{ number_format($invoice->paid,2,',',' ') }}</b></div>
                                    </td>
                                    <td class="cell-b-cond" data-sort="{{ $invoice->state }}">
                                        <div class="title-mobile"><span class="text">Status</span></div>
                                        <div class="cell-value"><span class="ball"></span></div>
                                    </td>
                                    <td class="cell-b-comment">
                                        <div class="title-mobile"><span class="text">Comment</span></div>
                                        <div class="cell-value">{{ $invoice->comment }}</div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td class="cell-b-invoice">
                                        <div class="title-mobile"><span class="text">Invoices</span></div><span class="nowrap"><b>{{ $invoices->size }}</b></span>
                                    </td>
                                    <td class="cell-b-sum">
                                        <div class="title-mobile"><span class="text"><span class="price">Sum<span class="currency">€</span></span></span></div><span class="nowrap"><b>{{ number_format($invoices->amount,2,',',' ') }}</b></span>
                                    </td>
                                    <td></td>
                                    <td class="cell-b-total-sum">
                                        <div class="title-mobile"><span class="text"><span class="price">Total sum<span class="currency">€</span></span></span></div><span class="nowrap"><b>{{ number_format($invoices->total,2,',',' ') }}</b></span>
                                    </td>
                                    <td class="cell-b-paid">
                                        <div class="title-mobile"><span class="text"><span class="price">Paid<span class="currency">€</span></span></span></div><span class="nowrap"><b>{{ number_format($invoices->paid,2,',',' ') }}</b></span>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="cart-table-container js_tabs-target" data-tabs="1" data-tab="2">
                        <table id="table-balance-payments" class="table-style-black table-balance table-wide table-underline js_table-tooltips js_dataTable">
                            <thead>
                                <tr>
                                    <td class="cell-b-date">Date</td>
                                    <td class="cell-b-type">Type</td>
                                    <td class="cell-b-sum"><span class="price">Sum<span class="currency">€</span></span></td>
                                    <td class="cell-b-comment">Comment</td>
                                    <td class="cell-b-balance"><span class="price">Balance<span class="currency">€</span></span></td>
                                    <td class="cell-b-Debt"><span class="price">Debt<span class="currency">€</span></span></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($moneyflow->operations as $shift)
                                <tr>
                                    <td class="cell-b-date" data-sort="{{ strtotime($shift->date) }}">
                                        <div class="title-mobile"><span class="text">Date</span></div>
                                        <div class="cell-value"><div class="b-date"><span>{{date('d.m.y', strtotime($shift->date))}}</span><span>{{date('H:i:s', strtotime($shift->date))}}</span></div>
                                        </div>
                                    </td>
                                    <td class="cell-b-type" data-sort="{{ $shift->type }}">
                                        <div class="title-mobile"><span class="text">Type</span></div>
                                        <div class="cell-value">{{ !$shift->type ? 'Payment' : 'Write-off' }}</div>
                                    </td>
                                    <td class="cell-b-sum" data-sort="{{ $shift->amount }}">
                                        <div class="title-mobile"><span class="text"><span class="price">Sum<span class="currency">€</span></span></span></div>
                                        <div class="cell-value"><b>{{ (!$shift->type ? '' : '-') . number_format($shift->amount,2,',',' ') }}</b></div>
                                    </td>
                                    <td class="cell-b-comment">
                                        <div class="title-mobile"><span class="text">Comment</span></div>
                                        <div class="cell-value">{{ $shift->comment }}</div>
                                    </td>
                                    <td class="cell-b-balance" data-sort="{{ $shift->balance }}">
                                        <div class="title-mobile"><span class="text"><span class="price">Balance<span class="currency">€</span></span></span></div>
                                        <div class="cell-value"><b>{{ number_format($shift->balance,2,',',' ') }}</b></div>
                                    </td>
                                    <td class="cell-b-Debt" data-sort="{{ $shift->debt }}">
                                        <div class="title-mobile"><span class="text"><span class="price">Debt<span class="currency">€</span></span></span></div>
                                        <div class="cell-value"><b>{{ number_format($shift->debt,2,',',' ') }}</b></div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td class="cell-b-type">
                                        <div class="title-mobile"><span class="text">Inv. / Writes off</span></div>
                                        <span class="nowrap"><b>{{ $moneyflow->size }} / {{ $moneyflow->size }}</b></span>
                                    </td>
                                    <td class="cell-b-sum">
                                        <div class="title-mobile"><span class="text"><span class="price">Sum<span class="currency">€</span></span></span></div>
                                        <span class="nowrap"><b>{{ number_format($moneyflow->received,2,',',' ') }} / {{ '-'.number_format($moneyflow->writtenoff,2,',',' ') }}</b></span>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
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
        var invoicesTable = $('#table-balance-invoices'),
            paymentsTable = $('#table-balance-payments'),
            invoicesDataTable,
            paymentsDataTable;

        if (invoicesTable.length) {
            initInvoicesTable(invoicesTable);
        };
        if (paymentsTable.length) {
            initPaymentsTable(paymentsTable);
        };

        function initInvoicesTable(table) {
            invoicesDataTable = table.DataTable({
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
                    { "orderable": false }
                ],
                "order": []
            });

            table.on( 'init', function () {
                cs.checkEditableHeight();
            } );
        }

        function initPaymentsTable(table) {
            paymentsDataTable = table.DataTable({
                "autoWidth": false,
                "searching": false,
                "paging": false,
                "info": false,
                "columns": [
                    null,
                    null,
                    null,
                    { "orderable": false },
                    null,
                    null
                ],
                "order": []
            });

            table.on( 'init', function () {
                cs.checkEditableHeight();
            } );
        }        
    }
</script>

@endsection
