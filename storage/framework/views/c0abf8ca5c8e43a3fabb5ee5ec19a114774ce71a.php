<?php $__env->startSection('content'); ?>
<main class="page-content">


<div class="page-header-bg animate page-header-bg--profile">
    <div class="page-header-bg__image" style="background-image: url(<?php echo e(url('/public/img/content/bg2.jpg')); ?>)"></div>
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title"><?php echo e($_page->text_10); ?></h2>
            <div class="ext-balance">
                <div class="ext-balance__item">
                    <h5 class="ext-balance__title"><span class="t-desktop">Debt</span><span class="t-mobile">Debt</span></h5>
                    <span class="ext-balance__val <?php echo e($_user->balance > 0 ? 'red' : ''); ?>"><?php echo e($_user->debt); ?><span class="currency">&nbsp;€</span></span>
                </div>
                <div class="ext-balance__item">
                    <h5 class="ext-balance__title"><span class="t-desktop">Balance</span><span class="t-mobile">Balance</span></h5>
                    <span class="ext-balance__val <?php echo e($_user->balance > 0 ? 'green' : ''); ?>"><?php echo e($_user->balance); ?><span class="currency">&nbsp;€</span></span>
                </div>
                <div class="ext-balance__item">
                    <h5 class="ext-balance__title"><span class="t-desktop">Deposit Available</span><span class="t-mobile">Deposit Available</span></h5>
                    <span class="ext-balance__val <?php echo e($_user->deposit > 0 ? 'green' : ''); ?>"><?php echo e($_user->deposit); ?><span class="currency">&nbsp;€</span></span>
                </div>
            </div>
        </div>
    </div> 
</div>
<!-- Section Cart -->
<section class="section section--content-inner section-cart animate">
    <div class="page-wrapper">
        <div class="page-container">

            <?php echo $__env->make('elements.profilemenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <h3 class="section-title-small"><?php echo e($_page->text_1); ?></h3>
            <div class="section-text">
                <?php echo e($_page->text_2); ?>

            </div>

            <div class="cart-container">
                <div class="cart-header-sorting-form">
                    <form id="table-sorting-form" class="form-style form-style--dark-small">
                        <div class="fields-container">
                            <div class="fields-row-container fields-row-container--sorting">

                                <div class="fields-row fields-row--sorting-brand">
                                    <label class="col field-block">
                                        <span class="field-block__title"><?php echo e($_page->text_3); ?></span>
                                        <span class="field-block__input-container">
                                            <input type="text" id="discounts-brand" name="brand">
                                            <span class="appearance"><span></span></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="fields-row fields-row--sorting-discount">
                                    <label class="col field-block">
                                        <span class="field-block__title"><?php echo e($_page->text_4); ?></span>
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
                                <td class="cell-discounts-logo"><?php echo e($_page->text_5); ?></td>
                                <td class="cell-discounts-group"><?php echo e($_page->text_6); ?></td>
                                <td class="cell-products-group"><?php echo e($_page->text_7); ?></td>
                                <td class="cell-personal-discount"><?php echo e($_page->text_8); ?></td>
                            </tr>
                        </thead>
                        <tbody>
                          <?php foreach($discounts as $idx => $discount): ?>
                            <tr data-brand="<?php echo e($discount->producer_name); ?>" data-group="<?php echo e($discount->Name); ?>">
                                <td class="cell-number" data-sort="<?php echo e($idx); ?>">
                                    <div class="title-mobile"><span class="text">№</span></div>
                                    <div class="cell-value"><b><?php echo e($idx+1); ?></b></div>
                                </td>
                                <td class="cell-discounts-logo" data-sort="<?php echo e($discount->producer_name); ?>">
                                    <div class="title-mobile"><span class="text"><?php echo e($_page->text_5); ?></span></div>
                                    <div class="cell-value"><div class="logo-image"><img alt="<?php echo e($discount->producer_name); ?>" src="<?php echo e(url('/public/img/icons-general/car-logos', $discount->producer_logo)); ?>"></div></div>
                                </td>
                                <td class="cell-discount-group" data-sort="<?php echo e($discount->Name); ?>">
                                    <div class="title-mobile"><span class="text"><?php echo e($_page->text_6); ?></span></div>
                                    <div class="cell-value"><b><?php echo e($discount->Name); ?></b></div>
                                </td>
                                <td class="cell-products-group" data-sort="<?php echo e($discount->products_amount); ?>">
                                    <div class="title-mobile"><span class="text"><?php echo e($_page->text_7); ?></span></div>
                                    <div class="cell-value"><span class="nowrap"><?php echo e($discount->products_amount); ?></span></div>
                                </td>
                                <td class="cell-personal-discount" data-sort="<?php echo e(100 - (100 * $discount->Factor)); ?>">
                                    <div class="title-mobile"><span class="text"><?php echo e($_page->text_8); ?></span></div>
                                    <div class="cell-value"><span class="nowrap"><b><?php echo e(100 - (100 * $discount->Factor)); ?>%</b></span></div>
                                </td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="form-style form-style--dark discounts-footer">
                        <div class="form-footer">
                            <div class="action-buttons active">
                                <a href="<?php echo e(url('/cart')); ?>" class="btn btn-red-small"><?php echo e($_page->text_9); ?></a>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>