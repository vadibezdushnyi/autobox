<?php $__env->startSection('content'); ?>

<main class="page-content">


<div class="page-header-bg animate page-header-bg--profile">
    <div class="page-header-bg__image" style="background-image: url(<?php echo e(url('/public/img/content/bg2.jpg')); ?>)"></div>
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title"><?php echo e($_page->text_1); ?></h2>
            <div class="ext-balance">
                    <div class="ext-balance__item">
                        <h5 class="ext-balance__title"><span class="t-desktop">Debt</span><span class="t-mobile">Debt</span></h5>
                        <span class="ext-balance__val <?php echo e($_user->debt > 0 ? 'red' : ''); ?>"><?php echo e($_user->debt); ?><span class="currency">&nbsp;€</span></span>
                    </div>
                    <div class="ext-balance__item">
                        <h5 class="ext-balance__title"><span class="t-desktop">Balance</span><span class="t-mobile">Balance</span></h5>
                        <span class="ext-balance__val <?php echo e($_user->balance == 0 ? 'red' : ( $_user->balance < 5000 ? 'yellow' : 'green')); ?>"><?php echo e($_user->balance); ?><span class="currency">&nbsp;€</span></span>
                    </div>
                    <div class="ext-balance__item">
                        <h5 class="ext-balance__title"><span class="t-desktop">Deposit Available</span><span class="t-mobile">Deposit Available</span></h5>
                        <span class="ext-balance__val <?php echo e($_user->deposit_available == 0 ? 'red' : ''); ?>"><?php echo e($_user->deposit_available); ?><span class="currency">&nbsp;€</span></span>
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

            <div class="cart-container js_tabs-scope" data-tabs="2">
                <div class="order-header">
                    <div class="order-header__info">
                        <a href="<?php echo e(url('/profile/orders')); ?>" class="link-back link-back--dark"><?php echo e($_page->text_2); ?></a>
                        <h3 class="order-title"><?php echo e($order->wb_id); ?></h3>
                        <table class="order-short-info">
                            <tbody>
                                <tr>
                                    <td><?php echo e($_page->text_8); ?>: <span class="value"><?php echo e($order->status_name); ?></span></td>%
                                    <td><?php echo e($_page->text_4); ?>: <span class="value total_netto"><?php echo e(sprintf("%.2f", $order->brutto)); ?></span></td>
                                </tr>
                                <tr>
                                    <td><?php echo e($_page->text_3); ?>: <span class="value"><?php echo e(date('d.m.Y', strtotime($order->created))); ?></span></td>
                                    <td><?php echo e($_page->text_5); ?>: <span class="value"><?php echo e(sprintf("%.2f", $order->vat)); ?>%</span></td>
                                </tr>
                                <tr>
                                    <td><?php echo e($_page->text_7); ?>: <span class="value">20</span></td>
                                    <td><?php echo e($_page->text_6); ?>: <span class="value total_brutto"><?php echo e(sprintf("%.2f", ( $order->brutto + ( $order->brutto/100*$order->vat ) ) )); ?></span></td>
                                    <input type="hidden" name="order" id="order-identifier" value="<?php echo e($order->id); ?>">
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="order-header__form">
                        <form id="order-search-form" class="form-style form-style--dark-small">
                            <div class="fields-container">
                                <div class="fields-row">
                                    <label class="col field-block field-block--search">
                                        <span class="field-block__input-container">
                                            <input type="text" id="order-partcode" name="order-partcode" placeholder="<?php echo e($_page->text_13); ?>" 
                                            onkeydown="if(event.keyCode==13) event.preventDefault(), __.filterProducts();">
                                            <span class="appearance"><span></span></span>
                                            <button type="button" class="btn btn-input-search icon icon-search2" onclick="__.filterProducts()"></button>
                                        </span>
                                    </label>
                                </div>
                                <div class="fields-row">
                                    <div class="col field-block field-block--dpd">
                                        <div class="dpd-title">Sort by:</div>
                                        <div class="dpd js_dropdown">
                                            <div class="dpd-field">
                                                <div class="dpd-field-input">
                                                    <span class="val js_dropdown-val">Manufacturer</span>
                                                    <input type="text" class="js_dropdown-input" value="cell-order-producer" name="sort-field">
                                                </div>
                                            </div>
                                            <div class="dpd-ct">
                                                <ul>
                                                    <li><a href="javascript:void(0)" class="js_dropdown-option" data-val="cell-order-producer">Manufacturer</a></li>
                                                    <li><a href="javascript:void(0)" class="js_dropdown-option" data-val="cell-order-partcode">Partcode</a></li>
                                                    <li><a href="javascript:void(0)" class="js_dropdown-option" data-val="cell-order-discount">Disc. gr</a></li>
                                                    <li><a href="javascript:void(0)" class="js_dropdown-option" data-val="cell-brutto-price">Price</a></li>
                                                    <li><a href="javascript:void(0)" class="js_dropdown-option" data-val="cell-order-quantity">Quant</a></li>
                                                    <li><a href="javascript:void(0)" class="js_dropdown-option" data-val="cell-sum">Sum</a></li>
                                                    <li><a href="javascript:void(0)" class="js_dropdown-option" data-val="cell-in-stock">In Stock</a></li>
                                                    <li><a href="javascript:void(0)" class="js_dropdown-option" data-val="cell-sent">Sent</a></li>
                                                    <li><a href="javascript:void(0)" class="js_dropdown-option" data-val="cell-delete">Stop</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="sort-ordering">
                                            <label class="btn btn-ordering">
                                                <input type="radio" name="sort-dir" value="1">
                                                <span class="box icon icon-arrow-up2"></span>
                                            </label>
                                            <label class="btn btn-ordering">
                                                <input type="radio" name="sort-dir" value="2" checked>
                                                <span class="box icon icon-arrow-down2"></span>
                                            </label>
                                        </div>
                                        <button type="button" class="btn btn-sorting-apply icon icon-arrows-circle2" onclick="__.filterProducts()"></button>
                                    </div>
                                </div>                                
                            </div>
                        </form>
                    </div>

                </div>

                <div class="form-tabs-2">
                    <div class="form-tabs-2__nav">
                        <a href="#" class="btn btn-tab js_tabs-trigger active" data-tabs="2" data-tab="1">
                            <span class="btn-content"><?php echo e($_page->text_9); ?></span>
                        </a>
                        <a href="#" class="btn btn-tab js_tabs-trigger" data-tabs="2" data-tab="2">
                            <span class="btn-content"><?php echo e($_page->text_11); ?></span>
                        </a>
                    </div>
                </div>

                <div class="cart-main">

                    <!-- Cart table -->
                    <div class="cart-table-container js_tabs-target active" data-tabs="2" data-tab="1">
                      <div class="cart-empty-container" style="display:<?php echo e(empty($order->products) ? 'block' : 'none'); ?>;">
                        <h3 style="text-align:center;font-size: 28px;"><?php echo e($_page->text_12); ?></h3>
                      </div>
                        <table id="order-table" style="display:<?php echo e(empty($order->products) ? 'none' : 'table'); ?>;" class="table-style-black table-order table-full-footer table-wide js_table-tooltips js_table-togglable js_dataTable">
                          <div id="remove_overlay" style="display:none;">
                            <div style="display:table-cell;vertical-align:middle;">
                              <div style="font-size:16px;color:#fff;margin-bottom:5px;"><?php echo e($_page->text_51); ?></div>
                              <button type="button" class="btn btn-red confirm" style="margin-right:5px;"><?php echo e($_page->text_52); ?></button>
                              <button type="button" class="btn btn-red decline" style="margin-left:5px;"><?php echo e($_page->text_53); ?></button>
                            </div>
                          </div>
                            <thead>
                                <tr>
                                    <td class="cell-order-number">№</td>
                                    <td class="cell-order-producer"><?php echo e($_page->text_16); ?></td>
                                    <td class="cell-order-partcode"><?php echo e($_page->text_13); ?></td>
                                    <td class="cell-order-title"><?php echo e($_page->text_14); ?></td>
                                    <td class="cell-order-discount"><?php echo e($_page->text_15); ?></td>
                                    <td class="cell-brutto-price"><span class="price"><?php echo e($_page->text_18); ?></span></td>
                                    <td class="cell-order-quantity"><?php echo e($_page->text_19); ?></td>
                                    <td class="cell-sum"><span class="price"><?php echo e($_page->text_20); ?></span></td>
                                    <td class="cell-comments-count"><?php echo e($_page->text_21); ?></td>
                                    <td class="cell-in-stock"><?php echo e($_page->text_22); ?></td>
                                    <td class="cell-sent"><?php echo e($_page->text_23); ?></td>
                                    <td class="cell-delete"><?php echo e($_page->text_17); ?></td>
                                    <td class="cell-watch"><span class="icon icon-info"></span></td>
                                </tr>
                            </thead>
                              <?php foreach($order->products as $n => $product): ?>
                                <tbody style="border-top: 1px solid #ededed;" data-idx="<?php echo e($n); ?>">
                                    <tr data-partcode="<?php echo e($product->Code); ?>" data-product="<?php echo e($product->id); ?>">
                                        <td class="cell-order-number" data-sort="<?php echo e($n + 1); ?>">
                                            <div class="title-mobile"><span class="text">№</span></div>
                                            <div class="cell-value"><b><?php echo e($n + 1); ?></b></div>
                                        </td>
                                        <td class="cell-order-producer" data-sort="<?php echo e($product->producer_name); ?>">
                                            <div class="title-mobile"><span class="text"><?php echo e($_page->text_16); ?></span></div>
                                            <div class="cell-value"><b><div class="logo-image"><img alt="<?php echo e($product->producer_name); ?>" src="<?php echo e(url('/public/img/icons-general/car-logos/' . $product->producer_logo)); ?>"></div></b></div>
                                        </td>
                                        <td class="cell-order-partcode" data-sort="<?php echo e($product->Code); ?>">
                                            <div class="title-mobile"><span class="text"><?php echo e($_page->text_13); ?></span></div>
                                            <div class="cell-value">
                                                <?php if($product->changed_code): ?>
                                                <div class="replacement">
                                                    <span class="first"><b><?php echo e($product->Code); ?></b></span>
                                                    <span class="icon icon-replacement"></span>
                                                    <span class="last"><?php echo e($product->changed_code); ?></span>
                                                </div>
                                                <?php else: ?>
                                                <b><?php echo e($product->Code); ?></b>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td class="cell-order-title" data-sort="<?php echo e($product->Details); ?>">
                                            <div class="title-mobile"><span class="text"><?php echo e($_page->text_14); ?></span></div>
                                            <div class="cell-value"><?php echo e($product->Details); ?></div>
                                        </td>
                                        <td class="cell-order-discount" data-sort="<?php echo e($product->ClientDiscountGroupId); ?>">
                                            <div class="title-mobile"><span class="text"><?php echo e($_page->text_15); ?></span></div>
                                            <div class="cell-value"><span class="nowrap"><?php echo e($product->ClientDiscountGroupId); ?></span></div>
                                        </td>
                                        <td class="cell-brutto-price" data-sort="<?php echo e($product->brutto); ?>">
                                            <div class="title-mobile"><span class="text"><span class="price"><?php echo e($_page->text_18); ?></span></span></div>
                                            <div class="cell-value"><span class="nowrap"><?php echo e(sprintf('%.2f', $product->brutto)); ?></span></div>
                                        </td>
                                        <td class="cell-order-quantity" data-sort="<?php echo e($product->qty); ?>">
                                            <div class="title-mobile"><span class="text"><?php echo e($_page->text_19); ?></span></div>
                                            <div class="cell-value"><span class="nowrap">
                                                <?php echo e($product->qty_ab > 0 && $product->qty_ab < $product->qty ? $product->qty_ab.'/'.$product->qty : $product->qty); ?>

                                            </span></div>
                                        </td>
                                        <td class="cell-sum" data-sort="<?php echo e($product->brutto_sum); ?>">
                                            <div class="title-mobile"><span class="text"><span class="price"><?php echo e($_page->text_20); ?></span></span></div>
                                            <div class="cell-value"><span class="nowrap"><?php echo e(sprintf('%.2f', $product->brutto_sum)); ?></span></div>
                                        </td>
                                        <td class="cell-comments-count" data-sort="<?php echo e($product->comment); ?>">
                                            <div class="title-mobile"><span class="text"><?php echo e($_page->text_21); ?></span></div>
                                            <div class="cell-value"><span class="nowrap"><?php echo e($product->comment); ?></span></div>
                                        </td>
                                        <td class="cell-in-stock <?= !$product->in_stock ? 'status-waiting' : ( $product->in_stock < $product->qty ? 'status-in-progress' : 'status-complete' ) ?>" data-sort="<?php echo e($product->in_stock); ?>">
                                            <div class="title-mobile"><span class="text"><?php echo e($_page->text_22); ?></span></div>
                                            <div class="cell-value"><span class="nowrap"><?php echo e($product->in_stock); ?></span></div>
                                        </td>
                                        <td class="cell-sent <?= !$product->sent ? 'status-waiting' : ( $product->sent < $product->qty ? 'status-in-progress' : 'status-complete' ) ?>" data-sort="<?php echo e($product->sent); ?>">
                                            <div class="title-mobile"><span class="text"><?php echo e($_page->text_23); ?></span></div>
                                            <div class="cell-value"><span class="nowrap"><?php echo e($product->sent); ?></span></div>
                                        </td>
                                        <td class="cell-delete" data-sort="<?php echo e($product->stop); ?>">
                                            <div class="title-mobile"><span class="text"><?php echo e($_page->text_17); ?></span></div>
                                            <div class="cell-value"><?php echo $product->stop ? '<span class="icon icon-cancel"></span>' : ''; ?></div>
                                        </td>
                                        <td class="cell-watch">
                                            <div class="title-mobile"><span class="text"></span></div>
                                            <div class="cell-value"><button type="button" class="btn btn-table-icon-plus js_btn-order-details"></button></div>
                                        </td>
                                    </tr>
                                    <tr class="row-details">
                                        <td colspan="14">
                                            <div class="extended-details">
                                                <div class="extended-header">
                                                    <div class="col col-left">
                                                        <div class="logo-image">
                                                            <img alt="<?php echo e($product->producer_name); ?>" src="<?php echo e(url('/public/img/icons-general/car-logos', $product->producer_logo)); ?>">
                                                        </div>
                                                        <div class="extended-header__text">
                                                            <?php echo e($_page->text_24); ?>: 
                                                            <?php if($product->changed_code): ?>
                                                            <div class="replacement">
                                                                <span class="first"><b><?php echo e($product->Code); ?></b></span>
                                                                <span class="icon icon-replacement"></span>
                                                                <span class="last"><?php echo e($product->changed_code); ?></span>
                                                            </div>
                                                            <?php else: ?>
                                                            <b><?php echo e($product->Code); ?></b>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col col-right">
                                                        <div class="extended-header__text extended-details__date"><span><?php echo e(date('j.m.y', strtotime($product->modified))); ?></span><span><?php echo e(date('H:i:s', strtotime($product->modified))); ?></span></div>
                                                    </div>
                                                </div>
                                                <div>
                                                  <?php if($product->history): ?>
                                                    <?php if($product->history->Before_Stock && !empty((array)$product->history->Before_Stock)): ?>
                                                      <div class="extended-table-container">
                                                      <table class="table-style-black table-extended table-extended-main">
                                                          <thead>
                                                              <tr>
                                                                  <td class="cell-details-number"><?php echo e($_page->text_25); ?></td>
                                                                  <td class="cell-details-date"><?php echo e($_page->text_26); ?></td>
                                                                  <td class="cell-details-quantity"><?php echo e($_page->text_27); ?></td>
                                                                  <td class="cell-details-factor"><?php echo e($_page->text_29); ?></td>
                                                                  <td class="cell-details-brutto-price"><span class="price"><?php echo e($_page->text_30); ?></span></td>
                                                                  <td class="cell-details-sum"><span class="price"><?php echo e($_page->text_31); ?></span></td>
                                                                  <td class="cell-details-comment"><?php echo e($_page->text_32); ?></td>
                                                                  <td class="cell-details-comment"><?php echo e($_page->text_33); ?></td>
                                                                  <td class="cell-details-replacementt"><?php echo e($_page->text_34); ?></td>
                                                                  <td class="cell-details-stop"><?php echo e($_page->text_35); ?></td>
                                                              </tr>
                                                          </thead>
                                                          <tbody>
                                                            <?php foreach($product->history->Before_Stock as $bsproduct): ?>
                                                              <tr>
                                                                  <td class="cell-details-number" data-sort="">
                                                                      <div class="title-mobile"><span class="text">№</span></div>
                                                                      <div class="cell-value"><?php echo e($bsproduct->Stage_Type.$bsproduct->Stage_Number); ?></div>
                                                                  </td>
                                                                  <td class="cell-details-date" data-sort="">
                                                                      <div class="title-mobile"><span class="text"><?php echo e($_page->text_26); ?></span></div>
                                                                      <div class="cell-value"><div class="extended-details__date"><span><?php echo e(date('d.m.Y', strtotime($bsproduct->Date_Created))); ?></span><span><?php echo e(date('H:i', strtotime($bsproduct->Date_Created))); ?></span></div></div>
                                                                  </td>
                                                                  <td class="cell-details-quantity" data-sort="">
                                                                      <div class="title-mobile"><span class="text"><?php echo e($_page->text_27); ?></span></div>
                                                                      <div class="cell-value"><span class="nowrap"><?php echo e($bsproduct->Quant); ?></span></div>
                                                                  </td>
                                                                  <td class="cell-details-factor" data-sort="">
                                                                      <div class="title-mobile"><span class="text"><?php echo e($_page->text_29); ?></span></div>
                                                                      <div class="cell-value"><span class="nowrap"><?php echo e(( $bsproduct->Discount_Percent < 0 ? abs($bsproduct->Discount_Percent).'%' : ' - ' )); ?></span></div>
                                                                  </td>
                                                                  <td class="cell-details-brutto-price" data-sort="">
                                                                      <div class="title-mobile"><span class="text"><span class="price"><?php echo e($_page->text_30); ?></span></span></div>
                                                                      <div class="cell-value"><span class="nowrap"><?php echo e(number_format($bsproduct->Netto_Price, 2, ',', ' ')); ?></span></div>
                                                                  </td>
                                                                  <td class="cell-details-sum" data-sort="">
                                                                      <div class="title-mobile"><span class="text"><span class="price"><?php echo e($_page->text_31); ?></span></span></div>
                                                                      <div class="cell-value"><span class="nowrap"><?php echo e(number_format($bsproduct->Netto_sum, 2, ',', ' ')); ?></span></div>
                                                                  </td>
                                                                  <td class="cell-details-comment" data-sort="">
                                                                      <div class="title-mobile"><span class="text"><?php echo e($_page->text_32); ?></span></div>
                                                                      <div class="cell-value"><?php echo e($bsproduct->Client_Comment); ?></div>
                                                                  </td>
                                                                  <td class="cell-details-comment" data-sort="">
                                                                      <div class="title-mobile"><span class="text"><?php echo e($_page->text_33); ?></span></div>
                                                                      <div class="cell-value"><?php echo e($bsproduct->User_Comment); ?></div>
                                                                  </td>
                                                                  <td class="cell-details-replacement" data-sort="">
                                                                      <div class="title-mobile"><span class="text"><?php echo e($_page->text_34); ?></span></div>
                                                                      <div class="cell-value">
                                                                        <span class="nowrap">
                                                                        <?php if($bsproduct->Replacement_Code): ?> 
                                                                            <span class="nowrap"><span class="icon icon-replacement single-rep"></span><?php echo e($bsproduct->Replacement_Code); ?></span>
                                                                        <?php endif; ?>
                                                                        </span>
                                                                       </div>
                                                                  </td>
                                                                  <td class="cell-details-stop">
                                                                      <div class="title-mobile"><span class="text"><?php echo e($_page->text_35); ?></span></div>
                                                                      <div class="cell-value">
                                                                        <?php if($bsproduct->Stop_Status): ?> 
                                                                            <span class="icon icon-cancel"></span> 
                                                                        <?php endif; ?>
                                                                    </div>
                                                                  </td>
                                                              </tr>
                                                              <?php endforeach; ?>
                                                          </tbody>
                                                      </table>
                                                     </div>
                                                    <?php endif; ?>
                                                    <?php if($product->history->Stock && !empty((array)$product->history->Stock)): ?>
                                                      <div class="extended-table-title"><b><?php echo e($_page->text_36); ?></b></div>
                                                      <div class="extended-table-container">
                                                        <table class="table-style-black table-extended">
                                                            <thead>
                                                                <tr>
                                                                    <td class="cell-details-number"><?php echo e($_page->text_37); ?></td>
                                                                    <td class="cell-details-date"><?php echo e($_page->text_38); ?></td>
                                                                    <td class="cell-details-quantity"><?php echo e($_page->text_39); ?></td>
                                                                    <td class="cell-details-packed"><?php echo e($_page->text_40); ?></td>
                                                                    <td class="cell-details-colli"><?php echo e($_page->text_41); ?></td>
                                                                    <td class="cell-details-shipment"><?php echo e($_page->text_42); ?></td>
                                                                    <td class="cell-details-transport"><?php echo e($_page->text_43); ?></td>
                                                                    <td class="cell-details-transport"><?php echo e($_page->text_55); ?></td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                              <?php foreach($product->history->Stock as $sproduct): ?>
                                                                <tr>
                                                                    <td class="cell-details-number" data-sort="">
                                                                        <div class="title-mobile"><span class="text">№</span></div>
                                                                        <div class="cell-value"><?php echo e($sproduct->Stage_Type.$bsproduct->Stage_Number); ?></div>
                                                                    </td>
                                                                    <td class="cell-details-date" data-sort="">
                                                                        <div class="title-mobile"><span class="text"><?php echo e($_page->text_38); ?></span></div>
                                                                        <div class="cell-value"><div class="extended-details__date"><span><?php echo e(date('d.m.Y', strtotime($sproduct->Recieved_Eingang_Date))); ?></span><span><?php echo e(date('H:i', strtotime($sproduct->Recieved_Eingang_Date))); ?></span></div></div>
                                                                    </td>
                                                                    <td class="cell-details-quantity" data-sort="">
                                                                        <div class="title-mobile"><span class="text"><?php echo e($_page->text_39); ?></span></div>
                                                                        <div class="cell-value"><span class="nowrap"><?php echo e($sproduct->Quant); ?></span></div>
                                                                    </td>
                                                                    <td class="cell-details-packed" data-sort="">
                                                                        <div class="title-mobile"><span class="text"><?php echo e($_page->text_40); ?></span></div>
                                                                        <div class="cell-value"><span class="nowrap"><?php echo e(strtotime($sproduct->Packed_Coli_Date) && $sproduct->Packed_Coli_Date !== '01.01.0001 0:00:00' ? date('d.m.Y', strtotime($sproduct->Packed_Coli_Date)) : ''); ?></span></div>
                                                                    </td>
                                                                    <td class="cell-details-colli" data-sort="">
                                                                        <div class="title-mobile"><span class="text"><?php echo e($_page->text_41); ?></span></div>
                                                                        <div class="cell-value"><span class="nowrap"><?php echo e($sproduct->Coli_Number); ?></span></div>
                                                                    </td>
                                                                    <td class="cell-details-shipment" data-sort="">
                                                                        <div class="title-mobile"><span class="text"><?php echo e($_page->text_42); ?></span></div>
                                                                        <div class="cell-value"><span class="nowrap"><?php echo e($sproduct->Delivery_Method); ?></span></div>
                                                                    </td>
                                                                    <td class="cell-details-transport" data-sort="">
                                                                        <div class="title-mobile"><span class="text"><?php echo e($_page->text_43); ?></span></div>
                                                                        <div class="cell-value"><span class="nowrap"><?php echo e($sproduct->Transport_Type); ?></span></div>
                                                                    </td>
                                                                    <td class="cell-details-transport" data-sort="">
                                                                        <div class="title-mobile"><span class="text"><?php echo e($_page->text_55); ?></span></div>
                                                                        <div class="cell-value"><span class="nowrap"><?php echo e(isset($sproduct->Delivery_Date) ? $sproduct->Delivery_Date : ''); ?></span></div>
                                                                    </td>
                                                                </tr>
                                                              <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <?php endif; ?>
                                                  <?php endif; ?>
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <?php endforeach; ?>
                            <tfoot>
                                <tr>
                                    <td class="cell-order-number"></td>
                                    <td class="cell-order-producer"></td>
                                    <td class="cell-order-partcode"></td>
                                    <td class="cell-order-title"></td>
                                    <td class="cell-order-discount"></td>
                                    <td class="cell-brutto-price"></td>
                                    <td class="cell-order-quantity"><?php echo e($_page->text_44); ?><div class="cell-value"><span class="nowrap total_qty"><?php echo e($order->all); ?></span></div></td>
                                    <td class="cell-sum"><span class="price"><?php echo e($_page->text_45); ?></span><div class="cell-value"><span class="nowrap total_amount"><?php echo e(sprintf('%.2f', $order->brutto)); ?></span></div></td>
                                    <td class="cell-comments-count"></td>
                                    <td class="cell-in-stock <?= !$order->instock ? 'status-waiting' : ( $order->instock < $order->all ? 'status-in-progress' : 'status-complete' ) ?>"><?php echo e($_page->text_46); ?><div class="cell-value"><span class="nowrap total_instock"><?php echo e($order->instock); ?></span></div></td>
                                    <td class="cell-sent <?= !$order->sent ? 'status-waiting' : ( $order->sent < $order->all ? 'status-in-progress' : 'status-complete' ) ?>"><?php echo e($_page->text_47); ?><div class="cell-value"><span class="nowrap total_sent"><?php echo e($order->sent); ?></span></div></td>
                                    <td class="cell-delete"></td>
                                    <td class="cell-watch"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Delete order -->
                    <div class="order-tab-container js_tabs-target" data-tabs="2" data-tab="2">
                      <?php if(!$order->editable): ?>
                      <p style="font-size: 18px;text-align: center;font-family: 'roboto-bold';line-height: 1.2;letter-spacing: .2px;text-transform: uppercase;padding: 40px 0px;
                      "><?php echo e($_page->text_54); ?></p>
                      <?php else: ?>
                        <div class="delete-order-block">
                            <h4 class="title"><?php echo e($_page->text_48); ?></h4>
                            <p class="subtitle"><?php echo e($_page->text_49); ?></p>
                            <a href="#" class="btn btn-red-small" onclick="__.removeOrder();"><?php echo e($_page->text_50); ?></a>
                        </div>
                      <?php endif; ?>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<section class="psc sct-chat ticket-chat-loader" style="background-color: #202020;">
    <input type="hidden" id="ticket-chat-identify" value="<?php echo e($order->crm_id); ?>" style="display: none;visibility: hidden;opacity: 0;">
    <div class="pwr content">
        <div class="pct">
            <h2 class="title-ticket"><span class="red"><?php echo e($_page->text_56); ?></span> <?php echo e($_page->text_57); ?><span class="icon icon-msg"></span></h2>

            <div class="chat-new-message">
                <h5><?php echo e($_page->text_58); ?></h5>
                <form id="ticket-message-form" enctype="multipart/form-data">
                    <div class="form-body">
                        <div class="field-row">
                            <div class="field-block__input-container">
                                <textarea placeholder="<?php echo e($_page->text_59); ?>" name="message"></textarea>
                            </div>
                        </div>                        
                    </div>
                    <div class="form-footer">
                        <div class="filebox js">
                            <input type="file" name="f[]" id="support_files" class="inputfile inputfile-6" data-multiple-caption="<?php echo e($_page->text_61); ?> {count}" multiple>
                            <label for="support_files">
                                <span></span> 
                                <strong>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg>
                                </strong>
                            </label>
                        </div>                            
                        <button type="button" class="btn btn-red-small" onclick="__.stm();"><?php echo e($_page->text_60); ?></button>
                    </div>
                </form>
            </div>

            <div class="chat-ct">

                <div class="chat">
                    <div class="msgs-ct" id="ticket-chat-wrapper">
                      <?php foreach($chat->list as $message): ?>
                        <?php if($message->user_id == $order->user_id): ?>
                          <div class="msg animate me">
                              <div class="avatar" style="background-image: url(<?php echo e(url('/public/assets/img/content/default-avatar.jpg')); ?>)">
                                <img src="<?php echo e(url('/public/assets/img/content/default-avatar.jpg')); ?>" alt="<?php echo e($message->user_name); ?>">
                              </div>
                              <div class="text"><div class="text-ct"><?php echo e($message->message); ?></div></div>
                              <div class="footer">
                                  <span class="name"><?php echo e($_page->text_62); ?></span>
                                  <span class="date"><?php echo e(date('d.m.y', strtotime($message->created))); ?><span class="time"><?php echo e(date('H:i', strtotime($message->created))); ?></span></span>
                              </div>
                          </div>
                        <?php else: ?>
                          <div class="msg animate">
                              <div class="avatar" style="background-image: url(<?php echo e(url('/public/assets/img/content/admin-avatar.jpg')); ?>)">
                                <img src="<?php echo e(url('/public/assets/img/content/admin-avatar.jpg')); ?>" alt="<?php echo e($message->user_name); ?>">
                              </div>
                              <div class="text"><div class="text-ct"><?php echo e($message->message); ?></div></div>
                              <div class="footer">
                                  <span class="name"><?php echo e($message->user_name); ?></span>
                                  <span class="date"><?php echo e(date('d.m.y', strtotime($message->created))); ?><span class="time"><?php echo e(date('H:i', strtotime($message->created))); ?></span></span>
                              </div>
                          </div>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </div>
                    <div class="pagination">
                      <?php if(sizeof($chat->list)): ?>
                        <a href="javascript:void(0)" class="item link active">1</a>
                      <?php endif; ?>
                    </div>
                </div>

            </div>

        </div>
    </div>


</section>

</main>

<script>
document.addEventListener("DOMContentLoaded", function() {

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

    var tableTogglable = $('.js_table-togglable');

    $('.js_btn-order-details').on('click', function(e) {
      $(this).closest('tr').toggleClass('active').next('tr').toggleClass('active');
    });
});
</script>

<?php echo $__env->make('elements.importresultmodal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>