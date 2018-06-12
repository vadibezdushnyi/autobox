<?php $__env->startSection('content'); ?>

<main class="page-content">


<!-- Section Prices -->
<section class="page-section section-prices animate">
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title"><?php echo e($_page->text_1); ?></h2>
            <h3 class="section-title-small section-title-small--red"><?php echo e($_page->text_2); ?></h3>
            <div class="section-text">
                <?php echo e($_page->text_3); ?>

            </div>

            <div class="pricelist-container animate">
                <div class="input-block-bg">
                    <div class="block-bg"  style="background-image: url(<?php echo e(url('/public/img/content/modal-bg1.jpg')); ?>)"></div>
                    <div class="code-field__container code-field__container--small">
                        <form>
                            <div class="code-field__input code-field__input--btn">
                                <label>
                                    <input type="search" placeholder="<?php echo e($_page->text_4); ?>" id="filter-pricelists-input" onkeydown="if(event.keyCode==13) event.preventDefault(), __.filterPricelists();">
                                </label>
                                <button type="button" class="btn-close icon icon-cross3" onclick="$('#filter-pricelists-input').val(''); __.filterPricelists();"></button>
                            </div>
                            <button type="button" class="btn btn-red code-field__btn icon icon-search" onclick="__.filterPricelists();"><?php echo e($_page->text_5); ?></button>
                        </form>
                    </div>
                </div>

                <div class="prices-table-container">
                    <table id="prices-table" class="table-style">
                        <thead>
                            <tr>
                                <td>
                                    <span class="title-border"><?php echo e($_page->text_6); ?></span>
                                </td>
                                <td>
                                    <span class="title-border"><?php echo e($_page->text_7); ?></span>
                                </td>
                                <td>
                                    <span class="title-border"><?php echo e($_page->text_8); ?></span>
                                </td>
                                <td>
                                    <span class="title-border"><?php echo e($_page->text_9); ?></span>
                                </td>
                                <td>
                                    <span class="title-border"><?php echo e($_page->text_10); ?></span>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                          <?php foreach($pricelists as $pricelist): ?>
                            <tr data-filter="<?php echo e(strtolower($pricelist->Name)); ?>">
                                <td class="cell-logo">
                                    <div class="title-mobile"><span class="title-border"><?php echo e($_page->text_6); ?></span></div>
                                    <div class="cell-value"><div class="logo-image"><img alt="<?php echo e($pricelist->Name); ?>" src="<?php echo e(url('/public/img/icons-general/car-logos/'.$pricelist->Logo)); ?>"></div></div>
                                </td>
                                <td>
                                    <div class="title-mobile"><span class="title-border"><?php echo e($_page->text_7); ?></span></div>
                                    <div class="cell-value"><span class="brand"><?php echo e($pricelist->Name . (strlen(trim($pricelist->Comment)) ? ' / '.$pricelist->Comment : '' )); ?></span></div>
                                </td>
                                <td class="cell-date">
                                    <div class="title-mobile"><span class="title-border"><?php echo e($_page->text_8); ?></span></div>
                                    <div class="cell-value"><?php echo e(date('d.m.Y', strtotime($pricelist->Modified))); ?></div>
                                </td>
                                <td>
                                    <div class="title-mobile"><span class="title-border"><?php echo e($_page->text_9); ?></span></div>
                                    <div class="cell-value"><span class="file-name"><?php echo e($pricelist->Name . '.xlsx'); ?> <?php echo $pricelist->New ? '<span class="new">' . $_page->text_11 . '</span>' : ''; ?></span>
                                        <?php /*<span class="file-info">0.00 Kb</span>*/?>
                                    </div>
                                </td>
                                <td class="cell-download">
                                    <div class="title-mobile"><span class="title-border"><?php echo e($_page->text_10); ?></span></div>
                                    <div class="cell-value"><a href="<?php echo e(url('prices', $pricelist->Name . '.xlsx')); ?>?o=<?php echo e($pricelist->OwnerSupplierId); ?>" target="_blank" class="btn btn-download icon icon-download"></a></div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</section>


</main>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>