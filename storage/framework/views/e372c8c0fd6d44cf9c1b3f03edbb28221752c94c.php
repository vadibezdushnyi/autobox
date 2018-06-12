<?php $__env->startSection('content'); ?>

<main class="page-content">

<div class="page-header-bg animate page-header-bg--profile">
    <div class="page-header-bg__image" style="background-image: url(<?php echo e(url('/public/img/content/bg2.jpg')); ?>)"></div>
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title"><?php echo e($_page->text_19); ?></h2>
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
                <div class="cart-header-actions">
                    <button class="btn btn-icon btn-black btn-cart-refresh" onclick="__.refreshCart()"><span class="icon icon-refresh"></span><?php echo e($_page->text_3); ?></button>
                    <button class="btn btn-icon btn-black btn-add-products js_modal-open" data-modal-type="add-products"><span class="icon"><span class="plus"></span></span><?php echo e($_page->text_4); ?></button>
                </div>
                <div class="cart-main" style="display:<?php echo e(empty($cart->products) ? 'none' : 'block'); ?>;">
                    <!-- Cart table -->
                    <div class="cart-table-container">
                        <table id="cart-table" class="table-style-black table-wide js_dataTable" style="position: relative;">
                          <div id="remove_overlay" style="display:none;">
                            <div style="display:table-cell;vertical-align:middle;">
                              <div style="font-size:16px;color:#fff;margin-bottom:5px;"><?php echo e($_page->text_21); ?></div>
                              <button type="button" class="btn btn-red confirm" style="margin-right:5px;"><?php echo e($_page->text_22); ?></button>
                              <button type="button" class="btn btn-red decline" style="margin-left:5px;"><?php echo e($_page->text_23); ?></button>
                            </div>
                          </div>
                            <thead>
                                <tr>
                                    <td class="cell-number">№</td>
                                    <td class="cell-logo"><?php echo e($_page->text_5); ?></td>
                                    <td class="cell-partcode"><?php echo e($_page->text_6); ?></td>
                                    <td class="cell-title"><?php echo e($_page->text_7); ?></td>
                                    <td class="cell-discount"><?php echo e($_page->text_8); ?></td>
                                    <?php /* ?>
                                    <td class="cell-price"><span class="price">{{ $_page->text_9 }}</span></td>
                                    <?php */ ?>
                                    <?php /* ?>
                                    <td class="cell-factor">{{ $_page->text_10 }}</td>
                                    <?php */ ?>
                                    <td class="cell-factor-price"><span class="price"><?php echo e($_page->text_11); ?></span></td>
                                    <td class="cell-quantity"><?php echo e($_page->text_12); ?></td>
                                    <td class="cell-total"><span class="price"><?php echo e($_page->text_13); ?></span></td>
                                    <td class="cell-comment"><?php echo e($_page->text_14); ?></td>
                                    <td class="cell-vin"><?php echo e($_page->text_15); ?></td>
                                    <td><img src="<?php echo e(url('/public/img/icons/alt-icon-20.png')); ?>" alt="alternative" title="Product replacenment"></td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                              <?php if($cart->products): ?>
                                <?php foreach($cart->products as $on => $p): ?>
                                  <?php if($p->not_found): ?>
                                  <tr data-product="<?php echo e($p->id); ?>">
                                    <td class="cell-number" data-sort="<?php echo e($on+1); ?>">
                                        <div class="title-mobile"><span class="text">№</span></div>
                                        <div class="cell-value"><?php echo e($on+1); ?></div>
                                    </td>
                                    <td class="cell-logo" data-sort="0">
                                        <div class="title-mobile"><span class="text"><?php echo e($_page->text_5); ?></span></div>
                                        <div class="cell-value"><span class="nowrap"> - </span></div>
                                    </td>
                                    <td class="cell-partcode" data-sort="<?php echo e($p->Code); ?>">
                                        <div class="title-mobile"><span class="text"><?php echo e($_page->text_6); ?></span></div>
                                        <div class="cell-value"><span class="nowrap"><?php echo e($p->Code); ?></span></div>
                                    </td>
                                    <td colspan="9" data-sort="0">
                                      <div class="cell-value"><span class="nowrap">Partcode removed or no longer available</span></div>
                                    </td>
                                    <td class="cell-delete" data-sort="0">
                                        <div class="title-mobile"><span class="text"></span></div>
                                        <div class="cell-value"><button type="button" class="btn btn-delete icon icon-trash" data-idx="<?php echo e($p->id); ?>" onclick="__.removeFromCartPopup(event)"></button></div>
                                    </td>
                                  </tr>
                                  <?php else: ?>
                                  <tr data-product="<?php echo e($p->id); ?>">
                                      <td class="cell-number" data-sort="<?php echo e($on+1); ?>">
                                          <div class="title-mobile"><span class="text">№</span></div>
                                          <div class="cell-value"><?php echo e($on+1); ?></div>
                                      </td>
                                      <td class="cell-logo" data-sort="<?php echo e($p->producer_name); ?>">
                                          <div class="title-mobile"><span class="text"><?php echo e($_page->text_5); ?></span></div>
                                          <div class="cell-value">
                                            <div class="logo-image">
                                              <img alt="<?php echo e($p->producer_name); ?>" title="<?php echo e($p->producer_name); ?>" src="<?php echo e(url('/public/img/icons-general/car-logos/'.$p->producer_logo)); ?>">
                                            </div>
                                          </div>
                                      </td>
                                      <td class="cell-partcode" data-sort="<?php echo e($p->Code); ?>">
                                          <div class="title-mobile"><span class="text"><?php echo e($_page->text_6); ?></span></div>
                                          <div class="cell-value"><span class="nowrap"><?php echo e($p->Code); ?></span></div>
                                      </td>
                                      <td class="cell-title" data-sort="<?php echo e($p->Details); ?>">
                                          <div class="title-mobile"><span class="text"><?php echo e($_page->text_7); ?></span></div>
                                          <div class="cell-value"><b><?php echo e($p->Details); ?></b></div>
                                      </td>
                                      <td class="cell-discount" data-sort="<?php echo e($p->FactorGroup); ?>">
                                          <div class="title-mobile"><span class="text"><?php echo e($_page->text_8); ?></span></div>
                                          <?php echo e($p->FactorGroup); ?><div class="cell-value"><span class="nowrap"><?php echo e($p->FactorGroup); ?></span></div>
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
                                      <td class="cell-factor-price" data-sort="<?php echo e(number_format($p->Price,2,',',' ')); ?>">
                                          <div class="title-mobile"><span class="text"><span class="price"><?php echo e($_page->text_11); ?></span></span></div>
                                          <div class="cell-value"><span class="nowrap"><?php echo e(number_format($p->Price,2,',',' ')); ?></span></div>
                                      </td>
                                      <td class="cell-quantity" data-sort="<?php echo e($p->qty); ?>"><div class="title-mobile"><span class="text"><?php echo e($_page->text_12); ?></span></div>
                                          <div class="cell-value"><input type="text" class="input-quantity" value="<?php echo e($p->qty); ?>" onchange="__.updateQty(<?php echo e($p->id); ?>, event)"></div>
                                      </td>
                                      <td class="cell-total" data-sort="<?php echo e(number_format($p->Price * $p->qty,2,',',' ')); ?>">
                                          <div class="title-mobile"><span class="text"><span class="price"><?php echo e($_page->text_13); ?></span></span></div>
                                          <?php echo e(number_format($p->Price * $p->qty,2,',',' ')); ?><div class="cell-value"><span class="nowrap"><b><?php echo e(number_format($p->Price * $p->qty,2,',',' ')); ?></b></span></div>
                                      </td>
                                      <td class="cell-comment js_editable-cell" data-cell="cell-comment">
                                          <div class="title-mobile"><span class="text"><?php echo e($_page->text_14); ?></span></div>
                                          <div class="editable-block js_editable">
                                              <div class="editable-block__value js_editable-value-container"><span class="js_editable-value"><?php echo e($p->comment); ?></span></div>
                                              <div class="editable-block__textarea js_editable-input"><textarea class="comment-textarea js_editable-textarea" onchange="__.updateComment(<?php echo e($p->id); ?>, event)"></textarea></div>
                                          </div>
                                      </td>
                                      <td class="cell-vin js_editable-cell" data-cell="cell-vin">
                                          <div class="title-mobile"><span class="text"><?php echo e($_page->text_15); ?></span></div>
                                          <div class="editable-block js_editable">
                                              <div class="editable-block__value js_editable-value-container"><span class="js_editable-value"><?php echo e($p->vin); ?></span></div>
                                              <div class="editable-block__textarea js_editable-input"><textarea class="comment-textarea js_editable-textarea" onchange="__.updateVin(<?php echo e($p->id); ?>, event)"></textarea></div>
                                          </div>
                                      </td>
                                      <td class="cell-delete">
                                        <?php if(strlen(trim($p->AltCode))): ?>
                                          <div class="title-mobile"><span class="text"></span></div>
                                          <div class="cell-value"><button type="button" class="btn btn-delete icon icon-refresh" data-idx="<?php echo e($p->product_id); ?>" onclick="__.cartReplacementPopup(event)"></button></div>
                                        <?php endif; ?>
                                      </td>
                                      <td class="cell-delete">
                                          <div class="title-mobile"><span class="text"></span></div>
                                          <div class="cell-value"><button type="button" class="btn btn-delete icon icon-trash" data-idx="<?php echo e($p->id); ?>" onclick="__.removeFromCartPopup(event)"></button></div>
                                      </td>
                                  </tr>
                                  <?php endif; ?>
                                <?php endforeach; ?>
                              <?php endif; ?>
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
                                    <td class="cell-quantity"><span class="nowrap total_qty"><?php echo e($cart->qty); ?></span></td>
                                    <td class="cell-total"><span class="nowrap total_amount"><b><?php echo e($cart->total); ?></b></span></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Negative balance -->
                    <div class="cart-empty-container notification" style="display: <?php echo e($cart->can_order ? 'none' : 'block'); ?>;">
                        <div class="form-style form-style--dark strong-m">
                            <div class="form-footer">
                                <div class="form-message icon icon-attention message-error active">
                                    <?php echo e($_page->text_24); ?> <strong class="price"><?php echo e($_user->balance); ?>€</strong>. <br><?php echo e($_page->text_25); ?>

                                </div>
                                <?php if(false): ?>
                                <div class="action-buttons active">
                                    <a href="javascript:void(0)" class="btn btn-red-small"><?php echo e($_page->text_26); ?></a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>                    

                    <!-- Cart table actions -->
                    <div class="cart-footer-actions">
                        <div class="total-amount">
                            <span class="text"><?php echo e($_page->text_16); ?></span><span class="value total_amount"><?php echo e($cart->total); ?></span>
                        </div>
                        <div class="action-buttons">
                            <button type="button" class="btn btn-grey-small" onclick="__.clearCartPopup();"><?php echo e($_page->text_17); ?></button>
                            <button type="button" class="btn btn-red-small <?php echo e(!$cart->can_order ? 'disabled' : ''); ?>" onclick="<?php echo e($cart->can_order ? '__.createOrder(event)' : ''); ?>">
                              <?php echo e($_page->text_18); ?>

                            </button>
                        </div>
                    </div>

                </div>
                <div class="cart-empty-container" style="display:<?php echo e(empty($cart->products) ? 'block' : 'none'); ?>;">
                  <h3 style="text-align:center;font-size: 28px;"><?php echo e($_page->text_20); ?></h3>
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

<?php echo $__env->make('elements.cartmodals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>