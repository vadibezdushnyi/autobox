<?php $__env->startSection('content'); ?>




<main class="page-content">

<!-- Section Cart -->
<section class="section section--content section-cart animate">
    <div class="page-wrapper">
        <div class="page-container">

            <h2 class="page-title">Balance</h2>

            <?php echo $__env->make('elements.profilemenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <div class="cart-container js_tabs-scope" data-tabs="1">

                <div class="ext-balance">
                    <div class="ext-balance__item">
                        <h5 class="ext-balance__title"><span class="t-desktop">Debt</span><span class="t-mobile">Debt</span></h5>
                        <span class="ext-balance__val">0<span class="currency">&nbsp;€</span></span>
                    </div>
                    <div class="ext-balance__item">
                        <h5 class="ext-balance__title"><span class="t-desktop">Balance</span><span class="t-mobile">Balance</span></h5>
                        <span class="ext-balance__val green">5 000<span class="currency">&nbsp;€</span></span>
                    </div>
                    <div class="ext-balance__item">
                        <h5 class="ext-balance__title"><span class="t-desktop">Deposit Available</span><span class="t-mobile">Deposit Available</span></h5>
                        <span class="ext-balance__val">20 000<span class="currency">&nbsp;€</span></span>
                    </div>
                </div>
                <div class="ext-balance">
                    <div class="ext-balance__item">
                        <h5 class="ext-balance__title"><span class="t-desktop">Debt</span><span class="t-mobile">Debt</span></h5>
                        <span class="ext-balance__val red">7 000<span class="currency">&nbsp;€</span></span>
                    </div>
                    <div class="ext-balance__item">
                        <h5 class="ext-balance__title"><span class="t-desktop">Balance</span><span class="t-mobile">Balance</span></h5>
                        <span class="ext-balance__val yellow">5 000<span class="currency">&nbsp;€</span></span>
                    </div>
                    <div class="ext-balance__item">
                        <h5 class="ext-balance__title"><span class="t-desktop">Deposit Available</span><span class="t-mobile">Deposit Available</span></h5>
                        <span class="ext-balance__val">13 000<span class="currency">&nbsp;€</span></span>
                    </div>
                </div>
                <div class="ext-balance">
                    <div class="ext-balance__item">
                        <h5 class="ext-balance__title"><span class="t-desktop">Debt</span><span class="t-mobile">Debt</span></h5>
                        <span class="ext-balance__val red">2 000<span class="currency">&nbsp;€</span></span>
                    </div>
                    <div class="ext-balance__item">
                        <h5 class="ext-balance__title"><span class="t-desktop">Balance</span><span class="t-mobile">Balance</span></h5>
                        <span class="ext-balance__val red">0<span class="currency">&nbsp;€</span></span>
                    </div>
                    <div class="ext-balance__item">
                        <h5 class="ext-balance__title"><span class="t-desktop">Deposit Available</span><span class="t-mobile">Deposit Available</span></h5>
                        <span class="ext-balance__val">13 000<span class="currency">&nbsp;€</span></span>
                    </div>
                </div>
                <div class="ext-balance">
                    <div class="ext-balance__item">
                        <h5 class="ext-balance__title"><span class="t-desktop">Debt</span><span class="t-mobile">Debt</span></h5>
                        <span class="ext-balance__val red">15 001<span class="currency">&nbsp;€</span></span>
                    </div>
                    <div class="ext-balance__item">
                        <h5 class="ext-balance__title"><span class="t-desktop">Balance</span><span class="t-mobile">Balance</span></h5>
                        <span class="ext-balance__val red">0<span class="currency">&nbsp;€</span></span>
                    </div>
                    <div class="ext-balance__item">
                        <h5 class="ext-balance__title"><span class="t-desktop">Deposit Available</span><span class="t-mobile">Deposit Available</span></h5>
                        <span class="ext-balance__val red">0<span class="currency">&nbsp;€</span></span>
                    </div>
                </div>

                <div class="form-tabs-2">
                    <div class="form-tabs-2__nav">
                        <a href="" class="btn btn-tab js_tabs-trigger active" data-tabs="1" data-tab="1">
                            <span class="btn-content">Invoices</span>
                        </a>
                        <a href="" class="btn btn-tab js_tabs-trigger" data-tabs="1" data-tab="2">
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
                                <tr class="status-complete">
                                    <td class="cell-b-date" data-sort="55434314324">
                                        <div class="title-mobile"><span class="text">Date</span></div>
                                        <div class="cell-value"><div class="b-date"><span>16.12.2017</span><span>09:30:00</span></div></div>
                                    </td>
                                    <td class="cell-b-invoice" data-sort="RE 1701">
                                        <div class="title-mobile"><span class="text">Invoice №</span></div>
                                        <div class="cell-value"><b>RE 1701</b></div>
                                    </td>
                                    <td class="cell-b-sum" data-sort="12000">
                                        <div class="title-mobile"><span class="text"><span class="price">Sum<span class="currency">€</span></span></span></div>
                                        <div class="cell-value"><b>12 000</b></div>
                                    </td>
                                    <td class="cell-b-VAT" data-sort="0">
                                        <div class="title-mobile"><span class="text">VAT</span></div>
                                        <div class="cell-value">0%</div>
                                    </td>
                                    <td class="cell-b-total-sum" data-sort="12000">
                                        <div class="title-mobile"><span class="text"><span class="price">Total sum<span class="currency">€</span></span></span></div>
                                        <div class="cell-value">12 000</div>
                                    </td>
                                    <td class="cell-b-paid" data-sort="12000">
                                        <div class="title-mobile"><span class="text"><span class="price">Paid<span class="currency">€</span></span></span></div>
                                        <div class="cell-value"><b>12 000</b></div>
                                    </td>
                                    <td class="cell-b-cond" data-sort="1">
                                        <div class="title-mobile"><span class="text">Status</span></div>
                                        <div class="cell-value"><span class="ball"></span></div>
                                    </td>
                                    <td class="cell-b-comment">
                                        <div class="title-mobile"><span class="text">Comment</span></div>
                                        <div class="cell-value">Waiting for confirmation</div>
                                    </td>
                                </tr>
                                <tr class="status-in-progress">
                                    <td class="cell-b-date" data-sort="44434314504">
                                        <div class="title-mobile"><span class="text">Date</span></div>
                                        <div class="cell-value"><div class="b-date"><span>15.12.2017</span><span>09:34:00</span></div></div>
                                    </td>
                                    <td class="cell-b-invoice" data-sort="RE 2401">
                                        <div class="title-mobile"><span class="text">Invoice №</span></div>
                                        <div class="cell-value"><b>RE 2401</b></div>
                                    </td>
                                    <td class="cell-b-sum" data-sort="12000">
                                        <div class="title-mobile"><span class="text"><span class="price">Sum<span class="currency">€</span></span></span></div>
                                        <div class="cell-value"><b>12 000</b></div>
                                    </td>
                                    <td class="cell-b-VAT" data-sort="0">
                                        <div class="title-mobile"><span class="text">VAT</span></div>
                                        <div class="cell-value">0%</div>
                                    </td>
                                    <td class="cell-b-total-sum" data-sort="12000">
                                        <div class="title-mobile"><span class="text"><span class="price">Total sum<span class="currency">€</span></span></span></div>
                                        <div class="cell-value">12 000</div>
                                    </td>
                                    <td class="cell-b-paid" data-sort="5000">
                                        <div class="title-mobile"><span class="text"><span class="price">Paid<span class="currency">€</span></span></span></div>
                                        <div class="cell-value"><b>5 000</b></div>
                                    </td>
                                    <td class="cell-b-cond" data-sort="2">
                                        <div class="title-mobile"><span class="text">Status</span></div>
                                        <div class="cell-value"><span class="ball"></span></div>
                                    </td>
                                    <td class="cell-b-comment">
                                        <div class="title-mobile"><span class="text">Comment</span></div>
                                        <div class="cell-value">Waiting for confirmation</div>
                                    </td>
                                </tr>
                                <tr class="status-waiting">
                                    <td class="cell-b-date" data-sort="33434314504">
                                        <div class="title-mobile"><span class="text">Date</span></div>
                                        <div class="cell-value"><div class="b-date"><span>14.12.2017</span><span>09:30:10</span></div></div>
                                    </td>
                                    <td class="cell-b-invoice" data-sort="RE 2403">
                                        <div class="title-mobile"><span class="text">Invoice №</span></div>
                                        <div class="cell-value"><b>RE 2403</b></div>
                                    </td>
                                    <td class="cell-b-sum" data-sort="12000">
                                        <div class="title-mobile"><span class="text"><span class="price">Sum<span class="currency">€</span></span></span></div>
                                        <div class="cell-value"><b>12 000</b></div>
                                    </td>
                                    <td class="cell-b-VAT" data-sort="0">
                                        <div class="title-mobile"><span class="text">VAT</span></div>
                                        <div class="cell-value">0%</div>
                                    </td>
                                    <td class="cell-b-total-sum" data-sort="12000">
                                        <div class="title-mobile"><span class="text"><span class="price">Total sum<span class="currency">€</span></span></span></div>
                                        <div class="cell-value">12 000</div>
                                    </td>
                                    <td class="cell-b-paid" data-sort="0">
                                        <div class="title-mobile"><span class="text"><span class="price">Paid<span class="currency">€</span></span></span></div>
                                        <div class="cell-value"><b>0</b></div>
                                    </td>
                                    <td class="cell-b-cond" data-sort="3">
                                        <div class="title-mobile"><span class="text">Status</span></div>
                                        <div class="cell-value"><span class="ball"></span></div>
                                    </td>
                                    <td class="cell-b-comment">
                                        <div class="title-mobile"><span class="text">Comment</span></div>
                                        <div class="cell-value">Waiting for confirmation</div>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td class="cell-b-invoice">
                                        <div class="title-mobile"><span class="text">Invoices</span></div><span class="nowrap"><b>3</b></span>
                                    </td>
                                    <td class="cell-b-sum">
                                        <div class="title-mobile"><span class="text"><span class="price">Sum<span class="currency">€</span></span></span></div><span class="nowrap"><b>36 000</b></span>
                                    </td>
                                    <td></td>
                                    <td class="cell-b-total-sum">
                                        <div class="title-mobile"><span class="text"><span class="price">Total sum<span class="currency">€</span></span></span></div><span class="nowrap"><b>36 000</b></span>
                                    </td>
                                    <td class="cell-b-paid">
                                        <div class="title-mobile"><span class="text"><span class="price">Paid<span class="currency">€</span></span></span></div><span class="nowrap"><b>20 000</b></span>
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
                                <tr>
                                    <td class="cell-b-date" data-sort="55434314324">
                                        <div class="title-mobile"><span class="text">Date</span></div>
                                        <div class="cell-value"><div class="b-date"><span>17.12.2017</span><span>09:30:00</span></div></div>
                                    </td>
                                    <td class="cell-b-type" data-sort="Payment">
                                        <div class="title-mobile"><span class="text">Type</span></div>
                                        <div class="cell-value">Payment</div>
                                    </td>
                                    <td class="cell-b-sum" data-sort="12000">
                                        <div class="title-mobile"><span class="text"><span class="price">Sum<span class="currency">€</span></span></span></div>
                                        <div class="cell-value"><b>12 000</b></div>
                                    </td>
                                    <td class="cell-b-comment">
                                        <div class="title-mobile"><span class="text">Comment</span></div>
                                        <div class="cell-value">RE 1701</div>
                                    </td>
                                    <td class="cell-b-balance" data-sort="12000">
                                        <div class="title-mobile"><span class="text"><span class="price">Balance<span class="currency">€</span></span></span></div>
                                        <div class="cell-value"><b>12 000</b></div>
                                    </td>
                                    <td class="cell-b-Debt" data-sort="0">
                                        <div class="title-mobile"><span class="text"><span class="price">Debt<span class="currency">€</span></span></span></div>
                                        <div class="cell-value"><b>0</b></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="cell-b-date" data-sort="31434314504">
                                        <div class="title-mobile"><span class="text">Date</span></div>
                                        <div class="cell-value"><div class="b-date"><span>15.12.2017</span><span>09:30:00</span></div></div>
                                    </td>
                                    <td class="cell-b-type" data-sort="Write off">
                                        <div class="title-mobile"><span class="text">Type</span></div>
                                        <div class="cell-value">Write off</div>
                                    </td>
                                    <td class="cell-b-sum" data-sort="-5000">
                                        <div class="title-mobile"><span class="text">Sum</span></div>
                                        <div class="cell-value"><b>-5 000</b></div>
                                    </td>
                                    <td class="cell-b-comment">
                                        <div class="title-mobile"><span class="text">Comment</span></div>
                                        <div class="cell-value">PayPal</div>
                                    </td>
                                    <td class="cell-b-balance" data-sort="7000">
                                        <div class="title-mobile"><span class="text">Balance</span></div>
                                        <div class="cell-value"><b>7 000</b></div>
                                    </td>
                                    <td class="cell-b-Debt" data-sort="0">
                                        <div class="title-mobile"><span class="text"><span class="price">Debt<span class="currency">€</span></span></span></div>
                                        <div class="cell-value"><b>0</b></div>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td class="cell-b-type">
                                        <div class="title-mobile"><span class="text">Inv. / Writes off</span></div>
                                        <span class="nowrap"><b>1 / 1</b></span>
                                    </td>
                                    <td class="cell-b-sum">
                                        <div class="title-mobile"><span class="text"><span class="price">Sum<span class="currency">€</span></span></span></div>
                                        <span class="nowrap"><b>12 000 / -5 000</b></span>
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
    // Keyboard ESC close modal trigger
    $(document).on('keyup', function(e) {
        var params = {};
        if (e.which == 27) {
            $('.field-block.field-list-active').removeClass('field-list-active');
        }
    });
    // Field list search
    $('.field-block--list input').on('input change paste propertychange', function(e) {
        var val = $(this).val();
            fieldBlock = $(this).closest('.field-block'),
            list = fieldBlock.find('.field-list'),
            listElements = list.find('li');

        listElements.removeClass('hidden').each(function() {
            if ($(this).find('a').text().trim().toLowerCase().indexOf(val.toLowerCase()) !== 0) $(this).addClass('hidden');
        });

        fieldBlock.addClass('field-list-active');

    });

    // Form logic
    $('.js_form-edit').on('click', function(e) {
        e.preventDefault();
        var form = $(this).closest('form'),
            tabsToggler = form.find('.tabs-toggler');

        form.removeClass('form-disabled').find('input[disabled]').prop("disabled", false).first().focus();
        form.find('.js_actions-save').addClass('active');
        tabsToggler.find('.btn').removeClass('active').filter('.js_form-edit').addClass('active');
        if (!clientInfo.mobile) {
            $('html, body').animate({ scrollTop: form.find('input').first().offset().top - cs.winHeight/3.8 }, 400);
        } else {
            $('html, body').animate({ scrollTop: form.find('input').first().offset().top - cs.winHeight/3.8 }, 0);
        }
    });
    $('.js_form-cancel').on('click', function(e) {
        e.preventDefault();
        var form = $(this).closest('form'),
            tabsToggler = form.find('.tabs-toggler');

        form.addClass('form-disabled').find('input').prop("disabled", true).blur();
        form.find('.js_actions-save').removeClass('active');
        tabsToggler.find('.btn').removeClass('active').filter('.js_form-cancel').addClass('active');
    });
  };

</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>